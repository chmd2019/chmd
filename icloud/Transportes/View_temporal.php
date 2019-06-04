<?php

  	$user = $service->userinfo->get(); //get user info 
	$correo=$user->email;
        require('../Model/Login.php');
       $objCliente=new Login();
       $consulta=$objCliente->Acceso($correo);
     
	if($consulta) //if user already exist change greeting text to "Welcome Back"
    {
            
         
 
 if( $cliente = mysql_fetch_array($consulta) )
              
{
     ?>

     <p align='center'>
         <span class='nuevo' id='nuevo'><a href='Temporal_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.png' width='80px' height='80px' alt='$modulo'></a>
       </p>
        <table id="gradient-style" summary="Meeting Results">
    <thead>
        <tr>
     
       <th bgcolor="#CDCDCD">Fechas</th>
       <th bgcolor="#CDCDCD">Estatus</th>

        </tr>
        </thead>
   
     
 <?php
 $id=$cliente[0];
$correo=$cliente[1];
$perfil=$cliente[2];
$estatus=$cliente[3];
$familia=$cliente[4];

/////////////////////////////////
  require('Control_temporal.php');
   $objPermanente=new Control_temporal();
  $consulta2=$objPermanente->mostrar_viaje($familia);
   $contador=0;
    $total = mysql_num_rows($consulta2);
  if($total==0){echo "<tr><td text-align: center;><b><p align='center'>Sin datos de permisos actualmente</p></b><td></tr>";}
  
   while($cliente2 = mysql_fetch_array($consulta2))
   {
 $contador++; 
 $Idpermiso=$cliente2[0];
 $fecha=$cliente2[25];
 
$status1=$cliente2[20];
            
            if($status1==1){$staus11="Pendiente";}
             if($status1==2){$staus11="Autorizado";}
              if($status1==3){$staus11="Declinado";}
       
              
              
               /*  echo "<tr>
                  
		   
		  <td><span class='modi' id='modi'><a href='Temporal_Ver.php?folio=$Idpermiso'>$fecha</span></td>
                  <td><span class='modi' id='modi'><a href='Temporal_Ver.php?folio=$Idpermiso'>$staus11</span></td>
                  
                   </tr>  ";*/
              
               echo "<tr>
                  
		   
		  <td><span class='modi' id='modi'>$fecha</span></td>
                  <td><span class='modi' id='modi'>$staus11</span></td>
                  
                   </tr>  ";
   }
   echo "     </table>";



//fin 

 
}
     else
      {
                  echo 'Este usuario no tiene Acceso:'.$user->email.',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="'.$redirect_uri.'?logout=1"> Log Out</a>]';
                  
      }
              
       
    }
	else //error en cosulta
	{ 
            
            echo 'Error en cosulta';
          
                //echo 'Hi '.$user->email.',<br> Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		//$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
		//$statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
		//$statement->execute();
		///echo $mysqli->error;
          
         }
	
       




