<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Restaurante;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    public function store(Request $request, $restaurante_id)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|min:3'
        ]);

        // Verificar si el usuario ya tiene una valoración para este restaurante
        $valoracionExistente = Valoracion::where('user_id', auth()->id())
            ->where('restaurante_id', $restaurante_id)
            ->first();

        if ($valoracionExistente) {
            return back()->with('error', 'Ya has valorado este restaurante. Puedes editar tu valoración existente.');
        }

        Valoracion::create([
            'user_id' => auth()->id(),
            'restaurante_id' => $restaurante_id,
            'puntuación' => $request->puntuacion,
            'comentario' => $request->comentario
        ]);

        return back()->with('success', 'Valoración publicada correctamente');
    }

    public function update(Request $request, Valoracion $valoracion)
    {
        $request->validate([
            'comentario' => 'required|min:3'
        ]);

        if ($valoracion->user_id !== auth()->id()) {
            return back()->with('error', 'No tienes permiso para editar esta valoración');
        }

        $valoracion->update([
            'comentario' => $request->comentario
        ]);

        return back()->with('success', 'Comentario actualizado correctamente');
    }

    public function destroy(Valoracion $valoracion)
    {
        if ($valoracion->user_id !== auth()->id()) {
            return back()->with('error', 'No autorizado');
        }

        $valoracion->update([
            'comentario' => null
        ]);

        return redirect()->back()->with('success', 'Comentario eliminado');
    }

    public function reset(Valoracion $valoracion)
    {
        if ($valoracion->user_id !== auth()->id()) {
            return back()->with('error', 'No tienes permiso para realizar esta acción');
        }

        $valoracion->update([
            'puntuación' => 0,
            'comentario' => ''
        ]);

        return redirect()->back()->with('success', 'Comentario eliminado correctamente');
    }
} 