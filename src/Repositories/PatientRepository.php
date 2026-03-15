<?php
namespace App\Repositories;

use App\Models\Patient;
use PDO;

class PatientRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT id, name, status FROM patients");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $patients = [];
        foreach ($results as $row) {
            $patients[] = new Patient($row['id'], $row['name'], $row['status']);
        }
        return $patients;
    }
}