<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Proteger todas las rutas de posts con el middleware de autenticación
Route::middleware('auth.micro')->group(function () {
    Route::apiResource('posts', PostController::class);
});
