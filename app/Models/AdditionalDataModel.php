<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AdditionalDataModel extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'contact',
        'gender',
        'memberDate',
        'validId',
        'block',
        'barangay',
        'municipality',
        'province',
        'country',
        'passport',
        'user_id',
        
    ];

    // Make sure this matches your migration table name
    protected $table = 'addtional_data';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
