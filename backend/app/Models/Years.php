<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    use HasFactory;

    protected $table = 'years';
    protected $primaryKey = 'year_id';
    protected $fillable = ['year'];

    public function images()
    {
        return $this->hasMany(Images::class, 'year_id', 'year_id');
    }
}
