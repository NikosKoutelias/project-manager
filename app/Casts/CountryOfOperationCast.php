<?php

namespace App\Casts;

use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class CountryOfOperationCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return CountryOfOperation::fromArray($value)->toString();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (!$value instanceof CountryOfOperation) {
            throw new InvalidArgumentException('The given value is not an Country of operation instance.');
        }

        return $value->toString();
    }
}
