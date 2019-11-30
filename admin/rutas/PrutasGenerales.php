<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('32', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$fecha_salida_general = '';
$show_vencido = false;
$sql = "SELECT fecha_programada FROM rutas_generales_alumnos LIMIT 1";
$query = mysqli_query($conexion , $sql);
if ($r = mysqli_fetch_array($query) ){
  $fecha_salida_general =  $r['fecha_programada'];
}
if ($fecha_salida_general != ''){
  //normalizo la fecha
    $array1 = explode(',' , $fecha_salida_general ); $array2= explode(' ',$array1[1]);
    $dia= $array2[1]; $mes= '';
    $_mes= strtolower($array2[2]);
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
      $anio = $array2[3] % 100;
      // fechas normalizadas

      $_fecha_today = strtotime(date('d-m-Y', time()));
      $_fecha_programada = strtotime( $mes. '/' .$dia. '/'.$anio);

      // $comparacion = 'hoy: '. $_fecha_today .', Programada: '.$_fecha_programada. ' - '. $fecha_salida_general;
  	  if ($_fecha_today > $_fecha_programada){
        $show_vencido = true;
      }
}

$datos = mysqli_query ( $conexion,"SELECT  r.*, u.nombre FROM rutas r LEFT JOIN usuarios u ON u.id=r.auxiliar WHERE r.tipo_ruta = '1'
order by r.camion;" );
//validar que existen rutas de pase de año
$sql ="SELECT COUNT(*) FROM rutas_generales_alumnos;";
$query = mysqli_query($conexion, $sql);
if ($r= mysqli_fetch_array($query)) $n = $r[0];
if ($n>0){
  $show_lista=true;
}else{
  $show_lista=false;
}
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
  <title>CHMD :: Rutas Generales</title>
  <link href="../dist/css/bootstrap.css" rel="stylesheet">
  <link href="../css/menu.css" rel="stylesheet">
  <!-- Dependencias Globales -->
  <?php include '../components/header.php'; ?>
  <style>
    .tag{
        padding: 10px;
        border-radius: 20px;
        width: 125px;
        display: block;
        margin: auto;
      }
    .tag-aprobado{
      background-color: #77AF65;
      color: white;
      }
    .tag-revisar{
          background-color: #EF4545;
          color: white;
      }
  </style>
</head>
<body>
   <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>RUTAS</h3>
        </div>
          <?php $perfil_actual='53'; include ('../menus_dinamicos/perfiles_dinamicos_rutas.php'); ?>
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
<a href="nueva_salida_general.php" style="cursor: pointer; margin:2px" class="pull-right"><svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
          <!-- Button trigger reset -->
          <button type="button" style="cursor: pointer; margin:5px;outline: none" class="btn btn-primary btn-default pull-right" onclick="reset()">
            <b><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;RESET</b>
          </button>
          <!-- Boton de Atras -->
          <a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
            <?php include 'componentes/btn_atras.php'; ?>
          </a>

<h2 class="text-primary">Listado de Rutas Generales</h2>
<!-- <input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> -->

  <table border="0" WIDTH="100%" >
    <tr class="row">
      Fecha de Proxima Salida General Programada <?php if($show_vencido){ ?> <span class="text-danger">(Vencida)</span><?php }  ?>:
      <input value="<?=$fecha_salida_general?>" class="form-control" size="15" id="fecha_salida_general" name="fecha_salida_general" placeholder="Seleccione la fecha de Salida General" type="text" disabled required/>
    </tr>
  </table>
<br>
<div class="table-responsive-lg">
  <table class="table" id="niveles_table">
    <thead>
      <tr>
        <td><b>Ruta</b></td>
        <td><b>Auxiliar</b></td>
        <td><b>Tipo ruta</b></td>
        <td><b>Camión</b></td>
        <td><b>Cupos(General/Total)</b></td>
        <td><b>Estatus</b></td>
        <td class="text-center"><b>Acciones</b></td>
      </tr>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php
    if ($show_lista){
        //Existen rutas Generales
        while ( $dato = mysqli_fetch_assoc ( $datos ) )
        {
          $id_ruta= $dato['id_ruta'];
          $nombre_ruta= $dato ['nombre_ruta'];
          $auxiliar = $dato['nombre'];
          $tipo_ruta = $dato['tipo_ruta'];
          $camion= $dato['camion'];
          $cupos= $dato['cupos'];

          if ($tipo_ruta==1) $tipo_ruta='GENERAL';
          else if ($tipo_ruta==2) $tipo_ruta ='KINDER';
          else $tipo_ruta = '-';

          //numero de alumnos por revisar  - mañana
          $por_revisar_m=0;
          $sql = "SELECT COUNT(*) FROM rutas_generales_alumnos WHERE id_ruta_general='$id_ruta' and (isnull(orden) or isnull(hora_regreso));";
          $query = mysqli_query($conexion, $sql);
          while($r = mysqli_fetch_array($query) ){
            $por_revisar_m = $r[0];
          }

          //numero de cupos Disponibles - Tarde
          $sql = "SELECT COUNT(*) FROM rutas_generales_alumnos WHERE id_ruta_general=$id_ruta";
          $query = mysqli_query($conexion, $sql);
          while($r = mysqli_fetch_array($query) ){
            $cupos_disponibles_t = $r[0];
          }
          // $show = false;
          // if ( $cupos_disponibles_t > 0 ) $show = true;
          // if ( $camion < 1 ) $show = false;
          $show=true;
          if($show){
            ?>
            <tr class="fila_alumnos" id="fila_<?=$id_ruta?>">
              <td><?php echo $nombre_ruta?></td>
              <td><?php echo $tipo_ruta?></td>
              <td><?php echo $auxiliar?></td>
              <td><?php
              if ($camion<=9) echo '0'.$camion ; else echo $camion;?></td>
              <td ><?php echo $cupos_disponibles_t.'/'.$cupos?></td>
              <td class="text-center">
                <?php if ($por_revisar_m>0 ){
                  ?>
                  <span class="tag tag-revisar" >REVISAR</span>
                  <?php
                }else{
                  ?>
                  <span class="tag tag-aprobado" >AUTORIZADO</span>
                  <?php
                }?>
              </td>
              <td class="text-center">
                <a data-target="#agregarNivel" data-toggle="modal"
                class="btn-editar" type="button"
                data-id="<?php echo $id_ruta?>">
                <?php include 'componentes/btn_ver.php'; ?>
              </a>
            </td>
          </tr>
          <?php
        }
      }
    }
       ?>
</tbody>
</table>
</div>
</div>
 <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
</div>
    <div class="overlay"></div>
  </div>

<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
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
      // agregar paginacion
          $('#niveles_table').DataTable( {
              "order": [[ 2, "asc" ]],
              paging:true,
              ordering:  true,
              searching:true,
              language: {
                  search: "Buscar:",
                  lengthMenu: "Se muestran _MENU_ registros por pagina",
                  zeroRecords: "No hay registros",
                  info: "Mostrando _PAGE_ de _PAGES_",
                  infoEmpty: "No hay registros",
                    paginate: {
                          first:      "Primero",
                          previous:   "Anterior",
                          next:       "Proximo",
                          last:       "Ultimo"
                                },
                  infoFiltered: "(filtrados de _MAX_ total de registros)"

              }
          } );
  });
</script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="js/PrutasGenerales.js"></script>
  <!-- <script type="text/javascript" src="../js/1min_inactivo.js" ></script> -->
</body>
</html>
