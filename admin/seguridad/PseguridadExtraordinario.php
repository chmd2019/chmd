<?php
include '../sesion_admin.php';
include '../conexion.php';

$root_imagenes=' http://chmd.chmd.edu.mx:65083';

if (!in_array('12', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$year=date('Y');
$mes=date('m');
$dia = date('d');
$mes_letras = $arrayMeses[(int)$mes - 1];

$datos = mysqli_query ( $conexion,"SELECT vpa.id as idpermisoalumno, vpa.id_alumno,ac.idcursar, ac.nombre, vp.id_permiso,vp.fecha_creacion,
  usu.correo,
  vp.comentarios,vpa.estatus,vp.nfamilia,
  vp.mensaje,
  vp.responsable,
  vp.parentesco,
  vp.fecha_creacion,
  vp.fecha_cambio,
  vp.fecha_respuesta,
  vp.tipo_permiso,
  vpa.hora_salida,
  vpa.hora_regreso,
  vpa.regresa,
  vpa.anio_creacion,
  ac.grupo,
  ac.grado,
  ac.nivel,
  ac.foto
  from
  Ventana_permisos_alumnos vpa
  LEFT JOIN Ventana_Permisos vp on vp.id_permiso=vpa.id_permiso
  LEFT JOIN alumnoschmd ac on ac.id = vpa.id_alumno
  LEFT JOIN usuarios usu on vp.idusuario=usu.id
  where vpa.estatus=2 and vp.tipo_permiso='4' and LOCATE('$year',vp.fecha_cambio )>0  and LOCATE( '$dia', vp.fecha_cambio )>0 and LOCATE( '$mes_letras', vp.fecha_cambio )>0 order by vpa.estatus_seguridad ;" );
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>CHMD :: Extraordinarios</title>
  <link href="../dist/css/bootstrap.css" rel="stylesheet">

  <link href="../css/menu.css" rel="stylesheet">
      <!-- Dependencias Globales -->
  <?php include '../components/header.php'; ?>

</head>
<body>
   <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>SEGURIDAD</h3>
        </div>
        
      <?php $perfil_actual='20'; include ('../menus_dinamicos/perfiles_dinamicos_seguridad.php'); ?>
       
    </nav>

    <!-- Page Content  -->
    <div id="content">
  <?php include_once "../components/navbar.php"; ?>
  <div class="reload">
  </div>
<div class="container" id='principal' style="max-width: 95vw;">
  <div class="masthead">
  </div>
  <br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->
<h2 class="text-center text-primary">Seguridad de Extraordinarios</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br>
 <br>
 <div class="table-responsive-lg">
<table class="table" id="niveles_table" width="100%">
  <thead>
    <td><b>Folio</b></td>
    <td><b>Nfamilia</b></td>
    <td><b>Estatus</b></td>
    <td><b>Responsable</b></td>
    <td><b>Hora Salida</b></td>
    <td><b>Hora Regreso</b></td>
    <td><b>Alumno</b></td>
    <td style="text-align:center"><b>Fotografía</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_alumno= $dato['id_alumno'];
      $nfamilia= $dato['nfamilia'];
      $id_permiso= $dato['id_permiso'];


      $idcursar= $dato['idcursar'];
      $idpermiso_alumno=$dato['idpermisoalumno'];

      $nombre_alumno = $dato['nombre'];
      $grado= $dato['grado'];
      $grupo= $dato['grupo'];
      $nivel= $dato['nivel'];
      //fotografia
      $foto= $dato['foto'];
      $foto = str_replace("C:\IDCARDDESIGN\CREDENCIALES\alumnos\\", '', $foto);
      $foto="$root_imagenes/CREDENCIALES/alumnos/$foto";

      $foto1="Con Foto";
      if($foto==null || is_file($foto)){
        $foto="sinfoto.png";
        $foto1="Sin foto";
      } else {
      }


      $regresa= $dato['regresa'];
      $hora_salida=$dato['hora_salida'];
      if ($regresa){
        $hora_regreso=$dato['hora_regreso'];
      }else{
        $hora_regreso='-';
      }

      $parentesco=$dato['parentesco'];
      $responsable= $dato['responsable'];


      $fecha_creacion= $dato['fecha_creacion'];
      $correo= $dato['correo'];
      $estatus= $dato['estatus'];
      $motivo=$dato['comentarios'];

      if($estatus==1){$staus1="Pendiente";}
      if($estatus==2){$staus1="Autorizado";}
      if($estatus==3){$staus1="Declinado";}
      if($estatus==4){$staus1="Cancelado por el usuario";}

      $mensaje=$dato['mensaje'];
      $fecha_cambio=$dato['fecha_cambio'];
      $fecha_respuesta = $dato['fecha_respuesta'];

      $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
      $array1 = explode(',' , $fecha_cambio );
      $array2= explode(' ',$array1[1]);
      $dia= $array2[1];
      $mes= '';
      $_mes= strtolower($array2[3]);
      switch ($_mes) {
            case 'enero':
            $mes=1;
            break;
            case 'febrero':
            $mes=2;
            break;
            case 'marzo':
            $mes=3;
            break;
            case 'abril':
            $mes=4;
            break;
            case 'mayo':
            $mes=5;
            break;
            case 'junio':
            $mes=6;
            break;
            case 'julio':
            $mes=7;
            break;
            case 'agosto':
            $mes=8;
            break;
            case 'septiembre':
            $mes=9;
            break;
            case 'octubre':
            $mes=10;
            break;
            case 'noviembre':
            $mes=11;
            break;
            case 'diciembre':
              $mes=12;
            break;
            default:
            $mes = -1;
          break;
      }



      if(1){
            $otro_dia=false;
      }else{
            $otro_dia=true;
      }

       if ($otro_dia==true){
        $color = '#ffc9ce';
        $borde= '#fff';
      }else{
        $color = '#fff';
        $borde= '#ddd';
      }
       //mostrar salida del alumno si es el dia del evento y hay treinta antes o despues de la hora del Evento
      $hora_actual = strtotime(date("d-m-Y H:i:s",time()));
      /* Hora Actual Test
        $hora_actual = strtotime('19-09-18 08:21:00');
      */

      $array = explode(':', $hora_salida);
      $hora_salida_hr= $array[0];
      $hora_salida_min= $array[1];
      //reconstruir fecha
      $anio= $array2[5] % 100;
      $_fecha_cambio= $mes.'/'.$dia.'/'.$anio.' '.$hora_salida_hr.':'.$hora_salida_min.':00';
      $fecha_entrada1 = new DateTime ($_fecha_cambio);
      $fecha_entrada2 = new DateTime ($_fecha_cambio);
      //horas +30min y -30min
      $hora_menos30 = $fecha_entrada1->modify('-30 minute');
      $hora_mas30 = $fecha_entrada2->modify('+30 minute');

      if ( ($hora_actual >= strtotime($hora_menos30->format('d-m-Y H:i:s'))) && ($hora_actual <= strtotime($hora_mas30->format('d-m-Y H:i:s'))) ) $show=true; else $show=false;

       if ($show){

      ?>
      <tr class="fila_alumnos" id="<?=$idpermiso_alumno?>"  style="background:<?=$color?>; border-bottom:  1px solid <?=$borde?>"  data-row="<?php echo $dato['id_permiso']?>">
        <td ><?php echo $id_permiso?></td>
        <td ><?php echo $nfamilia?></td>
        <td><?php echo $staus1?></td>
        <td><?php echo $responsable?></td>
            <td><?php echo $hora_salida?></td>
        <td><?php echo $hora_regreso?></td>
        <td><?php echo $nombre_alumno?></td>
        <td style="text-align:center" id="img_<?=$idpermiso_alumno?>"  onclick="set_estatus(<?=$idpermiso_alumno?>);">
            <img style="border: 1px solid #aaa; padding: 2px" src='<?php echo $foto ?>' alt="<?=$foto1?>" width="150px">
            <div>
          </div>
          <span class=""></span>
        </td>
    </td>
  </tr>
<?php } }?>
</tbody>
</table>
</div>

</div>
 <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>

</div>
    <div class="overlay"></div>
  </div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script type="text/javascript" src="js/Pseguridad.js"></script>
  <script type="text/javascript" src="../js/1min_inactivo.js" ></script>

 <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
  $(document).ready(function () {
      $("#sidebar").mCustomScrollbar({
          theme: "minimal"
      });

      $('#dismiss, .overlay').on('click', function () {
          $('#sidebar').removeClass('active');
          $('.overlay').removeClass('active');
      });

      $('#sidebarCollapse').on('click', function () {
          $('#sidebar').addClass('active');
          $('.overlay').addClass('active');
          $('.collapse.in').toggleClass('in');
          $('a[aria-expanded=true]').attr('aria-expanded', 'false');
      });

  });
</script>
</body>
</html>
