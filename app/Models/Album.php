<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    public function photos($userId = false, $isArchived = false)
    {
        if ($userId) {
            return $this->belongsToMany(Photo::class)->whereHas('users', function ($q) use ($userId, $isArchived) {
                return $q->where('user_id', $userId)->where('is_archived', $isArchived);
            });
        }
        return $this->hasMany(Photo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}