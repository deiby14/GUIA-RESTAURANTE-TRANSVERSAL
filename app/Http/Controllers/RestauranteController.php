<?php

namespace App\Http\Controllers;
use App\Models\Restaurante;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use Illuminate\Support\Facades\DB;

class RestauranteController extends Controller
{
    /**
     * Muestra una lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cargar los restaurantes con sus fotos y todas las valoraciones
        $restaurantes = Restaurante::with(['fotos', 'valoraciones'])->get();
        
        // Si el usuario está autenticado, cargar sus valoraciones
        if (auth()->check()) {
            $userRatings = Valoracion::where('user_id', auth()->id())
                ->pluck('puntuación', 'restaurante_id')
                ->toArray();
        } else {
            $userRatings = [];
        }

        return view('restaurantes.index', compact('restaurantes', 'userRatings'));
    }

    public function rate(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'restaurant_id' => 'required|exists:restaurantes,id',
                'rating' => 'required|integer|min:1|max:5'
            ]);

            // Crear o actualizar la valoración
            $valoracion = Valoracion::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'restaurante_id' => $request->restaurant_id
                ],
                [
                    'puntuación' => $request->rating
                ]
            );

            // Calcular la nueva media usando Query Builder para mejor rendimiento
            $newRating = DB::table('valoraciones')
                ->where('restaurante_id', $request->restaurant_id)
                ->avg('puntuación');

            DB::commit();

            return response()->json([
                'success' => true,
                'newRating' => round($newRating), // Redondear al entero más cercano
                'message' => 'Valoración guardada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la valoración'
            ], 500);
        }
    }
}