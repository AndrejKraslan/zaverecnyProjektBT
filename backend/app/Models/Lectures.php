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
    public function users(){
        return $this->belongsToMany(Users::class,'users_has_lectures',
            'user_id','lecture_id'); // neviem poradie
    }
    public function stages(){
        return $this->belongsTo(Stages::class,
            'stage_id','stage_id');
    }
    public function speakers(){
        return $this->belongsTo(Speakers::class,
            'speaker_id','speaker_id');
    }
}
