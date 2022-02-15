<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageFromUser extends Model
{
    protected $fillable = [
        'id',
        'message_id',
        'image_set_id',
    ];
}