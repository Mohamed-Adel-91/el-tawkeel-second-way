<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'guest_token',
        'ip_address',
        'car_id',
        'term_id',
        'user_id',
    ];
}
