
<?php
session_start();
$correo=$_SESSION['correo'];
 include_once("../Model/DBManager.php");
if(isset($_POST['submit'])){
	require('Ctr_uniformes.php');
	$objUniforme1=new Ctr_uniformes;
	
	$cliente_id = htmlspecialchars(trim($_POST['cliente_id']));
	$talla_sudadera = htmlspecialchars(trim($_POST['talla_sudadera']));
	$talla_pants = htmlspecialchars(trim($_POST['talla_pants']));
	$talla_playera = htmlspecialchars(trim($_POST['talla_playera']));
	$talla_educacionf = htmlspecialchars(trim($_POST['talla_educacionf']));
	$talla_kinder = htmlspecialchars(trim($_POST['talla_kinder']));
	$idalumno = htmlspecialchars(trim($_POST['idalumno']));
	$status  = htmlspecialchars(trim($_POST['status']));
        
        $tiposuda  = htmlspecialchars(trim($_POST['tiposuda']));  
        $tipoplayera  = htmlspecialchars(trim($_POST['tipoplayera']));
        $tipopants  = htmlspecialchars(trim($_POST['tipopants']));
        $tipoedu  = htmlspecialchars(trim($_POST['tipoedu']));
	$nfamilia=htmlspecialchars(trim($_POST['nfamilia']));
	

	
	if ( $objUniforme1->actualizar(array($talla_sudadera,
                                           $talla_pants,
                                           $talla_playera,
                                           $talla_educacionf,
                                           $talla_kinder,
                                           $idalumno,
                                           $status,          
                                           $nfamilia,
                                           $tiposuda,
                                           $tipoplayera,
                                           $tipopants,
                                           $tipoedu),$correo) == true){
		echo 'Datos Guardados';
              //echo "<script>jQuery(function(){ swal('Good job!', 'You clicked the buttonzzz!', 'success');});</script>";
	}else{
		echo 'Se produjo un error. Intente nuevamente';
	} 
}
else
    {
    ?>
<style type="text/css">
/* HIDE RADIO */
.hiddenradio [type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
.hiddenradio [type=radio] + img {
  cursor: pointer;
}

/* CHECKED STYLES */
.hiddenradio [type=radio]:checked + img {
  outline: 2px solid #f00;
}
  </style>
             <script type="text/javascript">
$(document).ready(function()
{
    
   
    $('.sudadera').hide();
    $('.chamarra').hide();
    $('.sudadera1').hide();
    $('.chamarra1').hide();
$('input[type=radio]').change(function() 
 { 
    // $('#target').hide(); //oculto mediante id
     var dato=this.value;
     if(dato=="1"){$('.sudadera').show(); $('.sudadera1').show();  $('.chamarra').hide();  $('.chamarra1').hide(); $('.inicial').hide();  $('.inicial1').hide();}
     if(dato=="2"){$('.chamarra').show();  $('.sudadera').hide(); $('.inicial').hide(); $('.chamarra1').show();  $('.sudadera1').hide(); $('.inicial1').hide();}
    
});
});



</script> 

  
<?php
     echo "<script>jQuery(function(){ swal('Atención!', 'Una vez seleccionada la talla y el modelo no habrá cambios.!', 'warning');});</script>";

     echo '<h2> <font color="#124A7B">Realizar Pedido</font></h2> ';  
    $v1=$_GET['var1'];
    if(isset($_GET['id']))
    {
        require('Ctr_uniformes.php');
		$objCliente=new Ctr_uniformes;
		$consulta = $objCliente->mostrar_cliente($_GET['id']);
		$cliente = mysql_fetch_array($consulta);
		$nfamilia=$cliente['idfamilia'];
                
                $Alumno=$cliente['nombre'];
                $grado=$cliente['grado_cursar'];
                $sexo=$cliente['sexo'];
		$cant_sudadera=$cliente['cant_sudadera'];
		$cant_panst=$cliente['cant_panst'];
		$cant_playera=$cliente['cant_playera'];
		$cant_educacionf=$cliente['cant_educacionf'];
		$cant_kinder=$cliente['cant_kinder'];
		$idalumno=$cliente['id'];
		$producto1=$cliente['producto1'];
		$producto2=$cliente['producto2'];
		$producto3=$cliente['producto3'];
		$producto4=$cliente['producto4'];
		$producto5=$cliente['producto5'];
		$idpaquete=$cliente['idpaquete'];
		$talla_sudadera=$cliente['talla_sudadera'];
		$talla_pants=$cliente['talla_pants'];
		$talla_playera=$cliente['talla_playera'];
		$talla_educacionf=$cliente['talla_educacionf'];
		$talla_kinder=$cliente['talla_kinder'];
                if($sexo=="F")
                {
                    $tipo="DAMA";
                }
                  if($sexo=="M")
                {
                    $tipo="CABALLERO";
                }
		
		//paquete 1 kinder
		if($idpaquete==1)
		{
		echo "<center>
	<form id='frmClienteActualizar' name='frmClienteActualizar' method='post' action='actualizar.php' onsubmit='ActualizarDatos(); return false'>
    	<input type='hidden' name='cliente_id' id='cliente_id'value='$idalumno' />
		
		<table id='gradient-style' summary='Meeting Results'  style='width: 100%;'>
                <thead>
                 <tr align='center' valign='middle'> 
                <th colspan=4>Alumno:   $Alumno</th>
                </tr>
                <tr>
                <td colspan=4><b>Grado a Cursar: <b>$grado</b></td>
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
   <td><SELECT NAME='talla_kinder' id='talla_kinder' SIZE='1'> 
   <OPTION VALUE='0'>Talla</OPTION> 
   <OPTION VALUE='2'>2 </OPTION> 
   <OPTION VALUE='3'>3 </OPTION> 
   <OPTION VALUE='4'>4 </OPTION> 
   <OPTION VALUE='5'>5 </OPTION>
      <OPTION VALUE='6'>6 </OPTION>
   </SELECT>
      <input type='radio' name='tiposuda' id='tiposuda'  value='3' checked style='visibility:hidden'>
   </td>
 
</tr>	
<tr align='center' valign='middle'> 
<th colspan=3> <font color='#FFFFFF' size='3'>Una vez seleccionada la talla y el modelo no habrá cambios.<font></th>
</tr>
		</table>
		<input  type='hidden' name='talla_sudadera' id='talla_sudadera' value='$talla_sudadera' />
		<input  type='hidden' name='talla_pants' id='talla_pants' value='$talla_pants' />
		<input  type='hidden' name='talla_playera' id='talla_playera' value='$talla_playera' />
		<input  type='hidden' name='talla_educacionf' id='talla_educacionf' value='$talla_educacionf' />	
                 <input  type='hidden' name='status' id='status' value='1' />			
		<input  type='hidden' name='idalumno' id='idalumno' value='$idalumno' />
                 <input  type='hidden' name='nfamilia' id='nfamilia' value='$nfamilia' />   
             
                <input  type='hidden' name='tipoplayera' id='tipoplayera' value='3' />
                <input  type='hidden' name='tipopants' id='tipopants' value='3' />
                <input  type='hidden' name='tipoedu' id='tipoedu' value='3' />
                     
	
	<!------------------------------------------------------------------------------------------------------->
<input type='submit' name='submit' id='registerNew' value='Guardar Pedido' /> 
<!--------------------------------------------------------------------------->

<input type='submit'  name='submit' value='Regresar' id='registerNew2' onclick='Cancelar();return false;' />
	</form></center>";
		
		} // fin de paquete 1
		
		//paquete 2 //primaria
		if($idpaquete==2)
		{
		echo "<center>
	<form id='frmClienteActualizar' name='frmClienteActualizar' method='post' action='actualizar.php' onsubmit='ActualizarDatos(); return false'>
    	<input type='hidden' name='cliente_id' id='cliente_id'value='$idalumno' />
		
		<table id='gradient-style' summary='Meeting Results' style='width: 100%;'>
                <thead>
                 <tr align='center' valign='middle'> 
                <th colspan=3>Alumno:   $Alumno</th>
                </tr>
                 <tr>
                <td colspan=4><b>Grado a Cursar:$grado</b></td>
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
		<td><SELECT NAME='talla_sudadera' id='talla_sudadera' SIZE='1'> 
   <OPTION VALUE='0'>selecciona</OPTION> 	
   <OPTION VALUE='5'>5  </OPTION> 
   <OPTION VALUE='6'>6 </OPTION> 
   <OPTION VALUE='8'>8 </OPTION> 
   <OPTION VALUE='10'>10 </OPTION> 
   <OPTION VALUE='12'>12 </OPTION> 
   <OPTION VALUE='14'>14 </OPTION> 
    </SELECT> 
   <input type='radio' name='tiposuda' id='tiposuda'  value='3' checked style='visibility:hidden'>
   </td>
  
		</tr>
		
		<tr>
		<td> $producto2</td>
		<td> $cant_panst</td>
<td><SELECT NAME='talla_pants' id='talla_pants' SIZE='1'> 
   <OPTION VALUE='0'>selecciona</OPTION> 	
   <OPTION VALUE='5'>5  </OPTION> 
   <OPTION VALUE='6'>6 </OPTION> 
   <OPTION VALUE='8'>8 </OPTION> 
   <OPTION VALUE='10'>10 </OPTION> 
   <OPTION VALUE='12'>12 </OPTION> 
   <OPTION VALUE='14'>14 </OPTION> 
   </SELECT>
   <SELECT NAME='tipopants' id='tipopants' SIZE='1' style='visibility:hidden'> 
   <OPTION VALUE='3' selected>Tipo</OPTION>  
   </SELECT> 
   </td>
   
		</tr>
		
	<tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td><SELECT NAME='talla_playera' id='talla_playera' SIZE='1'> 
   <OPTION VALUE='0'>selecciona</OPTION> 	
   <OPTION VALUE='5'>5  </OPTION> 
   <OPTION VALUE='6'>6 </OPTION> 
   <OPTION VALUE='8'>8 </OPTION> 
   <OPTION VALUE='10'>10 </OPTION> 
   <OPTION VALUE='12'>12 </OPTION> 
   <OPTION VALUE='14'>14 </OPTION> 
   </SELECT>
   <SELECT NAME='tipoplayera' id='tipoplayera' SIZE='1' style='visibility:hidden'> 
  <OPTION VALUE='3' selected>Tipo</OPTION> 
   </SELECT> 
   
  
   </td>
		</tr>
		
 <tr>
   <td>$producto4</td>
   <td>$cant_educacionf</td>
   <td><SELECT NAME='talla_educacionf' id='talla_educacionf' SIZE='1'> 
   <OPTION VALUE='0'>selecciona</OPTION> 	
   <OPTION VALUE='5'>5  </OPTION> 
   <OPTION VALUE='6'>6 </OPTION> 
   <OPTION VALUE='8'>8 </OPTION> 
   <OPTION VALUE='10'>10 </OPTION> 
   <OPTION VALUE='12'>12 </OPTION> 
   <OPTION VALUE='14'>14 </OPTION> 
   </SELECT>
   <SELECT NAME='tipoedu' id='tipoedu' SIZE='1'  style='visibility:hidden'> 
 <OPTION VALUE='3' selected>Tipo</OPTION>  
   </SELECT> 
   </td>
   
 
</tr>
<tr align='center' valign='middle'> 
                <th colspan=3> <font color='#FFFFFF' size='3'>Una vez seleccionada la talla y el modelo no habrá cambios.<font></th>
                </tr>

		
		</table>
		<input  type='hidden' name='nfamilia' id='nfamilia' value='$nfamilia' />
		<input  type='hidden' name='status' id='status' value='1' />	 
		<input  type='hidden' name='talla_kinder' id='talla_kinder' value='$talla_kinder' />	  
		<input  type='hidden' name='idalumno' id='idalumno' value='$idalumno' />
	
	  
	<!------------------------------------------------------------------------------------------------------->
<input type='submit' name='submit' id='registerNew' value='Guardar Pedido' /> 
<!--------------------------------------------------------------------------->

<input type='submit'  name='submit' value='Regresar' id='registerNew2' onclick='Cancelar();return false;' />
	</form></center>";
		
		} //fin de paquete 2
              
		///paquete3 4°bachillerato
		if($idpaquete==3)
		{
		echo "<center>
	<form id='frmClienteActualizar' name='frmClienteActualizar' method='post' action='actualizar.php' onsubmit='ActualizarDatos(); return false'>
    	<input type='hidden' name='cliente_id' id='cliente_id'value='$idalumno' />
		
		<table id='gradient-style' summary='Meeting Results' style='width: 100%;'>
                <thead>
                 <tr align='center' valign='middle'> 
                <th colspan=3>Alumno:   $Alumno</th>
                </tr>
               <tr>
                <td colspan=3><b>Grado a Cursar:$grado</b></td>
                </tr>
                <tr align='center' valign='middle'> 
                <th colspan=3><b>Seleccione el modelo del producto de su preferencia.</b></th>
                </tr>
                <td colspan=1>
                <label>
  <input type='radio' name='tiposuda' id='tiposuda'  value='1' required>
  <img src='images/sudadera.JPG' width='100' height='100'>
</label>
<BR>SUDADERA</td>
                <td colspan=2>
                        <label>
  <input type='radio' name='tiposuda' id='tiposuda'  value='2'  >
  <img src='images/chamarra.jpg' width='100' height='100'>
  
</label>
                <BR>CHAMARRA</td>
                </tr>
                <tr align='center' valign='middle'> 
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
  <td>
  <SELECT NAME='talla_sudadera1' id='talla_sudadera1' SIZE='1' class='sudadera' > 
   <OPTION VALUE='0'>Talla</OPTION> 	
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT>
    <SELECT NAME='talla_sudadera2' id='talla_sudadera2' SIZE='1' class='chamarra' > 
   <OPTION VALUE='0'>Talla</OPTION>
   <OPTION VALUE='12'>12</OPTION> 
   <OPTION VALUE='14'>14</OPTION> 
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT> 
     <SELECT NAME='talla_sudadera' id='talla_sudadera' SIZE='1' class='inicial' > 
   <OPTION VALUE='0'>Talla</OPTION> 	
 </SELECT>

   </td>
		</tr>
		
		
	<tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td><SELECT NAME='talla_playera' id='talla_playera' SIZE='1'> 
   <OPTION VALUE='0'>Talla</OPTION> 	
    <OPTION VALUE='12'>12</OPTION> 
   <OPTION VALUE='14'>14</OPTION> 
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT> 
   <SELECT NAME='tipoplayera' id='tipoplayera' SIZE='1'  style='visibility:hidden'> 
  <OPTION VALUE='3' selected>Tipo</OPTION>   
   </SELECT> 
   </td>
   
 
 
	
		 <tr align='center' valign='middle'> 
                <th colspan=3> <font color='#FFFFFF' size='3'>Una vez seleccionada la talla y el modelo no habrá cambios.<font></th>
                </tr>
		
		</table>
		<input  type='hidden' name='nfamilia' id='nfamilia' value='$nfamilia' />	
		<input  type='hidden' name='talla_pants1' id='talla_pants1' value='$talla_pants' />
                <input  type='hidden' name='talla_pants2' id='talla_pants2' value='$talla_pants' />
		<input  type='hidden' name='talla_educacionf' id='talla_educacionf' value='$talla_educacionf' />	
		<input  type='hidden' name='talla_kinder' id='talla_kinder' value='$talla_kinder' />	
                <input  type='hidden' name='status' id='status' value='1' />			
		<input  type='hidden' name='idalumno' id='idalumno' value='$idalumno' />
	           <input  type='hidden' name='tipopants' id='tipopants' value='3' />
                <input  type='hidden' name='tipoedu' id='tipoedu' value='3' />
	 
	<!------------------------------------------------------------------------------------------------------->
<input type='submit' name='submit' id='registerNew' value='Guardar Pedido' /> 
<!--------------------------------------------------------------------------->

<input type='submit'  name='submit' value='Regresar' id='registerNew2' onclick='Cancelar();return false;' />
	</form></center>";
		
		} ///fin de paquete 3
		
		//paquete4  5° y 6° bachillato
		if($idpaquete==4)
		{
		echo "<center>
	<form id='frmClienteActualizar' name='frmClienteActualizar' method='post' action='actualizar.php' onsubmit='ActualizarDatos(); return false'>
    	<input type='hidden' name='cliente_id' id='cliente_id'value='$idalumno' />
		
		<table id='gradient-style' summary='Meeting Results' style='width: 100%;'>
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
		<td><SELECT NAME='talla_sudadera' id='talla_sudadera' SIZE='1'> 
   <OPTION VALUE='0'>selecciona </OPTION> 	
   <OPTION VALUE='5'>5  </OPTION> 
   <OPTION VALUE='6'>6 </OPTION> 
   <OPTION VALUE='8'>8 </OPTION> 
   <OPTION VALUE='10'>10 </OPTION> 
   <OPTION VALUE='12'>12 </OPTION> 
   <OPTION VALUE='14'>14 </OPTION> 
   <OPTION VALUE='16'>16 </OPTION> 
   <OPTION VALUE='16'>16 </OPTION> 
   <OPTION VALUE='18'>18 </OPTION> 
   <OPTION VALUE='CH'>CH(36)</OPTION> 
   <OPTION VALUE='M(38)'>M(38)</OPTION> 
   <OPTION VALUE='G(40)'>G(40)</OPTION> 
   <OPTION VALUE='EX(42)'>EX(42)</OPTION> 
   </SELECT> </td>
    <td>
   <SELECT NAME='tiposuda' id='tiposuda' SIZE='1'> 
   <OPTION VALUE='0'>Tipo</OPTION> 
   <OPTION VALUE='1'>Abierta</OPTION> 
   <OPTION VALUE='2'>Cerrada</OPTION> 
   </SELECT> 
   </td>
		</tr>
		
		
	<tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td><SELECT NAME='talla_playera' id='talla_playera' SIZE='1'> 
<OPTION VALUE='0'>selecciona</OPTION> 	
  <OPTION VALUE='5'>5  </OPTION> 
   <OPTION VALUE='6'>6 </OPTION> 
   <OPTION VALUE='8'>8 </OPTION> 
   <OPTION VALUE='10'>10 </OPTION> 
   <OPTION VALUE='12'>12 </OPTION> 
   <OPTION VALUE='14'>14 </OPTION> 
   <OPTION VALUE='16'>16 </OPTION> 
   <OPTION VALUE='16'>16 </OPTION> 
   <OPTION VALUE='18'>18 </OPTION> 
   <OPTION VALUE='CH'>CH(36)</OPTION> 
   <OPTION VALUE='M(38)'>M(38)</OPTION> 
   <OPTION VALUE='G(40)'>G(40)</OPTION> 
   <OPTION VALUE='EX(42)'>EX(42)</OPTION> 
   </SELECT> </td>
        <td>
   <SELECT NAME='tipoplayera' id='tipoplayera' SIZE='1'  style='visibility:hidden'> 
  <OPTION VALUE='3' selected>Tipo</OPTION>  
   </SELECT> 
   </td>
   
 
	
		</tr>
		
		
		</table>
		<input  type='hidden' name='nfamilia' id='nfamilia' value='$nfamilia' />	
		<input  type='hidden' name='talla_pants' id='talla_pants' value='$talla_pants' />
                    
		<input  type='hidden' name='talla_educacionf' id='talla_educacionf' value='$talla_educacionf' />
                    
		<input  type='hidden' name='talla_kinder' id='talla_kinder' value='$talla_kinder' />
                    

                <input  type='hidden' name='status' id='status' value='1' />			
		<input  type='hidden' name='idalumno' id='idalumno' value='$idalumno' />
                    
                    <input  type='hidden' name='tipopants' id='tipopants' value='13' />
                   <input  type='hidden' name='tipoedu' id='tipoedu' value='13' />

";
                ?>
	
	
	<!------------------------------------------------------------------------------------------------------->
<input type='submit' name='submit' id='registerNew' value='Guardar Pedido' /> 
<!--------------------------------------------------------------------------->

<input type='submit'  name='submit' value='Regresar' id='registerNew2' onclick='Cancelar();return false;' />
     
	</form></center>";
		<?php
		} //fin de paquete 4
                  ////////////////////paquete 5/////////////////////////
              
		if($idpaquete==5)
		{
		echo "<center>
	<form id='frmClienteActualizar' name='frmClienteActualizar' method='post' action='actualizar.php' onsubmit='ActualizarDatos(); return false'>
    	<input type='hidden' name='cliente_id' id='cliente_id'value='$idalumno' />
		
		<table id='gradient-style' summary='Meeting Results' style='width: 100%;'>
                <thead>
                 <tr align='center' valign='middle'> 
                <th colspan=3>Alumno:   $Alumno</th>
                </tr>
                 <tr>
                <td colspan=3><b>Grado a Cursar:$grado</b></td>
                </tr>
                <tr>
                 <tr align='center' valign='middle'> 
                <th colspan=3><b>Seleccione el modelo del producto de su preferencia.</b></th>
                </tr>
                <td colspan=1>
                <label>
  <input type='radio' name='tiposuda' id='tiposuda'  value='1' required>
   <img src='images/sudadera.JPG' width='100' height='100'>
</label>
<BR>SUDADERA</td>
                <td colspan=2>
                        <label>
  <input type='radio' name='tiposuda' id='tiposuda'  value='2'  >
   <img src='images/chamarra.jpg' width='100' height='100'>
</label>
                <BR>CHAMARRA</td>
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
		<td>
   <SELECT NAME='talla_sudadera1' id='talla_sudadera1' SIZE='1' class='sudadera' > 
   <OPTION VALUE='0'>Talla</OPTION> 	
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT>
    <SELECT NAME='talla_sudadera2' id='talla_sudadera2' SIZE='1' class='chamarra' > 
   <OPTION VALUE='0'>Talla</OPTION>
   <OPTION VALUE='12'>12</OPTION> 
   <OPTION VALUE='14'>14</OPTION> 
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT> 
     <SELECT NAME='talla_sudadera' id='talla_sudadera' SIZE='1' class='inicial' > 
   <OPTION VALUE='0'>Talla</OPTION> 	
 </SELECT>

</td>
  
		</tr>
		
		<tr>
		<td> $producto2</td>
		<td> $cant_panst</td>
<td>
<SELECT NAME='talla_pants1' id='talla_pants1' SIZE='1' class='sudadera1'> 
 <OPTION VALUE='0'>Talla</OPTION> 	
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT>
   
<SELECT NAME='talla_pants2' id='talla_pants2' SIZE='1'  class='chamarra1'> 
 <OPTION VALUE='0'>Talla</OPTION> 
 <OPTION VALUE='12'>12</OPTION> 
   <OPTION VALUE='14'>14</OPTION> 
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT>
   

<SELECT NAME='talla_pants' id='talla_pants' SIZE='1' class='inicial1'> 
 <OPTION VALUE='0'>Talla</OPTION> 	
   </SELECT>




   <SELECT NAME='tipopants' id='tipopants' SIZE='1'  style='visibility:hidden'> 
   <OPTION VALUE='3' selected>Tipo</OPTION>  
   </SELECT> 
   </td>
   
		</tr>
		
	<tr>
		<td> $producto3</td>
		<td> $cant_playera</td>
		<td><SELECT NAME='talla_playera' id='talla_playera' SIZE='1'> 
 <OPTION VALUE='0'>Talla</OPTION>
 <OPTION VALUE='12'>12</OPTION> 
   <OPTION VALUE='14'>14</OPTION> 
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT>
   <SELECT NAME='tipoplayera' id='tipoplayera' SIZE='1'  style='visibility:hidden'> 
 <OPTION VALUE='3' selected>Tipo</OPTION> 
   </SELECT> 
   </td>
		</tr>
		
 <tr>
   <td>$producto4</td>
   <td>$cant_educacionf</td>
   <td><SELECT NAME='talla_educacionf' id='talla_educacionf' SIZE='1'> 
   <OPTION VALUE='0'>Talla</OPTION> 
   <OPTION VALUE='12'>12</OPTION> 
   <OPTION VALUE='14'>14</OPTION> 
   <OPTION VALUE='Extra_Chica'>Extra Chica</OPTION> 
   <OPTION VALUE='Chica'>Chica</OPTION> 
   <OPTION VALUE='Mediana'>Mediana</OPTION> 
   <OPTION VALUE='Grande'>Grande </OPTION> 
   <OPTION VALUE='Extra_Grande'>Extra Grande</OPTION> 
   </SELECT> 
   <SELECT NAME='tipoedu' id='tipoedu' SIZE='1'  style='visibility:hidden'> 
   <OPTION VALUE='3' selected>Tipo</OPTION> 
   </SELECT> 
   </td>
</tr>
 <tr align='center' valign='middle'> 
                <th colspan=3> <font color='#FFFFFF' size='3'>Una vez seleccionada la talla y el modelo no habrá cambios.<font></th>
                </tr>

		
		</table> 
		<input  type='hidden' name='nfamilia' id='nfamilia' value='$nfamilia' />	
		<input  type='hidden' name='status' id='status' value='1' />	 
		<input  type='hidden' name='talla_kinder' id='talla_kinder' value='$talla_kinder' />	  
		<input  type='hidden' name='idalumno' id='idalumno' value='$idalumno' />
	
	 
	<!------------------------------------------------------------------------------------------------------->
<input type='submit' name='submit' id='registerNew' value='Guardar Pedido' /> 
<!--------------------------------------------------------------------------->

<input type='submit'  name='submit' value='Regresar' id='registerNew2' onclick='Cancelar();return false;' />
	</form></center>";
		
		} 
		/////////////////////fin d epaquete 5//////////////////////////
		
        
    }
    else
    {
        
         echo "Error intentar de nuevo";
    }
  
}

?>

  
 
