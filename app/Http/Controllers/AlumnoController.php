<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Validator;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Alumno::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Alumno::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->update($request->all());
        return $alumno;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Alumno::destroy($id);
        return response()->json(['message' => 'Alumno eliminado correctamente']);
    }
}
