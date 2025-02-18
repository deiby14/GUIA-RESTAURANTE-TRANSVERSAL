<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests; // Importa el trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ValidatesRequests; // Usa el trait

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
        // Validar los datos del formulario de login
        $this->validate($request, [
            'email' => 'required|email',
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
            
            if ($role && $role->name === 'admin') {
                return redirect()->route('inicio.admin');
            }

            return redirect()->intended('home');
        }

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password], $request->filled('remember'))) {
            // Autenticación correcta, redirigir al usuario a la vista home.blade.php
            return redirect()->intended(route('home'));
        }

        // Autenticación fallida, volver al formulario de inicio de sesión con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son correctas.',
        ])->withInput($request->only('email', 'remember'));
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
        return redirect()->route('home');
    }
}