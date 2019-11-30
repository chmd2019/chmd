<?php
include '../../sesion_admin.php';
require '../../conexion.php';

$id_alumno = $_GET['id_alumno'];
$idcursar = $_GET['idcursar'];
$corte_semestral = intval(date("m"));

if ($conexion) {
  $respuesta = "";

  if ($idcursar >= 5 && $idcursar <= 13 ) {
    //solicita el año.
    $sql = "SELECT ciclo FROM Ciclo_escolar WHERE estatus = TRUE;";
    $anio =  mysqli_fetch_assoc(mysqli_query($conexion, $sql))['ciclo'];
    $sql = "SELECT COUNT(*) FROM Ventana_permisos_alumnos WHERE id_alumno = '$id_alumno' && anio_creacion = '$anio' and Estatus=2";
    mysqli_set_charset($conexion, 'utf8');
    $control = mysqli_query($conexion, $sql);
    $num_permisos_este_anio = mysqli_fetch_array($control);
    $num_permisos_este_anio = $num_permisos_este_anio[0];
    $respuesta = $num_permisos_este_anio >= 3 ? true : false;
  }
  elseif ($idcursar >= 14 && $idcursar <= 17 ) {
      $corte_semestral = intval(date("m")) <= 7 ? "-II" : "-I" ;
      $anio = date("Y");
      $anio = "$anio"."$corte_semestral";
      $sql = "SELECT COUNT(*) FROM Ventana_permisos_alumnos WHERE id_alumno = '$id_alumno' && anio_creacion = '$anio' and Estatus=2";
      mysqli_set_charset($conexion, 'utf8');
      $control = mysqli_query($conexion, $sql);
      $num_permisos_este_anio = mysqli_fetch_array($control);
      $num_permisos_este_anio = $num_permisos_este_anio[0];
      $respuesta = $num_permisos_este_anio >= 3 ? true : false;

  }
}

echo json_encode($respuesta);
