<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakerLecture extends Model
{
    use HasFactory;
    protected $table = 'speakers_has_lectures'; // názov spojovacej tabuľky

    protected $fillable = [
        'speaker_id',
        'lecture_id',
    ];
}
