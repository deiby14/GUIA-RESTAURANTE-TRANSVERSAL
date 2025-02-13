<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests; // Importa el trait para validación
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
        return view('auth.login'); // Asegúrate de tener una vista llamada 'login.blade.php'
    }

    /**
     * Maneja el intento de inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'El nombre de usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
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

        return back()->withErrors([
            'name' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
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