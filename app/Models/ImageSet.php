<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageSet extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'line_user_id',
        'title',
    ];

    public function images()
    {
        return $this->hasMany(ImageFromUser::class);
    }
}