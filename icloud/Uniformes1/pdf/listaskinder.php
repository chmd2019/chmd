<?php

ob_start();
require('Control_kinder.php');

$time = time();
 $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
 
   $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
       'Miercoles', 'Jueves', 'Viernes', 'Sabado');
   
   
   
    $idmaestro=$_GET["idmaestro"]; 
    
   if($idmaestro==1){$profe="SUSANA CHALOM";}
if($idmaestro==2){$profe="CELIA MUSTRI";}
if($idmaestro==3){$profe="JAQUELINE FRIDMAN";}
if($idmaestro==4){$profe="LIZETTE DALVA";}
if($idmaestro==5){$profe="DEBORA WLODAWER";}
if($idmaestro==6){$profe="BRENDA TREPMAN";}
if($idmaestro==7){$profe="MARGARITA ZONANA";}
if($idmaestro==8){$profe="REGINA RAYEK";}
if($idmaestro==9){$profe="NICOLE SONSINO";}
if($idmaestro==10){$profe="JEANETTE MARCOS";}
if($idmaestro==11){$profe="SOFIA PAGOVICH";}
if($idmaestro==12){$profe="DENISSE YAKIN";}
if($idmaestro==13){$profe="SHEILA AYSSENMESER";}
if($idmaestro==14){$profe="PAOLA CHEREM";}


    
?>

<link href="../css/pdf.css" rel="stylesheet" type="text/css">

<!--separador uno -->




<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
    
            
        <p align="center"> <br> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h2>Lista de Horarios:<?php echo $profe;?></h2><h3> Ciclo escolar 2018</h3></p>
        
    
   
   
        
    
    
    </page_header>
    <br><br><br>&nbsp;&nbsp;<br><br><br>&nbsp;&nbsp;
  <!--  <p align="right"> 
       
        <b>Ciudad de México a:<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
    </p>-->
    
    
    <?php
   
    
 //$idchofer=3124;
$ObjKinder=new Control_kinder();


    
    ?>

  <p align="center"> 
       
        
    <table id="gradient-style" summary="Meeting Results">
        <tr>
            <td>Orden</td>
            <td>horario</td>
            <td>Alumno</td>
  
            
        </tr>
        
           
    
   <?php  
    $consulta3=$ObjKinder->Pdfkinder($idmaestro);
 while($cliente13= mysql_fetch_array($consulta3))
  {
     
            $id=$cliente13[0];
            $orden=$cliente13[1];
            $horario=$cliente13[2];
            $dia=$cliente13[3];
            $idalumno=$cliente13[4];
            $alumnocheck=$cliente13[5];
            $profesor=$cliente13[6];
            $alumno=$cliente13[7];
            $grado=$cliente13[8];
            $grupo=$cliente13[9];     
    $junta=$horario." Hrs";
 echo " <tr><td> $id</td>" ;
 echo "<td> $junta</td>" ;
 echo "<td> $alumno</td></tr>" ;
 }
    ?>  
    
 
           
            
        
    </table>
    </p>   
    
    
      <page_footer>
          
      
    </page_footer>
</page>




<!--Se parador uno -->

<!-- Segunda Pagina -->

 
   
      

<?php
    $content = ob_get_clean();

    require_once(dirname(__FILE__).'/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'letter', 'fr', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('solicitud_chofer.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
