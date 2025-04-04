<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asignacion;

class Alumno extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'dni', 'telefono', 'email', 'nota_curso'
    ];

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
