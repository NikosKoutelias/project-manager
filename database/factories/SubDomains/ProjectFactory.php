<?php

namespace Database\Factories\SubDomains;

use App\Models\Domain\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->colorName(),
            'description' => fake()->realText(),
            'company_id' => array_values(Company::all()->pluck('id')->toArray())[rand(0, 2)],
        ];
    }
}
