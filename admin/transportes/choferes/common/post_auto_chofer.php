<?php

include '../conexion.php';

$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); //Para que se muestren las tildes

$isgood=true;

//Recoleccion de datos pos

if (isset($_POST['submit'])){
  $nchoferes=$_POST['nchoferes'] ;
  $choferes= $_POST['choferes'] ;
  $nautos= $_POST['nautos'] ;
  $autos= $_POST['autos'] ;
  $maxchoferes= $_POST['maxchoferes']  ;
  $maxautos= $_POST['maxautos'] ;
  $nfamilia= $_POST['nfamilia'] ;

  /************************** Conseguir la famila del chofer ********************************/

  if($connection){
    $sql = "SELECT familia from usuarios where numero=$nfamilia limit 1;";
    mysqli_set_charset($connection, 'utf8');
    $get_familia = mysqli_query($connection, $sql);
    if ($familia_apellidos = mysqli_fetch_array($get_familia)){
      $familia_letras=$familia_apellidos['familia'];
    }
  }

  /*************************Registro de nuevo choferes *********************/

  // Obtengo el arreglo de choferes

  $array_choferes= explode(",", $choferes );
  $c=1;
  foreach($array_choferes as $chofer){
    if ($c<=$nchoferes){
      $info_chofer= explode("|", $chofer);
      $nombre = $info_chofer[0];
      $apellido = $info_chofer[1];
      $nombre= $nombre .' '.$apellido;
      //          echo "Nombre: $nombre  apellido: $apellido";
      if($connection){
        //Comando de insercion
        $sql="INSERT INTO usuarios(nombre, numero, tipo, familia,estatus, celular, telefono, correo, calle, colonia, cp, correo2 )VALUES('$nombre','$nfamilia', 7, '$familia_letras', 1, '0000000000','0000000000', 'sin correo', 'sin calle', 'sin colonia', 'sin cp', 'sin correo'  )";
        mysqli_set_charset($connection, "utf8");
        $insertar = mysqli_query($connection, $sql);
        if (!$insertar) {
          die("error:" . mysqli_error($connection));
          //    echo "Registro fallido";
          $isgood=false;
        }else{
          //    echo 'Registro exitoso';
          $ultimo_id_conexion = mysqli_insert_id($connection);
          $fotografia = "C:\\\\IDCARDDESIGN\\\\CREDENCIALES\\\\padres\\\\$ultimo_id_conexion.jpg";
          $sql="UPDATE usuarios SET  fotografia='$fotografia'  where id=$ultimo_id_conexion";
          $insertar = mysqli_query($connection, $sql);
          if (!$insertar) {
            die("error:" . mysqli_error($connection));
            //    echo "Registro fallido";
            $isgood=false;
          }
        }
      }
    }
    $c++;
  }

  /*************************Registro de nuevos autos *********************/
  // Obtengo el arreglo de choferes
  $array_autos= explode(",", $autos );
  $c=1;
  foreach($array_autos as $auto){
    if ($c<=$nautos){
      $info_auto= explode("|", $auto);
      $marca = $info_auto[0];
      $modelo = $info_auto[1];
      $color = $info_auto[2];
      $placa = $info_auto[3];
      //almacenar con un comando sql
      if($connection){
        //Comando de insercion
        $sql="INSERT INTO Ventana_autos(marca, modelo, color, placas, idfamilia )VALUES('$marca','$modelo', '$color', '$placa' ,'$nfamilia' )";
        mysqli_set_charset($connection, "utf8");
        $insertar = mysqli_query($connection, $sql);
        if (!$insertar) {
          die("error:" . mysqli_error($connection));
          //  echo "Registro fallido";
          $isgood=false;
        }else{
          //  echo 'Registro exitoso';
        }
      }
    }
    $c++;
  }
}
if($isgood){
  echo 1;
}else{
  echo "Ocurrio un Error, Vuelva ha intentar";
}?>
