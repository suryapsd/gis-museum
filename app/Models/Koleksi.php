<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Koleksi extends Model
{
    use HasFactory, SoftDeletes;

    public function galeri() {
        return $this->belongsTo(Galeri::class);
    }

    public function koleksi_images() {
        return $this->hasMany(KoleksiImage::class, 'koleksi_id');
    }
    
}
