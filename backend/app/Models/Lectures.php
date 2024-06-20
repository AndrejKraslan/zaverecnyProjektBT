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
        'max_capacity',
        'start',
        'end',
        'stage_id'
    ];

    protected $attributes = [
        'capacity' => 0, // default 0
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class, 'users_has_lectures', 'lecture_id', 'user_id');
    }

    public function stages()
    {
        return $this->belongsTo(Stages::class, 'stage_id', 'stage_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speakers::class, 'speakers_has_lectures', 'lecture_id', 'speaker_id');
    }
}
