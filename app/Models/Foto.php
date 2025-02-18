<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{    
    use HasFactory;

    protected $fillable = ['ruta_imagen'];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
