<?php

namespace App\Http\Controllers;
use App\Models\Restaurante;
use App\Models\Tipocomida;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestauranteController extends Controller
{
    /**
     * Muestra una lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $restaurantes = Restaurante::with(['tipocomida', 'fotos', 'valoraciones'])->get();
        $userRatings = []; // Aquí deberías cargar las valoraciones del usuario si las necesitas
        
        return view('restaurantes.index', compact('restaurantes', 'userRatings'));
    }

    public function create()
    {
        return view('restaurantes.create'); // Si tienes una vista para crear
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'dirección' => 'required|string|max:255',
                'precio_medio' => 'required|string|in:$,$$,$$$,$$$$',
                'descripcion' => 'nullable|string',
                'ciudad_id' => 'required|exists:ciudades,id',
                'tipocomida_id' => 'required|exists:tipocomidas,id',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $restaurante = new Restaurante($validatedData);
            $restaurante->save();

            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->storeAs('public/restaurantes', $nombreImagen);
                
                $restaurante->fotos()->create([
                    'ruta_imagen' => 'storage/restaurantes/' . $nombreImagen
                ]);
            }

            return redirect()->back()->with('success', 'Restaurante creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el restaurante: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        return view('restaurantes.edit', compact('restaurante')); // Si tienes una vista para editar
    }

    public function update(Request $request, $id)
    {
        try {
            $restaurante = Restaurante::findOrFail($id);
            
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'dirección' => 'required|string|max:255',
                'precio_medio' => 'required|string|in:$,$$,$$$,$$$$',
                'descripcion' => 'nullable|string',
                'ciudad_id' => 'required|exists:ciudades,id',
                'tipocomida_id' => 'required|exists:tipocomidas,id',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $restaurante->update($validatedData);

            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($restaurante->fotos->isNotEmpty()) {
                    Storage::delete(str_replace('storage/', 'public/', $restaurante->fotos->first()->ruta_imagen));
                    $restaurante->fotos()->delete();
                }

                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->storeAs('public/restaurantes', $nombreImagen);
                
                $restaurante->fotos()->create([
                    'ruta_imagen' => 'storage/restaurantes/' . $nombreImagen
                ]);
            }

            return redirect()->back()->with('success', 'Restaurante actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el restaurante: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $restaurante = Restaurante::findOrFail($id);
            
            // Eliminar las imágenes físicas
            foreach ($restaurante->fotos as $foto) {
                Storage::delete(str_replace('storage/', 'public/', $foto->ruta_imagen));
            }
            
            // La eliminación en cascada se encargará de eliminar las fotos y valoraciones relacionadas
            $restaurante->delete();
            
            return redirect()->back()->with('success', 'Restaurante eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el restaurante: ' . $e->getMessage());
        }
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

    public function show(Restaurante $restaurante)
    {
        // Obtener las valoraciones del restaurante con sus usuarios
        $valoraciones = $restaurante->valoraciones()->with('user')->get();
        
        // Si el usuario está autenticado, obtener su valoración
        $miValoracion = auth()->check() 
            ? $restaurante->valoraciones()->where('user_id', auth()->id())->first() 
            : null;

        return view('restaurantes.show', compact('restaurante', 'valoraciones', 'miValoracion'));
    }
}
