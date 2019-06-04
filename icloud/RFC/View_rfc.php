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
               <span class='nuevo' id='nuevo'><a href='Rfc_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='100px' height='100px' alt='Nueva'></a></span>
           <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/home.png' width='100px' height='100px' alt='$modulo'></a>
       </p>
       
    <table id="gradient-style" summary="Meeting Results">
    <thead>
        <tr>
     
       <th bgcolor="#CDCDCD">Fecha</th>
       <th bgcolor="#CDCDCD">Estatus</th>
       <th bgcolor="#CDCDCD">Ver</tr>
        </thead>
    
    
 <?php
$id=$cliente[0];
$correo=$cliente[1];
$perfil=$cliente[2];
$estatus=$cliente[3];
$familia=$cliente[4];                    
  

///////////////////////////////////////////
  require('Control_rfc.php');
$ObjRfc=new Control_rfc();
$consulta1=$ObjRfc->mostrar_rfc($familia);
 $contador=0;
 while($cliente1 = mysql_fetch_array($consulta1))
  {
     
 $contador++; 
 $Idrfc=$cliente1[0];
 $fecha=$cliente1[11];
 $status1=$cliente1[12];
            
                         
            echo "<tr>
                  
		   
		  <td><span class='modi'><a href='Rfc_ver.php?folio=$Idrfc'>$fecha</span></td>
                  <td><span class='modi'><a href='Rfc_ver.php?folio=$Idrfc'>$status1</span></td>
                   <td><span class='modi'><a href='Rfc_ver.php?folio=$Idrfc'>Ver</span></td>
                  
                   </tr>  "; 

 }

               ////////////////////////////// fin de while
   ?>        
</table>
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
          
                //echo 'Hi '.$user->email.',<br> Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		//$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
		//$statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
		//$statement->execute();
		///echo $mysqli->error;
          
         }
      
                  ?> 