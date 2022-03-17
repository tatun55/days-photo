<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('auto_saving')->withTimestamps();
    }
}