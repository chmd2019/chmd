<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('15', $capacidades)){
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

$datos = mysqli_query ( $conexion,"SELECT  vp.id_permiso,vp.fecha_creacion,
  usu.correo,
  vp.comentarios,vp.estatus,vp.nfamilia,
  vp.mensaje,
  vp.responsable,
  vp.parentesco,
  vp.fecha_creacion,
  vp.fecha_cambio,
  vp.fecha_respuesta,
  vp.tipo_permiso,
  usu.familia,
  vp.tipo_evento,
  vp.codigo_invitacion,
  vp.empresa_transporte
  from  Ventana_Permisos vp
  LEFT JOIN usuarios usu on vp.idusuario=usu.id
where (vp.estatus=1 or vp.estatus=2)  and vp.tipo_permiso='5'  order by vp.estatus ASC" );
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
  <title>CHMD :: Eventos</title>
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
            <h3>EVENTOS</h3>
        </div>
        
                <?php $perfil_actual='25'; include ('../menus_dinamicos/perfiles_dinamicos_eventos.php'); ?>
      
    </nav>
<!-- Page Content  -->
    <div id="content">
  <?php include_once "../components/navbar.php"; ?>
  <div class="reload">
  </div>
<div class="container-fluid" id='principal'>
  <div class="masthead">
<!--Importante agregar el nivel para el correcto funcionamiento-->
<input id="nivel_perfil" type="text"  name="" value="1" hidden>
</div>
<br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->
<a href="alta_eventos.php" style="cursor: pointer; margin:2px" class="pull-right"><svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
          <style type="text/css">
            .sty0{fill:#6DC1EC;}
            .sty1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
            .sty2{fill:#0E497B;}
          </style>
          <g>
            <path class="sty0" d="M556.96,190.97H43.04c-16.68,0-30.33-13.65-30.33-30.33V48.9c0-16.68,13.65-30.33,30.33-30.33h513.92
              c16.68,0,30.33,13.65,30.33,30.33v111.74C587.29,177.33,573.64,190.97,556.96,190.97z"/>
            <g>
              <path class="sty1" d="M222.6,76.48c0-3.07,2.44-5.6,5.6-5.6h1.17c2.71,0,4.24,1.35,5.78,3.25l31.6,40.9V76.21
                c0-2.98,2.44-5.42,5.42-5.42c3.07,0,5.51,2.44,5.51,5.42v53.09c0,3.07-2.35,5.51-5.42,5.51h-0.45c-2.62,0-4.24-1.35-5.78-3.34
                l-32.5-42.07v40.09c0,2.98-2.44,5.42-5.42,5.42c-3.07,0-5.51-2.44-5.51-5.42V76.48z"/>
              <path class="sty1" d="M288.41,107.63V76.3c0-3.07,2.44-5.51,5.6-5.51c3.07,0,5.51,2.44,5.51,5.51v30.88
                c0,11.74,6.05,17.97,15.98,17.97c9.84,0,15.89-5.87,15.89-17.52V76.3c0-3.07,2.44-5.51,5.6-5.51c3.07,0,5.51,2.44,5.51,5.51v30.79
                c0,18.87-10.65,28.35-27.18,28.35C298.89,135.43,288.41,125.95,288.41,107.63z"/>
              <path class="sty1" d="M353.24,128.84v-52c0-3.16,2.44-5.6,5.6-5.6h36.75c2.71,0,4.97,2.26,4.97,4.97c0,2.8-2.26,4.97-4.97,4.97
                h-31.24V97.6h27.18c2.71,0,4.97,2.26,4.97,5.06c0,2.71-2.26,4.88-4.97,4.88h-27.18v16.97h31.69c2.71,0,4.96,2.26,4.96,4.97
                c0,2.8-2.26,4.97-4.96,4.97h-37.2C355.68,134.44,353.24,132,353.24,128.84z"/>
              <path class="sty1" d="M427.54,130.83l-22.12-52c-0.36-0.81-0.63-1.62-0.63-2.62c0-2.98,2.44-5.42,5.6-5.42
                c2.89,0,4.79,1.62,5.69,3.97l18.24,45.59l18.51-45.96c0.72-1.9,2.71-3.61,5.33-3.61c3.07,0,5.51,2.35,5.51,5.33
                c0,0.81-0.27,1.72-0.54,2.35l-22.21,52.37c-1.17,2.8-3.25,4.51-6.41,4.51h-0.63C430.79,135.34,428.72,133.63,427.54,130.83z"/>
              <path class="sty1" d="M468.08,103.02v-0.18c0-17.79,13.72-32.68,33.13-32.68s32.95,14.72,32.95,32.5v0.18
                c0,17.79-13.72,32.68-33.13,32.68C481.62,135.52,468.08,120.81,468.08,103.02z M522.52,103.02v-0.18
                c0-12.28-8.94-22.48-21.49-22.48s-21.31,10.02-21.31,22.3v0.18c0,12.28,8.94,22.39,21.49,22.39S522.52,115.3,522.52,103.02z"/>
            </g>
            <g>
              <path class="sty2" d="M143.72,97.4h-21.55V75.85c0-4.03-3.34-7.37-7.37-7.37c-4.03,0-7.37,3.34-7.37,7.37V97.4H85.88
                c-4.03,0-7.37,3.34-7.37,7.37c0,2.09,0.83,3.89,2.09,5.14c1.39,1.39,3.2,2.09,5.14,2.09h21.55v21.55c0,2.09,0.83,3.89,2.09,5.14
                c1.39,1.39,3.2,2.09,5.14,2.09c4.03,0,7.37-3.34,7.37-7.37v-21.27h21.55c4.03,0,7.37-3.34,7.37-7.37
                C150.95,100.74,147.75,97.4,143.72,97.4z"/>
              <path class="sty2" d="M114.8,38.73c-36.43,0-66.04,29.62-66.04,66.04s29.62,66.04,66.04,66.04s66.04-29.62,66.04-66.04
                S151.23,38.73,114.8,38.73z M114.8,156.08c-28.36,0-51.31-22.94-51.31-51.31s22.94-51.31,51.31-51.31s51.31,22.94,51.31,51.31
                S143.16,156.08,114.8,156.08z"/>
            </g>
          </g>
          </svg></a>
<a href="inscripcion_eventos.php" style="margin:5px;"  tooltips="" class="btn btn-primary btn-default pull-right btn-nuevo"><b><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;INSCRIBIR</b></a>

<a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
<h2 class="text-primary">Solicitudes de Eventos</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
<div class="table-responsive">
<table class="table" id="niveles_table">
  <thead>
    <td><b>Codigo</b></td>
    <td><b>Nfamilia</b></td>
    <td><b>Fecha de Solicitud</b></td>
    <td class="text-center"><b>Procesados</b></td>
    <td><b>Estatus</b></td>
    <td><b>Tipo de Evento</b></td>
    <td><b>Familia Anfitriona</b></td>
    <td><b>Acciones</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_permiso= $dato['id_permiso'];
      $nfamilia= $dato['nfamilia'];

      $responsable= $dato['responsable'];
      $parentesco=$dato['parentesco'];
      $familia  =   $dato['familia'];
      $tipo_evento = $dato['tipo_evento'];
      $codigo_invitacion=$dato['codigo_invitacion'];
      $empresa_transporte=$dato['empresa_transporte'];
      if (empty($empresa_transporte)){
        $empresa_transporte ='  -   ';
      }

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

      $fecha_actual = strtotime(date("d-m-Y",time()));
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


      $anio= $array2[5] % 100;
      $_fecha_cambio= $mes.'/'.$dia.'/'.$anio . ' 23:00:00';
      $fecha_entrada = strtotime ($_fecha_cambio);
      if ($fecha_entrada>=$fecha_actual) {$show=1;} else{ $show=0;}
        
  if ($show){

    $id_nivel='1';
    $alumnos_totales=0;
    $alumnos_procesados=0;
    //saber cuantos alumnos hay en Listas
    $sql ="SELECT COUNT(*) FROM Ventana_permisos_alumnos vpa INNER JOIN alumnoschmd ac ON ac.id=vpa.id_alumno and ac.id_nivel = '$id_nivel'  WHERE vpa.id_permiso ='$id_permiso' ";
    $query = mysqli_query($conexion, $sql) ;
    if ($r = mysqli_fetch_array($query) ){
      $alumnos_totales = $r[0];
    }
    //saber cuantos alumnos hay procesados
    $sql ="SELECT COUNT(*) FROM Ventana_permisos_alumnos vpa INNER JOIN alumnoschmd ac ON ac.id=vpa.id_alumno and ac.id_nivel = '$id_nivel'  WHERE vpa.id_permiso ='$id_permiso'  and vpa.estatus >'1'";
    $query = mysqli_query($conexion, $sql) ;
    if ($r = mysqli_fetch_array($query) ){
      $alumnos_procesados = $r[0];
    }
    //colocar en Verde
    $green=false;
    if ($alumnos_totales - $alumnos_procesados == '0') $green=true;
    ?>
    <tr class="fila_alumnos" id="fila_<?=$id_permiso?>"  style="border-bottom:  1px solid #eee; display:  none;"  data-row="<?php echo $dato['id_permiso']?>" >
      <td ><?php echo $codigo_invitacion?></td>
      <td ><?php echo $nfamilia?></td>
      <td><?php echo $fecha_creacion?></td>
      <td class="text-center <?php if ($green) echo 'text-success';?>"><?php echo "$alumnos_procesados/<b>$alumnos_totales</b>"?></td>
      <td><?php echo $staus1?></td>
      <td><?php echo $tipo_evento?></td>
      <td><?php echo $familia?></td>

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
    data-id="<?php echo $id_permiso?>"
    data-nfamilia="<?php echo $nfamilia?>"

    data-fecha="<?php echo $fecha_creacion?>"
    data-correo="<?php echo $correo?>"

    data-codigo="<?php echo $codigo_invitacion?>"
    data-familia="<?php echo $familia?>"
    data-fechaevento="<?php echo $fecha_cambio?>"
    data-tipoevento="<?php echo $tipo_evento?>"
    data-empresa="<?php echo $empresa_transporte?>"

    data-comentarios="<?php echo $motivo?>"
    data-mensaje="<?php echo $mensaje?>"

    data-responsable="<?php echo $responsable?>"
    data-parentesco="<?php echo $parentesco?>"

    data-nivelpermiso="1"
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
<?php }
}
?>

</tbody>
</table>
</div>
</div>
  <!-- Site footer -->
      <?php include_once "../components/footer.php"; ?>
    </div>
    <div class="overlay"></div>
  </div>

<!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script type="text/javascript" src="js/PeventosArea.js"></script>
  <script type="text/javascript" src="../js/1min_inactivo.js" ></script>

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
<div class="modal" id="agregarNivel" tabindex="-1" role="dialog"
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

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="4">
              <h4>Datos del Evento:</h4>
            </td>
          </tr>
          <tr>
            <td  WIDTH="70%" colspan="3">
              Fecha del Evento:
              <input
              name="fechaevento" id="fechaevento" type="text"
              class="form-control" placeholder="fechaevento"   readonly>
            </td>
            <td  WIDTH="30%" colspan="1">
              Codigo de Invitacion:
              <input
              name="codigo" id="codigo" type="text"
              class="form-control" placeholder="codigo"   readonly>
            </td>

          </tr>

          <tr>
            <td  WIDTH="30%" colspan="1">
              Tipo de Evento:
              <input
              name="tipoevento" id="tipoevento" type="text"
              class="form-control" placeholder="tipoevento"   readonly>
            </td>
            <td  WIDTH="40%" colspan="2">
              Familia Anfitriona:
              <input
              name="familia" id="familia" type="text"
              class="form-control" placeholder="familia" readonly>
            </td>
            <td  WIDTH="30%" colspan="1">
                Empresa de Transporte
                <input
                name="empresa" id="empresa" type="text"
                class="form-control" placeholder="empresa" readonly>
              </td>
          </tr>


        </table>
        <table>
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Alumnos enlistados al Evento:</h4>
            </td>
          </tr>

        </table>
        <table  border="0" WIDTH="700">
          <tr>
            <td  WIDTH="40%" colspan="3">Alumno</td>
            <td  WIDTH="45%" colspan="4">Grado - Grupo - Nivel</td>
            <td  WIDTH="15%" colspan="3">Acciones</td>
          </tr>
        </table>

        <table id="tabla_alumnos" border="0" WIDTH="700">
          <!-------------------------- Tabla de  Alumnos ----------------------------------------------->
        </table>
        <hr>
        <table>
          <tr >
            <td  WIDTH="40%">Acciones de Todos los Alumnos: </td>
            <td class="text-center" WIDTH="60%">
              <button class = "btn btn-success glyphicon glyphicon-ok"  onclick="accion_todos( 2 , <?=$id_nivel?>)" type="button" > Autorizar Todos</button>
              <button class="btn btn-danger glyphicon glyphicon-remove" onclick="accion_todos(3,  <?=$id_nivel?>)" type="button"> Declinar Todos</button>
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
        <!--  <option value="0" >Selecciona</option> -->
          <option value="2" style="color:white;background-color:#0b1d3f;" selected>Autorizado</option>
        <!--  <option value="3" style="color:red;background-color:yellow;">Declinado</option> -->
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
