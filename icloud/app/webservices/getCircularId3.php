

<html>
  <head>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">

  </head>
  <body>
  	<h2>
  		<font face="arial" color="#0000ff">
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



<div id="log">
  
</div>
<script>

var $log = $( "#log" ),
  str = "hello, <b>my name is</b> jQuery.",
  html = $.parseHTML( str ),
  nodeNames = [];
 
// Append the parsed HTML
$log.append( html );
 
// Gather the parsed HTML's node names
$.each( html, function( i, el ) {
  nodeNames[ i ] = "<li>" + el.nodeName + "</li>";
});
 
// Insert the node names
$log.append( "<h3>Node Names:</h3>" );
$( "<ol></ol>" )
  .append( nodeNames.join( "" ) )
  .appendTo( $log );
</script>


</script>


</font>
</h2>
  </body>
</html>



?>