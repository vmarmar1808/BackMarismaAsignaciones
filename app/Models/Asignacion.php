<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Empresa;

class Asignacion extends Model
{
    // Atributos que se pueden asignar masivamente
    protected $fillable = ['alumno_id', 'empresa_id', 'curso_academico', 'fecha_asignacion'];

    // Relación con el modelo Alumno (una asignación pertenece a un alumno)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // Relación con el modelo Empresa (una asignación pertenece a una empresa)
    public function empresa()    
    {
        return $this->belongsTo(Empresa::class);
    }
}
