<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Validator;

class AsignacionController extends Controller
{
    // Mostrar todas las asignaciones
    public function index()
    {
        return Asignacion::with(['alumno', 'empresa'])->get();
    }

   

    // Crear una nueva asignación
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

    // Mostrar una asignación específica por su ID
    public function show(string $id)
    {
        return Asignacion::with(['alumno', 'empresa'])->findOrFail($id);
    }

    // Actualizar una asignación
    public function update(Request $request, string $id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->update($request->all());
        return $asignacion;
    }

    // Eliminar una asignación
    public function destroy(string $id)
    {
        Asignacion::destroy($id);
        return response()->json(['message' => 'Asignación eliminada correctamente']);
    }
}
