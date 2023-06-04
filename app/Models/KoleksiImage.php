<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoleksiImage extends Model
{
    use HasFactory, SoftDeletes;

    public function koleksi() {
        return $this->belongsTo(Koleksi::class);
    }
}
