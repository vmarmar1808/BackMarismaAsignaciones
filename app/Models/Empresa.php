<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asignacion;


class Empresa extends Model
{
    protected $fillable = [
        'nombre', 'cif', 'sector', 'direccion', 'telefono', 
        'email', 'representante', 'representante_nif', 
        'tutor_laboral', 'tutor_laboral_nif', 'plazas_disponibles'
    ];

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
