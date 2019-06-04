

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
if (isset($authUrl))
    { 
    
	 header('Location: ../index.php');
	

        
        
    } 
   /*enviar datos a procesar */
    else
 { 
        //////////////////////////
      $user = $service->userinfo->get(); //get user info 
	$correo=$user->email;
        require('../Model/Login.php');
       $objCliente=new Login();
       $consulta=$objCliente->AccesoEventos($correo);
       
       	if($consulta) //if user already exist change greeting text to "Welcome Back"
    {
         
       
 if( $cliente = mysql_fetch_array($consulta) )
              
{
                
$id=$cliente[0];
$correo2=$cliente[1];
$estatus=$cliente[2];
$nombre=$cliente[3];
//$perfil=$cliente[2];

}
    }
        
        
        
        
        //////////////////////////
    
if(isset($_POST['submit']))
 {
 
require('Ctr_minuta.php');

$idusuario= htmlspecialchars(trim($_POST['idusuario']));
$titulo = htmlspecialchars(trim($_POST['titulo']));
$fecha1 = htmlspecialchars(trim($_POST['fecha1']));
$hora = htmlspecialchars(trim($_POST['hora']));
$convocado = htmlspecialchars(trim($_POST['convocado']));
$director = htmlspecialchars(trim($_POST['director']));
$invitado = htmlspecialchars(trim($_POST['invitado']));

$comite = htmlspecialchars(trim($_POST['comite']));
$cantidad = htmlspecialchars(trim($_POST['cantidad']));
$tema1 = htmlspecialchars(trim($_POST['tema1']));
$tema2 = htmlspecialchars(trim($_POST['tema2']));
$tema3 = htmlspecialchars(trim($_POST['tema3']));
$tema4 = htmlspecialchars(trim($_POST['tema4']));
$tema5 = htmlspecialchars(trim($_POST['tema5']));
$tema6 = htmlspecialchars(trim($_POST['tema6']));
$tema7 = htmlspecialchars(trim($_POST['tema7']));
$tema8 = htmlspecialchars(trim($_POST['tema8']));
$tema9 = htmlspecialchars(trim($_POST['tema9']));
$tema10 = htmlspecialchars(trim($_POST['tema10']));
$tema11 = htmlspecialchars(trim($_POST['tema11']));
$tema12 = htmlspecialchars(trim($_POST['tema12']));
$tema13 = htmlspecialchars(trim($_POST['tema13']));
$tema14 = htmlspecialchars(trim($_POST['tema14']));
$tema15 = htmlspecialchars(trim($_POST['tema15']));
$tema16 = htmlspecialchars(trim($_POST['tema16']));
$tema17 = htmlspecialchars(trim($_POST['tema17']));
$tema18= htmlspecialchars(trim($_POST['tema18']));
$tema19 = htmlspecialchars(trim($_POST['tema19']));
$tema20 = htmlspecialchars(trim($_POST['tema20']));
$tema21 = htmlspecialchars(trim($_POST['tema21']));
$tema22= htmlspecialchars(trim($_POST['tema22']));
$tema23 = htmlspecialchars(trim($_POST['tema23']));
$tema24= htmlspecialchars(trim($_POST['tema24']));
$tema25 = htmlspecialchars(trim($_POST['tema25']));
$tema26 = htmlspecialchars(trim($_POST['tema26']));



if(is_null($idusuario)){echo 'Error intentar de nuevo'; return false;}
if(is_null($titulo)){echo 'Error intentar de nuevo'; return false;}
if(is_null($fecha1)){echo 'Error intentar de nuevo'; return false;}
if(is_null($hora)){echo 'Error intentar de nuevo'; return false;}
if(is_null($convocado)){echo 'Error intentar de nuevo'; return false;}
if(is_null($director)){echo 'Error intentar de nuevo'; return false;}
if(is_null($invitado)){echo 'Error intentar de nuevo'; return false;}

if(is_null($comite)){echo 'Error intentar de nuevo'; return false;}

if(is_null($cantidad)){echo 'Error intentar de nuevo'; return false;}


if(is_null($tema1)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema2)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema3)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema4)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema5)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema6)){echo 'Error intentar de nuevo'; return false;}

if(is_null($tema7)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema8)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema9)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema10)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema11)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema12)){echo 'Error intentar de nuevo'; return false;}

if(is_null($tema13)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema14)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema15)){echo 'Error intentar de nuevo'; return false;}

if(is_null($tema16)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema17)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema18)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema19)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema20)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema21)){echo 'Error intentar de nuevo'; return false;}

if(is_null($tema22)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema23)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema24)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema25)){echo 'Error intentar de nuevo'; return false;}
if(is_null($tema26)){echo 'Error intentar de nuevo'; return false;}

	$objCliente=new Ctr_minuta();
        
	if ( $objCliente->Evento_Alta(array($idusuario,
                                          $titulo,
                                          $fecha1,
                                          $hora,
                                          $convocado,
                                          $director,
                                          $invitado,
                                          $comite,
                                          $cantidad,                                         
                                          $tema1,
                                          $tema2,
                                          $tema3,
                                          $tema4,
                                          $tema5,
                                          $tema6,
                                          $tema7,
                                          $tema8,
                                          $tema9,
                                          $tema10,
                                          $tema11,
                                          $tema12,
                                          $tema13,
                                          $tema14,
                                          $tema15, $tema1,
                                          $tema16,
                                          $tema17,
                                          $tema18,
                                          $tema19,
                                          $tema20,
                                          $tema21,
                                          $tema22,
                                          $tema23,
                                          $tema24,
                                          $tema25,$tema26)) == false)
                {
            
            
            
		echo 'Evento Guardado';
	         }
                 
                 else
             {
		echo 'Se produjo un error. Intente nuevamente ';
	    }
}
else
{
    

?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/prueba2.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/pruebajquery.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<h2> <font color="#124A7B">Nuevo Evento</font></h2>

 <?php
            /*fin de guardar datos a procesar*/
    $time = time();
 
   
          $folio=date('d')."".date('m')."".date('y')."".date("His");
           echo ' <h3> [<a href="'.$redirect_uri.'?logout=1">Salir</a>]<br>&nbsp; &nbsp;&nbsp; &nbsp;</h3>';   
            ?>


  
<form id="RegisterUserForm" name="RegisterUserForm" action="Evento_Alta.php" method="post" onsubmit='Prueba2(); return false' >    
  
            
   <center>

<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Título del evento:</font></label>
<input class="w3-input" name="titulo" type="text"  id="titulo" value="" placeholder="Agregar título" onBlur="comprobarTitulo()" required autofocus/>        
  <span id="estadousuario"></span> 
</p> 


 <div id="formulariomayores" >
     <br>
 <label for="papa"><font face="Candara" size="3" COLOR="#2D35A9">Fecha del evento:</font></label>

 
 <div class="form-group">
                
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy/mm/dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" id="fecha1" name="fecha1" value="" placeholder="dd/mm/aaaa"   readonly required >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" /><br/>
            </div>
</div>
<!--------------------------------------------------------------------------->
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript">

	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
                startDate: '0',
                daysOfWeekDisabled:[0,6],
		forceParse: 0
    });
	
        
        
      
	
</script>


 <p>
     <label for="hora"><font face="Candara" size="3" COLOR="#2D35A9">Hora:</font></label>
     <input class="w3-input" type="time" name="hora" id="hora" value="00:00" max="22:30" min="07:00" step="1" required="">
 </p>
 
 
<p>
    <label for="comite"><font face="Candara" size="3" COLOR="#2D35A9">Para el comité:</font></label>
    <select  type="select" name="comite" class="w3-input" id="comite" disabled> 
 <?php

require('Ctr_minuta.php');
$objComite=new Ctr_minuta();
$consulta2=$objComite->mostrar_comite($dato);
  
 if( $cliente2 = mysql_fetch_array($consulta2) )
{
$id_comite=$cliente2[0];
$comite=$cliente2[1];
echo "<option value='$id_comite' selected>$comite</option> ";
}

  
?>


<!--
<select  type="select" name="comite" class="w3-input" id="comite"> 
<option value="">Selecciona Dirección </option> 
<option value="1">Sistemas</option> 
<option value="2">Administrativo</option> 
<option value="2">Recursos Humanos</option> 
 </select>
-->
 </select>
</p>


<p>
<label for="convocado"><font face="Candara" size="3" COLOR="#2D35A9">Convocado Por:</font></label>
<input class="w3-input" name="convocado" type="text"  id="convocado" value="<?php echo "$nombre"?>" placeholder="Agregar Convocado" required />           
</p>

<p>
<label for="invitado"><font face="Candara" size="3" COLOR="#2D35A9">Invitados:</font></label>
<input class="w3-input" name="invitado" type="text"  id="invitado" value="" placeholder="Agregar nombre de invitado"  />        
</p>
<?php
$objDir=new Ctr_minuta();
$consulta22=$objDir->mostrar_director();
  
 if( $cliente22 = mysql_fetch_array($consulta22) )
{
$iddir=$cliente22[0];
$namedirector=$cliente22[1];

}
?>


<p>
<label for="director"><font face="Candara" size="3" COLOR="#2D35A9">Director:</font></label>
<input class="w3-input" name="director" type="text"  id="director" value="<?php echo "$namedirector";?>" placeholder="Agregar Director" required/>        
</p>

<!--
<p>
<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Número de temas a tratar:</font></label>
<select required type="select" name="cantidad" class="w3-input" id="cantidad"> 
<option value="">Cantidad de temas </option> 
<option value="1">1</option> 
<option value="2">2</option>
<option value="3">3</option> 
<option value="4">4</option>
<option value="5">5</option> 
<option value="6">6</option>
 </select>            
</p>
-->
 <h2> <font color="#124A7B">Temas:</font></h2>
 <!-- 
<input class="w3-input" name="tema1" type="text"  id="tema1" value=""   placeholder="Agrega tema"/>
<br>
    
   
<input class="w3-input" name="tema2" type="text"  id="tema2" value=""  placeholder="Agrega tema" />
<br>
    

<input class="w3-input" name="tema3" type="text"  id="tema3" value=""  placeholder="Agrega tema" />
<br>
    

<input class="w3-input" name="tema4" type="text"  id="tema4" value=""  placeholder="Agrega tema" />
<br>
    

<input class="w3-input" name="tema5" type="text"  id="tema5" value=""  placeholder="Agrega tema" />
<br>
 

<input class="w3-input" name="tema6" type="text"  id="tema6" value=""  placeholder="Agrega tema" />
  -->  
<input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $folio ?>" />
<!------------------------------------------------------------------------------------------------->

<!--------------------------Agregar vesion dinamia----------------------------------------------------------------------->


<!---------------------------------------------------------------------------------------------------------------------->

 
<?php


$objPendiente=new Ctr_minuta();
$consulta1=$objPendiente->mostrar_tema_pendiente($dato);
 $counter = 0;  
 while( $cliente1 = mysql_fetch_array($consulta1) )
{
$counter = $counter + 1;
$id_tema=$cliente1[0];
$tema=$cliente1[1];
$id_evento=$cliente1[2];
$estatus=$cliente1[3];

?>
<script>
    
    $(document).ready(function()
  {
      /*
var id_tema=<?php echo "$id_tema"; ?>;
var tema=<?php echo "$tema"; ?>;
var id_evento=<?php echo "$folio"; ?>;
var id_comite=<?php echo "$id_comite"; ?>;

      
  ///////////////////////////insertar en automatico los pendientes////////////////////////////////////////
   $.ajax(
	              {url : 'Validar_temas.php?Insertpendientes=true&id_tema='+id_tema+'&tema='+tema+'&id_evento='+id_evento+'&id_comite='+id_comite,dataType : 'json',
		     }).done(function(data) 
                     {
			if (data.id == '-1')
                        {

                         alertify.error("Error: ");  
  
			} 
                        else 
                        {
				 alertify.success("Correcto");  
  
			}
		})
  */
/////////////////////////////////////////////////////////////////////
  var addButton = $('.btn-danger'); //Add button selector
  var wrapper = $('.col-sm-9'); //Input field wrapper
  var fieldHTML = '<div style="margin-top:10px"class="input-group"> <input type="text" name="field_producto123[]" class="form-control"  value="<?php echo"$tema";?>" placeholder="Ingresa tema" readonly>    <div class="input-group-btn">  <button type="button" id="btn-erase12" class="btn btn-info">-</button></div></div>'; //New input field html
  //Once add button is clicked
     
        $(wrapper).append(fieldHTML);
  
  $(wrapper).on('click', '#btn-erase', function(e)
  { //Once remove button is clicked
      e.preventDefault();
       $(this).parent().parent().remove(); //Remove field html
  });
});
</script>



<?php
 }
  
  $total = mysql_num_rows($consulta1);
    if($total==0)
  {
       ?>

    <div class="col-sm-9">
             <div class="input-group">
                  
                 
                  <div class="input-group-btn">
                      
                 <button type="button" class="btn btn-danger">+</button>
                 
               </div>
             </div>
       
  </div>
  
  <?php
  }
  else
  {
     
    echo '   <div class="col-sm-9">
             <div class="input-group">
                  
                  <div class="input-group-btn">
                 <button type="button" class="btn btn-danger">+</button>
               </div>
             </div>
  </div>';
  }
  

?>

    
 

<!------------------------------------------------------------------------------------------------------->
<input type='submit' name='submit' id='registerNew' value='Guardar Evento' /> 
<!--------------------------------------------------------------------------->

<input type="submit"  name="submit" value="Regresar" id='registerNew2' onclick="Cancelar();return false;" />
       
</form>
<h2> <font color="#124A7B">Archivos adjuntos:</font></h2>
<iframe width="100%" height="800px" src="cargararchivos.php?linea=<?php echo "$folio";?>&id_comite=<?php echo "$id_comite";?>" frameborder="0"  framespacing="0" scrolling="no" border="10"  allowfullscreen></iframe>        

<?php
}
    }
?>