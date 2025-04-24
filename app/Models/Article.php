<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Article extends Model
{
    use Notifiable, HasFactory, HasUuids;
    protected $fillable = [
        'title',
        'content',
        'source',
        'published_at',
        'url',
        'category',
        'thumbnail'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];
}