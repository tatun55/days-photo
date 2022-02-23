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
        'album_id',
        'line_user_id',
        'message_id',
        'index',
        'created_at',
        'updated_at',
    ];
}