<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Province::insert([
            ['name' => 'San José', 'code' => 'SJ'],
            ['name' => 'Alajuela', 'code' => 'AL'],
            ['name' => 'Cartago', 'code' => 'CA'],
            ['name' => 'Heredia', 'code' => 'HE'],
            ['name' => 'Guanacaste', 'code' => 'GU'],
            ['name' => 'Puntarenas', 'code' => 'PU'],
            ['name' => 'Limón', 'code' => 'LI'],
        ]);
    }
}
