<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asignacion;


class Empresa extends Model
{
    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre', 'cif', 'sector', 'direccion', 'telefono', 
        'email', 'representante', 'representante_nif', 
        'tutor_laboral', 'tutor_laboral_nif', 'plazas_disponibles', 'ubicacion'
    ];

    // Relación con el modelo Asignacion de uno a muchos (una empresa puede tener varias asignaciones)
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
