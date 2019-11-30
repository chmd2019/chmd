<?php
require '../../conexion.php';

if (isset($_POST["id_ruta"])){
  //Datos POST
  $id_ruta = $_POST['id_ruta'];

  if ($conexion) {
      $band=false;
      $sql = "DELETE FROM  rutas WHERE id_ruta ='$id_ruta'";
      mysqli_set_charset($conexion, "utf8");
      $consulta = mysqli_query($conexion, $sql);
      if($consulta) {
          $band=true;
      }

      if (!$band) {
        echo json_encode(array ("estatus"=> false) );
        // echo "Registro fallido";
      }else{
      echo json_encode(array ("estatus"=> true) );
      }
    } else {
          echo json_encode(array ("estatus"=> false) );
    }
        mysqli_close($conexion);
}else{
  echo json_encode(array ("estatus"=> false) );
}

?>
