<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'follows';

    protected $fillable = [
        'following', 'followers'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function followingUser(){
        return $this->belongsTo(User::class, 'following', 'id');
    }

    public function followerUser(){
        return $this->belongsTo(User::class, 'followers', 'id');
    }
}
