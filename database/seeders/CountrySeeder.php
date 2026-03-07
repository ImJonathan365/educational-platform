<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Costa Rica', 'code' => 'CRI'],
            ['name' => 'Guatemala', 'code' => 'GTM'],
            ['name' => 'El Salvador', 'code' => 'SLV'],
            ['name' => 'Honduras', 'code' => 'HND'],
            ['name' => 'Nicaragua', 'code' => 'NIC'],
            ['name' => 'Panamá', 'code' => 'PAN'],
            ['name' => 'México', 'code' => 'MEX'],
            ['name' => 'Colombia', 'code' => 'COL'],
            ['name' => 'Argentina', 'code' => 'ARG'],
            ['name' => 'Chile', 'code' => 'CHL'],
            ['name' => 'Perú', 'code' => 'PER'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
