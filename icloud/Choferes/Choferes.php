<?php
session_start(); //session start
include_once("../Model/DBManager.php");
require_once ('../libraries/Google/autoload.php');
require_once '../Model/Config.php';




//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}


$service = new Google_Service_Oauth2($client);

//echo "$service";
  
if (isset($_GET['code'])) 
    {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}


if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
/*Agregar diseño*/

?>
<!DOCTYPE html>
<!-- Powered by Edlio -->

	<html lang="en" class="desktop">
<!-- w103 -->
<head>
<title>Colegio Hebreo Maguen David</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Colegio Hebreo Maguen David">
<meta name="generator" content="Edlio CMS">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<!--[if lt IE 9]><script src="/apps/js/common/html5shiv-pack-1499875166000.js"></script><![endif]-->
<!--<link rel="stylesheet" href="apps/shared/main-pack-1499875166000.css" type="text/css">
-->
<link rel="stylesheet" href="../shared/main.css" type="text/css">


<!---------maguen------------------------------------>


	
   <!----------------alert-------------------->

<!----------------Alert------------------------>		

<!----------------------------------------------------------->

</head>



<body >

<header id="header_main">
	
</header>
    <!----------------------adaptacion responsiva-->



    <!---------------------- fin adaptacion responsiva-->
    <link type="text/css" rel="stylesheet" href="../css/formresponsivos.css" />
<link type="text/css" rel="stylesheet" href="../css/permanete.css" />  
<link href="../css/prueba3.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="../js/alertify.js"></script>
<link rel="stylesheet" href="../css/alertify.core.css" />
<link rel="stylesheet" href="../css/alertify.default.css" />
<script src="../js/Alta_Chofer.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/Alta_Auto.js" type="text/javascript" charset="utf-8"></script>
 <script src="../js/jquery-1.3.1.min.js" type="text/javascript"></script>
  <script type="text/javascript">
$(document).ready(function()
{
  $('#tabla').show();
    
	// mostrar formulario de actualizar datos
	$("table tr .modi a").click(function(){
		$('#tabla').hide();
		$("#formulario").show();
		$.ajax({
			url: this.href,
			type: "GET",
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
	
	// llamar a formulario nuevo
	$("#nuevo a").click(function(){
		$("#formulario").show();
		$("#tabla").hide();
		$.ajax({
			type: "GET",
			url: 'Choferes_alta.php',
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
        
        
        $("#nuevo2 a").click(function(){
		$("#formulario").show();
		$("#tabla").hide();
		$.ajax({
			url: this.href,
			type: "GET",
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
});


</script>  
<!----------------------------librerias alertyfive-------------------------------------------------->
<!--
<script type="text/javascript">
    function autoRefreshPage()
    {
        window.location = window.location.href;
    }
    setInterval('autoRefreshPage()', 10000);
</script>
-->

<script>
var timeoutID;

function setup() {
  this.addEventListener("mousemove", resetTimer, false);
  this.addEventListener("mousedown", resetTimer, false);
  this.addEventListener("keypress", resetTimer, false);
  this.addEventListener("DOMMouseScroll", resetTimer, false);
  this.addEventListener("mousewheel", resetTimer, false);
  this.addEventListener("touchmove", resetTimer, false);
  this.addEventListener("MSPointerMove", resetTimer, false);

  startTimer();
}
setup();

function startTimer() {
  // wait 2 seconds before calling goInactive
  timeoutID = window.setTimeout(goInactive, 30000);
}

function resetTimer(e) {
  window.clearTimeout(timeoutID);

  goActive();
}

function goInactive() {
  // do something
  // alert("inactivo");
  window.location.reload();
}

function goActive() {
  // do something

  startTimer();
}
</script>
</head>


<div id="content_main">

    

<?php


////////////// fin agregar diseño////////////////////////////////

if (isset($authUrl))
    { 
    
	//show login url
	echo '<div align="center">';
	echo '<h2><font color="#124A7B">Acceso Google</font></h2>';
	
	echo '<br><br><a  href="' . $authUrl . '"><img src="../images/google.png"  id="total"/></a>';
	echo '</div>';
	

        
        
    } 
else 
{//esta logueado el correo de gmail
  
     ?>
        <!----------------------------------Java script solo para ------------------------------------------->
   
      <div id="formulario" style="display:none;">
    </div> 
        
  
   <center>  
       <div id="tabla"  >
       <h2> <font color="#124A7B">Choferes</font></h2> 
   

   <?php   
         
              include ('View_choferes.php');
         
         ?>
 
       </div>
   </center> 
 
                
   <?php         
            
            
            
    
   
       
    
}//esta logueado el correo de gmail



?>

</div>

<nav id="mobile_nav">
<a href="/apps/events/"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 62.6 60.3" enable-background="new 0 0 62.6 60.3" xml:space="preserve"><path d="M43.5 30.5c1 0 1.9 0.2 2.6 0.5 0.8 0.3 1.5 0.8 2.3 1.4l3.2-4.9c-1.2-0.9-2.4-1.6-3.7-2 -1.3-0.5-2.8-0.7-4.5-0.7 -1.9 0-3.6 0.3-5 1 -1.4 0.7-2.6 1.7-3.6 2.9 -1 1.2-1.7 2.6-2.1 4.3 -0.5 1.7-0.7 3.4-0.7 5.4v0.1c0 2.3 0.3 4.2 0.8 5.7 0.6 1.5 1.3 2.7 2.2 3.6 0.9 0.9 1.9 1.6 3.1 2.1 1.2 0.5 2.7 0.7 4.4 0.7 1.3 0 2.6-0.2 3.8-0.6 1.2-0.4 2.2-1 3.1-1.8 0.9-0.8 1.6-1.7 2.1-2.8 0.5-1.1 0.8-2.3 0.8-3.7v-0.1c0-1.2-0.2-2.3-0.7-3.3 -0.4-1-1-1.8-1.8-2.4 -0.7-0.6-1.6-1.1-2.6-1.5 -1-0.3-2-0.5-3.1-0.5 -1.2 0-2.3 0.2-3.1 0.6 -0.8 0.4-1.6 0.8-2.2 1.3 0.2-1.5 0.6-2.8 1.4-3.8C41 31 42.1 30.5 43.5 30.5zM39.7 39.7c0.6-0.6 1.4-0.9 2.5-0.9 1.1 0 1.9 0.3 2.6 0.9 0.6 0.6 0.9 1.4 0.9 2.3h0V42c0 0.9-0.3 1.7-0.9 2.3 -0.6 0.6-1.4 0.9-2.5 0.9 -1.1 0-1.9-0.3-2.6-0.9 -0.6-0.6-0.9-1.4-0.9-2.3v-0.1C38.8 41 39.1 40.3 39.7 39.7zM19.8 37.8l-9.2 7.1v5.2h19.5v-5.6H19.9l4.2-3c0.9-0.7 1.7-1.3 2.4-1.9 0.7-0.6 1.3-1.3 1.8-1.9 0.5-0.7 0.9-1.4 1.1-2.2 0.2-0.8 0.4-1.7 0.4-2.7v-0.1c0-1.2-0.2-2.2-0.7-3.2 -0.4-1-1.1-1.8-1.9-2.5 -0.8-0.7-1.8-1.2-2.9-1.6 -1.1-0.4-2.3-0.6-3.7-0.6 -1.2 0-2.3 0.1-3.2 0.4 -1 0.2-1.8 0.6-2.6 1 -0.8 0.4-1.5 1-2.2 1.7 -0.7 0.7-1.4 1.4-2 2.3l4.6 3.9c1-1.1 1.8-1.9 2.6-2.4 0.7-0.5 1.5-0.8 2.3-0.8 0.8 0 1.5 0.2 2 0.7 0.5 0.4 0.8 1.1 0.8 1.8 0 0.8-0.2 1.5-0.7 2.1C21.7 36.1 20.9 36.9 19.8 37.8zM43.8 10.2h0.5c1.5 0 2.7-1.2 2.7-2.7V2.7C47 1.2 45.8 0 44.3 0h-0.5c-1.5 0-2.7 1.2-2.7 2.7v4.9C41.2 9 42.4 10.2 43.8 10.2zM18.6 10.2H19c1.5 0 2.7-1.2 2.7-2.7V2.7C21.7 1.2 20.5 0 19 0h-0.5c-1.5 0-2.7 1.2-2.7 2.7v4.9C15.9 9 17.1 10.2 18.6 10.2zM58.7 19.9h3.9V7.3c0-1.3-1.1-2.4-2.4-2.4H48v2.7c0 2-1.6 3.6-3.6 3.6h-0.5c-2 0-3.6-1.6-3.6-3.6V4.9H22.7v2.7c0 2-1.6 3.6-3.6 3.6h-0.5c-2 0-3.6-1.6-3.6-3.6V4.9H2.8c-1.3 0-2.4 1.1-2.4 2.4v12.6h3.9H58.7zM58.7 21.9v33.5c0 0.8-0.2 1-1 1H5.2c-0.8 0-1-0.2-1-1V21.9H0.3v36c0 1.3 1.1 2.4 2.4 2.4h57.4c1.3 0 2.4-1.1 2.4-2.4v-36H58.7z"/></svg>Calendario</a>
<a href="/"><?xml version="1.0" encoding="utf-8"?>

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
viewBox="0 0 32.3 31.5" style="enable-background:new 0 0 32.3 31.5;" xml:space="preserve">
<defs xmlns="http://www.w3.org/1999/xhtml">
<style>
.st0 { fill: #FFFFFF; }
</style>
</defs>
<g>
<polygon class="st0" points="15.8,8 0,0 0,14.4 2.1,14.4 2.1,3.3 15.8,10.2 30.3,3.4 30.3,14.4 32.3,14.4 32.3,0.2 "/>
<polygon class="st0" points="30.3,29.5 2.1,29.5 2.1,17.8 0,17.8 0,31.5 32.3,31.5 32.3,17.8 30.3,17.8 "/>
<path class="st0" d="M9.2,13.6c-0.9,0-1.6,0.7-1.6,1.6v8.3c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6v-4.8c0-1.5,0.7-2.3,1.9-2.3
s1.9,0.8,1.9,2.3v4.8c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6v-4.8c0-1.5,0.7-2.3,1.9-2.3s1.9,0.8,1.9,2.3v4.8
c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6v-5.8c0-2.7-1.4-4.1-3.8-4.1c-1.5,0-2.7,0.6-3.7,1.8c-0.6-1.1-1.7-1.8-3.2-1.8
c-1.6,0-2.6,0.8-3.3,1.8v-0.1C10.8,14.3,10.1,13.6,9.2,13.6z"/>
</g>
</svg>
Mi Maguen</a>
<a href="/apps/news/"><?xml version="1.0" encoding="utf-8"?>

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
viewBox="0 0 33.8 31.2" style="enable-background:new 0 0 33.8 31.2;" xml:space="preserve">
<g transform="translate(0,-952.36218)">
<path d="M27,952.4c0.4,0,0.8,0.5,0.8,0.8v7.6h5.1c0.5,0,0.8,0.5,0.8,0.8v18.2c0,2.1-1.7,3.8-3.8,3.8H3.8c-2.1,0-3.8-1.7-3.8-3.8
v-26.6c0-0.4,0.4-0.8,0.8-0.8H27z M26.2,954.1H1.7v25.8c0,1.2,0.9,2.1,2.1,2.1h23.1c-0.4-0.6-0.7-1.3-0.7-2.1V954.1z M22.8,956.6
c0.4,0,0.8,0.5,0.8,0.8v5.9c0,0.4-0.4,0.8-0.8,0.8h-8.4c-0.4,0-0.8-0.4-0.8-0.8v-5.9c0-0.4,0.4-0.8,0.8-0.8H22.8z M10.1,957.4
c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H10.1z M22,958.3h-6.8v4.2H22V958.3z
M10.1,961.7c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H10.1z M32.1,962.5h-4.2v17.3
c0,1.2,0.9,2.1,2.1,2.1c1.2,0,2.1-0.9,2.1-2.1V962.5z M22.8,966.7c0.5,0,0.8,0.4,0.8,0.8c0,0.5-0.4,0.8-0.8,0.8H5.1
c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H22.8z M22.8,971.4c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8
s0.4-0.8,0.8-0.8H22.8z M22.8,976c0.5,0,0.8,0.4,0.8,0.8s-0.4,0.8-0.8,0.8H5.1c-0.5,0-0.8-0.4-0.8-0.8s0.4-0.8,0.8-0.8H22.8z"/>
</g>
</svg>
Noticias</a>
<a href="/apps/contact/"><svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1792 710v794q0 66-47 113t-113 47h-1472q-66 0-113-47t-47-113v-794q44 49 101 87 362 246 497 345 57 42 92.5 65.5t94.5 48 110 24.5h2q51 0 110-24.5t94.5-48 92.5-65.5q170-123 498-345 57-39 100-87zm0-294q0 79-49 151t-122 123q-376 261-468 325-10 7-42.5 30.5t-54 38-52 32.5-57.5 27-50 9h-2q-23 0-50-9t-57.5-27-52-32.5-54-38-42.5-30.5q-91-64-262-182.5t-205-142.5q-62-42-117-115.5t-55-136.5q0-78 41.5-130t118.5-52h1472q65 0 112.5 47t47.5 113z"/></svg>Contacto</a>
</nav>
<br> &nbsp; &nbsp; &nbsp;
<br> &nbsp; &nbsp; &nbsp;<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

</body>
</html>


<!-- 76ms -->


