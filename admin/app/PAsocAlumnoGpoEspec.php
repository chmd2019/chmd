<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)){
    header('Location: ../menu.php');
}

$root_imagenes=' http://chmd.chmd.edu.mx:65083';
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$idGrupo = $_GET["cboGrupoEsp"]; 
/*if (isset($_POST['id_ruta'])){
  $id_ruta = htmlspecialchars(trim($_POST['id_ruta'])) ;
}else{
  header('Location: Prutas.php');
}*/

$datos = mysqli_query ( $conexion, "SELECT * from App_grupos_especiales WHERE id=$idGrupo");
while ($r = mysqli_fetch_assoc($datos) ){
  $grupo= $r['grupo'];
  $descrip = $r['descripcion'];
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
      <title>CHMD :: Asignar grupos especiales a alumnos</title>
      <link href="../dist/css/bootstrap.css" rel="stylesheet">
      <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <link href="../css/menu.css" rel="stylesheet">
      <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.css">
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
            <h3>Grupos Especiales</h3>
        </div>
        <?php $perfil_actual='39';
           include ("../menus_dinamicos/perfiles_dinamicos_app.php");?>
    </nav>

    <!-- Page Content  -->
    <div id="content">
      <?php include_once "../components/navbar.php"; ?>

      <div class="container-fluid">
        <div class="masthead">
    </div>
    <br>
    <center><?php // echo isset($_POST['guardar']) ? $verificar=1 : '' ; ?></center>
    <!-- Button trigger modal -->
    <a href="Prutas.php" style="cursor: pointer;" class="pull-right">
    <!-- Boton de Atras -->
    <?php include 'componentes/btn_atras.php'; ?>
    </a>
    <center>
      <h2 class="text-primary">Control de Grupo - <?=$grupo?></h2>
    </center>
    <?php
    //  $familia=$_GET["nfamilia"];
    //  $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
    //$solicitante_admin = $user_session;
    //$solicitante_id = $id_user_session;

    //$datos = mysqli_query ($conexion, "SELECT adm.id, adm.usuario, usu.id as id_usuario, usu.correo  from usuarios usu INNER JOIN Administrador_usuarios adm ON usu.perfil_admin =adm.id  WHERE usu.id='$solicitante_id' LIMIT 1" );
    ?>
    <table border="0" WIDTH="100%" >
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Nombre del grupo:
                <input name="grupo" id="grupo" type="text" class="form-control" placeholder="Agrege el Nombre del grupo"  value="<?=$grupo?>" disabled="disabled">
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Descripci&oacute;n:
                <input name="descripcion" id="descripcion" type="text" class="form-control" placeholder="Agrege la descripcion"  value="<?=$descrip?>"  disabled="disabled">
              </td>
            </tr>
          </table>
         
    <center>
      <form id="eventos"  name="eventos" class="form-signin save-nivel"   >
        <div class="modal-body">
        <table border="0" WIDTH="100%">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4 class="">
                <?php
                $n_alumnos=0;  
                $sql ="SELECT COUNT(*) FROM vwAlumnosGruposEspeciales WHERE grupoEspecial=$idGrupo";
                $query = mysqli_query($conexion, $sql);
                if($r = mysqli_fetch_array($query)){
                  $n_alumnos= $r[0];
                }
                 ?>
                <b>Total de Alumnos registrados en este grupo: <i id="n_alumnos"><?=$n_alumnos?></i></b>
                <?php include 'componentes/buscador_alumnos.php'; ?>
              </h4><br>
            </td>
          </tr>
        </table>
        <div class="table-responsive" >
        <table class="table" id="lista_alumnos"  class="text-center"  WIDTH="100%" >
          <thead>
       <!--   <td ><b>Número</b></td>-->
            <td ><b>Id Alumno</b></td>
            <td ><b>Nombre</b></td>
            <td><b>Id Familia</b></td>
            <td ><b>Grado</b></td>
     
            <td><b>Acciones</b></td>
          </thead>
          <tbody>
            <!-- Lista de alumnos-->
            <?php 
            $c=0;
            $sql ="SELECT * FROM vwAlumnosGruposEspeciales WHERE grupoEspecial=$idGrupo";
            $query = mysqli_query ($conexion, $sql);
            while ($row = mysqli_fetch_assoc($query)){
              $id_alumno = $row['alumno_id'];
              $nombre = $row['nombre'];
              $idfamilia = $row['idfamilia'];
              $grado = $row['grado'];

              /*
              <!--  <td  id="orden_<?=//$id_alumno?>"><?=$c?></td>
              */
              $c++;
             ?>
               <tr class="enlistado" id="selected_<?=$id_alumno?>" data-id="<?=$id_alumno?>" data-orden="<?=$orden?>" style="border-bottom: 1px solid #ddd">
              
                <td  id="idalumnot_<?=$id_alumno?>"><?=$id_alumno?></td>
                <td hidden class="id_selected"  id="idt_<?=$id_alumno?>"><?=$id_alumno?></td>
                <td  id ="nombret_<?=$id_alumno?>"><?=$nombre?></td>
                <td  id ="familiat_<?=$id_alumno?>" ><?=$idfamilia?></td>
                <td  id ="gradot_<?=$id_alumno?>" ><?=$grado?></td>
              
                
                <td >
                <form method="POST" action="common/eliminarAsocGrupoEspecial.php" onsubmit="return confirm('¿Seguro que desea eliminar este alumno del grupo especial?');">
        <button type="submit" class="glyphicon glyphicon-trash btn-danger btn">
        <input type="hidden" name="idgrupo" value="<?=$id;?>">
                </td>
            </tr> 
            <?php 
            }
            ?>
          </tbody>
        </table>
        </div>
      </div>


        <div class="modal-footer" style="border:none">
          <button type="button" class="btn btn-danger" onclick="cancelar()">CANCELAR</button>
          <button type="button" class="btn btn-primary" onclick="enviar_formulario(<?=$id_ruta?>)"><b>GUARDAR</b></button>
        </div>

      </form>
    </center>

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
  <script type="text/javascript" src="js/control.js"></script>

  <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
  <script src="https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.min.js"></script>
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

