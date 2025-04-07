<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    //Mostrar todas las empresas
    public function index()
    {
        return Empresa::all();   
    }

    // Crear una nueva empresa
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cif' => 'required|string|size:9|unique:empresas,cif',
            'sector' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'representante' => 'required|string|max:100',
            'representante_nif' => 'required|string|size:9',
            'tutor_laboral' => 'required|string|max:100',
            'tutor_laboral_nif' => 'required|string|size:9',
            'plazas_disponibles' => 'required|integer|min:0',
        ]);

        return Empresa::create($request->all());
    }

    // Mostrar una empresa específica por su ID
    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json($empresa);
    }

    // Actualizar una empresa
    public function update(Request $request, string $id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return $empresa;
    }

    // Eliminar una empresa
    public function destroy($id)
    {
        Empresa::destroy($id);
        return response()->json(['message' => 'Empresa eliminada correctamente']);
    }
}
   