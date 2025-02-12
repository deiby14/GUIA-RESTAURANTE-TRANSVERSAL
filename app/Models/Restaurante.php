<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;
    public function fotos()
    {
        return $this->hasMany(Foto::class);    //un restaurante tiene muchas fotos
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);  //un restaurante tiene muchas valoraciones
    }
}
