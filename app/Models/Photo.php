<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'album_id',
        'message_id',
        'index',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    // protected $guarded = [];
}
