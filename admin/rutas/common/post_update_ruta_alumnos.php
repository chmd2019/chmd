<?php
require '../../conexion.php';

$error=false;
$error_doc ='sin error';
if (isset($_POST['alumnos'], $_POST['id_ruta'], $_POST['fecha'] )){

$id_ruta = $_POST['id_ruta']; 
$fecha = $_POST['fecha']; 
// echo 'id_ruta:' . $id_ruta;
// echo ' fecha: ' . $fecha;
   if ($conexion) {
    $alumnos = $_POST['alumnos'];
    foreach ($alumnos as $key => $alumno) {
      $id_alumno = $alumno['id_alumno'];
      $id_ruta = $alumno['id_ruta'] ;
      // $domicilio = $alumno['domicilio'];
      $hora_ma =  $alumno['hora_manana'];
      $hora_re =  $alumno['hora_regreso'];
      $orden_in = $alumno['orden_in'];
      $orden_out = $alumno['orden_out'];

// echo '<br>id_alumno:' . $id_alumno. ' hora_m:'. $hora_ma. ' orden:'.$orden;

      //SQL    
      $sql_update = "UPDATE rutas_historica_alumnos
      SET hora_manana = '$hora_ma', hora_regreso = '$hora_re', orden_in = '$orden_in', orden_out='$orden_out' 
      WHERE id_alumno = $id_alumno and fecha = '$fecha';"; 
      mysqli_set_charset($conexion, "utf8");
      $update = mysqli_query($conexion, $sql_update);
        if (!$update) {
           die("error:" . mysqli_error($conexion));
          $error = true; $error_doc='01: Error al actualizar alumno. ';
        }else{
          mysqli_query($conexion, 'COMMIT;');
        }
      }
 
     } else {
           $error = true;
          $error_doc='03: Error de Conexion. ';
    }
    mysqli_close($conexion);
}else{
  $error=true;
  $error_doc ='04: Error al enviar datos en POST';
}

//verificar error
if (!$error){
          echo json_encode(array ("estatus"=> true, "error"=>$error_doc) );
        }else{
          echo json_encode(array ("estatus"=> false , "error"=>$error_doc) );
        }

?>
