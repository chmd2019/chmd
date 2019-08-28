<?php

require_once '../../vendor/autoload.php';
require 'ControlMisArchivos.php';
require 'sesion.php';

//Fecha Actual
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
'Miércoles', 'Jueves', 'Viernes', 'Sabado');

//consegir familia
$user = $service->userinfo->get();
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->acceso_login($correo);
//get_familia
$consulta = mysqli_fetch_array($consulta);
$familia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);

$control= new ControlArchivos();
//padres
$padres = $control->get_padres($familia, $correo);
while($padre = mysqli_fetch_array($padres)){
  $tipo= $padre['tipo'];
  if ($tipo=='3'){
    //papa
    $papa = $padre['nombre'];
  }else if($tipo=='4'){
    //mama
    $mama = $padre['nombre'];
  }
}
//conseguir los Hijos
$hijos = $control->listado_hijos($familia);

ob_start();
//conseguir idchofer
?>


<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
  <p align="left">
    <b>IV. FORMATO DE AUTORIZACIÓN PARA TOMA DE FOTOGRAFÍAS Y VIDEO</b>
  </p>
  <p align="left">
    <i><b>Nota: Favor de imprimir, completar los datos y entregar a su educador </b></i>
  </p>
  <p align="justify" >
    <b>Como parte de nuestro programa educativo en la nueva era Maguen, los alumnos participan constantemente en diversas experiencias de aprendizaje además de ceremonias, festividades, competencias deportivas, etc.</b>
  </p>
  <p align="justify"  >
    <b>Para nosotros es importante conservar un testimonio de todos estos momentos y, además, publicarlos en diversos medios como la página web del Colegio, el micrositio de Cultura Digital, el Haderej impreso y el Haderej digital, así como en las redes sociales.</b>
  </p>

  <p align="justify" >
    <b>
      Es por esto que les pedimos llenar el siguiente formato y enviarlo a la brevedad a su educador.
    </b>
  </p>
  <br>
  <p align="left">
    <b>
      Por medio de la presente 	autorizo_____________ no autorizo______________
    </b>
  </p>
  <p align="justify" >
    <b>
      al Colegio Hebreo Maguen David a tomar fotografías y video a mi hijo en las actividades escolares y publicar esas fotografías y videos en los medios del Colegio.
    </b>
  </p>
  <p align="left" >
    <b>Fecha:</b> Ciudad de México, <?php echo date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');?>
  </p>
  <?php
    while( $alumno = mysqli_fetch_array($hijos)){
        $nombre  = $alumno['nombre'];
        ?>
        <p align="left" >
          <b>
            Nombre del Alumno: </b> <?=$nombre?>
          </p>
        <?php
    }
    ?>

    <?php
      if(isset($papa)){
          ?>
          <br><br>
          <p align="center" >
            ____________<u><?=$papa?></u>______________<br> <b>Nombre y firma de Papá</b>
          </p>
          <?php
      }
      if(isset($mama)){
        ?>
        <br><br>
        <p align="center" >
          ____________<u><?=$mama?></u>______________<br> <b>Nombre y firma de Mamá</b>
        </p>
        <?php
      }
      ?>
    <br>
  <p align="justify" >
    <b>
    En el caso de los alumnos que no entreguen el formato, daremos por hecho que autorizan la toma y publicación de fotografías y videos.
    </b>
  </p>
  </page>

<?php
$html = ob_get_contents();
ob_end_clean();


$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 25,
	'margin_right' => 25,
	'margin_top' => 30,
	'margin_bottom' => 30,
	'margin_header' => 0,
	'margin_footer' => 0
]);

$stylesheet = file_get_contents('../css/pdf_style.css');
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output('Formato_Autorizacion_foto_video.pdf', \Mpdf\Output\Destination::DOWNLOAD);


?>
