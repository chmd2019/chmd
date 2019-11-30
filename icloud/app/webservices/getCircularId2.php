

<html>
  <head>
  	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
 
  </head>
  <body {color: #6EC4EE;}>
    <style>
    @font-face {font-family: GothamRoundedMedium; src: url('GothamRoundedMedium_21022.ttf'); } 
    h3 {
         font-family: GothamRoundedMedium;
         color:#6EC4EE;
      }
    </style>  
  	<h3>
  		
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

</h3>
  </body>
</html>



?>