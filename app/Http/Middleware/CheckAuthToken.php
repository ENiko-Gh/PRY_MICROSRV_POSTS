<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = null;
        // Detectar si es petición API (Postman) o Web (navegador)
        $isApi = $request->is('api/*') || $request->expectsJson() || $request->bearerToken();

        if ($isApi) {
            $token = $request->bearerToken();
        } else {
            $token = Session::get('token');
        }

        if (!$token) {
            if ($isApi) {
                return response()->json(['message' => 'Token no proporcionado.'], 401);
            } else {
                return redirect()->route('login')->with('error', 'Sesión expirada. Inicie sesión.');
            }
        }

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->timeout(5)
                ->get('http://192.168.0.203:8000/api/validate-token');

            if ($response->failed()) {
                if (!$isApi) {
                    Session::forget('token');
                }
                if ($isApi) {
                    return response()->json(['message' => 'Token inválido o expirado.'], 401);
                } else {
                    return redirect()->route('login')->with('error', 'Sesión inválida. Inicie sesión nuevamente.');
                }
            }
        } catch (\Exception $e) {
            if (!$isApi) {
                Session::forget('token');
            }
            if ($isApi) {
                return response()->json(['message' => 'Error de conexión con autenticación.'], 500);
            } else {
                return redirect()->route('login')->with('error', 'Error de conexión con el servicio de autenticación.');
            }
        }

        return $next($request);
    }
}
