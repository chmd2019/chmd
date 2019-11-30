<?php
require '../../conexion.php';

$error=false;
$error_doc ='sin error';
if (isset($_POST['alumnos'], $_POST['id_ruta'] )){

$id_ruta = $_POST['id_ruta'];  
   if ($conexion) {
// Eliminar alumnos enlistados
$sql_delete = "DELETE FROM rutas_base_alumnos WHERE id_ruta_base='$id_ruta' ;";
$query_delete = mysqli_query($conexion, $sql_delete);
mysqli_query($conexion, "COMMIT;");
if ($query_delete){
    $alumnos = $_POST['alumnos'];
    foreach ($alumnos as $key => $alumno) {
      // echo "Alumno:" .$alumno['id_alumno']. $alumno['id_alumno'] .  $alumno['id_ruta_base']  . $alumno['domicilio']  .  $alumno['hora_manana']  . $alumno['hora_lu_ju']  . $alumno['hora_vie'] .'<br>' ;
        $sql = "INSERT INTO rutas_base_alumnos(
        id_alumno,
        id_ruta_base,
        domicilio,
        hora_manana,
        hora_lu_ju,
        hora_vie,
        orden_in,
        orden_out)
        VALUES (
          '" . $alumno['id_alumno'] . "',
          '" . $alumno['id_ruta']  . "',
          '" . $alumno['domicilio']  . "',
          '" . $alumno['hora_manana']  . "',
          '" . $alumno['hora_lu_ju']  . "',
          '" . $alumno['hora_vie']  . "',
          '" . $alumno['orden_in']  . "',
          '" . $alumno['orden_out']  . "'
        )"; 
        mysqli_set_charset($conexion, "utf8");
        $insertar = mysqli_query($conexion, $sql);
        if (!$insertar) {
           die("error:" . mysqli_error($conexion));
          $error = true; $error_doc='01: Error al insertar alumno. ';
        }
      }
  }else{
  $error = true;
  $error_doc='02: Error al eliminar bbdde de rutas_alumnos. ';
  }
     } else {
           $error = true;
          $error_doc='03: Error de Conexion. ';
    }
    mysqli_close($conexion);
}

//verificar error
if (!$error){
          echo json_encode(array ("estatus"=> true, "error"=>$error_doc) );
        }else{
          echo json_encode(array ("estatus"=> false , "error"=>$error_doc) );
        }

?>