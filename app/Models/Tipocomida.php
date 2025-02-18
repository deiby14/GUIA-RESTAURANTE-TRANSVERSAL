<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  
class Tipocomida extends Model
{
    protected $table = 'tipocomidas';
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación con Restaurantes
    public function restaurantes()
    {
        return $this->hasMany(Restaurante::class);
    }
}
