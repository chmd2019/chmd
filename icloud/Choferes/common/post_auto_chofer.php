<?php
require '../../Model/DBManager.php';

$db_manager = new DBManager();
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
          //almacenar con un comando sql
          $connection=$db_manager->conectar1();
          if($connection){
              //Comando de insercion
              $sql="INSERT INTO usuarios(nombre, numero, tipo, celular, telefono, correo, calle, colonia, cp, correo2 )VALUES('$nombre','$nfamilia', 7, '0000000000','0000000000', 'sin correo', 'sin calle', 'sin colonia', 'sin cp', 'sin correo'  )";
              mysqli_set_charset($connection, "utf8");
              $insertar = mysqli_query($connection, $sql);
              if (!$insertar) {
                  die("error:" . mysqli_error($connection));
              //    echo "Registro fallido";
                  $isgood=false;
              }else{
              //    echo 'Registro exitoso';
                $ultimo_id_conexion = mysqli_insert_id($connection);
                $foto=$ultimo_id_conexion.'.png';
                $sql="UPDATE usuarios SET  fotografia='$foto' where id=$ultimo_id_conexion limit 1";
                mysqli_set_charset($connection, "utf8");
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
        $connection=$db_manager->conectar1();
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
}

 ?>
