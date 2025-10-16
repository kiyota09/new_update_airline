<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userHistory extends Model
{
    protected $fillable = [
        'flightNo',
        'origin',
        'destination',
        'date',
        'time',
        'price',
        'name',
        'contact',
        'paymentMethod',

    ];
}
