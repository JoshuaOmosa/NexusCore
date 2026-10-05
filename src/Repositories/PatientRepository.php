<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Patient;
use PDO;

/**
 * PDO-backed patient storage. The connection is injected rather than created
 * here, and every query that takes input uses a prepared statement.
 */
final class PatientRepository implements PatientRepositoryInterface
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT id, name, status FROM patients ORDER BY id');
        return array_map([Patient::class, 'fromRow'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(int $id): ?Patient
    {
        $stmt = $this->db->prepare('SELECT id, name, status FROM patients WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Patient::fromRow($row) : null;
    }

    public function findByStatus(string $status): array
    {
        if (!in_array($status, Patient::STATUSES, true)) {
            return [];
        }
        $stmt = $this->db->prepare('SELECT id, name, status FROM patients WHERE status = :status ORDER BY id');
        $stmt->execute(['status' => $status]);
        return array_map([Patient::class, 'fromRow'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
