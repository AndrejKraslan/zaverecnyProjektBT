<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLecture extends Model
{
    use HasFactory;
    protected $table = 'users_has_lectures'; // názov vašej spojovacej tabuľky

    protected $fillable = [
        'user_id',
        'lecture_id',
    ];
}
