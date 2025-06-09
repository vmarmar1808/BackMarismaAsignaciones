<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsignacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

// Rutas públicas: No requieren autenticación ni verificación de rol
// Login, Logout y Register
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// Rutas protegidas por autenticación (auth:sanctum)
// Estas rutas requieren que el usuario esté logueado con un token válido.
Route::middleware('auth:sanctum')->group(function () {

    // Rutas para Alumnos (GET individual): Accesible por 'alumno' y 'profesor'
    Route::get('/alumnos/{id}', [AlumnoController::class, 'show'])->middleware('role:alumno,profesor');

    // Grupo de rutas para el rol 'profesor'
    // Todo lo demás dentro de este grupo solo será accesible si el usuario tiene el rol 'profesor'.
    Route::middleware('role:profesor')->group(function () {

        // Rutas para CRUD empresas
        Route::get('/empresas', [EmpresaController::class, 'index']);
        Route::post('/empresas', [EmpresaController::class, 'store']);
        Route::get('/empresas/{id}', [EmpresaController::class, 'show']);
        Route::put('/empresas/{id}', [EmpresaController::class, 'update']);
        Route::delete('/empresas/{id}', [EmpresaController::class, 'destroy']);

        // Rutas para CRUD alumnos (excepto el GET individual ya manejado arriba)
        Route::get('/alumnos', [AlumnoController::class, 'index']);
        Route::post('/alumnos', [AlumnoController::class, 'store']);
        Route::put('/alumnos/{id}', [AlumnoController::class, 'update']);
        Route::delete('/alumnos/{id}', [AlumnoController::class, 'destroy']);

        // Rutas para CRUD asignaciones
        Route::get('/asignaciones', [AsignacionController::class, 'index']);
        Route::post('/asignaciones', [AsignacionController::class, 'store']);
        Route::put('/asignaciones/{id}', [AsignacionController::class, 'update']);
        Route::get('/asignaciones/{id}', [AsignacionController::class, 'show']);
        Route::delete('/asignaciones/{id}', [AsignacionController::class, 'destroy']);

        // Rutas para modificar o eliminar un usuario
        Route::get('/usuarios', [UserController::class, 'index']);
        Route::put('/usuarios/{id}', [UserController::class, 'update']);
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);
    });
});