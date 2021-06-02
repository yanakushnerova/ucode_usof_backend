<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'content' => 'string',
        'comment_time'  => 'datetime'
    ];
}
