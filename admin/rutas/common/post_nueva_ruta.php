<?php
require '../../conexion.php';

if (isset($_POST["summit"])){
  //Datos POST
  $nombre_ruta = $_POST["nombre_ruta"];
  $prefecta = $_POST["prefecta"];
  $camion = $_POST['camion'];
  $cupos = $_POST['cupos'];

  if ($conexion) {
    $sql = "INSERT INTO rutas(
      nombre_ruta,
      prefecta,
      camion,
      cupos)
      VALUES (
        '" . $nombre_ruta . "',
        '" . $prefecta . "',
        '" . $camion . "',
        '" . $cupos . "'
      )";
      mysqli_set_charset($conexion, "utf8");
      $insertar = mysqli_query($conexion, $sql);
      if (!$insertar) {
        die("error:" . mysqli_error($conexion));
        echo json_encode(array ("estatus"=> false) );
        // echo "Registro fallido";
      }
      echo json_encode(array ("estatus"=> true) );
        } else {
          echo json_encode(array ("estatus"=> false) );
        }
        mysqli_close($conexion);
}else{
  echo json_encode(array ("estatus"=> false) );
}

?>

