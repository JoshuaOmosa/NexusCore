<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../config/database.php';

use App\Models\Patient;
use App\Repositories\PatientRepository;

$repo = new PatientRepository($pdo);

// Optional ?status= filter; anything not in the allowed list shows everyone.
$filter = isset($_GET['status']) && in_array($_GET['status'], Patient::STATUSES, true)
    ? $_GET['status']
    : null;
$patients = $filter ? $repo->findByStatus($filter) : $repo->findAll();

function e(string|int $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexusCore | Patient Management</title>
    <style>
        body { font-family: system-ui, sans-serif; padding: 20px; line-height: 1.6; max-width: 760px; margin: auto; }
        nav a { margin-right: 12px; }
        nav a.current { font-weight: bold; }
        .patient-card { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-left: 5px solid #007bff; }
        .status { font-weight: bold; text-transform: capitalize; }
        .status-active { color: #1b7f3b; }
        .status-pending { color: #b26a00; }
        .status-discharged { color: #666; }
        .empty { color: #666; font-style: italic; }
    </style>
</head>
<body>
    <h1>NexusCore Master List</h1>
    <nav>
        <a href="?" class="<?= $filter === null ? 'current' : '' ?>">All</a>
        <?php foreach (Patient::STATUSES as $s): ?>
            <a href="?status=<?= e($s) ?>" class="<?= $filter === $s ? 'current' : '' ?>"><?= e(ucfirst($s)) ?></a>
        <?php endforeach; ?>
    </nav>
    <hr>
    <?php if (!$patients): ?>
        <p class="empty">No patients to show.</p>
    <?php endif; ?>
    <?php foreach ($patients as $p): ?>
        <div class="patient-card">
            <strong>ID:</strong> <?= e($p->id) ?><br>
            <strong>Name:</strong> <?= e($p->name) ?><br>
            <strong>Status:</strong> <span class="status status-<?= e($p->status) ?>"><?= e($p->status) ?></span>
        </div>
    <?php endforeach; ?>
</body>
</html>
