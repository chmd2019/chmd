<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();



$niveles = mysqli_query ( $conexion,"SELECT id,nivel from Catalogo_nivel");
$grados = mysqli_query($conexion,"SELECT distinct idcursar,grado from alumnoschmd order by idcursar desc");
$grupos = mysqli_query ( $conexion,"SELECT id,grupo from catalago_grupos_cch");
$gruposEsp = mysqli_query ( $conexion,"SELECT id,grupo from App_grupos_especiales");
$gruposAdmin = mysqli_query ( $conexion,"SELECT id,grupo from App_grupos_administrativos");


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
  <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
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
<h2 class="text-primary">Circulares</h2>

<div class="table-responsive">

<br>
   

    <!-- Aquí va el formulario -->

    <form method="post" action="common/guardarCircular.php">
	
    <p>
        <input name="titulo" id="titulo" placeholder="titulo de la circular" class="form-control" required>
    </p>
    <p>
        <input name="descripcion" id="descripcion" placeholder="descripci&oacute;n de la circular" class="form-control" required>
    </p>
    <p>
    Estatus
        <select name="cboEstatus" id="cboEstatus" class="form-control">
        <option value="Enviada">Enviada</option>
        <option value="Guardada">Guardada</option>
        <option value="Programada">Programada</option>
        </select>    
    </p>
    <p>
        Nivel
        <select name="cboNivel" id="cboNivel" class="form-control">
        <option value="0">N/A</option>
            <?
            while ($row = mysqli_fetch_array($niveles, MYSQLI_ASSOC)){
                echo "<option value=\"".$row['id']."\"";
                echo ">".$row['nivel']."</option>\n";
            }
            ?>
        </select>
    </p>
    <p>
        Grado
        <select name="cboGrado" id="cboGrado" class="form-control">
        <option value="0">N/A</option>
        <?
            while ($row = mysqli_fetch_array($grados, MYSQLI_ASSOC)){
                echo "<option value=\"".$row['idcursar']."\"";
                echo ">".$row['grado']."</option>\n";
            }
            ?>
        </select>
    </p>
    <p>
        Grupo
        <select name="cboGrupo" id="cboGrupo" class="form-control">
        <?
            while ($row = mysqli_fetch_array($grupos, MYSQLI_ASSOC)){
                echo "<option value=\"".$row['id']."\"";
                echo ">".$row['grupo']."</option>\n";
            }
            ?>
        </select>
    </p>
    <p>
   

        Grupo Especial
        <select name="cboGrupoEsp"  id="cboGrupoEsp" class="form-control">
        <option value="0">N/A</option>
        <?
            while ($row = mysqli_fetch_array($gruposEsp, MYSQLI_ASSOC)){
                echo "<option value=\"".$row['id']."\"";
                echo ">".$row['grupo']."</option>\n";
            }
            ?>
        </select>
    </p>	

    <p>
        Grupo Administrativo
        <select name="cboGrupoAdmin" id="cboGrupoAdmin" class="form-control">
            <option value="0">N/A</option>
        <?
            while ($row = mysqli_fetch_array($gruposAdmin, MYSQLI_ASSOC)){
                echo "<option value=\"".$row['id']."\"";
                echo ">".$row['grupo']."</option>\n";
            }
            ?>
        </select>
    </p>	


    <p>


    Adjunto
        <select name="cboAdjunto" id="cboAdjunto" class="form-control">
        <option value='1' selected>Sí</option>
        <option value='0'>No</option>"
        </select>
    </p>

    <p>
        Contenido de la circular
    <textarea name="contenido" id="contenido">
    
    </textarea>
    <script>
        CKEDITOR.replace( 'contenido' );
    </script>
    </p>
    <p>
        <input name="cicloEscolar" id="cicloEscolar" placeholder="Ciclo Escolar" class="form-control" required>
    </p>
    <p>
        Enviar a todos
    <select name="cboEnviar" id="cboEnviar" class="form-control">
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
    </p>
    <p>
        <input type="submit" class="btn btn-success btn-block" value="Guardar Circular">
    </p>	



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
