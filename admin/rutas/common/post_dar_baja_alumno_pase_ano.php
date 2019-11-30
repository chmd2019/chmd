<?php
require '../../conexion.php';
$fecha = date('Y-m-d');
$error=false;
$error_doc="Sin Error";
if (isset($_POST["summit"])){
  //get Datos POST
  $id_alumno = $_POST["id_alumno"];
  $turno  = $_POST["turno"];
  //Verificar conexion con bbdd
  if ($conexion)
  {

    //realizar actualizacion
    if ($turno=='m'){
    $sql_update = "UPDATE rutas_pase_ano_alumnos SET id_ruta_base_m='0', domicilio_m='', hora_manana='',orden_in='' WHERE id_alumno='$id_alumno'" ;
    }else if ($turno =='t'){
    $sql_update = "UPDATE rutas_pase_ano_alumnos SET id_ruta_base_t='0', domicilio_t='', hora_lu_ju='', hora_vie='', orden_out=''  WHERE id_alumno='$id_alumno'" ;
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
