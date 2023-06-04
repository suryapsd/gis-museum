<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'museum_id', 'nama', 'desc'
    ];

    public function museum() {
        return $this->belongsTo(Museum::class);
    }

    public function koleksis() {
        return $this->hasMany(Koleksi::class, 'galeri_id');
    }
}
