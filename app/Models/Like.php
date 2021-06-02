<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment_id',
        'type'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'comment_id' => 'integer',
        'type' => 'string',
    ];
}
