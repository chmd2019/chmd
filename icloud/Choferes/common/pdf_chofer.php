<?php

require_once '../../vendor/autoload.php';
require 'ControlChoferes.php';


ob_start();
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
'Miércoles', 'Jueves', 'Viernes', 'Sabado');

//conseguir idchofer
if (isset($_GET['idchofer'])){
  $id_chofer=$_GET['idchofer'];
}
//conseguir nombre del chofer
$control = new ControlChoferes();
$query= $control->get_chofer($id_chofer);
  if($chofer = mysqli_fetch_array($query)){
    $nombre_chofer = $chofer['nombre'];
    $nfamilia= $chofer['numero'];
  }
//consulta de hijos
$hijos = $control->listado_hijos($nfamilia);
//consultar carros de la familia
$autos = $control->listado_tarjetones_activos($nfamilia);

?>


<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
  <page_header >
    <p align="center"><h2>FORMATO DE AUTORIZACIÓN A CHOFERES</h2>
      <h3> Ciclo escolar 2019-2020</h3></p>
  </page_header>
  <br>&nbsp;&nbsp;
  <p align="right">
    <b>Ciudad de México a: <?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
  </p>
  <p align="left"></p>
  <p align="left">
    Por este medio autorizo a : <b><?=$nombre_chofer?></b>     recoger a mi(s) hijo(s):
  </p>
  <p align="left">
    <table id="gradient-style" summary="Meeting Results">
      <tr>
        <th>Alumno</th>
        <th>Grado</th>
        <th>Grupo</th>
      </tr>
      <?php
      while( $alumno = mysqli_fetch_array($hijos)){
        $nombre  = $alumno['nombre'];
        $grupo = $alumno['grupo'];
        $grado = $alumno['grado'];
        ?>
        <tr>
          <td><?=$nombre?></td>
          <td><?=$grado?></td>
          <td><?=$grupo?></td>
        </tr>
        <?php
      }
       ?>
      </table>
  </p>

  <p align="left" style="border-top:1px solid #ddd; padding-top:3px">
    <b>Con el automóvil:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <table id="gradient-style" summary="Meeting Results">
      <tr>
        <th>Marca</th>
        <th>Submarca</th>
        <th>Modelo</th>
        <th>Color</th>
        <th>Placas</th>
      </tr>
      <?php
      while( $auto = mysqli_fetch_array($autos)){
        $marca  = $auto['marca'];
        $submarca  = $auto['submarca'];
        $modelo = $auto['modelo'];
        $color = $auto['color'];
        $placa = $auto['placa'];
        ?>
        <tr>
          <td><?=$marca?></td>
          <td><?=$submarca?></td>
          <td><?=$modelo?></td>
          <td><?=$color?></td>
          <td><?=strtoupper($placa)?></td>
        </tr>
        <?php
        }
        ?>
      </table>
    </p>

    <p style="text-align: justify;">

      Tanto el padre o madre de familia que autoriza, como el chofer, deberán entregar copia de su identificación oficial.<br><br>
      Es responsabilidad del padre o madre de familia mantener actualizada esta información avisando al Colegio de cualquier cambio en la misma.<br><br><br><br>
      ---------------------------------------------------------------<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre del padre o madre<br>
    <br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------------------------------<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Firma
    </p>
    <page_footer>
      <p style="text-align: justify; font-size:8px;" >
        <b> Aviso de privacidad</b><br>
        &nbsp;&nbsp;Vigente a partir del 1ro. de diciembre del 2011 en Colegio Hebreo Maguen David  A.C., con domicilio en Antiguo Camino a Tecamachalco No.370 Col. Vista Hermosa  Delegación Cuajimalpa, Ciudad de México, Distrito Federal,&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;la información de la comunidad estudiantil así como de los Padres de Familia y Tutores es tratada de forma estrictamente confidencial por lo que al proporcionar sus datos personales a esta Institución, consiente su tratamiento&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;con las siguientes finalidades: 1.- La realización de los expedientes de todos y cada uno de los alumnos inscritos en este Colegio; 2.- La realización de encuestas, así como la creación e implementación de procesos analíticos y <br>
        &nbsp;estadísticos necesarios o convenientes, relacionados con el mejoramiento del sistema educativo implementado en este Colegio; 3.- La promoción de servicios, beneficios adicionales, becas, bonificaciones, concursos, todo esto &nbsp;&nbsp;&nbsp;
        ofrecido por o relacionado con las Responsables o Terceros nacionales o extranjeros con quienes este Colegio mantenga alianzas educativas; 4.- La atención de requerimientos de cualquier autoridad competente; &nbsp;&nbsp;&nbsp;&nbsp;
        <br>&nbsp;&nbsp;5.- La realización de cualquier actividad complementaria o auxiliar necesaria para la realización de los fines anteriores; 6.- La realización de consultas, investigaciones y revisiones en relación a cualquier queja o reclamación; y <br>7.- Ponernos en contacto con Usted para tratar cualquier tema relacionado con las labores de sus hijos en su calidad de alumnos de este Colegio; 8.- Mantener actualizados nuestros registros. Para conocer el texto completo del&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;aviso de privacidad para la comunidad del Colegio Hebreo Maguen David A.C. favor de consultar nuestra página en Internet www.chmd.edu.mx

      </p>
    </page_footer>
  </page>

  <page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
    <page_header>
      <p></p>
    </page_header>
    <br><br>&nbsp;&nbsp;
    <br><br>&nbsp;&nbsp;
    <p align="left">
      <b>Instructivo:</b>
    </p>
    <br>&nbsp;&nbsp;
    <p align="left">
      1. Lena los datos en su totalidad
    </p>
    <p align="left">
      2. Guarda, descarga, imprime y firma
    </p>
    <p align="left">
      3. Adjunta los siguientes documentos en copias fotostáticas:
    </p>
    <p align="left">
    - Identificación oficial de padre o madre de familia que autoriza
    </p>
    <p align="left">
    - Identificación oficial del o de los choferes dados de alta
    </p>
    <p align="left">
      4. Entregar en la caja del colegio, en sobre cerrado
    </p>
    <p align="left">
      5. El costo por credencial es de $50.00 (Cincuenta pesos 00/100 MN)
    </p>
    <p align="left">
      6. Una vez entregados los documentos y hecho el pago, el chofer pasará al área de Audiovisual para la toma de fotografía y entrega de la credencial y tarjetón
    </p>
    <p align="left">
      7. Por su seguridad en caso de baja de un chofer; el trámite de aviso debe hacerse en el Mi Maguen (mismo módulo de choferes)
    </p>
    <p align="left">
    8. La vigencia de las credenciales es a julio 2020
    </p>
    <p align="left">
      9. El chofer que no esté dado de alta adecuadamente, no tendrá acceso al Colegio
    </p>
    <p align="left">
      10. Al cierre del periodo de altas por inicio del ciclo escolar; el trámite de alta se recibirá los días miércoles de 9:00 a 14:00 h
    </p>

    <page_footer></page_footer>
  </page>

<?php
$html = ob_get_contents();
ob_end_clean();


$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 14,
	'margin_right' => 14,
	'margin_top' => 10,
	'margin_bottom' => 14,
	'margin_header' => 5,
	'margin_footer' => 10
]);

$stylesheet = file_get_contents('../css/reportepdf.css');
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output('Doc_Autorizacion.pdf', \Mpdf\Output\Destination::DOWNLOAD);


?>
