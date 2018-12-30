<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    

    /**
     * Method One to One User -> Profile
     *
     * @return void
     */

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }


     /**
     * Method One to Many User -> Posts
     *
     * @return void
     */

    public function posts() {
        return $this->hasMany(Post::class);
    }



}
