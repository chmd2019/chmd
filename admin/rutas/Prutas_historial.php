<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('26', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$datos = mysqli_query ( $conexion,"SELECT  ra.id_alumno, ra.id_ruta_h as id_ruta_base, rh.nombre_ruta, a.nombre, rh.prefecta, rh.camion, ra.domicilio, ra.fecha FROM rutas_historica_alumnos ra 
  INNER JOIN rutas_historica rh ON rh.id_ruta_h  = ra.id_ruta_h and rh.fecha=ra.fecha  
  INNER JOIN alumnoschmd a ON a.id  = ra.id_alumno  
  ORDER BY ra.fecha;" );
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
          <?php $perfil_actual='51'; include ('../menus_dinamicos/perfiles_dinamicos_rutas.php'); ?>
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
<a href="Prutas_diaria.php" style="cursor: pointer;margin: 2px" class="pull-right">
<!-- Boton de Atras -->
<?php include 'componentes/btn_atras.php'; ?>
</a>
<h2 class="text-primary">Historial de Rutas</h2>
<!-- <input type="date" class="form-control filter" placeholder="Buscar Solicitud..."><br> -->
<br>
<div class="table-responsive-lg">
  <table class="table" id="niveles_table">
    <thead>
    <th>Alumno</th>
    <th>Domicilio</th>
    <th>Ruta</th>
    <th>Prefecto(a)</th>
    <th>Camión</th>
    <th>Fecha</th>
    <!-- <th class="text-center">Acciones</th> -->
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_ruta= $dato['id_ruta_base'];
      $id_alumno = $dato ['id_alumno'];
      $nombre = $dato ['nombre'];
      $domicilio  = $dato['domicilio'];
      $nombre_ruta= $dato ['nombre_ruta'];
      $prefecta= $dato['prefecta'];
      $camion= $dato['camion'];
      $fecha = date('d/m/Y', strtotime($dato['fecha']));  
      // $cupos= $dato['cupos'];
      $fecha_actual = date('Y-m-d');

      //numero de cupos Disponibles
      // $sql = "SELECT COUNT(*) FROM rutas_historica WHERE id_ruta_base=$id_ruta and fecha<$fecha";
      // $query = mysqli_query($conexion, $sql);
      // while($r = mysqli_fetch_array($query) ){
      //   $cupos_disponibles = $r[0];
      // }
      ?>
      <tr class="fila_alumnos" id="fila_<?=$id_ruta?>" >
        <td><?php echo $nombre?></td>
        <td><?php echo $domicilio?></td>
        <td><?php echo $nombre_ruta?></td>
        <td><?php echo $prefecta?></td>
        <td><?php
        if ($camion<=9) echo '0'.$camion ; else echo $camion;?></td>
        <td><?php echo $fecha?></td>
<!--         <td class="text-center">
      <a data-target="#agregarNivel" data-toggle="modal"
      class="btn-editar" type="button"
      data-id="<?php echo $id_ruta?>">
      <?php include 'componentes/btn_ver.php'; ?>
    </a>
</td> -->
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
              "order": [[ 5, "desc" ]],
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
  <script type="text/javascript" src="js/Prutas.js"></script>
  <script type="text/javascript" src="../js/1min_inactivo.js" ></script>
</body>
</html>
