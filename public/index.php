<?php
// Use __DIR__ to get the absolute path to the current folder (public),
// then go up one level to reach config/ or src/
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/Patient.php';
require_once __DIR__ . '/../src/Repositories/PatientRepository.php';

use App\Repositories\PatientRepository;


$repo = new PatientRepository($pdo);
$patients = $repo->findAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title>NexusCore | Patient Management</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .patient-card { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-left: 5px solid #007bff; }
        .status { font-weight: bold; color: green; }
    </style>
</head>
<body>
    <h1>🏥 NexusCore Master List</h1>
    <hr>
    <?php foreach ($patients as $p): ?>
        <div class="patient-card">
            <strong>ID:</strong> <?php echo $p->id; ?><br>
            <strong>Name:</strong> <?php echo htmlspecialchars($p->name); ?><br>
            <strong>Status:</strong> <span class="status"><?php echo $p->status; ?></span>
        </div>
    <?php endforeach; ?>
</body>
</html>