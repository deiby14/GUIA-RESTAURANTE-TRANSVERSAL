<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'dirección',
        'precio_medio',
        'tipocomida_id',
        'descripcion',
        'ciudad_id'
    ];
    
    public function fotos()
    {
        return $this->hasMany(Foto::class);  
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);  //un restaurante tiene muchas valoraciones
    }

    public function tipocomida()
    {
        return $this->belongsTo(Tipocomida::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }
}
