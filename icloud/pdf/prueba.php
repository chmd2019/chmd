<?php

ob_start();
require('../Choferes/Control_choferes.php');
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
'Miercoles', 'Jueves', 'Viernes', 'Sabado');
?>

<link href="../css/pdf.css" rel="stylesheet" type="text/css">

<!--separador uno -->

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
<page_header>


<p align="center"> <br> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>

<p align="right">

<b>Ciudad de México a:<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
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
  -El costo será de $50.00 por credencial y tendrá vigencia hasta julio de 2018.
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
  Directora de Administración y FinanzasAdministrativa</p>

  <page_footer>


  </page_footer>
</page>



<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
  <page_header>


    <p align="center"> <br> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <h2>FORMATO DE AUTORIZACIÓN A CHOFERES</h2><h3> Ciclo escolar 2018-2019</h3></p>







    </page_header>
    <br><br><br>&nbsp;&nbsp;<br><br><br>&nbsp;&nbsp;
    <p align="right">

      <b>Ciudad de México a:<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
    </p>


    <?php
    $idchofer=$_GET["idchofer"];
    //$idchofer=3124;
    $ObjRfc=new Control_choferes();
    $consulta1=$ObjRfc->mostrar_pdf($idchofer);
    if($cliente1 = mysql_fetch_array($consulta1))
    {

      $id=$cliente1[0];
      $nfamilia=$cliente1[1];
      $nombre=$cliente1[2];
      $idtipo=$cliente1[3];
      $idstatus=$cliente1[4];
      $fotografia=$cliente1[5];
      $fecha=$cliente1[6];
      $tipo=$cliente1[7];
      $correo=$cliente1[8];
      $marca=$cliente1[9];
      $modelo=$cliente1[10];
      $color=$cliente1[11];
      $placas=$cliente1[12];

    }

    ?>
    <p align="left">


    </p>
    <p align="left">

      Por este medio autorizo a : <b> <?php echo $nombre;?></b>     recoger a mi(s) hijo(s):
    </p>
    <p align="left">


      <table id="gradient-style" summary="Meeting Results">
        <tr>
          <td>Alumno</td>
          <td>Grado</td>
          <td>Grupo</td>

        </tr>


        <?php
        $consulta3=$ObjRfc->mostrar_alumnonos($nfamilia);
        while($cliente13= mysql_fetch_array($consulta3))
        {
          $idalumno=$cliente13[0];
          $alumno=$cliente13[2];
          $grado=$cliente13[3];
          $grupo=$cliente13[4];
          echo " <tr><td> $alumno</td>" ;
          echo "<td> $grado</td>" ;
          echo "<td> $grupo</td></tr>" ;
          }
          ?>





        </table>
      </p>







      <p align="left">

        <b>Con el automóvil:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <table id="gradient-style" summary="Meeting Results">
          <tr>
            <td>Marca</td>
            <td>Modelo</td>
            <td>Color</td>
            <td>Placas</td>
          </tr>

          <?php
          $consulta2=$ObjRfc->mostrar_autos($nfamilia);
          while($cliente12= mysql_fetch_array($consulta2))
          {

            $id=$cliente12[0];
            $marca=$cliente12[1];
            $modelo=$cliente12[2];
            $color=$cliente12[3];
            $placas=$cliente12[4];
            echo "  <tr><td>$marca</td>
              <td>$modelo</td>
              <td> $color</td>
              <td>$placas</td> </tr>";

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
