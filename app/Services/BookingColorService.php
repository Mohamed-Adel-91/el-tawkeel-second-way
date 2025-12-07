<?php

namespace App\Services;

use App\Models\Color;
use App\Models\BookingCarClone;
use App\Models\CarTerm;

class BookingColorService
{
    public function update(int $bookingCloneId, int $colorId, bool $isSecond = false): array
    {
        $color = Color::findOrFail($colorId);
        $bookingClone = BookingCarClone::findOrFail($bookingCloneId);
        $carTerm = CarTerm::find($bookingClone->car_term_id);
        $newPrice = $carTerm ? $carTerm->priceWithColor($colorId, true) : $bookingClone->price;

        if ($isSecond) {
            $bookingClone->update([
                'second_color_id' => $color->id,
                'second_color_name' => $color->name,
            ]);
        } else {
            $bookingClone->update([
                'color_id' => $color->id,
                'color_name' => $color->name,
                'price' => $newPrice,
            ]);
        }

        return [
            'color_name' => $color->name,
            'color_id' => $color->id,
            'price' => $newPrice,
            'price_formatted' => number_format($newPrice) . ' جنيه مصري',
        ];
    }
}
