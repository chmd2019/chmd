<?php
include '../../conexion.php';

if (isset ( $_POST ['nombre_nivel'] )){
  $nombre = $_POST ['nombre_nivel'];
  $funcion = $_POST ['funcion'];
  $mensaje= $_POST ['mensaje'];
  $estatus= $_POST ['estatus'];
  $exist_nivel = false;
  if (isset($_POST ['id_nivel'])){
    $exist_nivel  = true;
    $id_nivel = $_POST['id_nivel'];
  }
  $isOk='0';

  if ($nombre) {

    if ($exist_nivel){
      $query  = "SELECT COUNT(*) as npendientes FROM Ventana_permisos_alumnos vpa INNER JOIN alumnoschmd ac ON ac.id=vpa.id_alumno and ac.id_nivel = '$id_nivel'  WHERE vpa.id_permiso ='$funcion' and vpa.estatus='1'";
    }else{
      //Hay permisos en pendiente
      $query  = "SELECT count(*) as npendientes FROM Ventana_permisos_alumnos where id_permiso='$funcion' and estatus='1';";
    }
    $permisos=mysqli_query ( $conexion, $query );
    if ($permiso= mysqli_fetch_array($permisos)){
      $npendientes= $permiso['npendientes'];

      if ($npendientes==0){
        //Permisos autorizados

        if ($estatus==3)
        {
          //Se cambia el mensaje registrado en el permiso principal.
          $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje', estatus=3, archivado=1 WHERE id_permiso=$funcion";
          mysqli_query ( $conexion, $query );

        }else if ($estatus==2)
        {
          //Se cambia el mensaje registrado en el permiso principal.
          $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=2, archivado=1 WHERE id_permiso=$funcion";
          mysqli_query ($conexion,  $query );

        } else {
          $isOk='-1';
        }

        //end
      }else{
        $isOk='-1';
      }
    }
    /*
*/
/**fin */
  }
  $reply = json_encode ( array ("estatus" => $isOk, "pendientes"=> $npendientes) );
  echo $reply;
}
 ?>
