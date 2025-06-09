<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asignacion;

class Alumno extends Model
{
    //Atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre', 'apellido', 'dni', 'telefono', 'email', 'nota_curso'
    ];

    // Relación con el modelo Asignacion de uno a muchos (una por curso academico controlado en el controller)
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
