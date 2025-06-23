<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'phone',
        'is_read',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
