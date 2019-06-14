

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
 $folio= $_GET["folio"];    
require('Control_temporal.php');
   $objPermanente=new Control_temporal();
  $consulta2=$objPermanente->mostrar_viajes($folio);
  $cliente2 = mysql_fetch_array($consulta2);
  

 //////////////
 //$id=$cliente2[0];
                      $id=$row[0];
$fecha=$cliente2[1];
$correo=$cliente2[2];
$alumno1=$cliente2[3];
$alumno2=$cliente2[4];
$alumno3=$cliente2[5];
$alumno4=$cliente2[6];
$alumno5=$cliente2[7];
$ncalle=$cliente2[8];
$ncolonia=$cliente2[9];
$ncp=$cliente2[10];
$responsble=$cliente2[11];
$parentesco=$cliente2[12];
$celular=$cliente2[13];
$telefono=$cliente2[14];
$fecha_inicial=$cliente2[15];
$ficha_final=$cliente2[16];
$turno=$cliente2[17];
$comentarios=$cliente2[18];
$calle=$cliente2[19];
$colonia=$cliente2[20];
$cp=$cliente2[22];

                      
                   
///////////////////////////////////////////////////////////////////////////////////
                
                 ///Ingreso codigo de alta//
                ?>

      
 <form id="RegisterUserForm" name="RegisterUserForm"  method="post" onsubmit='Alta_Viaje(); return false' >
  
            
   <center>
<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de solicitud:</font></label>
<input class="w3-input" name="fecha" type="text"  id="fecha" value="<?php echo $fecha;?>" readonly="readonly" />        
</p> 

<p>
<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Solicitante:</font></label>
<input class="w3-input" name="correo" type="text"  id="correo" value="<?php echo "$correo";?>" onkeyup="this.value=this.value.toUpperCase()" readonly="readonly"/>             
</p>   

 <h2><font color="#124A7B">Selecciona  Alumnos</font></h2>

	<table id="gradient-style" summary="Meeting Results">
    <thead>
   		<tr>
                <!--<th bgcolor="#CDCDCD">Id</th>-->
    		<th bgcolor="#CDCDCD">Alumno</th>
    		<th bgcolor="#CDCDCD">Grupo</th>
    		 <!--<th bgcolor="#CDCDCD">Grado</th>-->
         
           
        </tr>
       </thead>
       <?php
$consulta1=$objCliente->mostrar_alumnos2($alumno1,$alumno2,$alumno3,$alumno4,$alumno5);
if($consulta1)
    {
             $counter = 0;
            // $numero = mysql_num_rows($consulta);
	while( $cliente1 = mysql_fetch_array($consulta1) )
                {
             $idalumno=$cliente1[0];
             $nombre=$cliente1[1];
             $grado=$cliente1[2];
             $grupo=$cliente1[3];
             $contador++;
             $counter = $counter + 1;
	?>
	
		  <tr id="fila-<?php echo $idalumno; ?>">
                       
			  <td bgcolor="#ffffff"><?php echo  $nombre; ?></td>
			
			 <td bgcolor="#ffffff"><?php echo $grupo ?></td>

			 
		  </tr>
	<?php
       
	}
        
        $talumnos=$counter;
        
}



?>
    </table>
       

<h2><font color="#124A7B">Dirección de cambio</font> </h2> 
<p>
<label for="calle"><font face="Candara" size="3" COLOR="#2D35A9">Calle y Número:</font></label>
<input class="w3-input" name="calle" type="text"  id="calle" value="<?php echo "$ncalle";?>"  placeholder="Agrega campo y número" readonly/>
</p>
<p>
 <label for="colonia"><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label>
 <input class="w3-input" name="colonia" type="text"  id="colonia"  value="<?php echo "$ncolonia";?>"  placeholder="Agrega colonia" readonly />
</p>
<p>
<label for="cp"><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label></td>
<input class="w3-input" name="cp" type="number"  id="cp"  value="<?php echo "$ncp";?>" placeholder="Agrega CP"  readonly/>
</p>
          
  
 
 
    <br>

<h2>Datos de responsable</h2>
 <p> 
  <label for="responsable"><font face="Candara" size="3" COLOR="#2D35A9">Nombre:</font></label>
  <input class="w3-input"  name="responsable" type="text"  id="responsable" value="<?php echo "$responsble"; ?>" readonly />
 </p>
   <p> 
  <label for="parentesco"><font face="Candara" size="3" COLOR="#2D35A9">Parentesco:</font></label>
  <input class="w3-input"  name="parentesco" type="text"  id="parentesco" value="<?php echo "$parentesco"; ?>" readonly />
 </p>  
        
 
 <p>
<label for="celular"><font face="Candara" size="3" COLOR="#2D35A9">Celular:</font></label>
<input class="w3-input"  name="celular" type="number"  id="celular" value="<?php echo "$celular"; ?>" readonly/> 
</p>
    
<p>
<label for="telefono"><font face="Candara" size="3" COLOR="#2D35A9">Teléfono:</font></label>
<input class="w3-input"  name="telefono" type="number"  id="telefono"  value="<?php echo "$telefono"; ?>" readonly />
  </p>

  <p>
<label for="fechaini"><font face="Candara" size="3" COLOR="#2D35A9">Fecha inicial:</font></label>
<input class="w3-input" id="fechaini" name="fechaini" type="text" value="<?php echo "$fecha_inicial"; ?>" readonly/>
</p>
<p>    
<label for="fechater"><font face="Candara" size="3" COLOR="#2D35A9">Fecha final:</font></label>
<input class="w3-input" id="fechater" name="fechater" type="text" value="<?php echo "$ficha_final"; ?>" readonly/>
</p>

<p>
 <label for="ruta"><font face="Candara" size="3" COLOR="#2D35A9">Ruta:</font></label>  
 <select type="select" name="ruta"  id="ruta" disabled="disabled"> 
<option value="0"><?php echo "$turno"; ?> </option> 
<option value="Mañana">Mañana</option> 
<option value="Tarde">Tarde</option> 
<option value="Mañana-Tarde">Mañana-Tarde</option> 
</select>
</p>

 <p>
<label for="Comentarios"><font face="Candara" size="3" COLOR="#2D35A9">Respuesta:</font></label>
<textarea  readonly  class="w3-input"  id="Comentarios" name="comentarios"   onkeyup="this.value=this.value.toUpperCase()" placeholder="Aun sin mensaje"><?php echo "$mensaje";?></textarea>
</p>
 <p>
<label for="Comentarios"><font face="Candara" size="3" COLOR="#2D35A9">Comentarios:</font></label>
<textarea readonly  class="w3-input"  id="Comentarios" name="comentarios"   onkeyup="this.value=this.value.toUpperCase()"><?php echo "$comentaios";?></textarea>
</p>
<input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $usuario ?>" />
<input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $fam ?>" />
<input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />

<div id="custom-speed" class="btn">
  

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

}
?>