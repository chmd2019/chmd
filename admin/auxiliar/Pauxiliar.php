<?php
include '../sesion_admin.php';
include '../conexion.php';

$root_imagenes=' http://chmd.chmd.edu.mx:65083';

if (!in_array('34', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$fecha = date('Y-m-d');
$year=date('Y');
$mes=date('m');
$dia = date('d');
$mes_letras = $arrayMeses[(int)$mes - 1];

//id ruta asignado
$id_ruta = 1;
$sql="SELECT rha.*,  ac.grupo,  ac.grado,  ac.nivel,  ac.foto, ac.nombre FROM rutas_historica_alumnos rha INNER JOIN alumnoschmd ac on ac.id = rha.id_alumno WHERE rha.fecha='$fecha' and id_ruta_h='$id_ruta'";

$datos = mysqli_query ( $conexion, $sql );
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
            <h3>Ruta: SANTA ROSA</h3>
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
<h2 class="text-center text-primary">Ruta: SANTA ROSA</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br>
 <br>
 <div class="table-responsive-lg">
<table class="table" id="niveles_table" width="100%">
  <thead>
    <td><b>Orden</b></td>
    <td><b>Domicilio</b></td>
    <!-- <td><b>Estatus</b></td> -->
    <!-- <td><b>Turno</b></td> -->
    <td><b>Alumno</b></td>
    <td style="text-align:center"><b>Fotografía</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_alumno= $dato['id_alumno'];
      $orden= $dato['orden_in'];
      $domicilio= $dato['domicilio'];
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

      // if($estatus==1){$staus1="Pendiente";}
      // if($estatus==2){$staus1="Autorizado";}
      // if($estatus==3){$staus1="Declinado";}
      // if($estatus==4){$staus1="Cancelado por el usuario";}
      $color = '#fff';
      $borde = '';

      $show=true;
       if ($show){

      ?>
      <tr class="fila_alumnos" id="<?=$id_alumno?>"  style="background:<?=$color?>; border-bottom:  1px solid <?=$borde?>" >
        <td ><?php echo $orden?></td>
        <td ><?php echo $domicilio?></td>
        <td><?php echo $nombre_alumno?></td>
        <td style="text-align:center" >
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
