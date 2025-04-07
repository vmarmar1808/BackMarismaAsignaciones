<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Validator;

class AlumnoController extends Controller
{
    //Mostrar todos los alumnos
    public function index()
    {
        return Alumno::all();
    }

    // Crear un nuevo alumno
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|size:9|unique:alumnos,dni',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'nota_curso' => 'nullable|numeric|min:0|max:10',
        ]);

        return Alumno::create($request->all());
    }

    // Mostrar un alumno específico por su ID
    public function show(string $id)
    {
        return Alumno::findOrFail($id);
    }


    // Actualizar un alumno
    public function update(Request $request, string $id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->update($request->all());
        return $alumno;
    }

    // Eliminar un alumno
    public function destroy(string $id)
    {
        Alumno::destroy($id);
        return response()->json(['message' => 'Alumno eliminado correctamente']);
    }
}
