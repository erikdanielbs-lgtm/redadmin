<?php

use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SegmentoController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\RedController;



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('inicio');


    Route::resource('segmentos', SegmentoController::class);
    Route::resource('dependencias', DependenciaController::class);
    Route::resource('dispositivos', DispositivoController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('redes', RedController::class);
    Route::resource('roles', RolController::class);
    // Route::resource('permisos', PermisoController::class);

    Route::get('registros/ocupadas', [RegistroController::class, 'ocupadas'])->name('registros.ocupadas');
    Route::get('registros/disponibles', [RegistroController::class, 'disponibles'])->name('registros.disponibles');
    Route::get('registros/eliminadas', [RegistroController::class, 'eliminadas'])->name('registros.eliminadas');

    Route::get('registros/buscar', [RegistroController::class, 'buscar'])->name('registros.buscar');

    Route::get('registros/usar', [RegistroController::class, 'usar'])->name('registros.usar');
    Route::get('registros/eliminar', [RegistroController::class, 'eliminar'])->name('registros.eliminar');

    Route::get('registros/modificar', function () {
        return view('registros.modificar');
    })->name('registros.modificar');

    Route::post('registros/modificar', [RegistroController::class, 'modificar'])->name('registros.modificar.post');

Route::get('registros/eliminar', function() {
    return view('registros.eliminar');
})->name('registros.eliminar');

Route::post('registros/eliminar', [RegistroController::class, 'eliminar'])->name('registros.eliminar.post');
Route::delete('registros/{id}/destroy', [RegistroController::class, 'destroy'])->name('registros.destroy');

Route::get('registros/eliminadas', [RegistroController::class, 'eliminadas'])->name('registros.eliminadas');

Route::post('registros/{id}/restore', [RegistroController::class, 'restore'])->name('registros.restore');
Route::delete('registros/{id}/forzar', [RegistroController::class, 'forceDestroy'])->name('registros.forceDestroy');

    Route::resource('registros', RegistroController::class)->except(['index']);
});