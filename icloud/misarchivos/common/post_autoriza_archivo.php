<?php
require '../../Model/DBManager.php';

$db_manager = new DBManager();
$connection=$db_manager->conectar1();
$isgood=true;
//Recoleccion de datos pos
if (isset($_POST['submit'])){
  $nfamilia = $_POST['nfamilia'];
  $idarchivo = $_POST['idarchivo'];
  $estatus = $_POST['estatus'];
  /************************** Conseguir la famila del chofer ********************************/
  if($connection){
    //Comando de insercion
    $sql="INSERT INTO Archivos_autorizacion( idarchivo, idfamilia, estatus )VALUES('$idarchivo', '$nfamilia','$estatus' )";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
      die("error:" . mysqli_error($connection));
      //    echo "Registro fallido";
      $isgood=false;
    }
  }
}
if($isgood){
  echo "1";
  //  echo 1;
}else{
  echo "Ocurrio un Error, Vuelva ha intentar";
}
?>
