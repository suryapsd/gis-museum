<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Images extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    protected $fillable = [
        'museum_id', 'path'
    ];

    public function setFilenamesAttribute($value){
        $this->attributes['path'] = json_encode($value);
    }

    public function museum()
    {
        return $this->belongsTo(Museums::class);
    }

}
