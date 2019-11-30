<?php
include '../../sesion_admin.php';
require '../../conexion.php';

$id_alumno = $_POST['id_alumno'];
$id_responsable = $_POST['$id_responsable'];
$id_usuario = $user_session;

$anio = date('Y');
$mes = date('m');
$dia = date('d');

$sql = "SELECT COUNT(*) AS n_salidas FROM Salidas_alumnos WHERE idalumno='$id_alumno' and YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and DAY(fecha)='$dia'";
  $query  = mysqli_query($conexion , $sql);
  if ($r  = mysqli_fetch_array($query) ){
    $n_registro = $r['n_salidas'];
    if ($n_registro > 0){
      //elimnar registro
      $registro=false;
      $sql ="DELETE FROM Salidas_alumnos WHERE idalumno='$id_alumno' and YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and DAY(fecha)='$dia'";
      $res  = mysqli_query($conexion,$sql);
    }else{
      //agregar registro
      $registro=true;
      $sql ="INSERT INTO Salidas_alumnos(idresponsable, idalumno,fecha , estatus, idusuario) VALUES( '$id_responsable', '$id_alumno' , NOW(), '1', '$id_usuario' )";
      $res  = mysqli_query($conexion,$sql);

    }

    $reply= array ("registro"=> $registro, "fecha" => "$anio - $mes - $dia" );
    echo json_encode($reply);
  }


 ?>
