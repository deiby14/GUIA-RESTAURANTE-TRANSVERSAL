<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;

class RestaurantesController extends Controller
{
    public function index()
    {
        $restaurantes = Restaurante::all();
        return view('administrar_restaurantes', compact('restaurantes'));
    }

    public function editRestaurante($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        return view('restaurantes.edit', compact('restaurante'));
    }

    public function updateRestaurante(Request $request, $id)
    {
        $restaurante = Restaurante::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        $restaurante->update($request->all());
        return redirect()->route('administrar.restaurantes')->with('success', 'Restaurante actualizado correctamente');
    }

    public function deleteRestaurante($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        $restaurante->delete();
        return redirect()->route('administrar.restaurantes')->with('success', 'Restaurante eliminado correctamente');
    }

    public function createRestaurante()
    {
        return view('restaurantes.create');
    }

    public function storeRestaurante(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'required|string'
        ]);

        Restaurante::create($request->all());

        return redirect()->route('administrar.restaurantes')
            ->with('success', 'Restaurante creado correctamente');
    }
}
