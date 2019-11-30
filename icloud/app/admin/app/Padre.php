<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    protected $table = 'App_papa';
    protected $primaryKey = 'id';
    protected $nombre = 'nombre';
    protected $apellidos = 'apellidos';
    protected $rol = 'Rol';
    protected $correo = 'correo';
    protected $familia = 'Familia';
}
