<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $salesRole = Role::create(['name' => 'Salesperson']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Sales Person',
            'email' => 'salesperson@example.com',
            'password' => Hash::make('123456'),
            'role_id' => $salesRole->id,
        ]);
    }
}
