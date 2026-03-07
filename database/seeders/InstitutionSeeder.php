<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;
use App\Models\Country;
use App\Models\Province;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeds a default institution with dynamic country and province lookup.
     * Falls back to null if countries/provinces are not seeded yet.
     */
    public function run(): void
    {
        if (Institution::exists()) {
            $this->command->info('Institution already exists. Skipping seeder.');
            return;
        }

        $country = Country::where('name', 'Costa Rica')->first() ?? Country::first();
        $province = Province::where('name', 'San José')->first() ?? Province::first();

        Institution::create([
            'name' => 'Mi Institución Educativa',
            'slogan' => 'Educación de calidad para todos',
            'institution_code' => 'MIE-001',
            'description' => 'Institución educativa comprometida con la excelencia académica y el desarrollo integral de nuestros estudiantes.',
            'address' => 'Avenida Central, San José',
            'country_id' => $country?->id,
            'province_id' => $province?->id,
            'postal_code' => '10101',
            'institution_type' => 'private',
            'logo' => null,
            'favicon' => null,
            'website' => 'https://www.miinstitucion.edu',
            'email' => 'contacto@institucion.edu',
            'phone' => '+506 2222-2222',
            'primary_color' => '#009dff',
            'secondary_color' => '#ffda09',
        ]);
    }
}
