<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_name',
        'phone_number',
        'date',
        'time',
        'party_size',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'party_size' => 'integer',
    ];
}
