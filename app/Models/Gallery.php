<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
} 