<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::insert([
            [
                'name' => 'Administrator',
                'is_active' => 1,
            ],
            [
                'name' => 'Admin',
                'is_active' => 1,
            ],
            [
                'name' => 'PIC',
                'is_active' => 1,
            ],
            [
                'name' => 'Instruktur',
                'is_active' => 1,
            ],
            [
                'name' => 'Murid',
                'is_active' => 1,
            ]
        ]);
    }
}
