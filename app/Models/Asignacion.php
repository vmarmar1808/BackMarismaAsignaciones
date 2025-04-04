<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Empresa;

class Asignacion extends Model
{
    protected $fillable = ['alumno_id', 'empresa_id', 'curso_academico', 'fecha_asignacion'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function empresa()    
    {
        return $this->belongsTo(Empresa::class);
    }
}
