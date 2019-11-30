<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VWGpoAdminUsuario extends Model
{
    protected $table = 'vwGpoAdminUsuarios';
    protected $primaryKey = 'id';
    protected $usuario_id = 'usuario_id';
    protected $grupo_id = 'grupo_id';
    protected $grupo = 'grupo';
    protected $nombre = 'nombre';
}
