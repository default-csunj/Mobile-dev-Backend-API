<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $table = 'likes_comments';

    protected $fillable = [
        'user_id', 'comment_id'
    ];

    public function details(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
