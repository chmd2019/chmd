<?php
require '../../conexion.php';
$fecha = date('Y-m-d');
$error=false;
$error_doc="Sin Error";  
if (isset($_POST["summit"])){
  //get Datos POST
  $id_ruta = $_POST["id_ruta"];
  $id_alumno = $_POST["id_alumno"];
  $turno  = $_POST["turno"];
  //Verificar conexion con bbdd
  if ($conexion) 
  {
    // Hacemos la actulizacion del cambio de ruta
    $orden='996';
    //realizar actualizacion
    if ($turno=='m'){
    $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h='$id_ruta', orden_in='$orden'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
    }else if ($turno =='t'){
    $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h_s='$id_ruta', orden_out='$orden'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
    }else{
    $sql_update = "COMMIT" ;
      $error=true;
      $error_doc="Sin Turno seleccionado";
    }

    $query_update = mysqli_query($conexion, $sql_update);
    if($query_update){
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

