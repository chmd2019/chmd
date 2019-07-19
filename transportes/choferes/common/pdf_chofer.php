<?php

require_once '../../../icloud/vendor/autoload.php';
require '../../../icloud/Choferes/common/ControlChoferes.php';

ob_start();

$time = time();

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',

'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');



$arrayDias = array( 'Domingo', 'Lunes', 'Martes',

'Miercoles', 'Jueves', 'Viernes', 'Sabado');



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

$autos = $control->listado_autos($nfamilia);



?>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">

<page_header>

<p align="center"> <br> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

<p align="right"><b>Ciudad de México a: <?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>

</p>

</page_header>

<br><br><br>&nbsp;&nbsp;<br><br><br>&nbsp;&nbsp;

<p align="left">

Estimados Padres de Familia:

</p>

<p align="left">

La seguridad de nuestros alumnos es primordial para el Colegio, por lo que les recordamos las políticas de tarjetón y credencial para choferes:

</p>

<p align="left">

-Es necesario llenar el formato de autorización a choferes para recoger a sus hijos (adjunto en esta circular) y entregarlo en la caja, en sobre cerrado, con copia de  identificación oficial del padre o madre de familia que autoriza, así como del chofer.

</p>

<p align="left">

  -Una vez entregada dicha información, el chofer pasará a Audiovisual para la toma de foto y la entrega de su tarjetón.

</p>

<p align="left">

  -El costo será de $50.00 por credencial y tendrá vigencia hasta julio de 2019.

</p>

<p align="left">

  -En caso de dar de baja al chofer, es necesario dar aviso por mail a bajacredencial@chmd.edu.mx

</p>

<p align="left">

  -El chofer que no cumpla con estos requisitos, no podrá ingresar al Colegio.

</p>

<p align="left">

  A lo largo del ciclo escolar, solamente podrán realizar el trámite los días miércoles, de 9:00 a 14:00. Este servicio se agregará a los trámites que podrán hacer en line a través de nuestra página web; les informaremos cuando estés listo.

</p>

<p align="left">

  Agradecemos su comprensión y apoyo.

</p>

<p style="text-align: center;"><br><br>

  Atentamente,<br><br>

  Martha Aurora Gómez Moscoso<br><br>

  Directora de Administración y FinanzasAdministrativa

</p>

<page_footer></page_footer>

</page>





<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">

  <page_header>

    <p align="center"> <br> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <h2>FORMATO DE AUTORIZACIÓN A CHOFERES</h2>

      <h3> Ciclo escolar 2019-2020</h3></p>

  </page_header>

  <br>&nbsp;&nbsp;

  <p align="right">

    <b>Ciudad de México a: <?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>

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



  <p align="left">

    <b>Con el automóvil:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <table id="gradient-style" summary="Meeting Results">

      <tr>

        <th>Marca</th>

        <th>Modelo</th>

        <th>Color</th>

        <th>Placas</th>

      </tr>

      <?php

      while( $auto = mysqli_fetch_array($autos)){

        $marca  = $auto['marca'];

        $modelo = $auto['modelo'];

        $color = $auto['color'];

        $placa = $auto['placas'];

        ?>

        <tr>

          <td><?=$marca?></td>

          <td><?=$modelo?></td>

          <td><?=$color?></td>

          <td><?=$placa?></td>

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

      <br><br><br><br>

      <br>-----------------------------------------<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Firma

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

<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf = new \Mpdf\Mpdf();

$stylesheet = file_get_contents('../../../icloud/Choferes/css/reportepdf.css');
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output('Doc_Autorizacion.pdf', \Mpdf\Output\Destination::DOWNLOAD);
?>
