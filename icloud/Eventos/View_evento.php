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
 

if (isset($authUrl))
    { 
    
	//show login url
	echo '<div align="center">';
	echo '<h2><font color="#124A7B">Mi Maguen</font></h2>';
	
	echo '<br><br><a  href="' . $authUrl . '"><img src="images/google.png"  id="total"/></a>';
	echo '</div>';
	

        
        
    } 
   else
   {
       ?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

  <script type="text/javascript">
$(document).ready(function()
{
  
    
	// mostrar formulario de actualizar datos
	
        ///
        $("#modi a").click(function(){
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
			url: 'Evento_Alta.php',
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
});

</script> 


 
 
 <link rel="stylesheet" type="text/css" href="../css/estilotdinamica.css"> 
     <p align='center'>
         
        <?php 
        if($perfil11=="3" )
            {
           echo " <span class='nuevo' id='nuevo'><a href='Evento_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        
            }
            elseif ($perfil11=="2") 
                {
              
                }
                 else
                {
               echo " <span class='nuevo' id='nuevo'><a href='Evento_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        
                }
                
        ?>

           <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.png' width='80px' height='80px' alt='$modulo'></a>
       </p>
     
       <section class="principal">

	

	<div class="formulario">
		
		<input type="text" name="caja_busqueda" id="caja_busqueda" class="form-control filter" placeholder="Buscar Minuta..."></input>
                <br>
		
	</div>

	<div id="datos"></div>
	
	
</section>
               
<script type="text/javascript" src="js/main.js"></script>

       
       
<?php       
   }

?>




