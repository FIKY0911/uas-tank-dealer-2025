<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $user->assignRole('super_admin');

        $user = User::firstOrCreate(
            ['email' => 'customer.1@admin.com'],
            ['name' => 'Customer1 Account', 'password' => Hash::make('password123')]
        );
        $user->assignRole('user');

        $user = User::firstOrCreate(
            ['email' => 'customer.2@admin.com'],
            ['name' => 'Customer2 Account', 'password' => Hash::make('password123')]
        );
        $user->assignRole('user');
    }
}
