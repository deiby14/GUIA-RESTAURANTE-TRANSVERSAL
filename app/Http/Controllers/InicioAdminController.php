<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioAdminController extends Controller
{
    public function index()
    {
        return view('inicio_admin');
    }
}
