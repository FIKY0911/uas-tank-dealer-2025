<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::firstOrCreate([
            'logo' => '',
            'name' => 'PT TANK MODERN',
            'phone' => '02123456789',
            'address' => 'Jl. Siap Tempur',
            'state' => 'Jakarta',
            'country' => 'Indonesia',
            'postcode' => '123456',
        ]);
    }
}
