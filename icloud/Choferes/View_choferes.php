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
$id=$cliente[0];
$correo=$cliente[1];
$perfil=$cliente[2];
$estatus=$cliente[3];
$familia=$cliente[4];  
require('Control_choferes.php');
 $ObjValida=new Control_choferes();
$consulta13=$ObjValida->Validar_choferes($familia);
 $cliente13 = mysql_fetch_array($consulta13);

   $cantchoferes=$cliente13[0];
   
   if($cantchoferes=="0" || $cantchoferes=="1"){ $valor="<span class='nuevo' id='nuevo'><a href='Choferes_alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='60px' height='60px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }else{$valor=""; }

?>

<p align='center'>
    <?php echo $valor; ?>
    <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.png' width='70px' height='60px' alt='$modulo'></a>
</p>
       
    <table id="gradient-style" summary="Meeting Results">
    <thead>
        <tr>
     
       <th bgcolor="#CDCDCD">Chofer</th>
    
       <th bgcolor="#CDCDCD">Estatus</th>
        <th bgcolor="#CDCDCD">Cancelar</th>
        
        </thead>
    
    
   <?php
                  
  

///////////////////////////////////////////
  
$ObjRfc=new Control_choferes();
$consulta1=$ObjRfc->mostrar_choferes($familia);
 $contador=0;
 while($cliente1 = mysql_fetch_array($consulta1))
  {
     
 $contador++; 
 
$idchofer=$cliente1[0];
$nfamilia=$cliente1[1];
$nombre=strtoupper($cliente1[2]);
$foto=$cliente1[3];
$parentesco=strtoupper($cliente1[4]);
$estatus=$cliente1[5];
if($estatus=="CANCELADO"){$sta="malo.png";}
if($estatus=="ACTIVO"){$sta="bueno.png";}
if($estatus=="PROCESO"){$sta="alerta.png"; $DESCARGA=" <a href='http://chmd.chmd.edu.mx:65083/demo/pdf/prueba.php?idchofer=$idchofer' target='_blank' title='Nuevo'> <img src='../images/dowload.png' width='52px' height='65px' > </a>";}
if($estatus=="PAGADO"){$sta="alerta.png";} 


   ?>
            
                         
         <tr>
                  
	  <td><?php echo $nombre?></td>
          <td><img src='../images/<?php echo $sta?>' width='50px' height='50px'>   </td>
          <td>
              <?php
            if($sta=="bueno.png")
               {
                 ?> 
              <a onClick="CancelarChofer (<?=$idchofer?>,'<?=$nombre?>','<?=$correo?>'); return false" href='eliminar.php?id=<?php echo $idchofer ?>'><img src='../images/malo.png' width='50px' height='50px'> 
               <?php
               }
               else
                {
                   echo "$DESCARGA"; 
               }    
                ?> 
              
           
           </td>
                                                                          
         </tr>
         
 <?php
 }

               ////////////////////////////// fin de while
   ?> 
        
</table>
<br>
<h2><font color="#124A7B">Auto </font></h2>
<p align='center'>
    
      </p>
<table id="gradient-style" summary="Meeting Results">
    <thead>
        <tr>
     
       <th bgcolor="#CDCDCD">Marca</th>
       <th bgcolor="#CDCDCD">Modelo</th>
       <th bgcolor="#CDCDCD">Color</th>
        <th bgcolor="#CDCDCD">Placas</th>
          <th bgcolor="#CDCDCD">Modificar</th>
        
     
        
        </thead>
         <?php
                   
  

///////////////////////////////////////////
$ObjAuto=new Control_choferes();
$consulta12=$ObjAuto->mostrar_autos($familia);

 while($cliente12 = mysql_fetch_array($consulta12))
{
   $idauto=$cliente12[0]; 
   $marca=$cliente12[1]; 
   $modelo=$cliente12[2];
   $color=$cliente12[3]; 
   $placas=$cliente12[4]; 
            echo "<tr>
                  
		   
		  <td>$marca</td>
                  <td>$modelo</td>
                  <td>$color</td>
                  <td>$placas</td>
                   <td><span class='nuevo' id='nuevo2'><a href='Autos_alta.php?id=$idauto' title='nuevo2'> <img src='../images/editar.png' width='40px' height='40px' alt='Nueva'><font color='#124A7B'></font></a></span></td>
                  
                   
                  
                   </tr>  "; 

 }

               ////////////////////////////// fin de while
   ?>     

</table>

<!------------------------padres de familia----------------------------------------------->
<h2><font color="#124A7B">Padres</font></h2>
    <table id="gradient-style" summary="Meeting Results">
    <thead>
        <tr>
     
       <th bgcolor="#CDCDCD">Familiar</th>
       <th bgcolor="#CDCDCD">Parentesco</th>
       <th bgcolor="#CDCDCD">Foto</th>
     
        
        </thead>
    
    
   <?php
                   
  

///////////////////////////////////////////
 
$consulta11=$ObjRfc->mostrar_padres($familia);
 $contador=0;
 while($cliente11 = mysql_fetch_array($consulta11))
  {
     
 $contador++; 
 
$idchofer=$cliente11[0];
$nfamilia=$cliente11[1];
$nombre=strtoupper($cliente11[2]);
$foto=$cliente11[3];
$parentesco=strtoupper($cliente11[4]);
$estatus=$cliente11[5];
if($estatus=="CANCELADO"){$sta="error.png";}
if($estatus=="ACTIVO"){$sta="bueno.png";}
if($estatus=="EN PROCESO"){$sta="alerta.png";}


if($foto==null){$foto="sinfoto.png"; $foto1="Sin foto";} else {$foto="../../CREDENCIALES/padres/$foto"; $foto1="Con Foto";}





            
                         
            echo "<tr>
                  
		   
		  <td>$nombre</td>
                  <td>$parentesco</td>
                   <td><img src='../images/$foto' width='60px' height='60px'  ><br></td>
                  
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