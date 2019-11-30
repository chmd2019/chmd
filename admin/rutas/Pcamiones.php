
<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('32', $capacidades)){
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
//$datos = mysql_query ( "select papa,calle,colonia,cp from usuarios where password='$fam'" );

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
      <title>CHMD :: Camiones</title>
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
            <h3>RUTAS</h3>
        </div>
      <?php $perfil_actual='54'; include ('../menus_dinamicos/perfiles_dinamicos_rutas.php'); ?>
    </nav>
    <!-- Page Content  -->
    <div id="content">
      <?php include_once "../components/navbar.php"; ?>

      <div class="container-fluid">
        <div class="masthead">
    </div>
    <br>
    <!-- Button trigger modal -->
<a href="Prutas.php" style="cursor: pointer;" class="pull-right">
<!-- Boton de Atras -->
<?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Nueva Ruta/camión:</h2>
    </center>
    <center>
      <form  id="eventos"  name="eventos" class="form-signin save-nivel"   >
        <div class="alert-save"></div>
        <div class="modal-body">
          <table border="0" WIDTH="100%" >
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Nombre de la Ruta:
                <input name="nombre_ruta" id="nombre_ruta" type="text" class="form-control" placeholder="Agrege el Nombre de la Nueva ruta"  value="" >
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Auxiliar:
                <select name="auxiliar" id="auxiliar" type="text" class="form-control">
                  <option value='0' selected disabled>SELECCIONAR AUXILIAR</option>
                  <?php    //auxiliares
                      $sql ="SELECT id, nombre FROM usuarios WHERE tipo ='9'";
                      $query = mysqli_query($conexion, $sql);
                      while($r = mysqli_fetch_array($query)){
                    ?>
                  <option value="<?php echo $r[0]; ?>" ><?php echo strtoupper($r[1]); ?></option>
                   <?php
                      }
                   ?>
                </select>
              </td>
            </tr>
          </table>
          <table border="0" WIDTH="100%">
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Tipo de Ruta:
                <select class="form-control" name="tipo_ruta" id="tipo_ruta"  onchange="existe_camion()">
                  <option value="0" selected disabled>SELECIONE UN TIPO DE RUTA</option>
                  <option value="1">GENERAL</option>
                  <option value="2">KINDER</option>
                </select>
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Número de Camión:
                <input onchange="existe_camion()" name="camion" id="camion" type="number" class="form-control" placeholder="Agrege el Número de camión"  value="" max="99" step="1" min="01">
                <small id="existe_camion" class="text-danger" style="display:none">Ya existe el Número de Camión</small>
              </td>
            </tr>
          </table>
          <table border="0" WIDTH="100%">
            <tr class="row">
              <td class="col-sm-6" colspan="1" WIDTH="50%">Número de Cupos:
                <input name="cupos" id="cupos" type="number" class="form-control" placeholder="Agrege el Número de cupos"  value="" min=10 max="60" step="1">
              </td>
            </tr>
          </table>
        <div class="modal-footer" style="border:none">
          <button type="button" class="btn btn-danger" onclick="cancelar()">CANCELAR</button>
          <button type="button" class="btn btn-primary" onclick="enviar_formulario()"><b>CREAR</b></button>
        </div>
      </form>
    </center>
      <br>
<div class="table-responsive-lg">
  <table class="table" id="niveles_table">
    <thead>
      <tr>
        <td><b>Ruta</b></td>
        <td><b>Auxiliar</b></td>
        <td><b>Tipo Ruta</b></td>
        <td><b>Camión</b></td>
        <td><b>Cupos(Mañana/Total)</b></td>
        <td><b>Cupos(Tarde/Total)</b></td>
        <td class="text-center"><b>Acciones</b></td>
      </tr>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php
      $sql = "SELECT  r.*, u.nombre FROM rutas r LEFT JOIN usuarios u ON u.id=r.auxiliar
order by r.camion;";
     $datos = mysqli_query ( $conexion,$sql );
     while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id_ruta = $dato['id_ruta'];
      $nombre_ruta = $dato ['nombre_ruta'];
      $auxiliar = $dato['nombre'];
      $camion = $dato['camion'];
      $cupos = $dato['cupos'];
      $tipo_ruta = $dato['tipo_ruta'];

      if ($tipo_ruta==1) $tipo_ruta='GENERAL';
      else if ($tipo_ruta==2) $tipo_ruta ='KINDER';
      else $tipo_ruta = '-';

      if ($auxiliar==NULL) $auxiliar= 'Sin Auxiliar';
      $auxiliar=strtoupper($auxiliar);

      //numero de cupos Disponibles
      $sql = "SELECT COUNT(*) FROM rutas_base_alumnos WHERE id_ruta_base_m=$id_ruta";
      $query = mysqli_query($conexion, $sql);
      while($r = mysqli_fetch_array($query) ){
        $cupos_disponibles_m = $r[0];
      }
      //numero de cupos Disponibles - Tarde
      $sql = "SELECT COUNT(*) FROM rutas_base_alumnos WHERE id_ruta_base_t=$id_ruta";
      $query = mysqli_query($conexion, $sql);
      while($r = mysqli_fetch_array($query) ){
        $cupos_disponibles_t = $r[0];
      }

      ?>
      <tr class="fila_alumnos" id="fila_<?=$id_ruta?>">
        <td><?php echo $nombre_ruta?></td>
        <td><?php echo $auxiliar?></td>
        <td><?php echo  $tipo_ruta ?></td>
        <td><?php
        if ($camion<=9) echo '0'.$camion ; else echo $camion;?></td>
        <td ><?php echo $cupos_disponibles_m.'/'.$cupos?></td>
        <td ><?php echo $cupos_disponibles_t.'/'.$cupos?></td>
        <td class="text-center">
        <?php if ($id_ruta>0 and $camion<900){
          ?>
            <a href="editar_camiones.php?id_ruta=<?=$id_ruta?>" data-id="<?php echo $id_ruta?>">
              <?php include 'componentes/btn_ver.php'; ?>
            </a>
            <a id="btn-eliminar_<?=$id_ruta?>" class="btn-eliminar" type="button" onclick="mod_eliminar(<?php echo $id_ruta?>, '<?=$nombre_ruta?>' )"
              data-id="<?php echo $id_ruta?>"  data-ruta="<?=$nombre_ruta?>" data-toggle="modal" data-target="#modal_cancelar_ruta" href="#modal_cancelar_ruta">
              <?php include 'componentes/btn_cancelar.php'; ?>
            </a>
          <?php
        } ?>
      </td>
      </tr>
<?php } ?>
</tbody>
</table>
</div>
  </div>
<!-- modal de eliminar ruta -->
<div id="modal_cancelar_ruta" class="modal" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-body">
         <p>¿Confirma que desea eliminar la ruta: <span id="modal_nombre_ruta"></span>?</p>
      </div>
    <div class="modal-footer" style="padding:1rem">
      <button class="btn btn-danger" type="button" name="button" data-dismiss="modal">Cancelar</button>
    <input type="hidden" id="modal_id_ruta" name="modal_id_ruta" value="">
      <button class="btn btn-muted" type="button" name="button" data-dismiss="modal"  onclick="eliminar_ruta()">Aceptar</button>
    </div>
   </div>
  </div>
</div>

<!-- toast de pueba   -->
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <img src="..." class="rounded mr-2" alt="...">
    <strong class="mr-auto">Bootstrap</strong>
    <small>11 mins ago</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Hello, world! This is a toast message.
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="js/Pcamiones.js"></script>
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
</body>
</html>
