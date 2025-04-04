<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Validator;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Asignacion::with(['alumno', 'empresa'])->get();
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
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'curso_academico' => 'required|string|max:9',
            'fecha_asignacion' => 'required|date',
        ]);

        $existe = Asignacion::where('alumno_id', $request->alumno_id)
            ->where('curso_academico', $request->curso_academico)
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'El alumno ya está asignado en este curso'], 422);
        }

        return Asignacion::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Asignacion::with(['alumno', 'empresa'])->findOrFail($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Asignacion::destroy($id);
        return response()->json(['message' => 'Asignación eliminada correctamente']);
    }
}
