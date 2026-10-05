<?php
declare(strict_types=1);

require_once __DIR__ . '/env.php';

load_env(__DIR__ . '/../.env');

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    env('DB_HOST', 'localhost'),
    env('DB_PORT', '3306'),
    env('DB_NAME', 'nexus_core')
);

try {
    $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS'), [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Log the real reason for the developer; never show host or driver
    // details to whoever is visiting the page.
    error_log('NexusCore DB connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Service temporarily unavailable.');
}
