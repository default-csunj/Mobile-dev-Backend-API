<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Follow;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // public function following()
    // {
    //     return $this->hasMany(Follow::class, 'following', 'id');
    // }
    
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'following', 'followers');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followers', 'following');
    }
    
    public function followedBy(User $user){
        return $this->following->contains('followers', $user->id);
    }

    public function followingBy(User $user){
        return $this->followers->contains('following', $user->id);
    }
}
