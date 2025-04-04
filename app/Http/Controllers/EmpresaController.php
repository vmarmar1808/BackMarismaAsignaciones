<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Empresa::all();   
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json($empresa);
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
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return $empresa;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Empresa::destroy($id);
        return response()->json(['message' => 'Empresa eliminada correctamente']);
    }
}
   