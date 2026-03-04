<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institution::create([
            'name' => 'Mi Institución Educativa',
            'short_name' => 'MIE',
            'description' => 'Descripción de la institución',
            'address' => 'San José, Costa Rica',
            'institution_type' => 'private',
            'favicon' => 'gei_favicon.ico',
            'email' => 'contacto@institucion.edu',
            'phone' => '+506 2222-2222',
            'primary_color' => '#3b82f6',
            'secondary_color' => '#8b5cf6',
            'province_id' => 1,
        ]);
    }
}
