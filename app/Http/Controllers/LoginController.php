<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        // Si la verificación falla, devolvemos JSON con código 401
        return response()->json([
            'error' => 'Credenciales incorrectas',
            'details' => [
                'message' => 'El correo o la contraseña son incorrectos.'
            ]
        ], 401);
    }

    $user = Auth::user();

    // Generar un nuevo token
    $token = $user->createToken('auth_token')->plainTextToken;

    // Devuelve una respuesta JSON con el token y los datos del usuario
    return response()->json([
        'message' => 'Login exitoso',
        'user' => $user->only('id', 'name', 'email', 'role'), 
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}

    // Metodo para cerrar sesión
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Cierre de sesión exitoso. Token invalidado.'
        ]);
    }
}
