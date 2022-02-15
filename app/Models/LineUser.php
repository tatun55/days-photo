<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LineUser extends Authenticatable
{
    protected $fillable = [
        'id',
        'name',
        'avatar',
    ];
}