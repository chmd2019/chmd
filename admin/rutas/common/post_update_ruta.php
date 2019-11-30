<?php
require '../../conexion.php';

if (isset($_POST["summit"])){
  //Datos POST
  $id_ruta = $_POST["id_ruta"];
  $nombre_ruta = $_POST["nombre_ruta"];
  $prefecta = $_POST["prefecta"];
  $camion = $_POST['camion'];
  $cupos = $_POST['cupos'];

  if ($conexion) {
    $sql = "UPDATE rutas SET nombre_ruta='$nombre_ruta', prefecta='$prefecta', camion ='$camion' , cupos= '$cupos' WHERE id_ruta='$id_ruta' ";
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

