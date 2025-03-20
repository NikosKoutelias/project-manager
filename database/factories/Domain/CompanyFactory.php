<?php

namespace Database\Factories\Domain;

use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'country_of_operation' => CountryOfOperation::fromArray(array_rand(CountryOfOperation::COUNTRIES)),
            'description' => fake()->realText(),
        ];
    }
}
