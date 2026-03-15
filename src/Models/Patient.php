<?php
namespace App\Models;

class Patient {
    public int $id;
    public string $name;
    public string $status;

    public function __construct(int $id, string $name, string $status) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
    }
}