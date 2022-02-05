<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostGuest extends Model
{
    use HasFactory;

    protected $table = 'post_guests';

    protected $fillable = [
        'caption', 'name', 'likes', 'comments'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];
}
