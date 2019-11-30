<?php
require '../../conexion.php';
$fecha = date('Y-m-d');
$error=false;
$error_doc="Sin Error";
if (isset($_POST["summit"])){
  //get Datos POST
  $id_alumno = $_POST["id_alumno"];
  //Verificar conexion con bbdd
  if ($conexion)
  {
    //realizar actualizacion
    $sql_delete = "DELETE FROM rutas_generales_alumnos WHERE id_alumno='$id_alumno'" ;

    $query_delete = mysqli_query($conexion, $sql_delete);
    if($query_delete){
      mysqli_query($conexion, 'COMMIT');
    }else{
       $error=true;
       $error_doc="Error al actualizar datos de la fecha de Hoy en DIARIOS";
       die('Error en DIARIOS');
    }
  }else{
    $error=true;
    $error_doc="Error de COnexion";
  }
  mysqli_close($conexion);
}else{
   $error=true;
    $error_doc="Error de Datos POST";
}

//verificar error
if (!$error){
          echo json_encode(array ("estatus"=> true, "error"=>$error_doc) );
        }else{
          echo json_encode(array ("estatus"=> false , "error"=>$error_doc) );
        }


?>
