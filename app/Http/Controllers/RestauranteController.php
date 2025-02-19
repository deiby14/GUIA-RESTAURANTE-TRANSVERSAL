<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Tipocomida;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Ciudad;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RestauranteController extends Controller
{
    /**
     * Muestra una lista de restaurantes o los resultados de la búsqueda.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Iniciamos la consulta base para restaurantes
        $query = Restaurante::with(['tipocomida', 'fotos', 'valoraciones', 'ciudad']);

        // Filtrar por nombre si se proporcionó
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtrar por ciudad si se proporcionó
        if ($request->filled('ciudad_id')) {
            $query->where('ciudad_id', $request->ciudad_id);
        } elseif ($request->filled('ciudad')) {
            $query->whereHas('ciudad', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->ciudad . '%');
            });
        }

        // Filtrar por tipo de comida
        if ($request->filled('tipocomida_id')) {
            $query->where('tipocomida_id', $request->tipocomida_id);
        }

        // Ordenar por precio
        if ($request->filled('orden_precio')) {
            $query->orderByRaw("CASE 
                WHEN precio_medio = '$' THEN 1 
                WHEN precio_medio = '$$' THEN 2 
                WHEN precio_medio = '$$$' THEN 3 
                WHEN precio_medio = '$$$$' THEN 4 
            END " . ($request->orden_precio === 'desc' ? 'DESC' : 'ASC'));
        }

        // Ordenar por puntuación
        if ($request->filled('orden_puntuacion')) {
            $query->withAvg('valoraciones', 'puntuación')
                  ->orderBy('valoraciones_avg_puntuación', $request->orden_puntuacion);
        }

        // Obtener los restaurantes según los filtros
        $restaurantes = $query->get();

        // Obtener los tipos de comida y ciudades para los dropdowns
        $tipos_comida = Tipocomida::all();
        $ciudades = Ciudad::all();

        // Si la solicitud es AJAX, solo devolver el HTML de la lista de restaurantes
        if ($request->ajax()) {
            return view('restaurantes.partials.restaurantes_list', compact('restaurantes'));
        }

        // Vista normal con todos los datos
        return view('restaurantes.index', compact('restaurantes', 'tipos_comida', 'ciudades'));
    }

    /**
     * Mostrar formulario para crear un nuevo restaurante
     */
    public function create()
    {
        return view('restaurantes.create'); // Si tienes una vista para crear
    }

    /**
     * Almacenar un nuevo restaurante
     */
    public function store(Request $request)
    {
        try {
            // Validación sin requerir imagen
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'dirección' => 'required|string|max:255',
                'precio_medio' => 'required|string|in:$,$$,$$$,$$$$',
                'descripcion' => 'nullable|string',
                'ciudad_id' => 'required|exists:ciudades,id',
                'tipocomida_id' => 'required|exists:tipocomidas,id',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Ahora es nullable
            ]);

            // Crear el restaurante
            $restaurante = Restaurante::create([
                'nombre' => $validatedData['nombre'],
                'dirección' => $validatedData['dirección'],
                'precio_medio' => $validatedData['precio_medio'],
                'descripcion' => $validatedData['descripcion'],
                'ciudad_id' => $validatedData['ciudad_id'],
                'tipocomida_id' => $validatedData['tipocomida_id'],
            ]);

            // Manejar la imagen solo si se proporciona una
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                
                $directorio = public_path('uploads/restaurantes');
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0755, true);
                }
                
                $imagen->move($directorio, $nombreImagen);
                
                $restaurante->fotos()->create([
                    'ruta_imagen' => 'uploads/restaurantes/' . $nombreImagen
                ]);
            }

            return redirect()->back()->with('success', 'Restaurante creado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error en store:', [
                'mensaje' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al crear el restaurante: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar el formulario para editar un restaurante
     */
    public function edit($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        return view('restaurantes.edit', compact('restaurante')); // Si tienes una vista para editar
    }

    /**
     * Actualizar un restaurante
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

    /**
     * Eliminar un restaurante
     */
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

    /**
     * Guardar una valoración para un restaurante
     */
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
                    'user_id' => Auth::id(),
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

    /**
     * Mostrar los detalles de un restaurante
     */
    public function show(Restaurante $restaurante)
    {
        // Obtener las valoraciones del restaurante con sus usuarios
        $valoraciones = $restaurante->valoraciones()->with('user')->get();
        
        // Si el usuario está autenticado, obtener su valoración
        $miValoracion = Auth::check() 
            ? $restaurante->valoraciones()->where('user_id', Auth::id())->first() 
            : null;

        return view('restaurantes.show', compact('restaurante', 'valoraciones', 'miValoracion'));
    }

    public function filtrar(Request $request)
    {
        $query = Restaurante::with(['ciudad', 'tipocomida']);

        if ($request->nombre) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->ciudad) {
            $query->where('ciudad_id', $request->ciudad);
        }

        if ($request->tipo) {
            $query->where('tipocomida_id', $request->tipo);
        }

        if ($request->precio) {
            $query->where('precio_medio', $request->precio);
        }

        $restaurantes = $query->get();
        return response()->json($restaurantes);
    }
}
