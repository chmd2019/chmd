<?php
require '../../conexion.php';

if (!isset($_GET['id_alumno'])) {
    header ('PseguridadPadres.php');
    exit();
}
$id_alumno = $_GET['id_alumno'];
$anio = date('Y');
$mes = date('m');
$dia = date('d');

$sql = "SELECT COUNT(*) AS n_salidas FROM Salidas_alumnos WHERE idalumno='$id_alumno' and YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and DAY(fecha)='$dia'";
  $query  = mysqli_query($conexion , $sql);
  if ($r  = mysqli_fetch_array($query) ){
    $n_registro = $r['n_salidas'];
    if ($n_registro > 0){
      $registro=true;
    }else{
      $registro=false;
    }

    $reply= array ("registro"=> $registro, "fecha" => "$anio - $mes - $dia" );
    echo json_encode($reply);
  }

?>
