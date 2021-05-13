<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubComment extends Model
{
    use HasFactory;

    protected $table = 'sub_comments';
    protected $fillable = [
        'sub_comment', 'user_id', 'comment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
}
