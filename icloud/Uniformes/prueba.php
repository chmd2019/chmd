
<?php


include_once("../Model/DBManager.php");

require('Ctr_uniformes.php');

include("../correo/class.phpmailer.php");

include("../correo/class.smtp.php");

$objCliente=new Ctr_uniformes;

$consulta=$objCliente->Correo();

$total = mysql_num_rows($consulta);
if($total==0){echo "<tr><td text-align: center;><b><p align='center'>ho hay datos</p></b><td></tr>";}
   
if($consulta) 
{
 
while( $cliente = mysql_fetch_array($consulta) )
{

   

            
$id=$cliente[0];            
$familia=$cliente[1];
$correo=$cliente[2];

 



$body = "<center><h2><font color='#124A7B'>Detalles de Pedido de Uniformes:$familia</font></h2></center>";
$body .= "<center>  <table table border='1'  style='width: 100%;'>";
$objCliente1=new Ctr_uniformes;
$consulta1=$objCliente1->Correo_pedido_casico($familia);
while( $cliente1 = mysql_fetch_array($consulta1) )
{
$Alumno=$cliente1['nombre'];
$producto1=$cliente1['producto1'];
$cant_sudadera=$cliente1['cant_sudadera'];
$talla_sudadera=$cliente1['talla_sudadera'];
$producto2=$cliente1['producto2'];
$cant_panst=$cliente1['cant_panst'];
$talla_pants=$cliente1['talla_pants'];
$producto3=$cliente1['producto3'];
$cant_playera=$cliente1['cant_playera'];
$talla_playera=$cliente1['talla_playera'];
$producto4=$cliente1['producto4'];
$cant_educacionf=$cliente1['cant_educacionf'];
$talla_educacionf=$cliente1['talla_educacionf'];
$producto5=$cliente1['producto5'];
$cant_kinder=$cliente1['cant_kinder'];
$talla_kinder=$cliente1['talla_kinder'];
$idpaquete=$cliente1['idpaquete'];

$tiposuda=$cliente1['tiposuda'];

if($tiposuda==1)
{   
 $tiposuda="SUDADERA"; 
}
elseif ($tiposuda==2)
{   
 $tiposuda="CHAMARRA"; 
}
          
//paquete 1
if($idpaquete==1)
{
$body .= "
                
                 <tr align='center' valign='middle'> 
                <td colspan=3  bgcolor='#124A7B'><font color='#FFFFFF'>Alumno:   $Alumno paquete:$idpaquete</font></td>
                </tr>
   		<tr>
   	         <th  bgcolor='#124A7B'><font color='#FFFFFF'>Producto</font></th>
    		 <th  bgcolor='#124A7B'><font color='#FFFFFF'>Cantidad</font></th>
    		 <th  bgcolor='#124A7B'><font color='#FFFFFF'>Talla</font></th>
                </tr>


<tr>
   <td>$producto5</td>
   <td>$cant_kinder</td>
   <td>$talla_kinder</td>
</tr>		
";
    
}//paquete 1 fin

  //paquete 2
if($idpaquete==2)
{
    	$body .= "
                 <tr align='center' valign='middle'> 
                <td colspan=3  bgcolor='#124A7B'><font color='#FFFFFF'>Alumno:   $Alumno paquete:$idpaquete</font></td>
                </tr>
   		<tr>
   	         <th  bgcolor='#124A7B'><font color='#FFFFFF'>Producto</font></th>
    		 <th  bgcolor='#124A7B'><font color='#FFFFFF'>Cantidad</font></th>
    		 <th  bgcolor='#124A7B'><font color='#FFFFFF'>Talla</font></th>  
                  </tr>
	         
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

		 ";
    
}    //paquete 2 fin  

//paquete 3  
if($idpaquete==3)
{
    $body .= "
                 <tr align='center' valign='middle'> 
                <td colspan=3 bgcolor='#124A7B'><font color='#FFFFFF'>Alumno:   $Alumno paquete:$idpaquete</font></td>
                </tr>
   		<tr>
   	         <th bgcolor='#124A7B'><font color='#FFFFFF'>Producto</font></th>
    		 <th bgcolor='#124A7B'><font color='#FFFFFF'>Cantidad</font></th>
    		 <th bgcolor='#124A7B'><font color='#FFFFFF'>Talla</font></th>
          
        </tr>
	
	<tr>
		<td>$tiposuda</td>
		<td>$cant_sudadera</td>
		<td>$talla_sudadera</td>
		</tr>
		
		
	<tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td>$talla_playera</td>
		</tr>
		
		
		";
} //paquete 3 fin  

//paquete 4 
if($idpaquete==4)
{
    $body .= "
                  <tr align='center' valign='middle'> 
                <td colspan=3 bgcolor='#124A7B'><font color='#FFFFFF'>Alumno:   $Alumno paquete:$idpaquete</font></td>
                </tr>
   		<tr>
                 
   	         <th bgcolor='#124A7B'><font color='#FFFFFF'>Producto</font></th>
    		 <th bgcolor='#124A7B'><font color='#FFFFFF'>Cantidad</font></th>
    		 <th bgcolor='#124A7B'><font color='#FFFFFF'>Talla</font></th>
          
        </tr>
	
	<tr>
		<td> $producto1</td>
		<td> $cant_sudadera</td>
		<td>$talla_sudadera </td>
		</tr>
		
		
	        <tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td>$talla_playera</td>
		</tr>

		";
           
    
}
//paquete 3  
if($idpaquete==5)
{
    $body .= "
                 <tr align='center' valign='middle'> 
                <td colspan=3 bgcolor='#124A7B'><font color='#FFFFFF'>Alumno:   $Alumno paquete:$idpaquete</font></td>
                </tr>
   		<tr>
   	         <th bgcolor='#124A7B'><font color='#FFFFFF'>Producto</font></th>
    		 <th bgcolor='#124A7B'><font color='#FFFFFF'>Cantidad</font></th>
    		 <th bgcolor='#124A7B'><font color='#FFFFFF'>Talla</font></th>
          
        </tr>
	</thead>
	<tr>
		<td>$tiposuda</td>
		<td>$cant_sudadera</td>
		<td>$talla_sudadera</td>
		</tr>
		
		
	<tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td>$talla_playera</td>
		</tr>
		
		
		";
} //paquete 3 fin  
      


    


}

$body .=       " </table> <center><br>";
$body .=       "<font color='#FF2626' size='3'>Nota:Una vez seleccionada la talla y el modelo no habrá cambios.<font>";
  $body .=       "<h3><font color='#124A7B'>Favor de no responder el correo.<br> Gracias</font> <h3> ";
//$body = 'Link para evaluación:<br>http://192.168.5.70:65083/CHMD/ ';
 

echo  $body; // Mensaje a enviar



             
	
	}
}
else
{
    echo "Error";
}
?>
         

