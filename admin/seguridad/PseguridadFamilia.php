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

if (!isset($_GET['nfamilia'],$_GET['id_responsable'] )){
  header('Location: PseguridadPadres.php');
  exit();
}

$nfamila  =  $_GET['nfamilia'];
$responsable_seleted = $_GET['id_responsable'];

$sql="SELECT id, idfamilia, nombre, id_nivel, foto, nivel  FROM alumnoschmd WHERE idfamilia='$nfamila'  order by id_nivel;";
$datos = mysqli_query ( $conexion,$sql );
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
  <title>CHMD :: Seguridad</title>
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
        
      <?php $perfil_actual='22'; include ('../menus_dinamicos/perfiles_dinamicos_seguridad.php'); ?>
    
    </nav>

    <!-- Page Content  -->
    <div id="content">
  <?php include_once "../components/navbar.php"; ?>
  <div class="reload">
  </div>
<div class="container" id='principal'>
  <div class="masthead" style="padding-top:10px ">

    <a class="pull-right" href="./PseguridadPadres.php">  <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
             <style type="text/css">
               .stq0{fill:#6DC1EC;}
               .stq1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
               .stq2{fill-rule:evenodd;clip-rule:evenodd;fill:#0E497B;}
             </style>
             <path class="stq0" d="M559.25,192.49H45.33c-16.68,0-30.33-13.65-30.33-30.33V50.42c0-16.68,13.65-30.33,30.33-30.33h513.92
               c16.68,0,30.33,13.65,30.33,30.33v111.74C589.58,178.84,575.93,192.49,559.25,192.49z"/>
             <g>
               <path class="stq1" d="M228.72,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
                 c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
                 c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C228,130.45,228.27,129.64,228.72,128.74z M270.07,110.86l-11.11-25.55
                 l-11.1,25.55H270.07z"/>
               <path class="stq1" d="M313.14,83.05h-15.35c-2.89,0-5.15-2.35-5.15-5.15s2.26-5.15,5.15-5.15h41.98c2.8,0,5.06,2.35,5.06,5.15
                 s-2.26,5.15-5.06,5.15h-15.44v47.85c0,3.07-2.53,5.51-5.6,5.51c-3.07,0-5.6-2.44-5.6-5.51V83.05z"/>
               <path class="stq1" d="M351.6,78.36c0-3.16,2.44-5.6,5.6-5.6h22.57c7.95,0,14.17,2.35,18.24,6.32c3.34,3.43,5.24,8.12,5.24,13.63
                 v0.18c0,10.11-5.87,16.25-14.36,18.87l12.1,15.26c1.08,1.35,1.81,2.53,1.81,4.24c0,3.07-2.62,5.15-5.33,5.15
                 c-2.53,0-4.15-1.17-5.42-2.89l-15.35-19.59h-13.99v16.97c0,3.07-2.44,5.51-5.51,5.51c-3.16,0-5.6-2.44-5.6-5.51V78.36z
                  M378.96,104.09c7.95,0,13-4.15,13-10.56v-0.18c0-6.77-4.88-10.47-13.09-10.47h-16.16v21.22H378.96z"/>
               <path class="stq1" d="M408.75,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
                 c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
                 c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C408.03,130.45,408.3,129.64,408.75,128.74z M450.1,110.86L439,85.31
                 l-11.1,25.55H450.1z M436.02,65.18c0-0.63,0.36-1.44,0.72-1.99l5.15-7.95c0.99-1.62,2.44-2.62,4.33-2.62c2.89,0,6.5,1.81,6.5,3.52
                 c0,0.99-0.63,1.9-1.53,2.71l-6.05,5.78c-2.17,1.99-3.88,2.44-6.41,2.44C437.19,67.07,436.02,66.35,436.02,65.18z"/>
               <path class="stq1" d="M476.01,128.92c-1.26-0.9-2.17-2.44-2.17-4.24c0-2.89,2.35-5.15,5.24-5.15c1.54,0,2.53,0.45,3.25,0.99
                 c5.24,4.15,10.83,6.5,17.7,6.5c6.86,0,11.2-3.25,11.2-7.95v-0.18c0-4.51-2.53-6.95-14.26-9.66c-13.45-3.25-21.04-7.22-21.04-18.87
                 v-0.18c0-10.83,9.03-18.33,21.58-18.33c7.95,0,14.36,2.08,20.04,5.87c1.26,0.72,2.44,2.26,2.44,4.42c0,2.89-2.35,5.15-5.24,5.15
                 c-1.08,0-1.99-0.27-2.89-0.81c-4.88-3.16-9.57-4.79-14.54-4.79c-6.5,0-10.29,3.34-10.29,7.49v0.18c0,4.88,2.89,7.04,15.08,9.93
                 c13.36,3.25,20.22,8.04,20.22,18.51v0.18c0,11.83-9.3,18.87-22.57,18.87C491.18,136.86,483.05,134.15,476.01,128.92z"/>
             </g>
             <g>
               <path class="stq2" d="M81.84,94.54h97.68c14.9,0,14.9,23.73,0,23.73H81.84l26.49,27.04c11.04,11.04-5.52,27.59-16.56,16.56
                 l-47.46-46.91c-4.41-4.97-4.41-12.69,0-17.11l47.46-46.91c11.04-11.59,27.59,5.52,16.56,16.56L81.84,94.54z"/>
             </g>
             </svg></a>
</div>
<br>
<center><?php echo isset($_POST['guardar']) ? $verificar:''; ?></center>
<!-- Button trigger modal -->
<h2 class="text-primary">Control de Salidas de la familia: <b><?=$nfamila?></b> </h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> 
<br>
 <div class="table-responsive-lg">
<table class="table" id="niveles_table">
  <thead>
    <td><b>Idusuario</b></td>
    <td><b>Nombre</b></td>
    <td><b>Nivel</b></td>
    <td><b>Fotografia</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_usuario= $dato['id'];
      $nfamilia= $dato['idfamilia'];
      $nombre_alumno= $dato['nombre'];
      $foto= $dato['foto'];
      $id_nivel= $dato['id_nivel'];
      $nivel=$dato['nivel'];
      //fotografia
      $foto = str_replace("C:\IDCARDDESIGN\CREDENCIALES\alumnos\\", '', $foto);
      $foto="$root_imagenes/CREDENCIALES/alumnos/$foto";

      $foto1="Con Foto";
      if($foto==null || is_file($foto)){
        $foto="sinfoto.png";
        $foto1="Sin foto";
      }
      ?>
      <tr class="fila_alumnos" id="<?=$id_usuario?>">
        <td ><?php echo $id_usuario ?></td>
        <td><?php echo $nombre_alumno?></td>
        <td><?php echo $nivel?></td>
        <td id="img_<?=$id_usuario?>" onclick="registrar_salida(<?=$id_usuario?>,<?=$responsable_seleted?>)">
            <img style="border: 1px solid #aaa; padding: 2px" src='<?php echo $foto ?>' alt="<?=$foto1?>" width="150px">
            <div>
          </div>
          <span class=""></span>
        </td>
  </tr>
<?php }?>
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

  <script type="text/javascript" src="js/PseguridadFamilia.js"></script>
  <!--<script type="text/javascript" src="../js/1min_inactivo.js" ></script>-->
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
