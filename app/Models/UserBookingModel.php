<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookingModel extends Model
{
    use HasFactory;

    // 👇 Explicitly tell Laravel which table this model uses
    protected $table = 'booking';

    protected $fillable = [
        'departure',
        'destination',
        'departureDate',
        'returnDate',
        'passengers',
        'tripType',
        'flightClasses',
        'data',
        'generated_by',
    ];

    // Each booking belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
