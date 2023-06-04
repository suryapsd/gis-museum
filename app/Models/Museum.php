<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Museum extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function images()
    {
        return $this->hasMany(Images::class, 'museum_id');
    }

    public function jenis_museum()
    {
        return $this->belongsTo(JenisMuseum::class, 'jenis_id');
    }

    public function penguruses() {
        return $this->hasMany(Pengurus::class);
    }

    public function getImage()
    {
    if (substr($this->image, 0, 5) == "https") {
    return $this->image;
    }

    if ($this->image) {
    return asset('/uploads/imgCover/' . $this->image);
    }

    return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
}
