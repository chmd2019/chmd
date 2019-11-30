<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoEspecialAlumno extends Model
{
    protected $table = 'App_grupos_especiales_alumnos';
    protected $primaryKey = 'id';
    protected $alumno_id = 'alumno_id';
    protected $grupo_id = 'grupo_id';
}
