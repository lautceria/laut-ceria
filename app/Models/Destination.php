<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $primaryKey = 'destination_id';
    protected $fillable = ['name', 'slug', 'description', 'coordinate'];

    public function images()
    {
        return $this->hasMany(Image::class, 'foreign_id', 'destination_id');
    }
}