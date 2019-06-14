

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
require('Control_permanente.php');
   $objPermanente=new Control_permanente();
  $consulta2=$objPermanente->mostrar_permanente($folio);
  $cliente2 = mysql_fetch_array($consulta2);
  

 //////////////
 //$id=$cliente2[0];
                      $fecha=$cliente2[1];
                      //$correo=$cliente2[2];
                      $calle=$cliente2[3];
                      $colonia=$cliente2[4];
                      $cp=$cliente2[5];
                      $ncalle=$cliente2[6];
                      $ncolonia=$cliente2[7];
                      $ncp=$cliente2[8];
                      $rutan=$cliente2[9];
                      $comentaios=$cliente2[10];
                      $lunes=$cliente2[11];
                      $martes=$cliente2[12];
                      $miercoles=$cliente2[13];
                      $jueves=$cliente2[14];
                      $viernes=$cliente2[15];
                      $alumno1=$cliente2[16];
                      $alumno2=$cliente2[17];
                      $alumno3=$cliente2[18];
                      $alumno4=$cliente2[19];
                      $alumno5=$cliente2[20];
                      $mensaje=$cliente2[21];
                      
                      if($lunes=="0"){$nlunes=''; }else{$nlunes='checked';}
                      if($martes=="0"){$nmartes='eee'; }else{$nmartes='checked';}
                      if($miercoles=="0"){$nmiercoles=''; }else{$nmiercoles='checked';}
                      if($jueves=="0"){$njueves=''; }else{$njueves='checked';}
                      if($viernes=="0"){$nviernes=''; }else{$nviernes='checked';}
///////////////////////////////////////////////////////////////////////////////////
                
                 ///Ingreso codigo de alta//
                ?>

      
 <form id="RegisterUserForm" name="RegisterUserForm" action="Permanente_Alta.php" method="post" onsubmit='Alta_Permante(); return false' >
  
            
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
          
  
 
    <h2><font color="#124A7B">Días de cambio:</font></h2>
    <br>
<table border=0>

<tr>
    <td colspan="5">
        
        <table>
            <tr>
                <td>
                   <b>Lunes</b> 
                </td>
                <td><br>&nbsp;&nbsp;</td>
                 <td>
                    <input type="checkbox" name="dia[]" id="lunes" value="lunes" disabled="disabled" <?php echo "$nlunes";?>>
                </td>
            </tr>
            <tr><td colspan="2">&nbsp;&nbsp;</td></tr>
            <tr>
                <td>
                  <b>Martes</b>  
                </td>
                <td>&nbsp;&nbsp;</td>
                 <td>
                   <input type="checkbox" name="dia[]" id="martes" value="martes" disabled="disabled" <?php echo "$nmartes";?>> 
                </td>
            </tr>
             <tr><td colspan="2">&nbsp;&nbsp;</td></tr>
            <tr>
                <td>
                   <b>Miércoles&nbsp;&nbsp;</b> 
                </td>
                <td>&nbsp;&nbsp;</td>
                 <td>
                   <input type="checkbox" name="dia[]" id="miercoles" value="miercoles"  disabled="disabled" <?php echo "$nmiercoles";?>> 
                </td>
            </tr>
             <tr><td colspan="2">&nbsp;&nbsp;</td></tr>
            <tr>
                <td>
                   <b>Jueves</b> 
                </td>
                <td>&nbsp;&nbsp;</td>
                 <td>
                    <input type="checkbox" name="dia[]" id="jueves" value="jueves"  disabled="disabled" <?php echo "$njueves";?>>
                </td>
            </tr>
                         <tr><td colspan="2">&nbsp;&nbsp;</td></tr>

            <tr>
                <td>
                   <b>Viernes</b> 
                </td>
               <td>&nbsp;&nbsp;</td>
                 <td>
                    <input type="checkbox" name="dia[]" id="viernes" value="viernes" disabled="disabled" <?php echo "$nviernes";?>><br> &nbsp;&nbsp;
                </td>
            </tr>
        </table>
       
         </td>
</tr>
    <tr>
        <td colspan="5"><br><br></td>
    </tr>
    <tr>
        

        <td align="left" colspan="5"> <br>
            <table border="0">
                <tr>
                    <td  align="right">
                      <label for="ruta"><font face="Candara" size="3" COLOR="#2D35A9">Ruta:</font></label>  
                    </td>
                    <td>
 <select disabled type="select" name="ruta"  id="ruta"> 
<option value="0"><?php echo "$rutan";?> </option> 
<option value="General 2:50 PM">General 2:50 PM</option> 
<option value="Taller 4:30 PM">Taller 4:30 PM</option> 
                    </td>
                </tr>
            </table>



</td>

    </tr>
</table>
<br>

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