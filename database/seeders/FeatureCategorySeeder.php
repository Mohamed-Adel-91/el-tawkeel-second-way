<?php

namespace Database\Seeders;

use App\Models\FeatureCategory;
use Illuminate\Database\Seeder;

class FeatureCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'عوامل الأمان',
            'الراحة والرفاهية',
            'التكنولوجيا',
        ];

        foreach ($categories as $name) {
            FeatureCategory::create(['name' => $name]);
        }
    }
}
