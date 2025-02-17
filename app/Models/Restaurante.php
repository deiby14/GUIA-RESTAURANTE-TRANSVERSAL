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
        return $this->hasMany(Valoracion::class);  
    }

    public function tipoComida()
        {
            return $this->belongsTo(Tipocomida::class);
        }
    
    public function ciudad()
        {
            return $this->belongsTo(Ciudad::class);
        }
}
