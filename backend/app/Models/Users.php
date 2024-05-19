<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['first_name','last_name','email','password','is_admin'];
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function lectures(){
        return $this->belongsToMany(Lectures::class,'users_has_lectures',
            'user_id','lecture_id');
    }

    public function setPasswordAtribute($password){
        $this->attributes['password'] = Hash::make($password);
    }
}
