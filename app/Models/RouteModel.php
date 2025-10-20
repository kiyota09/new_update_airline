<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteModel extends Model
{
    protected $fillable =[
        'origin_route',
        'destination_route',
        'base_price',
        'duration',
        'distance',
        'aircraft_id',
    ];

    protected $table = 'routes_location';

    public function rout()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
