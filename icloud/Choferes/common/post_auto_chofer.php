<?php
require '../../Model/DBManager.php';

$db_manager = new DBManager();
$connection=$db_manager->conectar1();
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
      //almacenar con un comando sql

      if($connection){
        //Comando de insercion
        $sql="INSERT INTO usuarios(nombre, numero, tipo, familia, celular, telefono, correo, calle, colonia, cp, correo2 )VALUES('$nombre','$nfamilia', 7, '$familia_letras', '0000000000','0000000000', 'sin correo', 'sin calle', 'sin colonia', 'sin cp', 'sin correo'  )";
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
  //obtengo numero de automoviles canceladeos
  $ids_cancelados  = array();
  if($connection){
    //id de automoviles canceladeos
      $sql="SELECT COUNT(*) as ncancelados from tarjeton_automoviles where idfamilia=$nfamilia and estatus='4'";
      $query  = mysqli_query($connection, $sql);
      if ($r  = mysqli_fetch_array($query)){
      $nautos_cancelados =  $r['ncancelados'];
        //buscar los id de los tarjetones
        if ($nautos_cancelados>0){
            $sql= "SELECT idtarjeton FROM tarjeton_automoviles WHERE idfamilia=$nfamilia and estatus='4' ";
            $query = mysqli_query($connection , $sql);
            while($r = mysqli_fetch_array($query)  )
            array_push($ids_cancelados, $r[0] );
        }
      }
    }

  // Obtengo el arreglo de choferes
  $array_autos= explode(",", $autos );
  $c=1;
  $n=0;
  foreach($array_autos as $auto){
    if ($c<=$nautos){
      $info_auto= explode("|", $auto);
      $marca = $info_auto[0];
      $submarca = $info_auto[1];
      $modelo = $info_auto[2];
      $color = $info_auto[3];
      $placa = $info_auto[4];

      //almacenar con un comando sql
      //  $connection=$db_manager->conectar1();
      if($connection){

        //actualizar Tarjetones antiguos
        if($nautos_cancelados>0){
          $id_cancelado=$ids_cancelados[$n];
          $sql ="UPDATE tarjeton_automoviles SET marca='$marca', submarca='$submarca' modelo='$modelo',color='$color', placa='$placa', estatus='2' WHERE idtarjeton='$id_cancelado'; ";
          mysqli_set_charset($connection, "utf8");
          $update = mysqli_query($connection, $sql);
          if (!$update) {
          //  echo "Registro fallido";
            die("error:" . mysqli_error($connection));
            $isgood=false;
          }else{ /*  echo 'Registro exitoso';*/ }
          $nautos_cancelados--;
          $n++;
        }else{
          //Comando de insercion
          $sql="INSERT INTO tarjeton_automoviles ( idfamilia , marca, submarca, modelo, color, placa, estatus) VALUES ('$nfamilia', '$marca','$submarca','$modelo', '$color', '$placa', '2' )";
          mysqli_set_charset($connection, "utf8");
          $insertar = mysqli_query($connection, $sql);
          if (!$insertar) {
          //  echo "Registro fallido";
            die("error:" . mysqli_error($connection));
            $isgood=false;
          }else{ /*  echo 'Registro exitoso'; */ }
        }
      }
    }
    $c++;
  }
}

if($isgood){
  echo "1";
//  echo 1;
}else{
  echo "Ocurrio un Error, Vuelva ha intentar";
}

?>