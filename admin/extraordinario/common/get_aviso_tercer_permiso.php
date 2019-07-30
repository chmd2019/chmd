<?php
include '../../sesion_admin.php';
require '../../conexion.php';

$id_alumno = $_GET['id_alumno'];
$idcursar = $_GET['idcursar'];
$corte_semestral = intval(date("m"));
$anio = date("Y");

if ($conexion) {
  $sql = "SELECT COUNT(*) FROM Ventana_permisos_alumnos WHERE id_alumno = '$id_alumno' && anio_creacion = '$anio'";
  mysqli_set_charset($conexion, 'utf8');
  $control = mysqli_query($conexion, $sql);
  $respuesta = "";
  if ($idcursar >= 0 && $idcursar <= 13 ) {
      $num_permisos_este_anio = mysqli_fetch_array($control);
      $num_permisos_este_anio = $num_permisos_este_anio[0];
      $respuesta = $num_permisos_este_anio >= 3 ? true : false;
  }
  elseif ($idcursar >= 14 && $idcursar <= 17 ) {
      $corte_semestral = intval(date("m")) <= 6 ? "-I" : "-II" ;
      $anio = "$anio"."$corte_semestral";
      $num_permisos_este_anio = mysqli_fetch_array($control);
      $num_permisos_este_anio = $num_permisos_este_anio[0];
      $respuesta = $num_permisos_este_anio >= 3 ? true : false;

  }
}

echo json_encode($respuesta);
