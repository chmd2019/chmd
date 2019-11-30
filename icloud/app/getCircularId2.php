

<html>
  <head>
  </head>
  <body>
    <p>
<?php

$usuario='sistemas';
$clave='S4st3m4s2019.';
$base='chmd_sistemas';


$idCircular = $_GET["id"];

$link = mysqli_connect('localhost', $usuario, $clave,$base);
if (!$link) {
  die('Not connected : ' . mysqli_error());
 
}

$db_selected = mysqli_select_db($link, $base);
if (!$db_selected) {
  die ('Cannot use $base : ' . mysqli_error());
}


$sql = mysqli_query($link,"SELECT DISTINCT id,titulo,contenido,estatus FROM  App_circulares WHERE id=$idCircular"); 

while($row = mysqli_fetch_assoc($sql)){
echo htmlspecialchars_decode(stripslashes($row['contenido'])); //The details is what contains the <strong>Test</strong>
  //echo $row['contenido'];
}

mysqli_close($conn) or die(mysqli_error());

?>
    </p>
  </body>
</html>



?>