<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
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
