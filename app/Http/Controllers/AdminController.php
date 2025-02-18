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
        $users = User::with('role')->get();
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
        try {
            $user = User::findOrFail($id);
            
            // Proteger al admin principal
            if ($user->rol_id === 1 && $user->email === 'admin@gmail.com') {
                return back()->with('error', 'No se puede eliminar al administrador principal');
            }

            // Eliminar valoraciones
            $user->valoraciones()->delete();
            
            // Eliminar usuario
            $user->delete();

            return redirect()->route('administrar')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
