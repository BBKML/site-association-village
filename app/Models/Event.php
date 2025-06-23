<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'image',
        'status',
        'max_participants',
    ];

    protected $casts = [
        'date' => 'datetime',
        'max_participants' => 'integer',
    ];
}
