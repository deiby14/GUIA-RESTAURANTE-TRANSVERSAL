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
     * Muestra una lista de restaurantes o los resultados de la búsqueda.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Si hay parámetros de búsqueda, los aplicamos
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

        // Obtener los restaurantes según los filtros
        $restaurantes = $query->get();

        // Enviar los resultados de la búsqueda a la vista
        return view('restaurantes.index', compact('restaurantes'));
    }

    public function create()
    {
        return view('restaurantes.create'); // Si tienes una vista para crear
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'precio_medio' => 'required|numeric',
            'tipo_cocina' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Buscar o crear el tipo de comida
            $tipocomida = Tipocomida::firstOrCreate(['nombre' => $request->tipo_cocina]);

            // Crear el restaurante
            $restaurante = new Restaurante();
            $restaurante->nombre = $request->nombre;
            $restaurante->direccion = $request->direccion;
            $restaurante->precio_medio = $request->precio_medio;
            $restaurante->tipocomida_id = $tipocomida->id;
            $restaurante->save();

            // Manejar la imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = $imagen->storeAs('public/restaurantes', $nombreImagen);
                
                // Crear el registro de la foto
                $restaurante->fotos()->create([
                    'ruta_imagen' => 'storage/restaurantes/' . $nombreImagen
                ]);
            }

            return redirect()->back()->with('success', 'Restaurante creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el restaurante: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        return view('restaurantes.edit', compact('restaurante')); // Si tienes una vista para editar
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'precio_medio' => 'required|numeric',
            'tipo_cocina' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $restaurante = Restaurante::findOrFail($id);
        $restaurante->nombre = $request->nombre;
        $restaurante->direccion = $request->direccion;
        $restaurante->telefono = $request->telefono;
        $restaurante->precio_medio = $request->precio_medio;
        $restaurante->tipo_cocina = $request->tipo_cocina;

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($restaurante->fotos && $restaurante->fotos->isNotEmpty()) {
                Storage::disk('public')->delete($restaurante->fotos->first()->ruta_imagen);
                $restaurante->fotos()->delete(); // Eliminar las fotos anteriores
            }
            $path = $request->file('imagen')->store('restaurantes', 'public');
            $restaurante->fotos()->create(['ruta_imagen' => $path]);
        }

        $restaurante->save();

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante actualizado correctamente');
    }

    public function destroy($id)
    {
        $restaurante = Restaurante::findOrFail($id);

        // Eliminar las fotos asociadas
        if ($restaurante->fotos && $restaurante->fotos->isNotEmpty()) {
            Storage::disk('public')->delete($restaurante->fotos->first()->ruta_imagen);
            $restaurante->fotos()->delete();
        }

        $restaurante->delete();

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante eliminado correctamente');
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
