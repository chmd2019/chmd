<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
     protected $table = 'alumnoschmd';
   	 protected $primaryKey = 'id';
   	 protected $nombre = 'nombre';
   	 protected $grupo = 'grupo';
   	 protected $grado = 'grado';
   	 protected $sexo = 'sexo';
   	 protected $idcursar = 'idcursar';
   	 protected $foto = 'foto';
   	 protected $codigo = 'codigo';
   	 protected $nivel = 'nivel';
   	 protected $fecha = 'fecha';
   	 protected $correo = 'correo';
   	 protected $idgrado_acursar = 'idgrado_acursar';
   	 protected $estatus = 'estatus';
   	 protected $id_nivel = 'id_nivel';
}
