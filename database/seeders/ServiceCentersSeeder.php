<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCenter;
use App\Models\Brand;
use App\Enums\CityEnum;

class ServiceCentersSeeder extends Seeder
{
    public function run(): void
    {
        $brand = Brand::first();
        if (!$brand) {
            $brand = Brand::create(['name' => 'Default Brand']);
        }

        $centers = [
            [
                'brand_id' => $brand->id,
                'name' => 'Nasr City Service Center',
                'location' => 'https://goo.gl/maps/nasr-city',
                'address' => 'Nasr City, Cairo',
                'phone' => '01000000001',
                'city' => CityEnum::CAIRO,
            ],
            [
                'brand_id' => $brand->id,
                'name' => 'Giza Service Center',
                'location' => 'https://goo.gl/maps/giza-center',
                'address' => '6th October, Giza',
                'phone' => '01000000002',
                'city' => CityEnum::GIZA,
            ],
        ];

        foreach ($centers as $center) {
            ServiceCenter::create($center);
        }
    }
}
