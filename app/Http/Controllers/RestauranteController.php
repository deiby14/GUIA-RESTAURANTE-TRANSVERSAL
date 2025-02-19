<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Tipocomida;
use App\Models\Ciudad;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestauranteController extends Controller
{
    /**
     * Muestra una lista de restaurantes o los resultados de la búsqueda.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Iniciamos la consulta base para restaurantes
            $query = Restaurante::with(['tipocomida', 'fotos', 'valoraciones']);

            // Filtrar por nombre si se proporcionó
            if ($request->filled('nombre')) {
                $query->where('nombre', 'like', '%' . $request->nombre . '%');
            }

            // Filtrar por ciudad si se proporcionó
            if ($request->filled('ciudad')) {
                $query->whereHas('ciudad', function ($q) use ($request) {
                    $q->where('nombre', 'like', '%' . $request->ciudad . '%');
                });
            }

            // Ordenar por precio si se proporcionó
            if ($request->filled('precio')) {
                $query->orderBy('precio_medio', $request->precio);
            }

            // Ordenar por valoración si se proporcionó
            if ($request->filled('valoracion')) {
                $query->withAvg('valoraciones', 'puntuación')
                      ->orderBy('valoraciones_avg_puntuación', $request->valoracion);
            }

            // Filtrar por ciudades seleccionadas
            if ($request->filled('ciudades')) {
                $query->whereIn('ciudad_id', $request->ciudades);
            }

            // Filtrar por tipos de comida seleccionados
            if ($request->filled('tiposComida')) {
                $query->whereIn('tipocomida_id', $request->tiposComida);
            }

            // Obtener los restaurantes según los filtros
            $restaurantes = $query->get();

            // Obtener los tipos de comida para el filtro
            $tipos_comida = Tipocomida::all();

            // Obtener las ciudades para el filtro
            $ciudades = Ciudad::all();

            // Si la solicitud es AJAX, devolver solo la lista de restaurantes
            if ($request->ajax()) {
                return view('restaurantes.partials.restaurantes_list', compact('restaurantes'));
            }

            // Enviar datos a la vista
            return view('restaurantes.index', [
                'restaurantes' => $restaurantes,
                'tipos_comida' => $tipos_comida,
                'ciudades' => $ciudades
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar los restaurantes: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario para crear un nuevo restaurante.
     */
    public function create()
    {
        return view('restaurantes.create');
    }

    /**
     * Almacenar un nuevo restaurante.
     */
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

    /**
     * Mostrar el formulario para editar un restaurante.
     */
    public function edit($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        return view('restaurantes.edit', compact('restaurante'));
    }

    /**
     * Actualizar un restaurante.
     */
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

    /**
     * Eliminar un restaurante.
     */
    public function destroy($id)
    {
        try {
            $restaurante = Restaurante::findOrFail($id);

            foreach ($restaurante->fotos as $foto) {
                Storage::delete(str_replace('storage/', 'public/', $foto->ruta_imagen));
            }

            $restaurante->delete();

            return redirect()->back()->with('success', 'Restaurante eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el restaurante: ' . $e->getMessage());
        }
    }

    /**
     * Guardar una valoración para un restaurante.
     */
    public function rate(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'restaurant_id' => 'required|exists:restaurantes,id',
                'rating' => 'required|integer|min:1|max:5'
            ]);

            $valoracion = Valoracion::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'restaurante_id' => $request->restaurant_id
                ],
                [
                    'puntuación' => $request->rating
                ]
            );

            $newRating = DB::table('valoraciones')
                ->where('restaurante_id', $request->restaurant_id)
                ->avg('puntuación');

            DB::commit();

            return response()->json([
                'success' => true,
                'newRating' => round($newRating),
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

    /**
     * Mostrar los detalles de un restaurante.
     */
    public function show(Restaurante $restaurante)
    {
        $valoraciones = $restaurante->valoraciones()->with('user')->get();
        $miValoracion = auth()->check() 
            ? $restaurante->valoraciones()->where('user_id', auth()->id())->first() 
            : null;

        return view('restaurantes.show', compact('restaurante', 'valoraciones', 'miValoracion'));
    }
}
