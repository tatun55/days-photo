<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'line_user_id',
    ];

    public function images()
    {
        return $this->hasMany(ImageFromUser::class);
    }
}