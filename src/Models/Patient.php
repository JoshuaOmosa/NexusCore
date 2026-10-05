<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Plain data object for one row of the patients table. Callers work with
 * this instead of raw database arrays.
 */
final class Patient
{
    public const STATUSES = ['active', 'pending', 'discharged'];

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $status,
    ) {
        if (!in_array($status, self::STATUSES, true)) {
            throw new \InvalidArgumentException("Unknown patient status: $status");
        }
    }

    /** Build a Patient from a database row, casting types explicitly. */
    public static function fromRow(array $row): self
    {
        return new self((int) $row['id'], (string) $row['name'], (string) $row['status']);
    }
}
