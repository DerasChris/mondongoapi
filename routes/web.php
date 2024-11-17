<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\NotificationController;
use App\Models\Historial;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//RUTAS MODELO TRABAJADORES
Route::get('/trabajadores', [TrabajadoresController::class, 'index']);
Route::get('/trabajadores/{id}', [TrabajadoresController::class, 'show']);
Route::post('/trabajadores/add-trabajador', [TrabajadoresController::class, 'insertarDocumento']);
Route::patch('/trabajadores/{id}', [TrabajadoresController::class, 'actualizarDocumento']);



//RUTAS MODELO TRABAJADORES
Route::get('/solicitudes', [SolicitudController::class, 'index']);
Route::get('/solicitudes-por-usuario/{id}', [SolicitudController::class, 'show']);
Route::post('/solicitudes/add-solicitud', [SolicitudController::class, 'insertarDocumento']);
Route::patch('/solicitudes/{id}/edit', [SolicitudController::class, 'update']);
Route::get('/solicitudes-por-trabajador/{id}', [SolicitudController::class, 'showTrabajador']);



//RUTAS MODELO HISTORIAL

Route::get('/historial', [HistorialController::class, 'index']);
Route::get('/historial-por-usuario/{id}', [HistorialController::class, 'show']);
Route::post('/historial/add-historial', [HistorialController::class, 'insertarDocumento']);


//RUTAS MODELO USUARIO

Route::get('/usuario/{id}', [UsuarioController::class, 'show']);
Route::get('/usuario-trabajador', [UsuarioController::class, 'index']);
Route::post('/usuario-add', [UsuarioController::class, 'insertarDocumento']);

//Ruta categorias
Route::get('/categorias', [CategoriasController::class, 'index']);

//Ruta categorias
Route::prefix('api')->group(function () {
    Route::post('/send-topic-notification', [NotificationController::class, 'sendTopicNotification'])
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});
