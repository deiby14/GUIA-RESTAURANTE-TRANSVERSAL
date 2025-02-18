<?php

namespace App\Http\Controllers;

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
        return view('restaurantes.index'); // Asegúrate de tener una vista llamada 'restaurants/index.blade.php'
    }
}