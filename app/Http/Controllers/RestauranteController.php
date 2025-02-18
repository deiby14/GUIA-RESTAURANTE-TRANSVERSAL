<?php

namespace App\Http\Controllers;
use App\Models\Restaurante;
use App\Models\Tipocomida;
use App\Models\Foto;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RestauranteController extends Controller
{
    /**
     * Muestra una lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $restaurantes = Restaurante::with(['tipocomida', 'fotos'])->get();
        $userRatings = []; // Aquí deberías cargar las valoraciones del usuario si las necesitas
        
        return view('administrar_restaurantes', compact('restaurantes', 'userRatings'));
    }

    public function create()
    {
        return view('restaurantes.create'); // Si tienes una vista para crear
    }

    public function store(Request $request)
    {
        Log::info('Iniciando creación de restaurante');
        Log::info('Datos recibidos:', $request->all());

        try {
            // 1. Validación
            Log::info('Iniciando validación');
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'dirección' => 'required|string|max:255',
                'precio_medio' => 'required|numeric',
                'tipo_cocina' => 'required|string',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'descripcion' => 'nullable|string',
                'ciudad_id' => 'nullable|exists:ciudades,id'
            ]);
            Log::info('Validación completada');

            // 2. Crear tipo de comida
            Log::info('Creando tipo de comida:', ['tipo' => $request->tipo_cocina]);
            $tipocomida = Tipocomida::firstOrCreate([
                'nombre' => $request->tipo_cocina
            ]);
            Log::info('Tipo de comida creado/encontrado:', ['id' => $tipocomida->id]);

            // 3. Crear restaurante
            Log::info('Creando restaurante');
            $restaurante = new Restaurante();
            $restaurante->nombre = $request->nombre;
            $restaurante->dirección = $request->dirección;
            $restaurante->precio_medio = $request->precio_medio;
            $restaurante->tipocomida_id = $tipocomida->id;
            $restaurante->descripcion = $request->descripcion;
            $restaurante->ciudad_id = $request->ciudad_id ?? 1;
            
            $saved = $restaurante->save();
            Log::info('Restaurante guardado:', [
                'success' => $saved,
                'id' => $restaurante->id,
                'datos' => $restaurante->toArray()
            ]);

            // 4. Procesar imagen
            if ($request->hasFile('imagen')) {
                Log::info('Procesando imagen');
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                
                Log::info('Creando directorio si no existe');
                Storage::makeDirectory('public/restaurantes');
                
                Log::info('Guardando imagen', ['nombre' => $nombreImagen]);
                $path = $imagen->storeAs('public/restaurantes', $nombreImagen);
                Log::info('Imagen guardada en:', ['path' => $path]);

                // Crear registro de foto
                Log::info('Creando registro de foto');
                $foto = $restaurante->fotos()->create([
                    'ruta_imagen' => 'storage/restaurantes/' . $nombreImagen
                ]);
                Log::info('Foto creada:', ['id' => $foto->id]);
            }

            Log::info('Restaurante creado exitosamente');
            return redirect()->back()->with('success', 'Restaurante creado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación:', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Error al crear restaurante:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
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
        $request->validate([
            'nombre' => 'required',
            'dirección' => 'required',
            'precio_medio' => 'required|numeric',
            'tipo_cocina' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $restaurante = Restaurante::findOrFail($id);
            $tipocomida = Tipocomida::firstOrCreate(['nombre' => $request->tipo_cocina]);

            $restaurante->nombre = $request->nombre;
            $restaurante->dirección = $request->dirección;
            $restaurante->precio_medio = $request->precio_medio;
            $restaurante->tipocomida_id = $tipocomida->id;

            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($restaurante->fotos->isNotEmpty()) {
                    $rutaAnterior = str_replace('storage/', 'public/', $restaurante->fotos->first()->ruta_imagen);
                    Storage::delete($rutaAnterior);
                    $restaurante->fotos()->delete();
                }

                // Guardar nueva imagen
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->storeAs('public/restaurantes', $nombreImagen);
                
                $restaurante->fotos()->create([
                    'ruta_imagen' => 'storage/restaurantes/' . $nombreImagen
                ]);
            }

            $restaurante->save();
            return redirect()->back()->with('success', 'Restaurante actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el restaurante: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $restaurante = Restaurante::findOrFail($id);
            
            // Eliminar fotos asociadas
            if ($restaurante->fotos->isNotEmpty()) {
                foreach ($restaurante->fotos as $foto) {
                    $rutaImagen = str_replace('storage/', 'public/', $foto->ruta_imagen);
                    Storage::delete($rutaImagen);
                }
                $restaurante->fotos()->delete();
            }

            // Eliminar valoraciones asociadas
            $restaurante->valoraciones()->delete();
            
            // Eliminar el restaurante
            $restaurante->delete();

            return redirect()->back()->with('success', 'Restaurante eliminado exitosamente');
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