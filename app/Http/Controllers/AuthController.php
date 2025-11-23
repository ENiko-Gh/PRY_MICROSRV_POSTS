<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // URL del Microservicio de Autenticación
    // Nota: Es mejor usar env() aquí si fuera un proyecto real, pero respeto la estructura.
    private $authApi = 'http://192.168.0.203:8000/api';

    /**
     * Muestra el formulario de login.
     * * CORRECCIÓN: Evitamos la redirección a posts.index aquí para romper el ciclo.
     * Si el usuario llega a /login, es porque quiere loguearse, incluso si tiene un token antiguo.
     */
    public function showLoginForm()
    {
        // === ARREGLO CRÍTICO ===
        // Si el usuario ya tiene un token y quiere ir a /login, 
        // asumimos que quiere cerrar la sesión o cambiar de usuario. 
        // No redirigimos automáticamente a posts para evitar el ciclo infinito 
        // si el token resulta ser inválido en el PostWebController.

        // OPCIÓN 1 (Recomendada): Mostrar siempre el formulario
        return view('auth.login');

        // OPCIÓN 2 (Si prefieres la redirección, pero es menos robusta):
        /* if (Session::has('token') && $this->isTokenValid(Session::get('token'))) {
            return redirect()->route('posts.index');
        }
        return view('auth.login');
        */
    }

    // Procesa el login y guarda el token en la sesión
    public function login(Request $request)
    {
        // 1. Validar las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // 2. Llamar al Microservicio de Autenticación (MS-Auth)
            $response = Http::post("{$this->authApi}/login", [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // 3. Verificar si el login fue exitoso
            if ($response->successful() && $response->json('token')) {
                $token = $response->json('token');

                // 4. ¡GUARDA EL TOKEN EN LA SESIÓN DEL MICROSERVICIO DE POSTS!
                Session::put('token', $token);

                return redirect()->route('posts.index')->with('success', 'Sesión iniciada correctamente.');
            }

            // Fallo en la autenticación (ej. 401 Unauthorized del MS-Auth)
            $message = $response->json('message') ?? 'Credenciales inválidas o error de conexión al MS-Auth.';
            return back()->withErrors(['login' => $message]);
        } catch (\Exception $e) {
            // Fallo de red (Guzzle)
            return back()->withErrors(['login' => 'Error de conexión al Microservicio de Autenticación.']);
        }
    }

    /**
     * Cierra la sesión y purga todos los datos.
     */
    public function logout(Request $request)
    {
        // 1. Eliminamos el token de la sesión.
        Session::forget('token');

        // 2. Eliminamos TODOS los datos de sesión y regeneramos el token de CSRF.
        // Esto garantiza que no quede NADA persistente del token anterior.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Purga adicional de las variables de sesión.
        Session::flush();

        // 4. Redirigimos a la página de login.
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
