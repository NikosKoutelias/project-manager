<?php

namespace App\Models\ValueObjects;

use InvalidArgumentException;

class Role
{
    private function __construct(private readonly string $role) {}

    const array ROLES = [
        'ADMIN' => 'admin',
        'USER' => 'user',
    ];

    public static function fromArray(string $role): Role
    {

        if (! self::ROLES[$role]) {
            throw new InvalidArgumentException('It is not valid role value');
        }

        return new self($role);
    }

    public function toString(): string
    {
        return $this->role;
    }
}
