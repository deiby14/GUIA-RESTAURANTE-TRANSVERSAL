<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('administrar', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol_id' => 'required|exists:roles,id'
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol_id' => $request->rol_id
            ]);

            return redirect()->route('administrar')->with('success', 'Usuario creado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('administrar')->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user->update($request->only(['name', 'email', 'rol_id']));
        
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('administrar')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        Log::info('Intentando eliminar usuario con ID: ' . $id); // Para debugging

        try {
            $user = User::findOrFail($id);
            
            // Verificar si es el admin principal
            if ($user->rol_id === 1 && $user->name === 'Admin') {
                return redirect()->route('administrar')
                    ->with('error', 'No se puede eliminar al administrador principal');
            }

            // Eliminar relaciones primero
            $user->valoraciones()->delete();
            $user->favorites()->detach();
            
            // Eliminar el usuario
            $deleted = $user->delete();

            if ($deleted) {
                return redirect()->route('administrar')
                    ->with('success', 'Usuario eliminado correctamente');
            } else {
                return redirect()->route('administrar')
                    ->with('error', 'No se pudo eliminar el usuario');
            }

        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario: ' . $e->getMessage()); // Para debugging
            return redirect()->route('administrar')
                ->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
