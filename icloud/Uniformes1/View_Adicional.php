                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

include_once("../Model/DBManager.php");

if(isset($_POST['submit']))
 {
	require('Ctr_uniformes.php');
	$objUniforme1=new Ctr_uniformes;
	
	$familia = htmlspecialchars(trim($_POST['familia']));
        
	if ( $objUniforme1->Terminar_pedido_adicional(array($familia)) == true)
            {
		//echo 'Pedido terminado';
            
	   }else
                {
		//echo 'Se produjo un error. Intente nuevamente';
	          } 
}
else
    {

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
	
	echo '<br><br><a  href="' . $authUrl . '"><img src="../images/google.png"  id="total"/></a>';
	echo '</div>';
	

        
        
    } 
   else
   {
     
       
       ?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>
$(document).ready(function()
{
$(".inline").colorbox({inline:true, width:"70%",height:"70%"});
$(".group4").colorbox({rel:'group4', slideshow:true});
});
</script>
<script src="js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="css/colorbox.css" />

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
			url: 'Guardar_pedido.php',
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
         
      

           <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.fw.png' width='80px' height='80px' alt='$modulo'></a>
           <a href='../index.php' title='Regresar'> <img src='../images/home.png' width='100px' height='100px' alt='$modulo'></a>
       </p>
       
        <table id="gradient-style" summary="Meeting Results" style='width: 100%;'>
    <thead>
   		<tr>
		
		<!--<th bgcolor="#CDCDCD">Id</th>-->
   	        <th bgcolor="#CDCDCD">Alumno</th>
    		 <!--<th bgcolor="#CDCDCD">Grado a Cursar</th>-->
    		
             <th bgcolor="#CDCDCD">Solicitud</th>
           <!--  <th bgcolor="#CDCDCD">Estatus</th>-->
        </tr>
        </thead>
        
 
    

       
<?php 
/////////////////////////////////////////////////////////////
  require('Ctr_uniformes.php');
   $objAlumnos=new Ctr_uniformes();
  $consulta2=$objAlumnos->mostrar_alumnos_adicional($familia);
   $contador=0;
   $contador1=0;
  $total = mysql_num_rows($consulta2);
    if($total==0){echo "<tr><td text-align: center;><b><p align='center'>sin datos de familia:$familia</p></b><td></tr>";}
    ///////////validacion de termino de pedido parcial////////////////////////////////////////////////
    $consulta2=$objAlumnos->mostrar_alumnos_adicional($familia);
    //////////////////////////////////////////////////////////////
while( $cliente1 = mysql_fetch_array($consulta2) )
        {
        $idalumno=$cliente1['id'];
        $idfamilia=$cliente1['idfamilia'];
        $alumno=$cliente1['nombre'];
        $grado=$cliente1['grado_cursar'];
        $status=$cliente1['status'];
        $idpaquete=$cliente1['idpaquete'];
        $contador++;
       
        
        
        
        if($status==1)
        {
            
          
              echo "    <tr id='fila-<?php echo  $idalumno ?>'>
		       <!--   <td>$idalumno</td>-->
			  <td>$alumno</td>
			 <!--<td>$grado</td>-->
			  <td><span class='modi'><img src='../images/complete.jpg' title='bloqueado' width='55px' height='50px' alt='bloqueado' /> </span></td>
			  <!--  <td><span id='nuevo'><img src='../images/bueno.png' width='40px' height='40px' alt='Agregar dato' /></span></td>-->
		  </tr>";
            
        }
     
        
        if($status==0)
        {
              $contador1++;
        
         echo "    <tr id='fila-$idalumno'>
		    <!--   <td>$idalumno</td>-->
		   <td>$alumno</td>
		    <!--  <td>$grado</td>-->	  
	           <td><span class='modi' id='modi'><a href='Guardar_Pedido.php?id=$idalumno' title='Nuevo'> <img src='../pics/editar.png' width='40px' height='40px' alt='Nueva'><font face='Candara' size='2' COLOR='#0F0A0A'><br>Selecciona</font></a></span></td>
		    <!--  <td><span id='nuevo'><img src='../images/alerta.png' width='40px' height='40px' /></a></span></td>-->
		   </tr>";
            }
        
	}
	
          if($status==3)
        {
            
          
              echo "   <tr align='center' valign='middle'> 
		           <td valign='middle' colspan=5><br><br>Pedido Terminado.<br>Le enviaremos un correo con la confirmación y descripción de su pedido.<br><br>Gracias por su atención.</td>
			
		         </tr>";
           
        
        
	
	}
 if($status==null)

{
       echo "   <tr align='center' valign='middle'> 
		          <td valign='middle' colspan=5><br>$alumno<br><b>AVISO<b><BR>Para su o sus hijos ya no aplica este servicio. <br>Seguramente porque sus hijos van en los últimos grados de bachillerato<br>Dudas favor de comunicarse al área de administración. <br><br> Gracias por su atención.<br></td>
			
		         </tr>";
           


}
$validar= $contador- $contador1;

 if($status==0 || $status==1 )
        {
            echo "<tr align='center' valign='middle'> <td colspan=5>
                <form id='frm' name='frm' method='post' action='View_Adicional.php' onsubmit='Terminar_pedido(); return false'>
               <input  type='hidden' name='validar' id='validar' value='$validar' />
               <input  type='hidden' name='familia' id='familia' value='$familia' />    


               <input type='submit' name='submit' id='registerNew' value='Terminar Pedido' /> 
                    </form>
                 </td></tr>";
        }
?>
     
           <tr align='center' valign='middle'> 
             
             <td colspan=5><a class='inline' href="#inline_content"><img src='images/sign.png' width=60 height=50 /><br>Detalles de Pedido Adicional</a></td>
			
             </td>
			 
             
         </tr>
    </table>
       
       
       
  <div style='display:none'>
			<div id='inline_content' style='padding:30px; background:#fff;'>
                            <center><h2><font color="#124A7B">Detalles de pedido adicional</font> </h2></center>
    <center>   <table id="gradient-style" summary="Meeting Results" style='width: 100%;'>
   
        <?php
        $res=mysql_query("SELECT * FROM uniformes_alumnos_adicional where idfamilia=".$idfamilia."  ");
        while($row=mysql_fetch_array($res))
        { 
$Alumno=$row['nombre'];
$producto1=$row['producto1'];
$cant_sudadera=$row['cantidad_sudadera'];
$talla_sudadera=$row['talla_sudadera'];
$producto2=$row['producto2'];

$cant_panst=$row['cantidad_pants'];

$talla_pants=$row['talla_pants'];
$producto3=$row['producto3'];


$cant_playera=$row['cantidad_playera'];

$talla_playera=$row['talla_playera'];
$producto4=$row['producto4'];



$cant_educacionf=$row['cantidad_educacionf'];


$talla_educacionf=$row['talla_educacionf'];
$producto5=$row['producto5'];

$cant_kinder=$row['cantidad_kinder'];

$talla_kinder=$row['talla_kinder'];
$idpaquete=$row['idpaquete'];

$tiposuda=$row['tiposuda'];
$tipoplayera=$row['tipoplayera'];
$tipopants=$row['tipopants'];
$tipoedu=$row['tipoedu'];
$sexo=$row['sexo'];

if($tiposuda==3)
{
   $tiposuda="no aplica"; 
}
elseif ($tiposuda==1)
{   
 $tiposuda="SUDADERA"; 
}
elseif ($tiposuda==2)
{   
 $tiposuda="CHAMARRA"; 
}

//////////////
if($tipoplayera==3)
{
   $tipoplayera="no aplica"; 
}
elseif ($tipoplayera==1)
{   
 $tipoplayera="DAMA"; 
}
elseif ($tipoplayera==2)
{   
 $tipoplayera="CABALLERO"; 
}
/////////////

if($tipopants==3)
{
   $tipopants="no aplica"; 
}
elseif ($tipopants==1)
{   
 $tipopants="DAMA"; 
}
elseif ($tipopants==2)
{   
 $tipopants="CABALLERO"; 
}
/////////////////////

if($tipoedu==3)
{
   $tipoedu="no aplica"; 
}

elseif ($tipoedu==1)
{   
 $tipoedu="DAMA"; 
}
elseif ($tipoedu==2)
{   
 $tipoedu="CABALLERO"; 
}
///////////



//paquete 1
if($idpaquete==1)
{
echo " <tr>   <table id='gradient-style' summary='Meeting Results'>
                <thead>
                 <tr align='center' valign='middle'> 
                <th colspan=3>Alumno:   $Alumno</th>
                </tr>
                <tr>
                 <td colspan=3></td>
                </tr>
                
   		<tr>
   	         <th bgcolor='#CDCDCD'>Producto</th>
    		 <th bgcolor='#CDCDCD'>Cantidad</th>
    		 <th bgcolor='#CDCDCD'>Talla</th>
               
          
        </tr>
	</thead>

<tr>
   <td>$producto5</td>
   <td>$cant_kinder</td>
   <td>$talla_kinder</td>
       
        
</tr>		
		</table>
	</tr>";
    
}//paquete 1 fin

  //paquete 2 primaria
if($idpaquete==2)
{
    	echo "<tr>
		<table id='gradient-style' summary='Meeting Results'>
                <thead>
                  <tr align='center' valign='middle'> 
                <th colspan=3>Alumno:   $Alumno</th>
                </tr>
                <tr>
                 <td colspan=3></td>
                </tr>
   		<tr>
   	         <th bgcolor='#CDCDCD'>Producto</th>
    		 <th bgcolor='#CDCDCD'>Cantidad</th>
    		 <th bgcolor='#CDCDCD'>Talla</th>  
               
                  </tr>
	          </thead>
	          <tr>
		<td> $producto1</td>
		<td> $cant_sudadera</td>
		<td>$talla_sudadera</td>
                
		</tr>
		

		<tr>
		<td> $producto2</td>
		<td> $cant_panst</td>
                 <td>$talla_pants</td>
                 
		</tr>
		
	        <tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td>$talla_playera</td>
               
		</tr>
		
                 <tr>
                 <td>$producto4</td>
                 <td>$cant_educacionf</td>
                 <td>$talla_educacionf</td>
                
                 </tr>

		
		</table>
                </tr> ";
    
}    //paquete 2 fin  

////////////////////paquete 5/////////////////////

if($idpaquete==5 ||$idpaquete==3 || $idpaquete==4)
{
    	echo "<tr>
		<table id='gradient-style' summary='Meeting Results'>
                <thead>
                  <tr align='center' valign='middle'> 
                <th colspan=4>Alumno:   $Alumno</th>
                </tr>
                <tr>
                 <td colspan=4></td>
                </tr>
   		<tr>
   	         <th bgcolor='#CDCDCD'>Producto</th>
    		 <th bgcolor='#CDCDCD'>Cantidad</th>
    		 <th bgcolor='#CDCDCD'>Talla</th>  
                 <th bgcolor='#CDCDCD'>Tipo</th>
                  </tr>
	          </thead>
	          <tr>
		<td> $producto1</td>
		<td> $cant_sudadera</td>
		<td>$talla_sudadera</td>
                <td>$tiposuda</td>
		</tr>
		

		<tr>
		<td> $producto2</td>
		<td> $cant_panst</td>
                 <td>$talla_pants</td>
                  <td colspan=2></td>
		</tr>
		
	        <tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td>$talla_playera</td>
                <td colspan=2></td>
		</tr>
		
                 <tr>
                 <td>$producto4</td>
                 <td>$cant_educacionf</td>
                 <td>$talla_educacionf</td>
                 <td colspan=2></td>
                 </tr>

		
		</table>
                </tr> ";
    
}

////////////////////////////////////
//paquete 3  








        }
        ?>
     
			
     </table>
        </center>
			</div>
</div>
       
       
 <?php

///////////////////////////////////////////////////
   }
}//fin de submit
?>




