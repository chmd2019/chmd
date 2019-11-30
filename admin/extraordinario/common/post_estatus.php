<?php
include '../../sesion_admin.php';
include '../../conexion.php';

if (isset ( $_POST ['nombre_nivel'] )){

  $nombre = $_POST ['nombre_nivel'];
  $funcion = $_POST ['funcion'];
  $idpermiso = $_POST ['idpermiso'];
  $mensaje= $_POST ['mensaje'];
  $estatus= $_POST ['estatus'];
  $isOk='0';

  if ($nombre) {
    header ( 'Content-type: application/json; charset=utf-8' );

    if ($estatus==3)
    {
        //se cambia el estatus de la autorizacion del alumno
        $query = "UPDATE Ventana_permisos_alumnos SET estatus='3' WHERE id='$funcion'";
        mysqli_query ( $conexion, $query );
        //Se cambia el mensaje registrado en el permiso principal.
        $query = "UPDATE Ventana_Permisos SET mensaje = CONCAT(mensaje, '$mensaje' ) WHERE id_permiso='$idpermiso'";
        mysqli_query ( $conexion, $query );

    }else if ($estatus==2)
    {
        //se cambia el estatus de la autorizacion del alumno
        $query = "UPDATE Ventana_permisos_alumnos SET estatus='2' WHERE id=$funcion";
        mysqli_query ( $conexion, $query );
        //Se cambia el mensaje registrado en el permiso principal.
        $query = "UPDATE Ventana_Permisos SET mensaje = CONCAT(mensaje, '$mensaje' ) WHERE id_permiso=$idpermiso";
        mysqli_query ( $conexion, $query );

    } else {
      $isOk='-1';
    }
  //Hay permisos en pendiente
    $query  = "SELECT count(*) as npendientes FROM Ventana_permisos_alumnos where id_permiso='$idpermiso' and estatus='1';";
    $permisos=mysqli_query ( $conexion, $query );
    if ($permiso= mysqli_fetch_array($permisos)){
      $npendientes= $permiso['npendientes'];

      if ($npendientes==0){
        //Permisos autorizados
        $query  = "SELECT count(*) as nautorizados FROM Ventana_permisos_alumnos where id_permiso='$idpermiso' and estatus='2';";
        $permisos=mysqli_query ( $conexion, $query );
        if ($permiso= mysqli_fetch_array($permisos)){
          $nautorizados= $permiso['nautorizados'];
        }

        //¿Hay permisos autarizados?
        if( $nautorizados>0 ){
          //SI - Estatus Autorizado
          $query = "UPDATE Ventana_Permisos SET estatus = '2', archivado='1' WHERE id_permiso='$idpermiso'";
          mysqli_query ( $conexion, $query );
        }else{
          //NO - Estatus declinado
          $query = "UPDATE Ventana_Permisos SET estatus = '3', archivado='1' WHERE id_permiso='$idpermiso'";
          mysqli_query ( $conexion, $query );
        }
      }
    }
    /*
*/
/**fin */
  }
  $reply= json_encode ( array ("estatus" => $isOk, "pendientes"=> $npendientes) );
  echo $reply;
}
 ?>
