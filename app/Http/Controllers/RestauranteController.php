<?php

namespace App\Http\Controllers;
use App\Models\Restaurante;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    /**
     * Muestra una lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lógica para obtener la lista de restaurantes
        $restaurantes = Restaurante::with('fotos')->get();
        return view('restaurantes.index', compact('restaurantes'));
    }
}