<?php

namespace App\Services;

use App\Models\Brand;

class BrandCarService
{
    public function build(int $id): array
    {
        $brand = Brand::with(['cars' => function ($q) {
            $q->where('status', true)
                ->with([
                    'brand',
                    'colors',
                    'terms' => fn($t) => $t->where('status', true)->with('specs'),
                ]);
        }])->findOrFail($id);

        $canonical = \unicode_slug($brand->name, '-');
        $slides = $brand->slider_images_paths;
        $hasSlides = !empty($slides);
        $fallback = $brand->banner_path;

        return [
            'brand' => $brand,
            'canonical' => $canonical,
            'slides' => $slides,
            'hasSlides' => $hasSlides,
            'fallback' => $fallback,
        ];
    }
}
