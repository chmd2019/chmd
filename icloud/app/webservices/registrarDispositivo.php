<?php
$usuario='sistemas';
$clave='S4st3m4s2019.';
$base='chmd_sistemas';
$correo = $_POST["correo"];
$device_token = $_POST["device_token"];
$plataforma = $_POST["plataforma"];
$link = mysqli_connect('localhost', $usuario, $clave,$base);
if (!$link) {
  die('Not connected : ' . mysqli_error());
 
}

$db_selected = mysqli_select_db($link, $base);
if (!$db_selected) {
  die ('Cannot use $base : ' . mysqli_error());
}
mysqli_query($link,'SET CHARACTER SET utf8');
      $sql = mysqli_query($link,"INSERT INTO app_dispositivos(correo,device_token,plataforma,fecha_registro) VALUES('$correo','$device_token','$plataforma',CURDATE())"); 
    $rows = array();
    while($r = mysqli_fetch_assoc($sql))
    {
        $rows[] = $r;
    }
    print json_encode($rows);



?>