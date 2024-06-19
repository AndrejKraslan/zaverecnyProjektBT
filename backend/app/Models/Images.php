<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $primaryKey = 'image_id';
    protected $fillable = ['image', 'year_id'];

    public function year()
    {
        return $this->belongsTo(Years::class, 'year_id', 'year_id');
    }
}
