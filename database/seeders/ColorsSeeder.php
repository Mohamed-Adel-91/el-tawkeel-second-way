<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;
use App\Enums\ColorTypeEnum;

class ColorsSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'أبيض', 'front_name' => 'White', 'type' => ColorTypeEnum::LIGHT, 'image' => null],
            ['name' => 'أسود', 'front_name' => 'Black', 'type' => ColorTypeEnum::DARK, 'image' => null],
            ['name' => 'فضي', 'front_name' => 'Silver', 'type' => ColorTypeEnum::LIGHT, 'image' => null],
            ['name' => 'رمادي', 'front_name' => 'Gray', 'type' => ColorTypeEnum::DARK, 'image' => null],
            ['name' => 'أزرق', 'front_name' => 'Blue', 'type' => ColorTypeEnum::DARK, 'image' => null],
            ['name' => 'أحمر', 'front_name' => 'Red', 'type' => ColorTypeEnum::DARK, 'image' => null],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(
                ['name' => $color['name']],
                [
                    'image' => $color['image'],
                    'front_name' => $color['front_name'],
                    'type' => $color['type'],
                ]
            );
        }
    }
}
