<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AircraftModel extends Model
{
    use HasFactory;
    protected $table = 'aircraft';
    protected $fillable = [
        'aircraft_id',
        'model',
        'registration',
        'business',
        'firstclass',
        'economy',
        'status',
        'location',
        'aircraft_id',
    ];
}
