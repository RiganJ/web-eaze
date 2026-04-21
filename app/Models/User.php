<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
   protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'is_active',
];

protected $hidden = [
    'password',
    'remember_token',
];

public function isRole($role)
{
    return $this->role === $role;
}

}
