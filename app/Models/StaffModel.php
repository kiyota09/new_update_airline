<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffModel extends Model
{
    protected $fillable = [
        'fullname',
        'role',
        'department',
        'status',
    ];
    protected $table = 'staff';
}
