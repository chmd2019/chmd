<?php

ob_start();


$time = time();
 $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
 
   $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
       'Miercoles', 'Jueves', 'Viernes', 'Sabado');
   
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

$descarga=$titulo."_".$comite;
 }

   
?>

<link href="css/report.css" rel="stylesheet" type="text/css">

<!--separador uno -->




<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>

    </page_header>
     
          <h3><b>Ciudad de MÉxico a</b>:<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3> 
   
            
        <p align="center"> 
        <!--    <img src='images/CHMD.png' width="120" height="80" title='CHMD'  />-->
        </p>
  
    <h4> <font color="#124A7B">JUNTA DE COMITÉ EJECUTIVO DE <?php echo "$comite";?>. <br>MINUTA DEL DÍA.</font></h4>
        
       <?php
       

$objInt=new Ctr_minuta();
$consulta4=$objInt->mostrar_integrantes_evento($id_evento);
  $salida2 = "";
 while( $cliente4 = mysql_fetch_array($consulta4) )
 {
     $id_usuario=$cliente4[0];
     $nombre=$cliente4[5];
     $asistencia=$cliente4[3];
     
      if($asistencia=="1")
          {
          $salida2.="&nbsp;".$nombre.",&nbsp;&nbsp;&nbsp;";
              }
      else {
          
      }
 
      
 }
     

?>

        
        <h2>Asistentes: <?php echo "$salida2";?></h2>
         <p>
           <!--  <img src='images/dividir.png' width="750" height="2" title='divisor'  />-->
        </p>
        <h2>Convocado por:  <?php echo "$convocado";?></h2>
         <p>
            <!-- <img src='images/dividir.png' width="750" height="2" title='divisor'  />-->
        </p>
    <h2>AGENDA DEL DÍA</h2>
    <p id="parrafo" class="parrafo">
        <?php 
       
$objTema=new Ctr_minuta();
$consulta2=$objTema->mostrar_temas($dato);
 $salida = "";
 while( $cliente2 = mysql_fetch_array($consulta2) )
 {
     
$counter = $counter + 1;
$id_tema=$cliente2[0];
$tema=$cliente2[1];
$estatustema=$cliente2[3];
$acuardos=$cliente2[4];
///////para dar enter despues del punto//
$resultado = str_replace(".", ".<br>", $acuardos);

$id_comite1=$cliente2[5];
$salida.="<h2>$tema:</h2>• $resultado.<br><br>";
echo "• $tema <br><br>";

 }
        
        
        ?>
        	
   
    </p>
     <p>
           <!--  <img src='images/dividir.png' width="750" height="2" title='divisor'  />-->
        </p>
        
        
           <h2>ACUERDOS</h2>
            <p id="parrafo" class="parrafo">
                
     <?php echo "$salida";?>
    </p>
    
        <!--<img src='images/dividir.png' width="750" height="2" title='divisor'  />-->
         <h2>Archivos adjuntos:</h2>
         <p>
             
             <?php
             
$objArchivo=new Ctr_minuta();
  $consulta44=$objArchivo->mostrar_archivos($id_evento);
  
 while( $cliente44 = mysql_fetch_array($consulta44) )
 {
 $id_archivo=$cliente44[0];
  $archivo=$cliente44[1];
            
              
?>

             <a href="http://docs.google.com/gview?url=http://chmd.chmd.edu.mx:65083/icloud/Eventos/uploads/<?php echo "$id_comite"; ?>/<?php echo "$archivo"; ?>&embedded=true">•<?php echo "$archivo"; ?></a><br><br>
<?php
}
?>
            
         </p>
        
            <h2>ELABORADO: </h2>
    <?php
   
    
 //$idchofer=3124;



    
    ?>

  
    
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
        $html2pdf->Output("Minuta_$descarga.pdf");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
