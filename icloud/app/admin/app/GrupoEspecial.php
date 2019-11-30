<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoEspecial extends Model
{
    protected $table = 'App_grupos_especiales';
    protected $primaryKey = 'id';
    protected $grupo = 'grupo';
    protected $descripcion = 'descripcion';
}
