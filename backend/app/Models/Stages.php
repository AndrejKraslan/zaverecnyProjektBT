<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    use HasFactory;
    protected $table = 'stages';
    protected $primaryKey = 'stage_id';
    protected $fillable = [
        'name',
        'date',
        'room'
    ];
    public function lectures(){
        return $this->hasMany(Lectures::class,
            'stage_id','stage_id');
    }

}
