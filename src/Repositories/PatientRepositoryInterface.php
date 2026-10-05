<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Patient;

/**
 * What the rest of the app needs from patient storage. Code depends on this
 * interface, so the MySQL implementation can be swapped (or faked in tests).
 */
interface PatientRepositoryInterface
{
    /** @return Patient[] */
    public function findAll(): array;

    public function findById(int $id): ?Patient;

    /** @return Patient[] */
    public function findByStatus(string $status): array;
}
