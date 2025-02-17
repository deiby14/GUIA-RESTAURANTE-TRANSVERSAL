<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class LoginController extends Controller
{
    use ValidatesRequests; // Usa el trait para validación

    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    /**
     * Maneja el intento de inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $this->validate($request, [
            'name' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'El nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            // Obtener el rol del usuario
            $role = Role::find(Auth::user()->rol_id);
            
            // Redirigir según el nombre del rol
            if ($role && $role->name === 'admin') {
                return redirect()->route('inicio.admin');
            }

            return redirect()->intended('home');
        }

        // Intentar autenticar al usuario
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password], $request->filled('remember'))) {
            // Autenticación correcta, redirigir al usuario a la vista home.blade.php
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'name' => 'El usuario o contraseña no coinciden en nuestros registros.',
        ])->withInput($request->only('name'));
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Cerrar sesión
        Auth::logout();

        // Limpiar los datos de la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de inicio
        return redirect('/');
    }
}