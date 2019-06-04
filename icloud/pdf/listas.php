<?php

ob_start();
require('Control_cch.php');

$time = time();
 $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
 
   $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
       'Miercoles', 'Jueves', 'Viernes', 'Sabado');
   
   
   
    $idmaestro=$_GET["idmaestro"]; 
    
   if($idmaestro==422){$profe="BELLA PICCIOTTO";}
   if($idmaestro==246){$profe="CECILIA GONZALEZ";}
   if($idmaestro==1){$profe="CECILIA RODRIGUEZ";}
   if($idmaestro==187){$profe="CINTHIA CRUZ ";}
   if($idmaestro==720){$profe="EDGAR HUERTA";}
   if($idmaestro==296){$profe="GUILLERMO VARGAS";}
   if($idmaestro==771){$profe="LEA MAMAN";}
   if($idmaestro==496){$profe="LIDIA GARCIA";}
   if($idmaestro==557){$profe="MERCEDES ORDOÑEZ";}
   if($idmaestro==669){$profe="ROSALIA MEDINA";}
   if($idmaestro==120){$profe="SOFY DAYAN";}
   if($idmaestro==599){$profe="THELMA SANDLER";}

    
?>

<link href="../css/pdf.css" rel="stylesheet" type="text/css">

<!--separador uno -->




<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
    
            
        <p align="center"> <br> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h2>Lista de Horarios:<?php echo $profe;?></h2><h3> Ciclo escolar 2018-2019</h3></p>
        
    
   
   
        
    
    
    </page_header>
    <br><br><br>&nbsp;&nbsp;<br><br><br>&nbsp;&nbsp;
    <p align="right"> 
       
        <b>Ciudad de México a:<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
    </p>
    
    
    <?php
   
    
 //$idchofer=3124;
$ObjRfc=new Control_cch();


    
    ?>

  <p align="left"> 
       
        
    <table id="gradient-style" summary="Meeting Results">
        <tr>
            <td>Orden</td>
            <td>horario</td>
            <td>Alumno</td>
             <td>Grado</td>
             <td>Grupo</td>
            
        </tr>
        
           
    
   <?php  
    $consulta3=$ObjRfc->Pdfcch($idmaestro);
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
    $junta=$horario." Hrs. &nbsp;&nbsp;".$dia;
 echo " <tr><td> $id</td>" ;
 echo "<td> $junta</td>" ;
 echo "<td> $alumno</td>" ;
 echo "<td> $grado</td>" ;
 echo "<td> $grupo</td></tr>" ;
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
