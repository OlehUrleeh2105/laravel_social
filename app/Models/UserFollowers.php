<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowers extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_user',
        'follow_to',
    ];
}
