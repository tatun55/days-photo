<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageFromUser extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'message_id',
        'line_user_id',
        'image_set_id',
    ];
}