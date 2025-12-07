<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Shape;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            [
                'brand' => 'جيتور',
                'shape' => 'SUV',
                'name'  => 'X70',
                'start_price' => 1230000,
                'show_status' => true,
            ],
            [
                'brand' => 'جيتور',
                'shape' => 'SUV',
                'name'  => 'X50',
                'start_price' => 1430000,
                'show_status' => true,
            ],
            [
                'brand' => 'جيتور',
                'shape' => 'SUV',
                'name'  => 'T1',
                'start_price' => 1530000,
                'show_status' => true,
            ],
            [
                'brand' => 'جيتور',
                'shape' => 'SUV',
                'name'  => 'T2',
                'start_price' => 1830000,
                'show_status' => true,
            ],
        ];

        foreach ($models as $data) {
            $brand = Brand::where('name', $data['brand'])->first();
            $shape = Shape::where('name', $data['shape'])->first();

            if ($brand && $shape) {
                CarModel::firstOrCreate(
                    ['name' => $data['name']],
                    [
                        'brand_id'   => $brand->id,
                        'shape_id'   => $shape->id,
                        'start_price' => $data['start_price'],
                        'show_status' => $data['show_status'],
                        'image' => $data['image'] ?? null,
                        'catalog' => $data['catalog'] ?? null,
                        'year' => $data['year'] ?? null,
                        'engine' => $data['engine'] ?? null,
                        'engine_type' => $data['engine_type'] ?? null,
                        'horse_power' => $data['horse_power'] ?? null,
                        'maintenance_schedule_pdf' => $data['maintenance_schedule_pdf'] ?? null,
                        'view_360_degree' => $data['view_360_degree'] ?? null,
                    ]
                );
            }
        }
    }
}
