<?php
require '../../conexion.php';

$error=false;
$error_doc ='sin error';
if (isset( $_POST['id_ruta'], $_POST['fecha'] )){

$id_ruta = $_POST['id_ruta']; 
$fecha = $_POST['fecha']; 
// echo 'id_ruta:' . $id_ruta;
// echo ' fecha: ' . $fecha;
   if ($conexion) {
    //mañana
    if (isset($_POST['alumnos_m'])){
        $alumnos_m = $_POST['alumnos_m'];
        foreach ($alumnos_m as $key => $alumno) {
          $id_alumno = $alumno['id_alumno'];
          $id_ruta = $alumno['id_ruta'] ;
          $hora_ma =  $alumno['hora_manana'];
          $orden_in = $alumno['orden_in'];
          //SQL - Mañana     
          $sql_update = "UPDATE rutas_historica_alumnos
          SET hora_manana = '$hora_ma', orden_in = '$orden_in'
          WHERE id_alumno = $id_alumno and fecha = '$fecha';"; 
          mysqli_set_charset($conexion, "utf8");
          $update = mysqli_query($conexion, $sql_update);
            if (!$update) {
               die("error:" . mysqli_error($conexion));
              $error = true; $error_doc='01: Error al actualizar alumno de la mañana. ';
            }else{
              mysqli_query($conexion, 'COMMIT;');
            }
          }
    }

      //tarde
    if (isset($_POST['alumnos_t'])){
        $alumnos_t = $_POST['alumnos_t'];
        foreach ($alumnos_t as $key => $alumno) {
          $id_alumno = $alumno['id_alumno'];
          $id_ruta = $alumno['id_ruta'] ;
          $hora_re =  $alumno['hora_regreso'];
          $orden_out = $alumno['orden_out'];
          //SQL - Tarde     
          $sql_update = "UPDATE rutas_historica_alumnos
          SET hora_regreso = '$hora_re', orden_out='$orden_out' 
          WHERE id_alumno = $id_alumno and fecha = '$fecha'"; 
          mysqli_set_charset($conexion, "utf8");
          $update = mysqli_query($conexion, $sql_update);
            if (!$update) {
               die("error:" . mysqli_error($conexion));
              $error = true; $error_doc='02: Error al actualizar alumno de la tarde. ';
            }else{
              mysqli_query($conexion, 'COMMIT;');
            }
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
