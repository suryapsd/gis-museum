<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengurus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'museum_id', 'nama_pengurus', 'image', 'jabatan', 'alamat_pengurus', 'telepon_pengurus', 'waktu_mulai', 'waktu_akhir', 'is_aktif'
    ];

    public function museum() {
        return $this->belongsTo(Museum::class);
    }
}
