<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'content',
        'category_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'status' => 'string',
        'content' => 'string',
        'category_id' => 'integer',
        'post_time' => 'datetime'
    ];
}
