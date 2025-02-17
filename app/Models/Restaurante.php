<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'precio_medio',
        'tipocomida_id',
        'ciudad_id',
    ];
    
    public function fotos()
    {
        return $this->hasMany(Foto::class);  
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);  //un restaurante tiene muchas valoraciones
    }
}
