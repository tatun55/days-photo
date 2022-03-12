<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the user associated with the CartItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function album(): HasOne
    {
        return $this->hasOne(Album::class, 'id', 'album_id');
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }
}