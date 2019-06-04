<?php

ob_start();


$time = time();
 $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
 
   $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
       'Miercoles', 'Jueves', 'Viernes', 'Sabado');
   
 require('Control.php');  
  
   $dato="260319180145";
$objVer=new Control();
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

        <h4> <font color="#124A7B">JUNTA DE COMITÉ EJECUTIVO  <?php echo "$comite";?>. <br>MINUTA DEL DÍA.</font></h4>
        
               <?php
 // require('Control_kinder.php');  
 //$objVer=new Control_kinder();
//$consulta1=$objVer->mostrar_evento($dato);      

$objInt=new Control();
$consulta4=$objInt->mostrar_integrantes_evento($id_evento);
 // $salida2 = "";
 /*
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
    */   

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
        $html2pdf->Output('solicitud_chofer.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
