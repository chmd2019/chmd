<?php
require '../../conexion.php';

if (isset($_POST["summit"])){
  //Datos POST
  $id_ruta = $_POST["id_ruta"];
  $prefecta = $_POST["prefecta"];
  $cupos = $_POST['cupos'];
  $fecha= $_POST['fecha'];

  if ($conexion) {
    $sql = "UPDATE rutas_historica SET  prefecta='$prefecta', cupos= '$cupos' WHERE id_ruta_h='$id_ruta' and fecha ='$fecha'";
      mysqli_set_charset($conexion, "utf8");
      $insertar = mysqli_query($conexion, $sql);
      if (!$insertar) {
        // die("error:" . mysqli_error($conexion));
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

