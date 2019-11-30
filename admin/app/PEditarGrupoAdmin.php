<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$id = $_GET["id"];
$sql = "SELECT * from App_grupos_administrativos WHERE id=$id";
$datos = mysqli_query ( $conexion,$sql);
$dato = mysqli_fetch_assoc ($datos);
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
  <title>CHMD :: App</title>
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
            <h3>APP</h3>
        </div>
          <?php $perfil_actual='40';
           include ("../menus_dinamicos/perfiles_dinamicos_app.php");
         ?>
    </nav>

    <!-- Page Content  -->
    <div id="content">
  <?php include_once "../components/navbar.php"; ?>
<div class="container-fluid">
  <div class="masthead">

</div>
<br>
<center><?php echo isset($_POST['guardar']) ? $verificar : '' ; ?></center>
<!-- Button trigger modal -->
<a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
<h2 class="text-primary">Modificar grupo administrativo</h2>

<div class="table-responsive">
<center>
<form method="POST" action="common/actualizarGrupoAdmin.php">

<table class="table table-striped" id="niveles_table">
<tr style="background:<?=$color?>; border-bottom: 1px solid <?=$borde?>"  data-row="<?php //echo $dato['id_permiso']?>">

<td>Nombre del grupo</td>
<td><input name="grupo" id="grupo" value="<?=$dato["grupo"]?>"></td>
</tr>
<tr>
<td>Descripci&oacute;n del grupo</td>
<td><input name="descrip" id="descrip" value="<?=$dato["descripcion"]?>"></td>
<td><input type="hidden" id="id" name="id"  value="<?=$dato["id"]?>"></td>
</tr>
<tr>
<td colspan="2"><input type="submit" class="btn btn-info" value="Actualizar"></td>
</tr>
</table>

</form>
</center>

</div>
</div>
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
  <script type="text/javascript" src="js/Ppadres.js"></script>
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
