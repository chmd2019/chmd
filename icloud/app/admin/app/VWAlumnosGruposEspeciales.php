<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VWAlumnosGruposEspeciales extends Model
{
    protected $table = 'vwAlumnosGruposEspeciales';
    protected $primaryKey = 'id';
    protected $grupoEspecial = 'grupoEspecial';
    protected $alumno_id = 'alumno_id';
    protected $nombre = 'nombre';
    protected $idFamilia = 'idfamilia';
    protected $grado = 'grado';
}
