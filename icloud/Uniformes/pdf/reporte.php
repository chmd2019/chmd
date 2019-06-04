<?php

require('conexion.php');
ob_start();
?>

<link href="css/reportepdf.css" rel="stylesheet" type="text/css">

<!--separador uno -->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <p align="center"> <img src='images/preguntas.png' title='Editar'/></p>
      <page_footer>
            <h5 align="center">pagina 1</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                     <img src='images/footer.png' title='Editar'/>
                  
                </td>
            </tr>
        </table>
    </page_footer>
</page>


<!--Se parador uno -->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 100%;  text-align: center">
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    <br><br><br>

<?php
$familia=$_GET["id"]; 

$req="SELECT * FROM becas_respuesta_preguntas WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
     
$id=$row['id'];
$respuesta1=$row['respuesta1'];
$respuesta2=$row['respuesta2'];
$respuesta3=$row['respuesta3'];
$respuesta4=$row['respuesta4'];
$respuesta5=$row['respuesta5'];
$respuesta6=$row['respuesta6'];
$respuesta7=$row['respuesta7'];
$idfamilia=$row['idfamilia'];


   
}
?>
        <h4 >Formato de preguntas </h4><br>
    <table align="center"   id="gradient-style" summary="Meeting Results" >
	   <tr>
               <th><p class="mayuscula">No.</p> </th>
	<th align="center">Preguntas:  </th>
	<th> </th>
	</tr>
	<tr>
	<td> </td>
        <td><p class="mayuscula">¿ Es la primera vez que solicita Beca?</p> </td>
	<td width=100>&nbsp; </td>
	</tr>
	<tr>
	<td  colspan="3">
	<span class="span"><?php echo $respuesta1; ?></span>
	</td>
	</tr>
	<tr>
	<td> </td>
        <td><p class="mayuscula"> ¿Se le ha proporcionado beca anteriormente? </p> </td>
	<td width=100>&nbsp; </td>
	</tr>
	<tr>
	<td colspan="3">
            <span class="span"><?php echo $respuesta2; ?></span>
	</td>
        </tr>
        <?php
        if($respuesta2=="SI")
        {
            echo "<tr><td colspan='3'>
            <p>3.¿Desde hace cuanto tiempo?</p> <span class='span'> $respuesta3 Años</span>
	</td></tr>";
            
        }
        
        ?>
	
        
        
        
        
	
	
	
	<tr>
	<td> </td>
        <td><p class="mayuscula">¿Que alternativas intentaron antes de solicitar la beca?</p></td>
	<td width=100>&nbsp; </td>
	</tr>
	<tr>
	<td colspan="3">
            <span class="span"><?php echo $respuesta4; ?></span>
	</td>
	</tr>
		<tr>
	<td></td>
        <td><p class="mayuscula">¿Han recurrido a su familia?</p></td>
	<td width=100>&nbsp; </td>
	</tr>
	<tr>
	<td colspan="3">
            <span class="span"><?php echo $respuesta5; ?></span>
	</td>
	</tr>
        
       <?PHP 
       if($respuesta5=="NO")
       {
           echo "	<tr>
	<td></td>
        <td><p>¿Por que?</p></td>
	<td width=100>&nbsp; </td>
	</tr>
	<tr>
	<td colspan='3'>
            <span class='span'>$respuesta6</span>
	</td>
	</tr>";
           
       }
       
       ?>
       
	
        


	</table>

    <page_footer>
          <h5 align="center">pagina 2</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_footer>
	
   
</page>
<!--separador uno -->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
     <p align="center"> <img src='images/generales.png' title='Editar'/></p>
      <page_footer>
            <h5 align="center">pagina 3</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>


<!--Se parador uno -->

<!-- Segunda Pagina -->

   <page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 70%; text-align: center " >
                    <img src='images/titulo.png'   />
                </td>
            </tr>
        </table>
    </page_header>
       
       <H4>FORMATO DE DATOS GENERALES</H4>
<?php
$familia=$_GET["id"]; 

$req="SELECT * FROM becas_repuestas_dgenerales WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
    $id=$row['id'];
$nombretitu=$row['nombretitu'];
$direcciontitu=$row['direcciontitu'];
$coloniatitu=$row['coloniatitu'];
$casapropiatitu=$row['casapropiatitu'];

$renta=$row['renta'];
$propietario=$row['propietario'];
$telefono=$row['telefono'];
$vcomercial=$row['vcomercial'];
$pmensual=$row['pmensual'];



$telefonotitu=$row['telefonotitu'];
$estadociviltitu=$row['estadociviltitu'];
$celulartitu=$row['celulartitu'];
$cpersonastitu=$row['cpersonastitu'];
$comunidad=$row['comunidad'];
$nombremadre=$row['nombremadre'];
$estadocivilmadre=$row['estadocivilmadre'];
$direccionmadre=$row['direccionmadre'];
$coloniamadre=$row['coloniamadre'];
$casapropiamadre=$row['casapropiamadre'];
$telefonomadre=$row['telefonomadre'];
$celularmadre=$row['celularmadre'];
$cpersonasmadre=$row['cpersonasmadre'];
$reside=$row['reside'];

$otroreside=$row['otroreside'];
$paga=$row['paga'];
$otropaga=$row['otropaga'];
$trabaja=$row['trabaja'];
$otrotrabaja=$row['otrotrabaja'];



$empresatitu=$row['empresatitu'];
$telempresatitu=$row['telempresatitu'];
$negiciotitu=$row['negiciotitu'];
$profesiontitu=$row['profesiontitu'];
$puestotitu=$row['puestotitu'];
$jefetitu=$row['jefetitu'];
$tiempotitu=$row['tiempotitu'];
$sbrutotitu=$row['sbrutotitu'];
$snetotitu=$row['snetotitu'];
$otrostitu=$row['otrostitu'];
$totaltitu=$row['totaltitu'];

$comentarios1=$row['comentarios1'];
$empresaesposa=$row['empresaesposa'];
$telempresaesposa=$row['telempresaesposa'];
$negicioespo=$row['negicioespo'];
$profesionespo=$row['profesionespo'];
$puestoespo=$row['puestoespo'];
$jefeespo=$row['jefeespo'];
$tiempoespo=$row['tiempoespo'];
$sbrutoespo=$row['sbrutoespo'];
$snetoespo=$row['snetoespo'];
$otrosespo=$row['otrosespo'];
$totalespo=$row['totalespo'];
$comentarios2=$row['comentarios2'];
$idfamilia=$row['idfamilia'];
$sueldos=$totaltitu + $totalespo;
}
?>
   <table align="center" id='gradient-style' summary='Meeting Results'>
        
                  
                <thead>
                    <tr align='center' valign='middle'> 
		    <th colspan=2>INFORMACION DEL PADRE (TITULAR)</th>     
                    </tr>
                    </thead>
                 <tr>
                 <td> NOMBRE: <span class="span"><?php echo$nombretitu;?></span></td>
                 <td> DIREECCION: <span class="span"><?php echo$direcciontitu; ?></span></td>
                 </tr>
                 
                  <tr>
                 <td> COLONIA: <span class="span"><?php echo $coloniatitu; ?></span></td>
                 <td> CASA PROPIA: <span class="span"><?php echo $casapropiatitu; ?></span></td>
                 </tr>
                 
                 <?php
                



                 if($casapropiatitu=="SI")
                     {
                     echo "
                     <tr>
                     <td>
                     Valor Comercial:<span class='span'>$vcomercial</span>
                     </td>
                     <td>
                     Pago mensual:<span class='span'>$pmensual</span>
                     </td>
                     </tr>";
                     }
                     
                     else
                         {
                           echo "
                     <tr>
                     <td>
                     Pago de Renta:<span class='span'>$renta</span>
                     </td>
                     <td>
                     Propietario:<span class='span'>$propietario</span>
                     </td>
                     </tr>
                     <tr>
                     <td colspan=2>
                     Teléfono:<span class='span'>$telefono</span>
                     </td>
                     </tr>";
                         
                     }
                 ?>
                 
                 <tr>
                  <td>TELEFONO: <span class="span"><?php echo $telefonotitu; ?></span></td>
                <td>ESTADO CIVIL: <span class="span"><?php echo $estadociviltitu; ?></span></td>
                 </tr>
                 
                  <tr>
                 <td> CELULAR: <span class="span"><?php echo $celulartitu; ?></span></td>
                 <td> CUANTAS PERSONAS DEPENDEN DE TI: <span class="span"><?php echo $cpersonastitu; ?> PERSONAS</span></td>
		  </tr>
                 
                  <tr>
                 <td> COMUNIDAD A LA QUE PERTENECE: <span class="span"><?php echo $comunidad; ?></span></td>
                 <td> </td>
                 </TR>
                  <tr>
                 <th colspan=2>
                 EL ALUMNO RESIDE CON: <span class="span"><?php echo $reside; ?></span> 
                 </th>
                 </tr>
                 
                 <?php 
                 




if($reside=="Otros")
    {
    echo " <tr>
                 <th colspan=2>
                RESIDE CON: <span class='span'>$otroreside</span> 
                 </th>
                 </tr>";
}
else
{
    
}




    echo " <tr>
                 <td >
                ¿Quién paga las colegiaturas: <span class='span'>$paga</span> 
                 </td>";
    if($paga=="Otros")
        {
        echo "<td >
                ¿Persona que paga: <span class='span'>$otropaga</span> 
                 </td>";
        }
 else 
     {
      echo "<th >
                
                 </th>";
     
 }
                 
        echo "  </tr>";
    
  echo " <tr>
                 <th >
                ¿EL Padre trabaja: <span class='span'>$trabaja</span> 
                 </th>"; 
  
   if($trabaja=="NO")
        {
        echo "<th >
              ¿Explica: <span class='span'>$otrotrabaja</span> 
               </th>
                </tr>";
        }
 else 
     {
      echo "<th >
              
               </th>
                </tr>";
        
 }
        
    

                 
                 
                 ?>
                 
                 
                 </table>
        
        <table align="center"  id='gradient-style' summary='Meeting Results'>
               <tr align='center' valign='middle'> 
              <th colspan=2>
              EXPERIENCIA LABORAL ACTUAL DEL PADRE (TITULAR)
               </th>
               </tr>
                 <tr>
                     <td> <p class="mayuscula">empresa:  <span class="span"><?php echo $empresatitu; ?></span></p> </td>
                     <td> <p class="mayuscula">Telefono: <span class="span"><?php echo $telempresatitu ; ?></span></p></td>
                 </TR>
                 <tr>
                     <td> <p class="mayuscula">Es negocio propio: <span class="span"><?php echo $negiciotitu; ?></span></p></td>
                     <td><p class="mayuscula">Profesion : <span class="span"><?php echo $profesiontitu; ?></span></p></td>
                 </tr>
                  <tr>
                 <td><p class="mayuscula"> Que puesto ocupa  : <span class="span"><?php echo $puestotitu; ?></span></p></td>
                 <td> <p class="mayuscula">Jefe inmediato: <span class="span"><?php echo $jefetitu; ?></span></p></td>
                 </tr>
                 <tr>
                 <td><p class="mayuscula">¿tiempo trabajando en la empresa?:  <span class="span"><?php echo $tiempotitu; ?> AÑOS</span></p></td>
                 <td><p class="mayuscula">Sueldo Mensual Bruto : $<span class="span"><?php echo $sbrutotitu; ?></span></p></td>
                 </tr>
                 <tr>
                     <td><p class="mayuscula"> Sueldo mensual Neto: $<span class="span"><?php echo $snetotitu; ?></span></p></td>
                     <td><p class="mayuscula"> Otros Ingresos: $<span class="span"><?php echo $otrostitu; ?></span></p></td>
                 </TR>
                 <tr>
                 <td> TOTAL DE INGRESOS NETOS:  $<span class="span"><?php echo $totaltitu; ?></span></td>
                 <td></td>
                 </TR>
                 <tr>
                     <td colspan="2">Comentarios:
                         
                         <span class="span"><?php echo $comentarios1; ?></span>
                     </td>
                 </tr>
               </table>

        <table  align="center" id='gradient-style' summary='Meeting Results'>
                <thead>
                    <tr align='center' valign='middle'> 
		    <th colspan=2>INFORMACION DE LA MADRE(ESPOSA)</th>     
                    </tr>
                    </thead>
                 <tr>
                 <td> NOMBRE: <span class="span"><?php echo $nombremadre; ?></span></td>
                 <td> DIREECCION: <span class="span"><?php echo $direccionmadre; ?></span></td>
                 </TR>
                 
                  <tr>
                 <td> COLONIA: <span class="span"><?php echo $coloniamadre; ?></span></td>
                 <td>CASA PROPIA: <span class="span"><?php echo $casapropiamadre; ?></span></td>
		
                 </TR>
                 
                 <tr>
                  <td> TELEFONO: <span class="span"><?php echo $telefonomadre; ?></span></td>
               <td> ESTADO CIVIL: <span class="span"><?php echo $estadocivilmadre; ?></span></td>
               
		
                 </TR>
                  <tr>
                 
                 <td> CELULAR: <span class="span"><?php echo $celularmadre; ?></span></td>
                 <td><p class="mayuscula"> Cuantas personas depende de ti: <span class="span"><?php echo $cpersonasmadre; ?> PERSONAS</span></p></td>
		
                 </TR>

                 </table>
       <?php
       if($empresaesposa=="0")
       {
          ?>
             <table align='center' id='gradient-style' summary='Meeting Results'>
               <tr align='center' valign='middle'> 
              <th colspan=2>
             EXPERIENCIA LABORAL ACTUAL DE LA ESPOSA
               </th>
               </tr>
                 <tr>
                 <td>NO TRABAJA <span class="span"></span></td>
                 <td><p class="mayuscula">  <span class="span"></span></p></td>
                 </TR>
               </table>
           
         <?php
       }
        else 
       {
       ?>
        <table align="center" id='gradient-style' summary='Meeting Results'>
               <tr align='center' valign='middle'> 
              <th colspan=2>
             EXPERIENCIA LABORAL ACTUAL DE LA ESPOSA
               </th>
               </tr>
                 <tr>
                 <td>EMPRESA: <span class="span"><?php echo $empresaesposa; ?></span></td>
                 <td><p class="mayuscula"> Telefono: <span class="span"><?php echo $telempresaesposa; ?></span></p></td>
                 </TR>
                 <tr>
                     <td><p class="mayuscula"> Es negocio propio: <span class="span"><?php echo $negicioespo; ?></span></p></td>
                     <td><p class="mayuscula">Profesion : <span class="span"><?php echo $profesionespo; ?></span></p></td>
                 </TR>
                  <tr>
                      <td><p class="mayuscula"> Que puesto ocupa  : <span class="span"><?php echo $puestoespo; ?></span></p></td>
                      <td><p class="mayuscula"> Jefe inmediato: <span class="span"><?php echo $jefeespo; ?></span></p></td>
                 </TR>
                 <tr>
                     <td><p class="mayuscula"> ¿tiempo trabajando en la empresa?: <span class="span"><?php echo $tiempoespo; ?> AÑOS</span></p></td>
                     <td><p class="mayuscula">Sueldo Mensual Bruto : $<span class="span"><?php echo $sbrutoespo; ?></span></p></td>
                 </TR>
                 <tr>
                     <td><p class="mayuscula"> Sueldo mensual Neto: $<span class="span"><?php echo $snetoespo; ?></span></p></td>
                     <td><p class="mayuscula"> Otros Ingresos:$ <span class="span"><?php echo $otrosespo; ?></span></p></td>
                 </TR>
                 
                 <tr>
                     <td> TOTAL DE INGRESOS NETOS:$ <span class="span"><?php echo $totalespo; ?></span> </td>       
                 <td></td>
                 </tr>
                 <tr>
                     <td colspan="2">Comentarios:
                         
                         <span class="span"><?php echo $comentarios1; ?></span>
                     </td>
                 </tr>
               </table>
       
       <?php
           
       }
      

       ?>
 
    
    <page_footer>
         <h5 align="center">pagina 4</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
	
   
</page>
   
      
<!--separador -->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
     <p align="center"> <img src='images/alumnos.png' title='Editar'/></p>
      <page_footer>
          
          <h5 align="center">pagina 5</h5> 
        <table class="page_footer">
            
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>


<!--Se parador-->
<!-- Datos de alumnos--->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
    <h4 >Formato de datos de alumnos </h4><br>
    <table align='center' id='gradient-style' summary='Meeting Results'>
               <tr align='center' valign='middle'> 
              <th colspan=5>
             SI HA TENIDO O TIENE ALGUN TIPO DE BECA POR PARTE DEL COLEGIO MAGUEN DAVID SEÑALE:
               </th>
               </tr>
                 <tr>
                <td>Alumno</td>
    		<td>Grado a Cursar</td>
                <td>% BECA OTORGADA EN 2017-2018</td>
                <td>% BECA SOLICITADO EN 2018-2019</td>
                <td>Otorgado por</td>
                 </TR>
             
   
    
<?php
$familia=$_GET["id"]; 
$req="SELECT * FROM becas_respuesta_alumnos  WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
    $id=$row['id'];
$alumno1=$row['alumno1'];
$otorgado1=$row['otorgado1'];
$beca1=$row['beca1'];
$beca21=$row['beca21'];
$alumno2=$row['alumno2'];
$otorgado2=$row['otorgado2'];
$beca2=$row['beca2'];
$beca22=$row['beca22'];
$alumno3=$row['alumno3'];
$otorgado3=$row['otorgado3'];
$beca3=$row['beca3'];
$beca23=$row['beca23'];
$alumno4=$row['alumno4'];
$otorgado4=$row['otorgado4'];
$beca4=$row['beca4'];
$beca24=$row['beca24'];
$alumno5=$row['alumno5'];
$otorgado5=$row['otorgado5'];
$beca5=$row['beca5'];
$beca25=$row['beca25'];
$total=$row['total'];
$opc=$row['opc'];
$nombre1=$row['nombre1'];
$colegio1=$row['colegio1'];
$escolar1=$row['escolar1'];
$porcentaje1=$row['porcentaje1'];
$nombre2=$row['nombre2'];
$colegio2=$row['colegio2'];
$escolar2=$row['escolar2'];
$porcentaje2=$row['porcentaje2'];
$nombre3=$row['nombre3'];
$colegio3=$row['colegio3'];
$escolar3=$row['escolar3'];
$porcentaje3=$row['porcentaje3'];
$idfamilia=$row['idfamilia'];
$ingreso=$row['ingreso'];
$acursar1=$row['acursar1'];
$solicitado=$row['solicitado'];
$ingreso1=$row['ingreso1'];
$acursar2=$row['acursar2'];
$solicitado1=$row['solicitado1'];

}
$req="select a.id,a.nombre,c.grado from alumnoschmd a LEFT JOIN catalogo_grado_cursar c on a.idcursar=c.idcursar where a.idfamilia=".$familia;
$sql= mysql_query($req);
while($cliente =  mysql_fetch_array($sql))
        {
    $idalumno=$cliente[0];
        $alumno=$cliente[1];
        $grado=$cliente[2];
          $i++;
            $otorgado=${'otorgado'.$i};
                $beca=${'beca'.$i};
         $becaw=${'beca2'.$i};
          
          
          echo "<tr>
                <TD ALIGN='CENTER'><span class='span'>$alumno</span> </td>
             <TD ALIGN='CENTER'><span class='span'>$grado</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$beca</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$becaw</span> </td>
                <TD ALIGN='CENTER'><span class='span'>CHMD</span> </td>
               </tr>";

    
}
    ?>
             <tr>
            <th colspan=5> Alumnos de nuevo ingreso</th>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td>Grado a Cursar:</td>
            <td>% Solicitado</td>
            <td colspan=2>Solicitado A</td>
        </tr>
        
     
         <tr>
             <td><?php echo "$ingreso"; ?></td>
            <td><?php echo "$acursar1"; ?></td>
            <td><?php echo "$solicitado"; ?></td>
            <td colspan=2>CHMD</td>
        </tr> 
        <tr>
            <td><?php echo "$ingreso1"; ?></td>
            <td><?php echo "$acursar2"; ?></td>
            <td><?php echo "$solicitado1"; ?></td>
            <td colspan=2>CHMD</td>
        </tr>
        
        
                 
                 
                 
                 
                 
                 
                 <?php
                 if($opc==0)
                 {
                    ECHO' 
                         <tr>
                        <th colspan=5><p class="mayuscula">¿Tienes hijos en otro colegio que tengan beca?</p></th>
                 </TR>
               
                      <tr>
                          <td colspan=5><span class="span">NO TIENE  OTROS HIJOS</span></td>
                 </TR>';
                    
                 }
                 else
                 {

                           echo '
               <tr>
                        <th colspan=5><p class="mayuscula">¿Tienes hijos en otro colegio que tengan beca?</p></th>
                 </TR>
             <tr>
   	    <TD ALIGN="CENTER">Nombre</td>
           <TD ALIGN="CENTER">Colegio</td>
           <TD ALIGN="CENTER">Año escolar</td>
           <TD ALIGN="CENTER">% Beca otorgado</td>
           <td></td>
        </tr>';
                            echo "<tr>
                <TD ALIGN='CENTER'><span class='span'>$nombre1</span> </td>
             <TD ALIGN='CENTER'><span class='span'>$colegio1</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$escolar1</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$porcentaje1</span> </td>
                <TD ALIGN='CENTER'><span class='span'></span> </td>
               </tr>";
                         
                         
                    
                     
                     if($nombre2==null)
                     {  
                     }
                     else
                     {
                          echo "<tr>
                <TD ALIGN='CENTER'><span class='span'>$nombre2</span> </td>
                <TD ALIGN='CENTER'><span class='span'>$colegio2</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$escolar2</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$porcentaje2</span> </td>
                <TD ALIGN='CENTER'><span class='span'></span> </td>
               </tr>";
                     }
                     
                     
                         if($nombre3==null)
                     {   
                         
                     }
                     else
                     {
                      echo "<tr>
                <TD ALIGN='CENTER'><span class='span'>$nombre3</span> </td>
                <TD ALIGN='CENTER'><span class='span'>$colegio3</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$escolar3</span> </td>
               <TD ALIGN='CENTER'><span class='span'>$porcentaje3</span> </td>
                <TD ALIGN='CENTER'><span class='span'></span> </td>
               </tr>";   
                     }

                 }
                 ?>
                    
                 </table>
      <page_footer>
          
          <h5 align="center">pagina 6</h5> 
        <table class="page_footer">
            
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<!--  FIN de Datos de alumnos--->
<!--propiedades-->
<!--separador -->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
     <p align="center"> <img src='images/propiedades.png' title='Editar'/></p>
      <page_footer>
          
          <h5 align="center">pagina 7</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<!--Separador -->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
   <h4 >Formato de propiedades </h4><br>  
    <?php
$familia=$_GET["id"]; 

$req="SELECT * FROM becas_respuesta_propiedades WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{

$id=$row['id'];



$idfamilia=$row['idfamilia'];


/**/
$cuernavaca=$row['cuernavaca'];
$explica==$row['explica'];

$adicional=$row['adicional'];
$domicilioadicional=$row['domicilioadicional'];
$valoradicional=$row['valoradicional'];
$moneda4=$row['moneda4'];

$adicional1=$row['adicional1'];
$domicilioadicional1=$row['domicilioadicional1'];
$valoradicional1=$row['valoradicional1'];
$moneda5=$row['moneda5'];


}
?>
   <table align='center'   id='gradient-style' summary='Meeting Results'>
        <tr>  
         <th  colspan='3'>
	Si tiene otras propiedades dentro y fuera del país indique (terreno, casa en renta, casa de campo, ranchos, tiempos compartidos, etc.)
	</th>
      
	</tr>
   <?php


///////////cuernavaca
//
if($cuernavaca==1)
{
    $cuerna="SI TENGO";
    
    ECHO "    
        
	
        
        <tr>
	<td colspan='3'>Explica: </td>
        
	</tr>
          <tr>
	<td colspan='3'><span class='span'>$explica</span> </td>
        
	</tr>";
}
else 
{
      $cuerna="NO TENGO";
       ECHO " 
    
        
        
        <tr>
        <td><span class='span'>$cuerna</span></td>
	<td  colspan='2'> </td>
	
	</tr>";
    
} 




//RENTE PROPIEDAD

if($adicional==1)
{
    $adicional2="SI TENGO";
    
    ECHO " 
        
 <tr>
         
         <th  colspan='3'>
	TIENE OTRA PROPIEDAD QUE RENTE? $adicional2
	</th>
      
	</tr>
	
        
        <tr>
	<td>DOMICILIO </td>
        <td>VALOR COMERCIAL ACTUAL</td>
	<td>Tipo de moneda</td>
	</tr>
          <tr>
	<td><span class='span'>$domicilioadicional</span> </td>
        <td><span class='span'>$valoradicional</span></td>
	<td><span class='span'>$moneda4</span></td>
	</tr>";
}
else 
{
      $adicional2="NO TENGO";
       ECHO " 
        <tr>
        <th  colspan='3'>
	TIENE OTRA PROPIEDAD QUE RENTE? 
	</th>
	</tr>
        <tr>
        <td><span class='span'>$adicional2</span></td>
	<td  colspan='2'> </td>
	
	</tr>";
    
} 

//////////////OTRO VALOR ADICIONAL
if($adicional1==1)
{
    $adicionals="SI TENGO";
    
    ECHO " 
 <tr>
 <th  colspan='3'>
	TIENE OTRA PROPIEDAD QUE HABITE? $adicionals
	</th>
	</tr> 
        <tr>
	<td>DOMICILIO </td>
        <td>VALOR COMERCIAL ACTUAL</td>
	<td>Tipo de moneda</td>
	</tr>
          <tr>
	<td><span class='span'>$domicilioadicional1</span> </td>
        <td><span class='span'>$valoradicional1</span></td>
	<td><span class='span'>$moneda5</span></td>
	</tr>";
}
else 
{
      $adicionals="NO TENGO";
       ECHO "  
        <tr>
        <th  colspan='3'>
	TIENE OTRA PROPIEDAD QUE HABITE?
	</th>
	</tr>
        <tr>
        <td><span class='span'>$adicionals</span></td>
	<td  colspan='2'> </td>
	
	</tr>";
    
} 



    ?>
</table>
      <page_footer>
          
          <h5 align="center">pagina 8</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>


<!--Fin de propiedades-->


<!--separador ingresos -->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <p align="center"> <img src='images/ingresos.png' title='Editar'/></p>
      <page_footer>
          
          <h5 align="center">pagina 9</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<!--Separador -->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    <h4>FORMATO DE PASIVOS</h4>
   
<?php
 $familia=$_GET["id"]; 
$req="SELECT * FROM becas_repuestas_ingresos WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
$id=$row['id'];

$consepto=$row['consepto'];
$tiempo=$row['tiempo'];
$cuenta=$row['cuenta'];
$institucion=$row['institucion'];
$saldo=$row['saldo'];
$consepto1=$row['consepto1'];
$tiempo1=$row['tiempo1'];
$cuenta1=$row['cuenta1'];
$institucion1=$row['institucion1'];
$saldo1=$row['saldo1'];
$preg2=$row['preg2'];
$consepto3=$row['consepto3'];
$tiempo3=$row['tiempo3'];
$cuenta3=$row['cuenta3'];
$institucion3=$row['institucion3'];
$credito3=$row['credito3'];

$consepto5=$row['consepto5'];
$tiempo5=$row['tiempo5'];
$cuenta5=$row['cuenta5'];
$institucion5=$row['institucion5'];
$credito5=$row['credito5'];
$consepto6=$row['consepto6'];
$tiempo6=$row['tiempo6'];
$cuenta6=$row['cuenta6'];
$institucion6=$row['institucion6'];
$credito6=$row['credito6'];
$consepto7=$row['consepto7'];
$tiempo7=$row['tiempo7'];
$cuenta7=$row['cuenta7'];
$institucion7=$row['institucion7'];
$credito7=$row['credito7'];
$preg3=$row['preg3'];
$status=$row['status'];
$modelo=$row['modelo'];
$valor=$row['valor'];
$cantidad=$row['cantidad'];
$mensual=$row['mensual'];
$modo=$row['modo'];
$status1=$row['status1'];
$modelo1=$row['modelo1'];
$valor1=$row['valor1'];
$cantidad1=$row['cantidad1'];
$mensual1=$row['mensual1'];
$modo1=$row['modo1'];
$status2=$row['status2'];
$modelo2=$row['modelo2'];
$valor2=$row['valor2'];
$cantidad2=$row['cantidad2'];
$mensual2=$row['mensual2'];
$modo2=$row['modo2'];
$status3=$row['status3'];
$modelo3=$row['modelo3'];
$valor3=$row['valor3'];
$cantidad3=$row['cantidad3'];
$mensual3=$row['mensual3'];
$modo3=$row['modo3'];
$idfamilia=$row['idfamilia'];

if($tiempo==11)
{
 $tiempo="NO APLICA";   
}

if($tiempo1==11)
{
 $tiempo1="NO APLICA";   
}

if($tiempo3==11)
{
    $tiempo3=0;
}

if($tiempo5==11)
{
    $tiempo5=0;
}
if($tiempo6==11)
{
    $tiempo6=0;
}
if($tiempo7==11)
{
    $tiempo7=0;
}

 if ($modo==1)
{
     $modo="PAGADO";
}
 elseif ($modo==2)
{
     $modo="FINANCIAMIENTO";
}
 elseif ($modo==3)
{
     $modo="NO APLICA";
}

//////////////
 if ($modo1==1)
{
     $modo1="PAGADO";
}
 elseif ($modo1==2)
{
     $modo1="FINANCIAMIENTO";
}
 elseif ($modo1==3)
{
     $modo1="NO APLICA";
}

///////////////////
 if ($modo2==1)
{
     $modo2="PAGADO";
}
 elseif ($modo2==2)
{
     $modo2="FINANCIAMIENTO";
}
 elseif ($modo2==3)
{
     $modo2="NO APLICA";
}
//////////
 if ($modo3==1)
{
     $modo3="PAGADO";
}
 elseif ($modo3==2)
{
     $modo3="FINANCIAMIENTO";
}
 elseif ($modo3==3)
{
     $modo3="NO APLICA";
}





///pregunta 2
if($preg2=="NO")
{
 $pregw=" NO TENGO";   
 echo " <table align='center'   id='gradient-style' summary='Meeting Results'>
           <tr>
           <th  colspan='5'>
           Tiene más cuentas de cheques o tarjetas de crédito favor de anexarlas al presente documento. 
           </th>
           </tr> 
            <tr>
           <td>
                   <span class='span'> $pregw</span>
              
           </td>
           </tr> 
        
    </table>";
}
 else 
{
     $pregw=" SI TENGO";   
    echo "<table align='center'   id='gradient-style' summary='Meeting Results'>
           <tr>
           <th  colspan='5'>
            Tiene más cuentas de cheques o tarjetas de crédito favor de anexarlas al presente documento. 
           </th>
           </tr> 
           <tr>
           <td colspan='5'>
                   <span class='span'> $pregw</span>
              
           </td>
           </tr> 
           <tr>
               <td>TIPO DE CUENTA</td>  
               <td>ANTIGUEDAD</td> 
               <td>NO.CUENTA</td> 
               <td>INSTITUCION</td> 
               <td>CREDITO O SALDO</td> 
               
           </tr>
           
            <tr>
           <td>
                   <span class='span'> $consepto3</span>
              
           </td>
           <td>
                   <span class='span'> $tiempo3</span>
              
           </td>
           <td>
                   <span class='span'> $cuenta3</span>
              
           </td>
           <td>
                   <span class='span'> $institucion3</span>
              
           </td>
           <td>
                   <span class='span'> $credito3</span>
              
           </td>
           </tr> 
           
           
           
<tr>
           <td>
                   <span class='span'> $consepto5</span>
              
           </td>
           <td>
                   <span class='span'> $tiempo5</span>
              
           </td>
           <td>
                   <span class='span'> $cuenta5</span>
              
           </td>
           <td>
                   <span class='span'> $institucion5</span>
              
           </td>
           <td>
                   <span class='span'> $credito5</span>
              
           </td>
           </tr> 
           
/**/

<tr>
           <td>
                   <span class='span'> $consepto</span>
              
           </td>
           <td>
                   <span class='span'> $tiempo</span>
              
           </td>
           <td>
                   <span class='span'> $cuenta</span>
              
           </td>
           <td>
                   <span class='span'> $institucion</span>
              
           </td>
           <td>
                   <span class='span'> $saldo</span>
              
           </td>
           </tr> 
           <tr>
           <td>
                   <span class='span'> $consepto1</span>
              
           </td>
           <td>
                   <span class='span'> $tiempo1</span>
              
           </td>
           <td>
                   <span class='span'> $cuenta1</span>
              
           </td>
           <td>
                   <span class='span'> $institucion1</span>
              
           </td>
           <td>
                   <span class='span'> $saldo1</span>
              
           </td>
           </tr> 



           <tr>
           <td>
                   <span class='span'> $consepto6</span>
              
           </td>
           <td>
                   <span class='span'> $tiempo6</span>
              
           </td>
           <td>
                   <span class='span'> $cuenta6</span>
              
           </td>
           <td>
                   <span class='span'> $institucion6</span>
              
           </td>
           <td>
                   <span class='span'> $credito6</span>
              
           </td>
           </tr> 
        <tr>
           <td>
                   <span class='span'> $consepto7</span>
              
           </td>
           <td>
                   <span class='span'> $tiempo7</span>
              
           </td>
           <td>
                   <span class='span'> $cuenta7</span>
              
           </td>
           <td>
                   <span class='span'> $institucion7</span>
              
           </td>
           <td>
                   <span class='span'> $credito7</span>
              
           </td>
           </tr> 
        
    </table>";
}
///PREGUNTA 3
if($preg3=="NO")
{
 $pregw=" NO TENGO";   
 echo " <table align='center'   id='gradient-style' summary='Meeting Results'>
           <tr>
           <th  colspan='5'>
          ¿Tiene automóviles? 
           </th>
           </tr> 
            <tr>
           <td>
                   <span class='span'> $pregw</span>
              
           </td>
           </tr> 
        
    </table>";
}
 else 
{
     $pregw=" SI TENGO";   
    echo "<table align='center'   id='gradient-style' summary='Meeting Results'>
           <tr>
           <th  colspan='5'>
              ¿Tiene automóviles? 
           </th>
           </tr> 
           <tr>
           <td colspan='5'>
                   <span class='span'> $pregw</span>
              
           </td>
           </tr> 
           <tr>
               <td>MARCA O MODELO</td>  
               <td>VALOR COMERCIAL</td> 
               <td>MODO DE PAGO</td> 
               <td>TOTAL DE LA DEUDA</td> 
               <td>MENSUALIDADES</td> 
               
           </tr>
           
            <tr>
           <td>
                   <span class='span'> $modelo</span>
              
           </td>
           <td>
                   <span class='span'> $valor</span>
              
           </td>
           <td>
                   <span class='span'> $modo </span>
              
           </td>
           <td>
                   <span class='span'>$cantidad </span>
              
           </td>
           <td>
                   <span class='span'>$mensual </span>
              
           </td>
           </tr> 
           
            <tr>
           <td>
                   <span class='span'> $modelo1</span>
              
           </td>
           <td>
                   <span class='span'> $valor1</span>
              
           </td>
           <td>
                   <span class='span'> $modo1 </span>
              
           </td>
           <td>
                   <span class='span'>$cantidad1 </span>
              
           </td>
           <td>
                   <span class='span'>$mensual1 </span>
              
           </td>
           
           </tr> 
           
   <tr>
           <td>
                   <span class='span'> $modelo2</span>
              
           </td>
           <td>
                   <span class='span'> $valor2</span>
              
           </td>
           <td>
                   <span class='span'> $modo2 </span>
              
           </td>
           <td>
                   <span class='span'>$cantidad2 </span>
              
           </td>
           <td>
                   <span class='span'>$mensual2 </span>
              
           </td>
           </tr> 
           

            <tr>
           <td>
                   <span class='span'> $modelo3</span>
              
           </td>
           <td>
                   <span class='span'> $valor3</span>
              
           </td>
           <td>
                   <span class='span'> $modo3 </span>
              
           </td>
           <td>
                   <span class='span'>$cantidad3</span>
              
           </td>
           <td>
                   <span class='span'>$mensual3 </span>
              
           </td>
           </tr> 
        
        
    </table>";
}

}
  ?>  
    
    
  
  
      <page_footer>
          
          <h5 align="center">pagina 10</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<!--fin de gastos-->
<!--VIAJES-->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <p align="center"> <img src='images/viajes.png' title='Editar'/></p>
      <page_footer>
          
          <h5 align="center">pagina 11</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<!--formato de viajes-->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
        <h4>FORMATO DE VIAJES</h4>
   
<?php
 $familia=$_GET["id"]; 
$req="SELECT * FROM becas_respuesta_viajes WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
$id=$row['id'];
$opc=$row['opc'];
$lugar1=$row['lugar1'];
$person1=$row['person1'];
$cantperson1=$row['cantperson1'];
$fecha1=$row['fecha1'];
$tiempo1=$row['tiempo1'];
$costo1=$row['costo1'];
$financiamiento1=$row['financiamiento1'];
$lugar2=$row['lugar2'];
$person2=$row['person2'];
$cantperson2=$row['cantperson2'];
$fecha2=$row['fecha2'];
$tiempo2=$row['tiempo2'];
$costo2=$row['costo2'];
$financiamiento2=$row['financiamiento2'];
$lugar3=$row['lugar3'];
$person3=$row['person3'];
$cantperson3=$row['cantperson3'];
$fecha3=$row['fecha3'];
$tiempo3=$row['tiempo3'];
$costo3=$row['costo3'];
$financiamiento3=$row['financiamiento3'];
$lugar4=$row['lugar4'];
$person4=$row['person4'];
$cantperson4=$row['cantperson4'];
$fecha4=$row['fecha4'];
$tiempo4=$row['tiempo4'];
$costo4=$row['costo4'];
$financiamiento4=$row['financiamiento4'];
$idfamilia=$row['idfamilia'];

if($opc==0)
{
    $opc="NO HEMOS TENIDO VIAJES";
    
    ECHO "  <table align='center'   id='gradient-style' summary='Meeting Results' >
	 <tr>
         
        <th  colspan='3'>
	FAVOR DE INDICAR SI HA REALIZADO UN VIAJE CUALQUIER MIEMBRO DE LA FAMILIA EN LOS ÚLTIMOS 12 MESES, ASÍ MISMO INDICAR EL LUGAR, FECHA,NÚMERO DE DÍAS,COSTO DE LOS VIAJES Y LA PERSONA QUE PAGO DICHOS VIAJES?
	</th>
      
	</tr>
         <tr>
         
         <td>
	 <span class='span'> $opc</span>
	</td>
      
	</tr>
    </table>";
}
else
{
    $opc="SI HEMOS TENIDO VIAJES";
    ECHO "  <table align='center'   id='gradient-style' summary='Meeting Results' >
	 <tr>
         
        <th  colspan='4'>
	FAVOR DE INDICAR SI HA REALIZADO UN VIAJE CUALQUIER MIEMBRO DE LA FAMILIA EN LOS ÚLTIMOS 12 MESES, ASÍ MISMO INDICAR EL LUGAR, FECHA,NÚMERO DE DÍAS,COSTO DE LOS VIAJES Y LA PERSONA QUE PAGO DICHOS VIAJES?
	</th>
      
	</tr>
         <tr>
         <td colspan='4'>
	 <span class='span'> $opc</span>
	</td>
	</tr>
         <tr>
         <th colspan='4'>
	 VIAJE 1
	</th>
	</tr>
        <tr>
        <td>LUGAR:</td>
        <td><span class='span'>$lugar1</span></td>
        <td>QUIEN REALIZO EL VIAJE:</td>
        <td><span class='span'>$person1</span></td>
        </tr>
         <tr>
        <td>NO. TOTAL DE PERSONAS:</td>
        <td><span class='span'>$cantperson1</span></td>
        <td>FECHA:</td>
        <td><span class='span'>$fecha1</span></td>
        </tr>
        
          <tr>
        <td>NUMERO DE DÍAS:</td>
        <td><span class='span'>$tiempo1</span></td>
        <td>COSTO TOTAL:</td>
        <td><span class='span'>$costo1</span></td>
        </tr>
        
        <tr>
         <td colspan='2'>COMO SE FINANCIO EL VIAJE:
	</td>
         <td colspan='2'>
	 <span class='span'> $financiamiento1</span>
	</td>
	</tr>
        
  <!--viaje 2-->
  <tr>
         <th colspan='4'>
	 VIAJE 2
	</th>
	</tr>
        <tr>
        <td>LUGAR:</td>
        <td><span class='span'>$lugar2</span></td>
        <td>QUIEN REALIZO EL VIAJE:</td>
        <td><span class='span'>$person2</span></td>
        </tr>
         <tr>
        <td>NO. TOTAL DE PERSONAS:</td>
        <td><span class='span'>$cantperson2</span></td>
        <td>FECHA:</td>
        <td><span class='span'>$fecha2</span></td>
        </tr>
        
          <tr>
        <td>NUMERO DE DÍAS:</td>
        <td><span class='span'>$tiempo2</span></td>
        <td>COSTO TOTAL:</td>
        <td><span class='span'>$costo2</span></td>
        </tr>
        
        <tr>
         <td colspan='2'>COMO SE FINANCIO EL VIAJE:
	</td>
         <td colspan='2'>
	 <span class='span'> $financiamiento2</span>
	</td>
	</tr>
        
  <!--viaje 3-->
  <tr>
         <th colspan='4'>
	 VIAJE 3
	</th>
	</tr>
        <tr>
        <td>LUGAR:</td>
        <td><span class='span'>$lugar3</span></td>
        <td>QUIEN REALIZO EL VIAJE:</td>
        <td><span class='span'>$person3</span></td>
        </tr>
         <tr>
        <td>NO. TOTAL DE PERSONAS:</td>
        <td><span class='span'>$cantperson3</span></td>
        <td>FECHA:</td>
        <td><span class='span'>$fecha3</span></td>
        </tr>
        
          <tr>
        <td>NUMERO DE DÍAS:</td>
        <td><span class='span'>$tiempo3</span></td>
        <td>COSTO TOTAL:</td>
        <td><span class='span'>$costo3</span></td>
        </tr>
        
        <tr>
         <td colspan='2'>COMO SE FINANCIO EL VIAJE:
	</td>
         <td colspan='2'>
	 <span class='span'> $financiamiento3</span>
	</td>
	</tr>
        
  <!--viaje 4-->
  <tr>
         <th colspan='4'>
	 VIAJE 4
	</th>
	</tr>
        <tr>
        <td>LUGAR:</td>
        <td><span class='span'>$lugar4</span></td>
        <td>QUIEN REALIZO EL VIAJE:</td>
        <td><span class='span'>$person4</span></td>
        </tr>
         <tr>
        <td>NO. TOTAL DE PERSONAS:</td>
        <td><span class='span'>$cantperson4</span></td>
        <td>FECHA:</td>
        <td><span class='span'>$fecha4</span></td>
        </tr>
        
          <tr>
        <td>NUMERO DE DÍAS:</td>
        <td><span class='span'>$tiempo4</span></td>
        <td>COSTO TOTAL:</td>
        <td><span class='span'>$costo4</span></td>
        </tr>
        
        <tr>
         <td colspan='2'>COMO SE FINANCIO EL VIAJE:
	</td>
         <td colspan='2'>
	 <span class='span'> $financiamiento4</span>
	</td>
	</tr>


    </table>";
}



}

?>
      <page_footer>
          
          <h5 align="center">pagina 12</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>


<!--fin de viajes-->
<!--SEGUROS-->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <p align="center"> <img src='images/seguros.png' title='Editar'/></p>
      <page_footer>
          
          <h5 align="center">pagina 13</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<!--formato de SEGUROS-->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
     <h4>FORMATO DE SEGUROS</h4>
     <?php
 $familia=$_GET["id"]; 
$req="SELECT * FROM becas_respuesta_seguros WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
$id=$row['id'];
$opc=$row['opc'];
$consepto1=$row['consepto1'];
$empresa1=$row['empresa1'];
$tiempo1=$row['tiempo1'];
$consepto2=$row['consepto2'];
$empresa2=$row['empresa2'];
$tiempo2=$row['tiempo2'];
$consepto3=$row['consepto3'];
$empresa3=$row['empresa3'];
$tiempo3=$row['tiempo3'];
$consepto4=$row['consepto4'];
$empresa4=$row['empresa4'];
$tiempo4=$row['tiempo4'];
$consepto5=$row['consepto5'];
$empresa5=$row['empresa5'];
$tiempo5=$row['tiempo5'];
$consepto6=$row['consepto6'];
$empresa6=$row['empresa6'];
$tiempo6=$row['tiempo6'];
$consepto7=$row['consepto7'];
$empresa7=$row['empresa7'];
$tiempo7=$row['tiempo7'];
$consepto8=$row['consepto8'];
$empresa8=$row['empresa8'];
$tiempo8=$row['tiempo8'];
$idfamilia=$row['idfamilia'];



}

if($opc==0)
{
    $opc="NO TENGO NINGUN TIPO DE SEGURO";
    ECHO " <table align='center'   id='gradient-style' summary='Meeting Results' >
         <tr>
             <th colspan='4'>
                ¿Tiene algun tipo de seguro: vida,medico,Autos,De accidentes?  
             </th>
         </tr>
         
          <tr>
             <td>
              <span class='span'>$opc</span>
             </td>
         </tr>"
            . "</table>";
}
 else 
{
     ECHO " <table align='center'   id='gradient-style' summary='Meeting Results' >
         <tr>
             <th colspan='4'>
                ¿Tiene algun tipo de seguro: vida,medico,Autos,De accidentes?  
             </th>
         </tr>
         
          <tr>
             <td colspan='4'>
              <span class='span'>$opc</span>
             </td>
         </tr>
         
         
         <tr>
             <th colspan='4'>
                Agrega los seguros con los que cuentas actualmente, en caso de ser de autos agrega la cantidad contratada.
             </th>
         </tr>
         
         
         <tr>
             <td>ID</td>
             <td>CONCEPTO</td>
             <td>EMPRESA</td>
             <td>CONTRATADO POR</td>
             
         </tr>
         
         
           <tr>
             <td>1</td>
             <td>$consepto1</td>
             <td>$empresa1</td>
             <td>$tiempo1</td>         
         </tr>
         
           <tr>
             <td>2</td>
             <td>$consepto2</td>
             <td>$empresa2</td>
             <td>$tiempo2</td>         
         </tr>
         
           <tr>
             <td>3</td>
             <td>$consepto3</td>
             <td>$empresa3</td>
             <td>$tiempo3</td>         
         </tr>
         
           <tr>
             <td>4</td>
             <td>$consepto4</td>
             <td>$empresa4</td>
             <td>$tiempo4</td>         
         </tr>
         
           <tr>
             <td>5</td>
             <td>$consepto5</td>
             <td>$empresa5</td>
             <td>$tiempo5</td>         
         </tr>
         
         
           <tr>
             <td>6</td>
             <td>$consepto6</td>
             <td>$empresa6</td>
             <td>$tiempo6</td>         
         </tr>
         
           <tr>
             <td>7</td>
             <td>$consepto7</td>
             <td>$empresa7</td>
             <td>$tiempo7</td>         
         </tr>
         
         
         <tr>
             <td>8</td>
             <td>$consepto8</td>
             <td>$empresa8</td>
             <td>$tiempo8</td>         
         </tr>
         
     </table>
     ";
    
}

?>
   
   
      <page_footer>
          
          <h5 align="center">pagina 14</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>

<!--separador de ingresos mensuales--->
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <p align="center"> <img src='images/mensuales.png' title='Editar'/></p>
      <page_footer>
          
          <h5 align="center">pagina 15</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>

<!--fin de separador de ingresos mensuales-->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
   
    <h4>FORMATO DE GASTOS Y INGRESOS MENSUALES</h4> 
<link href="css/report.css" rel="stylesheet" type="text/css">
     <?php
 $familia=$_GET["id"]; 
$req="SELECT * FROM becas_respuestas_gastosm WHERE idfamilia=".$familia." and periodo='2018-2019' limit 1";
$sql= mysql_query($req);
while($row =  mysql_fetch_array($sql))
{
$id=$row['id'];
$tpersonas=$row['tpersonas'];
$ingresos1=$row['ingresos1'];
$ingresos2=$row['ingresos2'];
$ingresos3=$row['ingresos3'];
$ingresos4=$row['ingresos4'];
$ingresos5=$row['ingresos5'];
$ingresos6=$row['ingresos6'];
$ingresos7=$row['ingresos7'];
$cant8=$row['cant8'];
$cant9=$row['cant9'];
$cant10=$row['cant10'];
$cant11=$row['cant11'];
$cant12=$row['cant12'];
$cant13=$row['cant13'];
$cant14=$row['cant14'];
$cant15=$row['cant15'];
$cant16=$row['cant16'];
$cant17=$row['cant17'];
$cant18=$row['cant18'];
$cant19=$row['cant19'];
$cant20=$row['cant20'];
$cant21=$row['cant21'];
$cant22=$row['cant22'];
$cant23=$row['cant23'];
$cant24=$row['cant24'];
$cant25=$row['cant25'];
$cant26=$row['cant26'];
$cant27=$row['cant27'];
$cant28=$row['cant28'];
$cant29=$row['cant29'];
$cant30=$row['cant30'];
$cant31=$row['cant31'];
$cant32=$row['cant32'];
$cant33=$row['cant33'];
$cant34=$row['cant34'];
$cant35=$row['cant35'];
$obs8=$row['obs8'];
$obs9=$row['obs9'];
$obs10=$row['obs10'];
$obs11=$row['obs11'];
$obs12=$row['obs12'];
$obs13=$row['obs13'];
$obs14=$row['obs14'];
$obs15=$row['obs15'];
$obs16=$row['obs16'];
$obs17=$row['obs17'];
$obs18=$row['obs18'];
$obs19=$row['obs19'];
$obs20=$row['obs20'];
$obs21=$row['obs21'];
$obs22=$row['obs22'];
$obs23=$row['obs23'];
$obs24=$row['obs24'];
$obs25=$row['obs25'];
$obs26=$row['obs26'];
$obs27=$row['obs27'];
$obs28=$row['obs28'];
$obs29=$row['obs29'];
$obs30=$row['obs30'];
$obs31=$row['obs31'];
$obs32=$row['obs32'];
$obs33=$row['obs33'];
$obs34=$row['obs34'];
$obs35=$row['obs35'];
$gasto8=$row['gasto8'];
$gasto9=$row['gasto9'];
$gasto10=$row['gasto10'];
$gasto11=$row['gasto11'];
$gasto12=$row['gasto12'];
$gasto13=$row['gasto13'];
$gasto14=$row['gasto14'];
$gasto15=$row['gasto15'];
$gasto16=$row['gasto16'];
$gasto17=$row['gasto17'];
$gasto18=$row['gasto18'];
$gasto19=$row['gasto19'];
$gasto20=$row['gasto20'];
$gasto21=$row['gasto21'];
$gasto22=$row['gasto22'];
$gasto23=$row['gasto23'];
$gasto24=$row['gasto24'];
$gasto25=$row['gasto25'];
$gasto26=$row['gasto26'];
$gasto27=$row['gasto27'];
$gasto28=$row['gasto28'];
$gasto29=$row['gasto29'];
$gasto30=$row['gasto30'];
$gasto31=$row['gasto31'];
$gasto32=$row['gasto32'];
$gasto33=$row['gasto33'];
$gasto34=$row['gasto34'];
$gasto35=$row['gasto35'];
$gasto36=$row['gasto36'];
$idfamilia=$row['idfamilia'];
$explica=$row['explica'];

$residuo=$ingresos7-$gasto36;
if($cant8==11)
{
  $cant8="0";  
}
if($cant9==11)
{
  $cant9="0";  
}
if($cant10==11)
{
  $cant10="0";  
}
if($cant11==11)
{
  $cant11="0";  
}

if($cant12==11)
{
  $cant12="0";  
}

if($cant13==11)
{
  $cant13="0";  
}

if($cant14==11)
{
  $cant14="0";  
}

if($cant15==11)
{
  $cant15="0";  
}

if($cant16==11)
{
  $cant16="0";  
}

if($cant17==11)
{
  $cant17="0";  
}
if($cant18==11)
{
  $cant18="0";  
}

if($cant19==11)
{
  $cant19="0";  
}

if($cant20==11)
{
  $cant20="0";  
}

if($cant21==11)
{
  $cant21="0";  
}

if($cant22==11)
{
  $cant22="0";  
}

if($cant23==11)
{
  $cant23="0";  
}
if($cant24==11)
{
  $cant24="0";  
}
if($cant25==11)
{
  $cant25="0";  
}

if($cant26==11)
{
  $cant26="0";  
}

if($cant27==11)
{
  $cant27="0";  
}

if($cant28==11)
{
  $cant28="0";  
}

if($cant29==11)
{
  $cant29="0";  
}


if($cant30==11)
{
  $cant30="0";  
}

if($cant31==11)
{
  $cant31="0";  
}

if($cant32==11)
{
  $cant32="0";  
}
if($cant33==11)
{
  $cant33="0";  
}
if($cant34==11)
{
  $cant34="0";  
}

if($cant35==11)
{
  $cant35="0";  
}
ECHO"  
<table align='center'   id='gradient-style' summary='Meeting Results' >
<tr>
<th colspan='3'>
INGRESOS FAMILIARES 
</th>
</tr>
<tr>       
<td>
CONCEPTO 
</td>
<td>
CANTIDAD
</td>
</tr>  
<tr>
<td>
NUMERO DE PERSONAS QUE APORTAN EL INGRESO FAMILIAR:
</td>
<td>
$tpersonas
</td>
</tr>
<tr>
<td>
SUELDO:
</td>
<td>
$ingresos1
</td>
</tr>
<tr>
<td>
HONORARIOS:
</td>
<td>
$ingresos2
</td>
</tr>
<tr>
<td>
COMISIONES:
</td>
<td>
 $ingresos3
</td>
</tr>

<tr>
<td>
RENTA:
</td>
<td>
 $ingresos4
</td>
</tr>


<tr>
<td>
INTERESES:
</td>
<td>
 $ingresos5
</td>
</tr>

<tr>
<td>
OTROS GASTOS:
</td>
<td>
 $ingresos6
</td>
</tr>

<tr>
<td>
TOTAL MENSUAL:
</td>
<td>
<span class='span'>$ingresos7</span>
</td>
</tr>
</table>";
ECHO"   <table align='center'   id='gradient-style' summary='Meeting Results' >
<tr>
<th>CONCEPTO</th>
<th>CANTIDAD</th>
<th>OBSERVACIONES</th>
<th>GASTO MENSUAL</th>
</tr>
<tr><td>Renta o Hipoteca</td><td>$cant8</td><td>$obs8</td><td>$gasto8</td></tr>
<tr><td>Mantenimiento</td><td>$cant9</td><td>$obs9</td><td>$gasto9</td></tr>
<tr><td>Predial</td><td>$cant10</td><td>$obs10</td><td>$gasto10</td></tr>
<tr><td>Agua</td><td>$cant11</td><td>$obs11</td><td>$gasto11</td></tr>
<tr><td>Luz</td><td>$cant12</td><td>$obs12</td><td>$gasto12</td></tr>
<tr><td>Gas</td><td>$cant13</td><td>$obs13</td><td>$gasto13</td></tr>
<tr><td>Teléfono</td><td>$cant14</td><td>$obs14</td><td>$gasto14</td></tr>
<tr><td>Alimentos (Super)</td><td>$cant15</td><td>$obs15</td><td>$gasto15</td></tr>
<tr><td>Financiamiento de Auto</td><td>$cant16</td><td>$obs16</td><td>$gasto16</td></tr>
<tr><td>Tarjetas de Credito</td><td>$cant17</td><td>$obs17</td><td>$gasto17</td></tr>
<tr><td>Medicamentos</td><td>$cant18</td><td>$obs18</td><td>$gasto18</td></tr>
<tr><td>Colegiaturas</td><td>$cant19</td><td>$obs19</td><td>$gasto19</td></tr>
<tr><td>Deportivo</td><td>$cant20</td><td>$obs20</td><td>$gasto20</td></tr>
<tr><td>Médicos y Terapias</td><td>$cant21</td><td>$obs21</td><td>$gasto21</td></tr>
<tr><td>Actividades de los hijos</td><td>$cant22</td><td>$obs22</td><td>$gasto22</td></tr>
<tr><td>Cablevisión o SKY</td><td>$cant23</td><td>$obs23</td><td>$gasto23</td></tr>
<tr><td>Teléfono Celular</td><td>$cant24</td><td>$obs24</td><td>$gasto24</td></tr>
<tr><td>Internet</td><td>$cant25</td><td>$obs25</td><td>$gasto25</td></tr>
<tr><td>Seguro gastos mayores</td><td>$cant26</td><td>$obs26</td><td>$gasto26</td></tr>
<tr><td>Seguro Automóvil</td><td>$cant27</td><td>$obs27</td><td>$gasto27</td></tr>
<tr><td>Seguro Casa Habitación</td><td>$cant28</td><td>$obs28</td><td>$gasto28</td></tr>
<tr><td>Servidumbre</td><td>$cant29</td><td>$obs29</td><td>$gasto29</td></tr>
<tr><td>Chofer</td><td>$cant30</td><td>$obs30</td><td>$gasto30</td></tr>
<tr><td>Gasolina</td><td>$cant31</td><td>$obs31</td><td>$gasto31</td></tr>
<tr><td>Arija</td><td>$cant32</td><td>$obs32</td><td>$gasto32</td></tr>
<tr><td>Vacaciones</td><td>$cant33</td><td>$obs33</td><td>$gasto33</td></tr>
<tr><td>Gastos Fines de semana</td><td>$cant34</td><td>$obs34</td><td>$gasto34</td></tr>
<tr><td>Otros Gastos</td><td>$cant35</td><td>$obs35</td><td>$gasto35</td></tr>
<tr><td colspan='2'>TOTAL DE GASTOS MENSUALES</td><td <td colspan='2'><span class='span'>$gasto36</span></td></tr>
.</table>";



}

 


?>
  
  
    
    
      <page_footer>
          
          <h5 align="center">pagina 16</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                   <img src='images/footer.png' title='Editar'/>
                </td>
            </tr>
        </table>
    </page_footer>
</page>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <p align="center"> <img src='images/concentrado.png' title='Editar'/></p>
      <page_footer>
            <h5 align="center">pagina 17</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                     <img src='images/footer.png' title='Editar'/>
                  
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
               <td style="width: 100%; text-align: center " >
                    <img src='images/titulo.png' title='Editar'  />
                </td>
            </tr>
        </table>
    </page_header>
    <br> <h4>CONCENTRADO DE EGRESOS Y INGRESOS</h4>
     <table align="center"   id="gradient-style" summary="Meeting Results" >
	   <tr>
         <th><p class="mayuscula">NO.</p> </th>      
        <th><p class="mayuscula">CONCEPTO</p> </th>
	<th align="center">CANTIDAD</th>
	</tr>
	<tr>
	<td>1. </td>
        <td><p class="mayuscula">sueldo de padre</p> </td>
        <td width=100><span class='span'>$<?php echo $totaltitu;?></span> </td>
	</tr>
	
	<tr>
	<td>2. </td>
        <td><p class="mayuscula"> sueldo de madre </p> </td>
        <td width=100><span class='span'>$<?php echo $totalespo;?></span> </td>
	</tr>
        
	
        <tr>
            <th colspan="2"><p class="mayuscula">RESULTADO</p></th>
	<td width=100> <span class='span'>$<?php echo $sueldos;?></span></td>
	</tr>

	</table>
    
    <br><br>
    <table align="center"   id="gradient-style" summary="Meeting Results" >
	   <tr>
         <th><p class="mayuscula">NO.</p> </th>      
        <th><p class="mayuscula">CONCEPTO</p> </th>
	<th align="center">CANTIDAD</th>
	</tr>
	<tr>
	<td>1. </td>
        <td><p class="mayuscula">TOTAL DE INGRESOS</p> </td>
        <td width=100><span class='span'>$<?php echo $ingresos7;?></span> </td>
	</tr>
	
	<tr>
	<td>2. </td>
        <td><p class="mayuscula"> TOTAL DE EGRESOS </p> </td>
        <td width=100><span class='span'>$<?php echo $gasto36;?></span> </td>
	</tr>
        
	
        <tr>
            <th colspan="2"><p class="mayuscula">RESULTADO</p></th>
	<td width=100> <span class='span'>$<?php echo $residuo;?></span></td>
	</tr>
        
        
        <tr>
            <th colspan="3"><p class="mayuscula">Comentarios</p></th>
	
	</tr>
        
        <tr>
           
	<td colspan="3"> <?php echo $explica;?></td>
	</tr>

    </table><br><br>
    
      <page_footer>
            <h5 align="center">pagina 18</h5> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: center">
                     <img src='images/footer.png' title='Editar'/>
                  
                </td>
            </tr>
        </table>
    </page_footer>
</page>
<?php
    $content = ob_get_clean();

    require_once(dirname(__FILE__).'/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'letter', 'fr', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Seccion_preguntas.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
