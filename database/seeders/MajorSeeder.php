<?php

namespace Database\Seeders;

use App\Models\Majors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Majors::insert([
            [
                'name' => 'Web Programming',
                'is_active' => 1,
            ],
            [
                'name' => 'Teknik Jaringan',
                'is_active' => 1,
            ],
            [
                'name' => 'Teknik Komputer',
                'is_active' => 1,
            ],
            [
                'name' => 'Tata Boga',
                'is_active' => 1,
            ],
        ]);
    }
}
