<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$idAlumno = $_GET["idAlumno"];
$gruposEsp = mysqli_query ( $conexion,"SELECT id,grupo from App_grupos_especiales");
$sql = "SELECT * from alumnoschmd WHERE id=$idAlumno";
$datos = mysqli_query ( $conexion,$sql);

$alumnosAsociados = mysqli_query($conexion,"SELECT * FROM vwAlumnosGruposEspeciales WHERE alumno_id=$idAlumno");


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
          <?php $perfil_actual='39';
           include ("../menus_dinamicos/perfiles_dinamicos_app.php");
         ?>
    </nav>
    </div>
    

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


<h2 class="text-primary">Asociar Alumnos</h2>


<div class="table-responsive">
<table class="table" id="niveles_table">
  <thead>
    <td><b>Id</b></td>
    <td><b>Nombre</b></td>
    <td><b>Grupo</b></td>
    <td><b>Grado</b></td>
    <td><b>Correo</b></td>
  

  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
      <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id= $dato['id'];
      $nombre=$dato['nombre'];
      $grupo=$dato['grupo'];
      $grado=$dato['grado'];
      $correo= $dato['correo'];
      ?>
      <tr data-row="<?php echo $dato['id_permiso']?>">
        <td><?php echo $id ?></td>
        <td><?php echo $nombre ?></td>
        <td><?php echo $grupo ?></td>
        <td><?php echo $grado?></td>
       <td><?php echo $correo?></td>
       
    </tr>
  <?php }?>

    


</tbody>
</table>
</div>

<br>
<div>
 <p>
        Grupo Especial a asociar
        <form name="asociar" action="common/AsociarAlumno.php" method="POST">
        <input name="idAlumno" id="idAlumno" value="<?= $id;?>" type="hidden">
        <select name="cboGrupoEsp" id="cboGrupoEsp" class="form-control">
        <?
            while ($row = mysqli_fetch_array($gruposEsp, MYSQLI_ASSOC)){
                echo "<option value=\"".$row['id']."\"";
                echo ">".$row['grupo']."</option>\n";
            }
            ?>
        </select>
        <br/>
        <input type="submit" class="btn btn-group-xs btn-info" value="Asociar"/>
        </form>
    </p>	



  </div>

</div>


<h3 class="text-primary">Grupos asociados a este alumno</h3>


<div class="table-responsive">
<table class="table" id="niveles_table">
  <thead>
    <td><b>Id</b></td>
    <td><b>Nombre</b></td>
    <td><b>Grupo Asociado</b></td>
    <td><b>Familia</b></td>
    <td><b>Grado</b></td>
    <td><b>Acciones</b></td>
  

  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
      <?php while ( $alumnoAsociados = mysqli_fetch_assoc ( $alumnosAsociados ) )
    {
      $id= $alumnoAsociados['id'];
      $nombre=$alumnoAsociados['nombre'];
      $idGrupo=$alumnoAsociados['grupoEspecial'];
      $grupo=$alumnoAsociados['grupoEspecialNombre'];
      $familia=$alumnoAsociados['idfamilia'];
      $grado=$alumnoAsociados['grado'];
   
      ?>
      <tr data-row="<?php echo $dato['id_permiso']?>">
        <td><?php echo $id ?></td>
        <td><?php echo $nombre ?></td>
        <td><?php echo $grupo ?></td>
        <td><?php echo $familia ?></td>
        <td><?php echo $grado?></td>
        <td>


        <form method="POST" action="common/disociarAlumno.php" onsubmit="return confirm('¿Seguro que desea eliminar esta asociación?');">
        <button type="submit" class="glyphicon glyphicon-trash btn-danger btn">
        <input type="hidden" name="idGrupoAsoc" value="<?=$id;?>">
        <input type="hidden" name="idAlumno" id="idAlumno" value="<?=$idAlumno;?>">
        </span>


        </form>
      
            
    </td>
    </tr>
  <?php }
  
  ?>

    


</tbody>
</table>
</div>
 

<br>
<br>

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


  

}



</script>
</body>



</html>
