

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
 
require('Control_choferes.php');	
$idusuario= htmlspecialchars(trim($_POST['idusuario']));
$nfamilia = htmlspecialchars(trim($_POST['nfamilia']));
$chofer= htmlspecialchars(trim($_POST['chofer']));
$correo = htmlspecialchars(trim($_POST['correo']));
$paterno= htmlspecialchars(trim($_POST['paterno']));
$materno = htmlspecialchars(trim($_POST['materno']));
$nombre=$chofer." ".$paterno." ".$materno;

$marca= htmlspecialchars(trim($_POST['marca']));
$modelo = htmlspecialchars(trim($_POST['modelo']));
$color= htmlspecialchars(trim($_POST['color']));
$placas = htmlspecialchars(trim($_POST['placas']));


if(is_null($idusuario)){echo 'Error intentar de nuevo'; return false;}
if(is_null($nfamilia)){echo 'Error intentar de nuevo'; return false;}
if(is_null($chofer)){echo 'Error intentar de nuevo'; return false;}
if(is_null($correo)){echo 'Error intentar de nuevo'; return false;}
if(is_null($paterno)){echo 'Error intentar de nuevo'; return false;}
if(is_null($materno)){echo 'Error intentar de nuevo'; return false;}
if(is_null($marca)){echo 'Error intentar de nuevo'; return false;}
if(is_null($modelo)){echo 'Error intentar de nuevo'; return false;}
if(is_null($color)){echo 'Error intentar de nuevo'; return false;}
if(is_null($placas)){echo 'Error intentar de nuevo'; return false;}



  
  $ObjAuto=new Control_choferes();
$consulta12=$ObjAuto->obtener_ID();

 while($cliente12 = mysql_fetch_array($consulta12))
{
   $idauto=$cliente12[0];
$folio=$idauto+1;
$foto="C:\\\\IDCARDDESIGN\\\\CREDENCIALES\\\\\padres\\\\".$nfamilia."-".$folio.".JPG";
 }



$objCliente=new Control_choferes();

$verdadero=1;
$falso=0;
	
	if ( $objCliente->Alta_chofer(array($nfamilia,
            $nombre,
            $correo,$marca,$modelo,$color,$placas,$folio,$foto )) == false)
                {
		echo$verdadero;
	}else{
		echo$falso;
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
alertify.alert("<h2><font color='#124A7B'>Alta de Chofer:</font> </h2><p align='justify'>Una vez terminado el proceso no olvides descarga el formato y llevar los papeles solicitados.<br><font color='red'>Nota: Solo se pueden agregar 2 choferes y 2 autos.</font></p>", function(){
 });


</script>
      
<form id="RegisterUserForm" name="RegisterUserForm" action="Choferes_alta.php" method="post" onsubmit='Alta_Chofer(); return false' >
  
             
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
   <label for="chofer"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Nombres:</font></label>
   <input name="chofer" id="chofer" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z ]{3,40}"
         title="Agrega nombres sin acentos, numeros o signos especiales" />      
</p>

<p>
   <label for="marca"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Apellido Paterno:</font></label>
   <input name="paterno" id="paterno" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z ]{3,40}"
         title="Agrega Apellido sin acentos, numeros o signos especiales"/>      
</p>

<p>
   <label for="modelo"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Apellido Materno:</font></label>
   <input name="materno" id="materno" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z ]{3,40}"
         title="Agrega apellido sin acentos, numeros o signos especiales"/>      
</p>

<!-------------------------------Auto----------------------------------->

<?php
require('Control_choferes.php');
$ObjRfc=new Control_choferes();
$consulta1=$ObjRfc->mostrar_autos($fam);
 $contador=0;
 if($cliente1 = mysql_fetch_array($consulta1))
  {
     
 $contador++; 
 
$idauto=$cliente1[0];
$marca=$cliente1[1];
$modelo=$cliente1[2];
$color=$cliente1[3];
$placas=$cliente1[4];
  }

?>
<p>
   <label for="chofer"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Marca:</font></label>
   <input name="marca" id="marca" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z0-9 ]{3,20}"
         title="Agrega marca sin acentos, numeros o signos especiales" />      
</p>

<p>
   <label for="marca"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Modelo/Submarca:</font></label>
   <input name="modelo" id="modelo" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z0-9 ]{3,20}"
         title="Agrega modelo sin acentos, numeros o signos especiales"/>      
</p>

<p>
   <label for="modelo"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Color:</font></label>
   <input name="color" id="color" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z ]{3,20}"
         title="Agrega color sin acentos, numeros o signos especiales"/>      
</p>
<p>
   <label for="modelo"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Placas:</font></label>
   <input name="placas" id="placas" class="w3-input" type="text"   placeholder="Dato obligatorio" value="" minlength="3" maxlength="40" onkeyup="this.value=this.value.toUpperCase()"   required pattern="[A-Za-z0-9]{3,8}"
         title="Agrega placas sin acentos,simbolos especiales o espacios"/>      
</p>

<!------------------------------------------------------------------>
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