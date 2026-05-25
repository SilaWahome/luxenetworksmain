<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'info@luxenetworks.co.ke'],
            [
                'first_name' => 'Admin',
                'second_name' => 'User',
                'company_name' => 'Luxenet Admin',
                'phone_number' => '+256700000000',
                'mikrotics_count' => 0,
                'password' => 'Threatmatrix254#',
            ]
        );

        // Sample Leads
        User::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'first_name' => 'John',
                'second_name' => 'Doe',
                'company_name' => 'Doe Networks',
                'phone_number' => '+256700000001',
                'mikrotics_count' => 2,
            ]
        );

        User::updateOrCreate(
            ['email' => 'jane@example.com'],
            [
                'first_name' => 'Jane',
                'second_name' => 'Smith',
                'company_name' => 'Smith Solutions',
                'phone_number' => '+256700000002',
                'mikrotics_count' => 5,
            ]
        );

        User::updateOrCreate(
            ['email' => 'alex@luxenet.africa'],
            [
                'first_name' => 'Alex',
                'second_name' => 'Wasswa',
                'company_name' => 'Alex Systems',
                'phone_number' => '+256700000003',
                'mikrotics_count' => 1,
            ]
        );
    }
}
