<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('administrar', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user->update($request->all());
        return redirect()->route('administrar')->with('success', 'Usuario actualizado correctamente');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('administrar')->with('success', 'Usuario eliminado correctamente');
    }

    public function createUser()
    {
        return view('users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'rol_id' => 'required|exists:roles,id'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id
        ]);

        return redirect()->route('administrar')->with('success', 'Usuario creado correctamente');
    }
}
