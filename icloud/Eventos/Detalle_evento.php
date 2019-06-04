
<?php
include_once("../Model/DBManager.php");
   /*enviar datos a procesar */
    
if(isset($_POST['submit']))
 {
 
require('Ctr_minuta.php');

$idusuario= htmlspecialchars(trim($_POST['idusuario']));
/*
$cantidad = htmlspecialchars(trim($_POST['cantidad']));
$id_tema1 = htmlspecialchars(trim($_POST['id_tema1']));
$status1 = htmlspecialchars(trim($_POST['status1']));
$acuerdos1 = htmlspecialchars(trim($_POST['acuerdos1']));

$id_tema2 = htmlspecialchars(trim($_POST['id_tema2']));
$status2 = htmlspecialchars(trim($_POST['status2']));
$acuerdos2 = htmlspecialchars(trim($_POST['acuerdos2']));

$id_tema3 = htmlspecialchars(trim($_POST['id_tema3']));
$status3 = htmlspecialchars(trim($_POST['status3']));
$acuerdos3 = htmlspecialchars(trim($_POST['acuerdos3']));

$id_tema4 = htmlspecialchars(trim($_POST['id_tema4']));
$status4 = htmlspecialchars(trim($_POST['status4']));
$acuerdos4 = htmlspecialchars(trim($_POST['acuerdos4']));

$id_tema5 = htmlspecialchars(trim($_POST['id_tema5']));
$status5 = htmlspecialchars(trim($_POST['status5']));
$acuerdos5 = htmlspecialchars(trim($_POST['acuerdos5']));

$id_tema6 = htmlspecialchars(trim($_POST['id_tema6']));
$status6 = htmlspecialchars(trim($_POST['status6']));
$acuerdos6 = htmlspecialchars(trim($_POST['acuerdos6']));


*/

if(is_null($idusuario)){echo 'Error intentar de nuevo'; return false;}

/*
if(is_null($cantidad)){echo 'Error intentar de nuevo'; return false;}
if(is_null($id_tema1)){echo 'Error intentar de nuevo'; return false;}
if(is_null($status1)){echo 'Error intentar de nuevo'; return false;}
if(is_null($acuerdos1)){echo 'Error intentar de nuevo'; return false;}

if(is_null($id_tema2)){echo 'Error intentar de nuevo'; return false;}
if(is_null($status2)){echo 'Error intentar de nuevo'; return false;}
if(is_null($acuerdos2)){echo 'Error intentar de nuevo'; return false;}

if(is_null($id_tema3)){echo 'Error intentar de nuevo'; return false;}
if(is_null($status3)){echo 'Error intentar de nuevo'; return false;}
if(is_null($acuerdos3)){echo 'Error intentar de nuevo'; return false;}

if(is_null($id_tema4)){echo 'Error intentar de nuevo'; return false;}
if(is_null($status4)){echo 'Error intentar de nuevo'; return false;}
if(is_null($acuerdos4)){echo 'Error intentar de nuevo'; return false;}

if(is_null($id_tema5)){echo 'Error intentar de nuevo'; return false;}
if(is_null($status5)){echo 'Error intentar de nuevo'; return false;}
if(is_null($acuerdos5)){echo 'Error intentar de nuevo'; return false;}

if(is_null($id_tema6)){echo 'Error intentar de nuevo'; return false;}
if(is_null($status6)){echo 'Error intentar de nuevo'; return false;}
if(is_null($acuerdos6)){echo 'Error intentar de nuevo'; return false;}
*/


	$objCliente=new Ctr_minuta();
        
	if ( $objCliente->Actualizar_evento(array($idusuario)) == false)
 {
		echo 'Minuta Concluida';
}
else
{
echo 'Se produjo un error. Intente nuevamente ';
}



}
else
{
    

?>
  


<script src="js/Detalle_evento.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery_minituna.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  


 <?php
 $dato=$_GET['id'];
require('Ctr_minuta.php');
$objVer=new Ctr_minuta();
$consulta1=$objVer->mostrar_evento($dato);
  
 if( $cliente1 = mysql_fetch_array($consulta1) )
 {
$id_evento=$cliente1[0];
$titulo=$cliente1[1];
$fecha=$cliente1[2];
$hora=$cliente1[3];
$fevento=$fecha." ".$hora;
$convocado=$cliente1[4];
$director=$cliente1[5];
$invitados=$cliente1[6];
$estatus=$cliente1[7];
$id_comite=$cliente1[8];
$comite=$cliente1[9];
 }

 
 
            /*fin de guardar datos a procesar*/
    $time = time();
 
  
            ?>
  <div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Temas Adicionales</h4>
   </div>
   <div class="modal-body">
    <form method="post" id="insert_form">
     <label>Tema</label>
     <input type="text" name="tema" id="tema" class="form-control" required=""/>
     <br />
     <label>Acuerdos</label>
     <textarea name="acuerdos" id="acuerdos" class="form-control" required></textarea>
     <br />
     <!--
     <label>Estatus</label>
     <select name="gender" id="gender" class="form-control" required>
      <option value="">Pendiente</option>  
      <option value="1">Pendiente</option>  
      <option value="2">Concluido</option>
     </select>-->
     <br/>  
     <input type="hidden" name="id_evento" id="id_evento" class="form-control" value="<?php echo "$id_evento";?>"/>
     
     
     <input type="submit" name="insert" id="insert" value="Agregar" class="btn btn-success" />

    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
  </div>

<h2> <font color="#124A7B">Minuta:</font></h2>
 <button type="button" name="age" id="age" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary">Agregar Temas</button>
 

  
 
<!----------------------------------------------------------------------------------------------------------------------------------------------->
<form id="RegisterUserForm" name="RegisterUserForm" action="Detalle_evento.php" method="post" onsubmit='Detalle_evento(); return false' >    
  
            
   <center>



<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Título del evento:</font></label>
<input class="w3-input" name="titulo" type="text"  id="titulo" value="<?php echo "$titulo"; ?>" placeholder="Agregar tutulo" readonly/>        
</p> 

<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha del evento:</font></label>
<input class="w3-input" name="fecha" type="text"  id="fecha" value="<?php echo "$fevento"; ?>" placeholder="Agregar tutulo" readonly/>        
</p> 

<p>
<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Convocado Por:</font></label>
<input class="w3-input" name="convocado" type="text"  id="convocado" value="<?php echo "$convocado"; ?>"  readonly="readonly"/>             
</p>

<p>
<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Para el comité:</font></label>
<input class="w3-input" name="comite" type="text"  id="comite" value="<?php echo "$comite"; ?>"  readonly="readonly"/>             
</p>

<p>
    <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Integrantes:</font></label><br>
 <?php

$objInt=new Ctr_minuta();
$consulta4=$objInt->mostrar_integrantes_evento($id_evento);
$cuenta = 0;
  $salida = "";
 while( $cliente4 = mysql_fetch_array($consulta4) )
 {
     $cuenta = $cuenta + 1;
     $id_usuario=$cliente4[2];
     $asistencia=$cliente4[3];
     $nombre=$cliente4[5];
 
      //$salida.="<b>".$nombre."</b><br>";
      if($asistencia=="1")
          {
          echo "<input type='checkbox' id='integrante$cuenta' name='integrante$cuenta' value='$id_usuario'  title='$id_usuario' checked><b>&nbsp;&nbsp;&nbsp;$nombre</b><br><br>";
          }
      else {
           echo "<input type='checkbox' id='integrante$cuenta' name='integrante$cuenta' value='$id_usuario'  title='$id_usuario' ><b>&nbsp;&nbsp;&nbsp;$nombre</b><br><br>";
      
      }
 
      
 }
     
           
?>
     

<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Director:</font></label>
<input class="w3-input" name="director" type="text"  id="director" value="<?php echo "$director" ?>"readonly="readonly" />        
</p>

<p>
<label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Invitados:</font></label>
<input class="w3-input" name="fecha" type="text"  id="fecha" value="<?php echo "$invitados" ?>"readonly="readonly" />        
</p>



<div id="employee_table">
    
<h2> <font color="#124A7B">Temas:</font></h2>
<?php
$objTema=new Ctr_minuta();
$consulta2=$objTema->mostrar_temas($dato);
$counter = 0; 
 while( $cliente2 = mysql_fetch_array($consulta2) )
 {
     
$counter = $counter + 1;
$id_tema=$cliente2[0];
$tema=$cliente2[1];
$estatustema=$cliente2[3];
$acuardos=$cliente2[4];
$id_comite2=$cliente2[5];
$update=$cliente2[8];
?>

 <script>
         $(document).ready(function()
{ 
     var dato1 = "<?php echo $estatustema; ?>" ;
     

           $("#status<?php echo"$counter"; ?> option[value='<?php echo $estatustema; ?>']").attr("selected",true);
   
     
     
     
   
    
    
    
});
      
  </script> 

<p>
 <input class="w3-input" name="id_tema<?php echo"$counter"; ?>" type="hidden"  id="id_tema<?php echo"$counter"; ?>" value="<?php echo "$id_tema"; ?>" placeholder="Agregar tutulo" readonly/>
<input  name="titulo1" type="text"  class="confondo" id="tema<?php echo "$counter"; ?>" value="<?php echo "$tema"; ?>" placeholder="Agregar tutulo" readonly/>


 
 <?php
 $objTemap=new Ctr_minuta();
$consulta3=$objTemap->mostrar_tema_pendiente2($tema);
$total = mysql_num_rows($consulta3);
 if($total==0)
 {
    if($estatus=='Pendiente')
{
   if($estatustema==0)
       {
       //validamos si ya agregaron texto pero aun no cambien de estatus
       
       if($update==1)
           {
           echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  ";
           }
           else
           {
              echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' ></textarea>  "; 
           }
        
      } 
   else 
   {
      echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  ";  
   }
   
 
}

 }
 else
 {
      while( $cliente3 = mysql_fetch_array($consulta3) )
 {
     $id_tema1=$cliente3[0];
     $tem1a=$cliente3[1];
    $acuardos1=$cliente3[2];
    echo "<textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdosp$counter' name='acuerdos' readonly >$acuardos1</textarea>  ";
    
 }
     if($update==1)
           {
           echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' >$acuardos</textarea>  ";
           }
           else
           {
              echo "  <textarea placeholder='Ingresa Acuerdos' class='w3-input'  id='acuerdos$counter' name='acuerdos$counter'  onBlur='Acuerdos$counter()' ></textarea>  "; 
           }
 }

 


 
 ?>


<label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Estatus:</font></label> 
<select  type="select" name="status<?php echo"$counter"; ?>" class="w3-input" id="status<?php echo"$counter"; ?>"  required> 
<option value="">Selecciona Estatus </option> 
<option value="1">Pendiente</option> 
<option value="2">Concluido</option>
</select>
</p> 
<?php
 }
$cantidad = $counter;
?>

</div>




 <input type="hidden" name="cantidad" id="cantidad"  value="<?php echo $cantidad ?>" />
<input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $dato ?>" />
<input type='submit' name='submit' id='registerNew' value='Cerrar Evento' /> 
<!--------------------------------------------------------------------------->

<input type="submit"  name="submit" value="Regresar" id='registerNew2' onclick="Cancelar();return false;" />
       
</form>
<h2> <font color="#124A7B">Archivos adjuntos:</font></h2>
<?php
$objArchivo=new Ctr_minuta();
  $consulta44=$objArchivo->mostrar_archivos($dato);
  
 while( $cliente44 = mysql_fetch_array($consulta44) )
 {
 $id_archivo=$cliente44[0];
  $archivo=$cliente44[1];
?>
<a href="uploads/<?php echo "$id_comite"; ?>/<?php echo "$archivo"; ?>" download="<?php echo "$archivo"; ?>"><img src="../pics/activos/comites/adjunto.png" width="50" height="50" /><?php echo "$archivo"; ?></a>
<?php
}
?>

<iframe width="100%" height="800px" src="cargararchivos.php?linea=<?php echo "$dato";?>&id_comite=<?php echo "$id_comite";?>" frameborder="0"  framespacing="0" scrolling="no" border="10"  allowfullscreen></iframe>        


<?php
//echo "valor:$id_comite";
}
?>


