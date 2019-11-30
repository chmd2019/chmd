<?php
include '../sesion_admin.php';
include '../conexion.php';
if (!in_array('32', $capacidades)){
    header('Location: ../menu.php');
}
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$fecha = date('Y-m-d');
$datos = mysqli_query ( $conexion,"SELECT rh.id_ruta_h as id_ruta, rh.nombre_ruta, rh.camion, rh.cupos, u.nombre as auxiliar FROM rutas_historica rh LEFT JOIN usuarios u ON u.id=rh.auxiliar  WHERE rh.fecha = '$fecha' and rh.camion>0" );
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
  <title>CHMD :: Rutas del Día</title>
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
          <?php $perfil_actual='50'; include ('../menus_dinamicos/perfiles_dinamicos_rutas.php'); ?>
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
<button type="button" style="cursor: pointer; margin:5px;outline: none" class="btn btn-primary btn-default pull-right" onclick="deamon_rutas_generales()">
  <b><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;SALIDA GENERAL</b>
</button>
<!-- Button trigger modal -->
<button type="button" style="cursor: pointer; margin:5px;outline: none" class="btn btn-primary btn-default pull-right" onclick="deamon_rutas()">
<b><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;ACTUALIZAR</b>
</button>
<!-- <a href="alta_rutas.php" style="cursor: pointer; margin:2px" class="pull-right">
<span class="glyphicon glyphicon-update"></span> ACTUALIZAR
</a> -->
<a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
<h2 class="text-primary">Listado de Rutas del  Día</h2>
<!-- <input type="text" class="form-control filter"
placeholder="Buscar Solicitud...">
<br>
-->
<br>
<div class="table-responsive-lg">
  <table class="table" id="niveles_table">
    <thead>
    <td><b>Ruta</b></td>
    <td><b>Prefecto(a)</b></td>
    <td><b>Camión</b></td>
    <td><b>Cupos(Mañana/Total)</b></td>
    <td><b>Cupos(Tarde/Total)</b></td>
    <td><b>Estatus</b></td>
    <td class="text-center"><b>Acciones</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_ruta= $dato['id_ruta'];
      $nombre_ruta= $dato ['nombre_ruta'];
      $auxiliar= $dato['auxiliar'];
      $camion= $dato['camion'];
      $cupos= $dato['cupos'];
      $fecha = date('Y-m-d');
      //numero de cupos Disponibles
      $sql = "SELECT COUNT(*) FROM rutas_historica_alumnos WHERE id_ruta_h=$id_ruta and fecha='$fecha';";
      $query = mysqli_query($conexion, $sql);
      while($r = mysqli_fetch_array($query) ){
        $cupos_disponibles = $r[0];
      }
      //numero de cupos Disponibles - Tarde
      $sql = "SELECT COUNT(*) FROM rutas_historica_alumnos WHERE id_ruta_h_s=$id_ruta and fecha='$fecha';";
      $query = mysqli_query($conexion, $sql);
      while($r = mysqli_fetch_array($query) ){
        $cupos_disponibles_s = $r[0];
      }
      //numero de alumnos por revisar  - mañana
      $por_revisar_m=0;
      $sql = "SELECT COUNT(*) FROM rutas_historica_alumnos WHERE id_ruta_h=$id_ruta and orden_in>900 and fecha='$fecha';";
      $query = mysqli_query($conexion, $sql);
      while($r = mysqli_fetch_array($query) ){
        $por_revisar_m = $r[0];
      }

    //numero de alumnos por revisar - Tarde
      $por_revisar_t=0;
      $sql = "SELECT COUNT(*) FROM rutas_historica_alumnos WHERE id_ruta_h_s=$id_ruta and orden_out>900 and fecha='$fecha';";
      $query = mysqli_query($conexion, $sql);
      while($r = mysqli_fetch_array($query) ){
        $por_revisar_t = $r[0];
      }

      ?>
      <tr class="fila_alumnos" id="fila_<?=$id_ruta?>" >
        <td><?php echo $nombre_ruta?></td>
        <td><?php echo $auxiliar?></td>
        <td><?php
          if ($camion>900){
            echo '';
          } else{
            if ($camion<=9) echo '0'.$camion ; else echo $camion;
          }

          ?>
        </td>
        <td ><?php echo $cupos_disponibles.'/'.$cupos?></td>
        <td ><?php echo $cupos_disponibles_s.'/'.$cupos?></td>
        <td class="text-center">
          <?php if ($cupos_disponibles > $cupos || $por_revisar_m>0  || $por_revisar_t>0){
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
      data-id="<?php echo $id_ruta?>"
      data-fecha ="<?=$fecha?>"
      >
      <?php include 'componentes/btn_ver.php'; ?>
    </a>
</td>
</tr>
<?php } ?>
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
  <script type="text/javascript" src="js/Prutas_diaria.js"></script>
  <!-- <script type="text/javascript" src="../js/1min_inactivo.js" ></script> -->
</body>
</html>
