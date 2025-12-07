<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\Color;
use App\Models\CarTerm;
use App\Models\CarModel;
use App\Models\BookingCarClone;
use App\Models\CarModelColor;

class BookingService
{
    public function build(int $carModelId, int $termId, ?int $colorId, ?int $cloneId = null): array
    {
        $carModel = CarModel::findOrFail($carModelId);
        $brand = $carModel->brand;
        $carTerm = CarTerm::findOrFail($termId);
        $color = $colorId ? Color::findOrFail($colorId) : null;
        $priceWithColor = $carTerm->priceWithColor($color?->id, true);

        $attributes = [
            'car_model_id'       => $carModel->id,
            'car_model_name'     => $carModel->name,
            'car_brand_id'       => $brand->id,
            'car_brand_name'     => $brand->name,
            'car_term_id'        => $carTerm->id,
            'car_term_name'      => $carTerm->term_name,
            'color_id'           => $color?->id,
            'color_name'         => $color?->name,
            'second_color_id'    => null,
            'second_color_name'  => null,
            'price'              => $priceWithColor,
            'reservation_amount' => $carTerm->reservation_amount,
        ];

        if ($cloneId) {
            $bookingCarClone = BookingCarClone::findOrFail($cloneId);
            $bookingCarClone->fill($attributes);
            $bookingCarClone->save();
        } else {
            $bookingCarClone = BookingCarClone::create($attributes);
        }

        $firstColorImage = null;
        if ($colorId) {
            $colorRecord = Color::where('id', $colorId)
                ->first();
            $firstColorImage = $colorRecord ? Color::UPLOAD_FOLDER . $colorRecord->image : null;
        }

        $cars = CarModel::with(['brand', 'colors', 'terms', 'brand.serviceCenters'])
            ->where('id', $carModel->id)
            ->where('show_status', true)
            ->get();

        $banks = Bank::orderBy('name')->get(['id', 'name']);
        $branches = $brand->serviceCenters()
            ->orderBy('city')
            ->orderBy('name')
            ->get();

        return [
            'bookingCarClone' => $bookingCarClone,
            'cars' => $cars,
            'branches' => $branches,
            'car' => $carModel,
            'banks' => $banks,
            'firstColorImage' => $firstColorImage,
        ];
    }
}
