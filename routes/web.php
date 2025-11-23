<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostWebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas: login y logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta raíz: redirige según si hay token en sesión
Route::get('/', function () {
    if (session()->has('token')) {
        return redirect()->route('posts.index');
    }
    return redirect()->route('login');
});

// Rutas protegidas: requieren token válido (middleware 'auth.micro')
Route::middleware(['auth.micro'])->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostWebController::class, 'index'])->name('posts.index');
        Route::get('/create', [PostWebController::class, 'create'])->name('posts.create');
        Route::post('/', [PostWebController::class, 'store'])->name('posts.store');
        Route::get('/{id}/edit', [PostWebController::class, 'edit'])->name('posts.edit');
        Route::put('/{id}', [PostWebController::class, 'update'])->name('posts.update');
        Route::delete('/{id}', [PostWebController::class, 'destroy'])->name('posts.destroy');
    });
});
