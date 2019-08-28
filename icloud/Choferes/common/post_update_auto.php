<?php

require '../../Model/DBManager.php';
require '../../Helpers/DateHelper.php';


$db_manager = new DBManager();
$date_helper = new DateHelper();
//seteael uso horario para ciudad de mexico
$date_helper->set_timezone();

//Recoleccion de datos pos
if (isset($_POST['submit'])){

  $idcarro = $_POST['idcarro'];
  $marca= $_POST['marca'];
  $submarca= $_POST['submarca'];
  $modelo=$_POST['modelo'];
  $color= $_POST['color'];
  $placa=$_POST['placa'];

/*************************Autualizar auto *********************/
//almacenar con un comando sql
$connection=$db_manager->conectar1();
if($connection){
    //Comando de insercion
    $sql="UPDATE tarjeton_automoviles SET marca='$marca',submarca='$submarca' , modelo='$modelo', color='$color', placa='$placa' WHERE idtarjeton=$idcarro";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
        die("error:" . mysqli_error($connection));
        //echo "Registro fallido";
        echo 0;
    }else{
        //echo 'Registro exitoso';
        echo 1;
    }
  }
}

//echo 0;
// almaceno choferes

 ?>
