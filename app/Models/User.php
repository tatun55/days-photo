<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'avatar',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}