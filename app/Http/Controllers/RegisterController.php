<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Valida los datos recibidos en el request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // La validación de confirmación
            'role' => 'in:alumno,profesor'
        ]);

        // Si la validación falla, devuelve los errores y un código 422
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Datos de entrada incorrectos',
                'details' => $validator->errors()
            ], 422); // Error 422 para validaciones fallidas
        }

        // Si pasa la validación, crea el usuario
        $user = User::create($request->only(['name', 'email', 'password', 'role']));


        // Respuesta exitosa con código 201
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user
        ], 201);
    }
}



