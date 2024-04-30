<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectures extends Model
{
    use HasFactory;
    protected $table = 'lectures';
    protected $primaryKey = 'lecture_id';
    protected $fillable = [
        'name',
        'description',
        'image',
        'capacity',
        'max_capacity',
        'start',
        'end',
        'speaker_id',
        'stage_id'
    ];
}
