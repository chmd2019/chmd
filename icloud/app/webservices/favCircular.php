<?php
$usuario='sistemas';
$clave='S4st3m4s2019.';
$base='chmd_sistemas';
$usuario_id = $_POST["usuario_id"];
$circular_id = $_POST["circular_id"];

$link = mysqli_connect('localhost', $usuario, $clave,$base);
if (!$link) {
  die('Not connected : ' . mysqli_error());
 
}

$db_selected = mysqli_select_db($link, $base);
if (!$db_selected) {
  die ('Cannot use $base : ' . mysqli_error());
}
mysqli_query($link,'SET CHARACTER SET utf8');
      $sql = mysqli_query($link,"UPDATE App_circulares_usuarios SET favorito=1 WHERE usuario_id=$usuario_id AND circular_id=$circular_id"); 
    $rows = array();
    while($r = mysqli_fetch_assoc($sql))
    {
        $rows[] = $r;
    }
    print json_encode($rows);



?>