<?php
require '../../conexion.php';

if (isset($_POST["camion"])){
  //Datos POST
  $camion = $_POST['camion'];
  $tipo_ruta = $_POST['tipo_ruta'];
  if ($conexion) {
      $existe=false;
      $sql = "SELECT COUNT(*) as n FROM  rutas  WHERE  camion='$camion'  AND tipo_ruta='$tipo_ruta'";
      mysqli_set_charset($conexion, "utf8");
      $consulta = mysqli_query($conexion, $sql);
      if( $r = mysqli_fetch_assoc($consulta)) {
        $n = $r['n'];
        if ($n>0){
          $existe=true;
        }
      }

      if (!$existe) {
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
