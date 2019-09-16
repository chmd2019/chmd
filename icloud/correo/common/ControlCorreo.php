<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/DBManager.php";

class ControlCorreo
{
  var $con;
  public function __construct(){
      $this->con = new DBManager();
  }

/********************************* COnsulta de Permisos************************************/
//Permisos Diarias
public function PermisosDiarios(){
  $connection = $this->con->conectar1();
  if ($connection) {
      $sql = "SELECT * from Ventana_Permisos  vp
      LEFT JOIN usuarios vs on vp.idusuario=vs.id
      where vp.tipo_permiso=1";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
  }
}
//Permisos Viajes o Temporales
public function PermisosTemporales(){
  $connection = $this->con->conectar1();
  if ($connection) {
      $sql = "SELECT * from Ventana_Permisos  vp
      LEFT JOIN usuarios vs on vp.idusuario=vs.id
      where vp.tipo_permiso=1";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
  }
}
//Permisos Permanentes
public function PermisosPermanentes(){
  $connection = $this->con->conectar1();
  if ($connection) {
      $sql = "SELECT * from Ventana_Permisos  vp
      LEFT JOIN usuarios vs on vp.idusuario=vs.id
      where vp.tipo_permiso=1";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
  }
}


/////////////////////////////////////////////del dia
/*
function diario()
{
  if($this->con->conectar1()==true){
    mysql_set_charset('utf8');
    return mysql_query("select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,vp.notificacion3,vp.mensaje from Ventana_Permiso  vp
    LEFT JOIN Ventana_user vs on vp.idusuario=vs.id ");
  }
}
*/


function notificacion_dia_solicitud($id)
{
  if($this->con->conectar1()==true)
  {
    return mysql_query("update Ventana_Permiso set notificacion1=1 where id=".$id);
  }
}

function notificacion_dia_autorizdo($id)
{
  if($this->con->conectar1()==true)
  {
    return mysql_query("update Ventana_Permiso set notificacion2=1 where id=".$id);
  }
}


function notificacion_dia_declinado($id)
{
  if($this->con->conectar1()==true)
  {
    return mysql_query("update Ventana_Permiso set notificacion3=1 where id=".$id);
  }
}


/////////////////////////////////////////////////fin del dia

//////////////////////////viaje
/*
function Viaje()
{
  if($this->con->conectar1()==true){
    mysql_set_charset('utf8');
    return mysql_query("select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,vp.notificacion3,vp.mensaje from Ventana_Permiso  vp
    LEFT JOIN Ventana_user vs on vp.idusuario=vs.id");
  }
}
*/


function notificacion_viaje_solicitud($id)
{
  if($this->con->conectar1()==true)
  {

    return mysql_query("update Ventana_Permiso set notificacion1=1 where id=".$id);
  }
}

function notificacion_viaje_autorizdo($id)
{
  if($this->con->conectar1()==true)
  {

    return mysql_query("update Ventana_Permiso set notificacion2=1 where id=".$id);
  }
}


function notificacion_viaje_declinado($id)
{
  if($this->con->conectar1()==true)
  {

    return mysql_query("update Ventana_Permiso set notificacion3=1 where id=".$id);
  }
}


////////////////////////fin de viaje
/////////////////////////////// permanente


function notificacion_permanente_solicitud($id)
{
  if($this->con->conectar1()==true)
  {

    return mysql_query("update Ventana_Permiso set notificacion1=1 where id=".$id);
  }
}

function notificacion_permanente_autorizdo($id)
{
  if($this->con->conectar1()==true)
  {

    return mysql_query("update Ventana_Permiso set notificacion2=1 where id=".$id);
  }
}


function notificacion_permanente_declinado($id)
{
  if($this->con->conectar1()==true)
  {

    return mysql_query("update Ventana_Permiso set notificacion3=1 where id=".$id);
  }
}
}




/*permanente
select * from Ventana_Permisos  vp
LEFT JOIN usuarios vs on vp.idusuario=vs.id
where vp.tipo_permiso=3

/*diario
select * from Ventana_Permisos  vp
LEFT JOIN usuarios vs on vp.idusuario=vs.id
where vp.tipo_permiso=1

/*viaje o temporal
select * from Ventana_Permisos  vp
LEFT JOIN usuarios vs on vp.idusuario=vs.id
where vp.tipo_permiso=2
*/
?>
