<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante; // Asegúrate de importar el modelo Restaurant si existe

class RestaurantController extends Controller
{
    /**
     * Muestra la lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener todos los restaurantes desde la base de datos
        $restaurants = Restaurante::all(); // Si no usas un modelo, puedes omitir esta línea

        // Pasar los restaurantes a la vista
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Muestra un restaurante específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Obtener un restaurante por su ID
        $restaurant = Restaurante::findOrFail($id);

        // Mostrar la vista del restaurante
        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Muestra el formulario para crear un nuevo restaurante.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Almacena un nuevo restaurante en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos enviados
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Crear un nuevo restaurante
        Restaurante::create($request->all());

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('restaurants.index')->with('success', 'Restaurante creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un restaurante.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Obtener el restaurante por su ID
        $restaurant = Restaurante::findOrFail($id);

        // Mostrar el formulario de edición
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Actualiza un restaurante en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Encontrar el restaurante y actualizarlo
        $restaurant = Restaurante::findOrFail($id);
        $restaurant->update($request->all());

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('restaurants.index')->with('success', 'Restaurante actualizado exitosamente.');
    }

    /**
     * Elimina un restaurante de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Encontrar y eliminar el restaurante
        $restaurant = Restaurante::findOrFail($id);
        $restaurant->delete();

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('restaurants.index')->with('success', 'Restaurante eliminado exitosamente.');
    }
}