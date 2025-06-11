<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use App\Models\Alumno;

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

    // Comprobar si el alumno ya tiene una asignación en el mismo curso
    $existe = Asignacion::where('alumno_id', $request->alumno_id)
        ->where('curso_academico', $request->curso_academico)
        ->exists();

    if ($existe) {
        return response()->json(['message' => 'El alumno ya está asignado en este curso'], 422);
    }

    // Comprobar si la empresa tiene plazas disponibles
    $empresa = Empresa::findOrFail($request->empresa_id);
    if ($empresa->plazas_disponibles <= 0) {
        return response()->json(['message' => 'La empresa no tiene plazas disponibles'], 422);
    }

    // Crear la asignación
    $asignacion = Asignacion::create($request->all());

    // Reducir las plazas disponibles de la empresa
    $empresa->plazas_disponibles -= 1;
    $empresa->save();

    return $asignacion;
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
        $asignacion = Asignacion::findOrFail($id);

        // Obtener la empresa y liberar una plaza
        $empresa = $asignacion->empresa;
        if ($empresa) {
            $empresa->plazas_disponibles += 1;
            $empresa->save();
        }

        $asignacion->delete();

        return response()->json(['message' => 'Asignación eliminada correctamente']);
    }

    public function byAlumnoEmail(string $email)
{
    // Validación y normalización del email
    $email = strtolower(trim($email));
    
    if (empty($email)) {
        return response()->json(['message' => 'El email no puede estar vacío'], 400);
    }

    // Depuración: Verificar si el alumno existe
    $alumno = Alumno::where('email', $email)->first();
    
    if (!$alumno) {
        return response()->json([
            'message' => 'No se encontró ningún alumno con el email: '.$email,
            'debug' => ['email_buscado' => $email]
        ], 404);
    }

    // Consulta mejorada con eager loading y verificación
    $asignaciones = Asignacion::with(['alumno', 'empresa'])
        ->where('alumno_id', $alumno->id)
        ->get();

    if ($asignaciones->isEmpty()) {
        return response()->json([
            'message' => 'El alumno existe pero no tiene asignaciones',
            'alumno_id' => $alumno->id,
            'email' => $email
        ], 404);
    }

    return $asignaciones;
}

}
