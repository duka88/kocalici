<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
      use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','about'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot(){
        
        parent::boot();

        static::created(function($user){
           $user->profile()->create();

          
        });
        
        static::deleted(function($user){
           $user->profile()->delete();

          
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(){

        return $this->role == 'admin';
    }

    public function recipes(){
        return $this->hasMany(Recipe::class);
    }

     public function scores(){
        return $this->hasMany(Score::class);
    }

    public function likes(){

        return $this->hasMany(Like::class);
    }

    public function profile(){

        return $this->hasOne(Profile::class);
    }
}
