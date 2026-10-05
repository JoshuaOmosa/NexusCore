<?php
declare(strict_types=1);

// Dependency-free test runner: exercises PatientRepository against an
// in-memory SQLite database with the same table shape as database.sql.
// Run with:  php tests/run.php

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../config/env.php';

use App\Models\Patient;
use App\Repositories\PatientRepository;

$failures = 0;
$passes = 0;

function check(string $name, bool $ok): void
{
    global $failures, $passes;
    echo ($ok ? "  PASS  " : "  FAIL  ") . $name . PHP_EOL;
    $ok ? $passes++ : $failures++;
}

function make_db(bool $seed = true): PDO
{
    $db = new PDO('sqlite::memory:', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $db->exec("CREATE TABLE patients (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','discharged','pending'))
    )");
    if ($seed) {
        $db->exec("INSERT INTO patients (name, status) VALUES
            ('John Doe', 'active'), ('Jane Smith', 'pending'), ('Robert Brown', 'discharged')");
    }
    return $db;
}

echo "PatientRepository" . PHP_EOL;
$repo = new PatientRepository(make_db());

$all = $repo->findAll();
check('findAll returns every row', count($all) === 3);
check('findAll returns Patient objects', $all[0] instanceof Patient);
check('ids are cast to int', $all[0]->id === 1);

check('findById finds an existing patient', $repo->findById(2)?->name === 'Jane Smith');
check('findById returns null when missing', $repo->findById(999) === null);

check('findByStatus filters', array_map(fn($p) => $p->name, $repo->findByStatus('discharged')) === ['Robert Brown']);
check('findByStatus rejects unknown status', $repo->findByStatus("active' OR '1'='1") === []);

check('findAll on empty table returns []', (new PatientRepository(make_db(false)))->findAll() === []);

echo PHP_EOL . "Patient" . PHP_EOL;
try {
    new Patient(1, 'X', 'deleted');
    check('rejects unknown status', false);
} catch (InvalidArgumentException) {
    check('rejects unknown status', true);
}

echo PHP_EOL . "env loader" . PHP_EOL;
$tmp = tempnam(sys_get_temp_dir(), 'env');
file_put_contents($tmp, "# comment\nNC_TEST_A=hello\nNC_TEST_B=\"quoted\"\n");
putenv('NC_TEST_B=from-environment');
load_env($tmp);
unlink($tmp);
check('reads KEY=VALUE', env('NC_TEST_A') === 'hello');
check('real environment wins over .env', env('NC_TEST_B') === 'from-environment');
check('default used when unset', env('NC_TEST_MISSING', 'fallback') === 'fallback');

echo PHP_EOL . "$passes passed, $failures failed" . PHP_EOL;
exit($failures === 0 ? 0 : 1);
