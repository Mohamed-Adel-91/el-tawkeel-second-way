<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'جيتور',
                'logo' => '1753025102JtgHUFZUVV6QGKe0OOvp.png',
                'banner' => '1753611866WPChtfZIMpopEoTLlsk8.jpg',
                'description' => null,
                'show_status' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['name' => $brand['name']], $brand);
        }
    }
}
