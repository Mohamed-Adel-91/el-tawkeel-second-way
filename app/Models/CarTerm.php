<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarTerm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_model_id',
        'term_name',
        'price',
        'inventory',
        'reservation_amount',
        'color_over_price',
        'status',
    ];

    protected $casts = [
        'color_over_price' => 'array',
        'status' => 'boolean',
    ];

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function specs()
    {
        return $this->hasMany(Specs::class, 'car_term_id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'car_term_feature')
            ->using(CarTermFeature::class)
            ->withPivot('value', 'status')
            ->withTimestamps();
    }

    public function priceWithColor(?int $colorId, bool $fallbackToLowest = false): float
    {
        $base = (float)($this->price ?? 0);
        $map = is_array($this->color_over_price) ? $this->color_over_price : [];
        $map = array_filter($map, fn($v) => $v !== null && $v !== '' && is_numeric($v));
        if ($colorId && isset($map[$colorId])) {
            return $base + (float)$map[$colorId];
        }
        if ($fallbackToLowest && !empty($map)) {
            return $base + (float)min($map);
        }
        return $base;
    }
}
