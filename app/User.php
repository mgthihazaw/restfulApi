<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table ='users';

    const VERIFIED_USER ='1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'TRUE';
    const REGULAR_USER = 'FALSE';

    protected $fillable = [
        'name',
        'email', 
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        

    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function isAdmin(){
        return $this->admin == USER::ADMIN_USER;
    }
    public function isVerified(){
        return USER::VERIFIED_USER;
    }
    public static function generateVerificationCode(){
        return str_random(40);
    }
}
