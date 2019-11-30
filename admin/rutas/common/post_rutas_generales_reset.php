<?php
require '../../conexion.php';

if (isset($_POST["reset"])){

  if ($conexion) {
      $band=false;
      $sql = "TRUNCATE TABLE rutas_generales_alumnos";
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
