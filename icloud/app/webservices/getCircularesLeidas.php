<?php
$usuario='sistemas';
$clave='S4st3m4s2019.';
$base='chmd_sistemas';

$usuario_id = $_GET["usuario_id"];


$link = mysqli_connect('localhost', $usuario, $clave,$base);
if (!$link) {
  die('Not connected : ' . mysqli_error());
 
}

$db_selected = mysqli_select_db($link, $base);
if (!$db_selected) {
  die ('Cannot use $base : ' . mysqli_error());
}
mysqli_query($link,'SET CHARACTER SET utf8');
      $sql = mysqli_query($link,"SELECT id,titulo,estatus,ciclo_escolar_id,created_at,updated_at,leido,favorito,compartida,eliminado,status_envio,envio_todos FROM  vwCircularesUsuario where usuario_id='$usuario_id' AND leido=1 order by id desc"); 
    $rows = array();
    while($r = mysqli_fetch_assoc($sql))
    {
        $rows[] = $r;
    }
    print json_encode($rows);



?>