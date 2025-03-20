<?php

namespace Database\Seeders;

use App\Models\Domain\Company;
use App\Models\SubDomains\Project;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(2)->create();
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => Role::fromArray('ADMIN'),
            'permissions' => json_encode(['companies' => [], 'projects' => []]),
        ]);

        Company::factory(3)->create([]);
        Project::factory(10)->create([]);
    }
}
