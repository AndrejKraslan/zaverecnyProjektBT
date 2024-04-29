<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speakers extends Model
{
    use HasFactory;
    protected $table = 'speakers';
    protected $primaryKey = 'speaker_id';
    protected $fillable = ['name','description_short','description_long','image','facebook_url','instagram_url',
        'twitter_url','web_url'];
}
