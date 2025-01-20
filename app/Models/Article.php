<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'source',
        'published_at',
        'url',
        'category'
    ];
    
    protected $casts = [
        'published_at' => 'datetime'
    ];
}
