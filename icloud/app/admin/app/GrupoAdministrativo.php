<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoAdministrativo extends Model
{
   protected $table = 'App_grupos_administrativos';
   protected $primaryKey = 'id';
   protected $grupo = 'grupo';
   protected $descripcion = 'descripcion';
}
