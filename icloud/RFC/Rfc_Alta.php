

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
else 
{
    /*enviar datos a procesar */
    
   
if(isset($_POST['submit']))
    {
 
require('Control_rfc.php');	
$idusuario= htmlspecialchars(trim($_POST['idusuario']));
$nfamilia = htmlspecialchars(trim($_POST['nfamilia']));
$razonsocial = htmlspecialchars(trim($_POST['razonsocial']));
$rfc = htmlspecialchars(trim($_POST['rfc']));
$calle = htmlspecialchars(trim($_POST['calle']));
$colonia = htmlspecialchars(trim($_POST['colonia']));
$cp = htmlspecialchars(trim($_POST['cp']));
$municipio = htmlspecialchars(trim($_POST['municipio']));
$entidad = htmlspecialchars(trim($_POST['entidad']));
$correo = htmlspecialchars(trim($_POST['correo']));


	$objCliente=new Control_rfc();
	if ( $objCliente->Alta_rfc(array($rfc,
$razonsocial,
$entidad,
$calle,
$colonia,
$municipio,
$cp,
$nfamilia,
$correo,
$idusuario )) == false)
                {
		echo 'Solicitud Guardada';
	}else{
		echo 'Se produjo un error. Intente nuevamente ';
	}
} 
    else
 {
    
    
    
    /*fin de guardar datos a procesar*/
    $time = time();
 $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
 
   $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
       'Miercoles', 'Jueves', 'Viernes', 'Sabado');
   
   
   
    
         $user = $service->userinfo->get(); //get user info 
	$correo=$user->email;
        require('../Model/Login.php');
       $objCliente=new Login();
       $consulta=$objCliente->Acceso($correo);
       if($consulta) //if user already exist change greeting text to "Welcome Back"
    {
           
           
           
           
            if( $cliente = mysql_fetch_array($consulta) )
              
        {
 
$id=$cliente[0];
$correo1=$cliente[1];
$perfil=$cliente[2];
$estatus=$cliente[3];
$fam=$cliente[4];

/////////////////////datos de domicilio de familia//////////////////////////////////
 
  
///////////////////////////////////////////////////////////////////////////////////
                
                 ///Ingreso codigo de alta//
                ?>
<script type="text/javascript">
alertify.alert("<h2><font color='#124A7B'>Cambios de datos:</font> </h2><p align='justify'>Una vez validado el cambio, recibira correo de confirmacion.</p>", function(){
 });


</script>
      
<form id="RegisterUserForm" name="RegisterUserForm" action="Rfc_Alta.php" method="post" onsubmit='Alta_Rfc(); return false' >
  
             
   <br>  
   <center>
<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de solicitud:</font></label>
<input class="w3-input" name="fecha" type="text"  id="fecha" value="<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>" readonly="readonly" />        
</p> 

<p>
<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Solicitante:</font></label>
<input class="w3-input" name="correo" type="text"  id="correo" value="<?php echo "$correo";?>" onkeyup="this.value=this.value.toUpperCase()" readonly="readonly"/>             
</p>   
  
 <br>

<p>
   <label for="razonsocial"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Razon Social:</font></label>
   <input name="razonsocial" id="razonsocial" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" style="text-transform:uppercase;"  required/>      
</p>
<p>      
 <label for="razonsocial"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">RFC:</font></label>
  <input class="w3-input" name="rfc" type="text"  maxlength="13" id="rfc" value="" style="text-transform:uppercase;"   placeholder="xxx-xxxxxx-xxx" required/>
</p>

<p>
<label for="calle"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Calle y Número:</font></label>
<input class="w3-input" name="calle" type="text"  maxlength="35" id="calle" value="" style="text-transform:uppercase;"   placeholder="Agrega campo y número" required/>
</p>
<p>
 <label for="colonia"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label>
 <input class="w3-input" name="colonia" type="text"  id="colonia"   placeholder="Agrega colonia" style="text-transform:uppercase;"  required />
</p>

<p>
<label for="cp"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label>
<input class="w3-input" name="cp" type="number"  id="cp" placeholder="Agrega CP" required/>
</p>
  
<p>
 <label for="municipio"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Delegación / municipio:</font></label>
 <input class="w3-input" name="municipio" type="text"  id="municipio"   placeholder="Agrega Delegación / municipio" style="text-transform:uppercase;"  required />
</p>
  
<label for="ruta"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Entidad Federativa:</font></label><br>
   <select required type="select" name="entidad"  id="entidad"> 
<option value="0">selecciona opción </option> 
<option value="Ciudad de México">Ciudad de México</option> 
<option value="Estado de México">Estado de México</option> 
</select>
 

<br>

<input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $id ?>" />
<input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $fam ?>" />
<div id="custom-speed" class="btn">
  
<input type="submit" name="submit" value="Enviar"/>
<input type="submit"  name="submit" value="Regresar" onclick="Cancelar();return false;" />
</div>
       
</form>
                
               
           
           <?php
         }
         
         
         
         
          else
      {
                  echo 'Este usuario no tiene Acceso:'.$user->email.',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="'.$redirect_uri.'?logout=1"> Log Out</a>]';
                  
      }
         
        
     
       
    }
    
    
       else //error en cosulta
        { 
            
            echo 'Error en cosulta';
          
          
       }
}//
}
?>