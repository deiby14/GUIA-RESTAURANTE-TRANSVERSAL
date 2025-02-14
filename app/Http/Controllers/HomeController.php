<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Muestra la vista home.blade.php.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home'); // Asegúrate de tener una vista llamada 'home.blade.php'
    }
}