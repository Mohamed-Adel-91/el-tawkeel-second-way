<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\FeatureCategory;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'عوامل الأمان' => [
                'وسائد هوائية',
                'فرامل ABS',
                'حساسات ركن',
            ],
            'الراحة والرفاهية' => [
                'مكيف هواء',
                'نوافذ كهربائية',
            ],
            'التكنولوجيا' => [
                'نظام ملاحة',
                'مثبت سرعة',
            ],
        ];

        foreach ($features as $categoryName => $items) {
            $category = FeatureCategory::where('name', $categoryName)->first();
            if (! $category) {
                $category = FeatureCategory::create(['name' => $categoryName]);
            }

            foreach ($items as $name) {
                Feature::create([
                    'feature_category_id' => $category->id,
                    'name' => $name,
                    'status' => true,
                ]);
            }
        }
    }
}
