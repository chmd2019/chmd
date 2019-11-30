<?php
include '../../conexion.php';

if (isset ( $_POST ['nombre_nivel'] )){
  $nombre = $_POST ['nombre_nivel'];
  $funcion = $_POST ['funcion'];
  $estatus= $_POST ['estatus'];
  $isOk='0';

  if ($nombre) {
    if($estatus == 2){
      //autorizado
       $isOk='0';
    }else if($estatus == 3){
      //permiso Declinado 
      //declinar Permiso Principal
       $query = "UPDATE Ventana_Permisos SET mensaje = 'Permiso Declinado', estatus=3, archivado=1 WHERE id_permiso=$funcion";
      mysqli_query ( $conexion, $query );
      //declinar todo los permisos por alumno 
      $query_alumnos = "UPDATE Ventana_permisos_alumnos SET estatus=3 WHERE id_permiso=$funcion";
      mysqli_query ( $conexion, $query_alumnos );
      $isOk='0';
    }else{
      $isOk='-1';
    }

/**fin */
  }
  $reply = json_encode ( array ("estatus" => $isOk) );
  echo $reply;
}
 ?>
