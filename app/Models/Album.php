<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    // protected $table = 'album_user';

    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the group associated with the Album
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}