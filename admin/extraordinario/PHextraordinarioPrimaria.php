<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('8', $capacidades)){
    header('Location: PHextraordinarioBachillerato.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$datos = mysqli_query ( $conexion,"SELECT vpa.id as idpemisoalumno, vpa.id_alumno, ac.nombre, vp.id_permiso,vp.fecha_creacion,
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
  ac.nivel
  from
  Ventana_permisos_alumnos vpa
  LEFT JOIN Ventana_Permisos vp on vp.id_permiso=vpa.id_permiso
  LEFT JOIN alumnoschmd ac on ac.id = vpa.id_alumno
  LEFT JOIN usuarios usu on vp.idusuario=usu.id
  where vpa.estatus>1 and vp.tipo_permiso='4' and ac.id_nivel='2' order by vp.fecha_respuesta DESC " );
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
            <h3>EXTRAORDINARIOS</h3>
        </div>
        
          <?php $perfil_actual='16'; include ('../menus_dinamicos/perfiles_dinamicos_extraordinarios.php'); ?>
       </nav>

    <!-- Page Content  -->
    <div id="content">
<?php include_once "../components/navbar.php"; ?>
  <div class="reload">
  </div>
<div class="container-fluid" id='principal'>
  <div class="masthead">
  </div>
  <br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->
<?php
$_nivel='2';
include 'componentes/nuevos_permisos.php'; ?>
<a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
<h2 class="text-primary">Historial de Extraordinarios Primaria</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
<div class="table-responsive-lg">
<table class="table" id="niveles_table">
  <thead>
    <td><b>Folio</b></td>
    <td><b>Nfamilia</b></td>
    <td><b>Fecha de Solicitud</b></td>
    <td><b>Estatus</b></td>
    <td><b>Fecha Programada</b></td>
    <td><b>Alumno</b></td>
    <td class="text-center"><b>Acciones</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $idpermiso_alumno=$dato['idpemisoalumno'];
      $id_ulumno= $dato['id_alumno'];

      $id_permiso= $dato['id_permiso'];
      $nfamilia= $dato['nfamilia'];


      $nombre_alumno = $dato['nombre'];
      $grado= $dato['grado'];
      $grupo= $dato['grupo'];
      $nivel= $dato['nivel'];

      $regresa= $dato['regresa'];
      $hora_salida=$dato['hora_salida'];
      $hora_regreso=$dato['hora_regreso'];

      $responsable= $dato['responsable'];
      $parentesco=$dato['parentesco'];


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
      switch ($array2[3]) {
            case 'Enero':
            $mes=1;
            break;
            case 'Febrero':
            $mes=2;
            break;
            case 'Marzo':
            $mes=3;
            break;
            case 'Abril':
            $mes=4;
            break;
            case 'Mayo':
            $mes=5;
            break;
            case 'Junio':
            $mes=6;
            break;
            case 'Julio':
            $mes=7;
            break;
            case 'Agosto':
            $mes=8;
            break;
            case 'Septiembre':
            $mes=9;
            break;
            case 'Octubre':
            $mes=10;
            break;
            case 'Noviembre':
            $mes=11;
            break;
            case 'Diciembre':
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
      ?>
      <tr  style="background:<?=$color?>; border-bottom:  1px solid <?=$borde?>"  data-row="<?php echo $dato['id_permiso']?>">
        <td ><?php echo $id_permiso?></td>
        <td><?php echo $nfamilia?></td>
        <td><?php echo $fecha_creacion?></td>
        <td><?php echo $staus1?></td>
        <td><?php echo $fecha_cambio?></td>
        <td><?php echo $nombre_alumno?></td>

        <td class="text-center">
          <!--
            <button class="btn-autorizar btn btn-success" type="button"
            data-id="<?php echo $id?>"
            data-nombre="<?php echo $nfamila?>">
            <span class="glyphicon glyphicon-cloud">Autorizar</span>
          </button>
        -->
        <a data-target="#agregarNivel" data-toggle="modal"
        class="btn-editar" type="button"
        data-id="<?php echo $idpermiso_alumno?>"
        data-idpermiso="<?php echo $id_permiso?>"
        data-nfamilia="<?php echo $nfamilia?>"

        data-fecha="<?php echo $fecha_creacion?>"
        data-correo="<?php echo $correo?>"

        data-nombre="<?php echo $nombre_alumno?>"
        data-grado="<?php echo $grado?>"
        data-grupo="<?php echo $grupo?>"
        data-nivel="<?php echo $nivel?>"
        data-estatus="<?php echo $estatus?>"

        data-fechap="<?=$fecha_cambio?>"
        data-regresa="<?=$regresa?>"
        data-horasalida="<?=$hora_salida?>"
        data-horaregreso="<?=$hora_regreso?>"

        data-comentarios="<?php echo $motivo?>"
        data-mensaje="<?php echo $mensaje?>"

        data-responsable="<?php echo $responsable?>"
        data-parentesco="<?php echo $parentesco?>"

        data-fechacambio="<?php echo $fecha_cambio?>"
        data-frespuesta="<?php echo $fecha_respuesta?>">

         <?php include 'componentes/btn_ver.php'; ?>
      </a>

    <!--  <button class="btn-borrar btn btn-danger" type="button"
      data-id="<?php echo $idpermiso_alumno?>"
      data-nombre="<?php echo $nfamila ?>">
      <span class="glyphicon glyphicon-trash">Archivar</span>
    </button> -->

    <!--
      <a href="grado.php?qwert=<?php echo $dato['id']?>&amp;nombre=<?php echo $dato['nombre']?>"
        style="cursor: pointer;"><img src="img/pdf.png" width="40" height="40"/>
      </a>-->
    </td>
  </tr>
<?php }?>
</tbody>
</table>
</div>
</div>
<!-- /container -->
 <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
</div>
    <div class="overlay"></div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="js/PHextraordinarioArea.js"></script>
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
<!-- Modal -->
<div class="modal " id="agregarNivel" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="max-width: 750px">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="modalNivelTitulo">titulo</h4>
      <button type="button" class="close" data-dismiss="modal"
      aria-hidden="true">&times;</button>
    </div>
    <form class="form-signin save-nivel" method='post'>
      <div class="alert-save"></div>
      <div class="modal-body">
        <table border="0" WIDTH="700">

          <tr>
            <td WIDTH="10%" >Nfamilia:
              <input
              name="nfamilia" id="nfamilia" type="text"
              class="form-control" placeholder="nfamilia"  readonly>
            </td>

            <td WIDTH="50%">Fecha de solicitud:
              <input
              name="fecha_s" id="fecha_s" type="text"
              class="form-control" placeholder="fecha_s" readonly>
            </td>

            <td  WIDTH="40%">Solicitante:
              <input
              name="solicitante" id="solicitante" type="text"
              class="form-control" placeholder="solicitante"   readonly>
            </td>
          </tr>
        </table>

        <table>

          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Alumno de Permiso:</h4>
            </td>
          </tr>

        </table>
        <table  border="0" WIDTH="700">
          <tr>
            <td  WIDTH="40%">Alumno</td>
            <td>Grado</td>
            <td>Grupo</td>
            <td>Nivel</td>
          </tr>
        </table>
        <table id="tabla_alumnos" border="0" WIDTH="700">
          <tr>
            <td  WIDTH="40%">  <input
              name="nombre" id="nombre" type="text"
              class="form-control" placeholder="nombre"   readonly></td>
            <td>  <input
              name="grado" id="grado" type="text"
              class="form-control" placeholder="grado"   readonly></td>
            <td>  <input
              name="grupo" id="grupo" type="text"
              class="form-control" placeholder="grupo"   readonly></td>
            <td>  <input
              name="nivel" id="nivel" type="text"
              class="form-control" placeholder="nivel"   readonly></td>
          </tr>
        </table>

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="4">
              <h4>Datos de Permiso:</h4>
            </td>
          </tr>
          <tr>
            <td  WIDTH="75%" colspan="3">
              fecha de permiso:
              <input
              name="fechacambio" id="fechacambio" type="text"
              class="form-control" placeholder="Calle_numero1"   readonly>
            </td>
            <td  WIDTH="25%" colspan="1">
              Regresa:
              <input
              name="regresa" id="regresa" type="text"
              class="form-control" placeholder="regresa?"   readonly>
            </td>
          </tr>

          <tr>
            <td  WIDTH="50%" colspan="2">
              Hora de Salida:
              <input
              name="hora_salida" id="hora_salida" type="text"
              class="form-control" placeholder="hora_salida"   readonly>
            </td>
            <td  WIDTH="50%" colspan="2">
              Hora de Regreso:
              <input
              name="hora_regreso" id="hora_regreso" type="text"
              class="form-control" placeholder="hora_regreso" readonly>
            </td>
          </tr>
        </table>

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="4">
              <h4>Datos de Responsable:</h4>
            </td>
          </tr>
          <tr>
            <td  WIDTH="70%"  colspan="3">
              Responsable:
              <input
              name="responsable" id="responsable" type="text"
              class="form-control" placeholder="responsable"  readonly>
            </td>
            <td  WIDTH="30%"   colspan="1">
              Parentesco:
              <input
              name="parentesco" id="parentesco" type="text"
              class="form-control" placeholder="parentesco" readonly>
            </td>
          </tr>
        </table>


        Motivo de La solicitud:
        <textarea class="form-control"  id="comentarios" name="comentarios"  readonly></textarea>
        Comentarios de respuesta:
        <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
        <input name="funcion" id="funcion" type="text"
        class="form-control" value="0" required style="display: none;">
        <input name="idpermiso" id="idpermiso" type="text"
        class="form-control" value="0" required style="display: none;">
        <br>

        Fecha de Respuesta:
        <input name="frespuesta" id="frespuesta" type="text"
        class="form-control" placeholder="frespuesta" readonly>
        <br>
        Accion:
        <select name="estatus" id="estatus">
          <option value="0" >Selecciona</option>
          <option value="2" style="color:white;background-color:#0b1d3f;" >Autorizado</option>
          <option value="3" style="color:red;background-color:yellow;">Declinado</option>
        </select>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary" name="guardar"><b>GUARDAR</b></button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
