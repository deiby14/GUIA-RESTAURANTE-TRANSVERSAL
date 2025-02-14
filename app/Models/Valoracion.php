<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'user_id',
        'restaurante_id',
        'puntuación',
        'comentario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);  //una valoracion pertenece a un usuario
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurante::class);  //una valoracion pertenece a una valoracion 
    }
}
