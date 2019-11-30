<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
   protected $table = 'App_circulares';
   protected $primaryKey = 'id';
   protected $titulo = 'titulo';
   protected $contenido = 'contenido';
   protected $fecha = 'fecha';
   protected $descripcion = 'descripcion';
   protected $estatus = 'estatus';
   protected $adjunto = 'adjunto';
   protected $ciclo_escolar_id = 'ciclo_escolar_id';
   protected $fecha_programada = 'fecha_programada';
   protected $status_envio = 'status_envio';
   protected $envio_todos = 'envio_todos';
   protected $slug = 'slug';
   
}
