<?php

namespace App\Models;

use App\Models\CommentLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'comment', 'user_id', 'user_id', 'post_id'
    ];

    public function details(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class, 'comment_id', 'id');
    }

    public function subComments(){
        return $this->hasMany(SubComment::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

}
