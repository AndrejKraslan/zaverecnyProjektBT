<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['first_name','last_name','email','password','is_admin'];

    public function lectures(){
        return $this->belongsToMany(Lectures::class,'users_has_lectures',
            'user_id','lecture_id');
    }
}
