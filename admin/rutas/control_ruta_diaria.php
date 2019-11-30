<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('26', $capacidades)){
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
if (isset($_POST['id_ruta'])){
  $id_ruta = htmlspecialchars(trim($_POST['id_ruta'])) ;
}else{
  header('Location: Prutas_diaria.php');
}
$fecha = date('Y-m-d');
$datos = mysqli_query ( $conexion, "SELECT rh.nombre_ruta , rh.camion , rh.prefecta , rh.cupos FROM rutas_historica rh  WHERE rh.id_ruta_h='$id_ruta' and fecha='$fecha' LIMIT 1;");
while ($r = mysqli_fetch_assoc($datos) ){
  $nombre_ruta= $r['nombre_ruta'];
  $camion = $r['camion'];
  $prefecta = $r['prefecta'];
  $cupos = $r['cupos'];
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
      <title>CHMD :: Control de Rutas Diarias</title>
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
      <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_rutas.php'); ?>
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
    <a href="Prutas_diaria.php" style="cursor: pointer;" class="pull-right">
    <!-- Boton de Atras -->
    <?php include 'componentes/btn_atras.php'; ?>
    </a>
    <center>
      <h2 class="text-primary">Control de Rutas - <?=$nombre_ruta?></h2>
    </center>
    <?php
    //  $familia=$_GET["nfamilia"];
    //  $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
    // $solicitante_admin = $user_session;
    // $solicitante_id = $id_user_session;
    // $datos = mysqli_query ($conexion, "SELECT adm.id, adm.usuario, usu.id as id_usuario, usu.correo  from usuarios usu INNER JOIN Administrador_usuarios adm ON usu.perfil_admin =adm.id  WHERE usu.id='$solicitante_id' LIMIT 1" );
    ?>
        <table border="0" WIDTH="100%" >
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Nombre de la Ruta:
                <input name="nombre_ruta" id="nombre_ruta" type="text" class="form-control" placeholder="Agrege el Nombre de la Nueva ruta"  value="<?=$nombre_ruta?>" disabled="disabled">
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Prefecta:
                <input name="prefecta" id="prefecta" type="text" class="form-control" placeholder="Agrege la Prefecta"  value="<?=$prefecta?>"  disabled="disabled">
              </td>
            </tr>
          </table>
          <table border="0" WIDTH="100%">
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Número de Camión:
                <input name="camion" id="camion" type="number" class="form-control" placeholder="Agrege el Número de camión"  value="<?=$camion?>" max="99" step="1" min="01" disabled="disabled">
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Número de Cupos:
                <input name="cupos" id="cupos" type="number" class="form-control" placeholder="Agrege el Número de cupos"  value="<?=$cupos?>" max="99" step="1" min="01" disabled="disabled">
              </td>
            </tr>
            <tr class="row">
              <td  class="col-sm" >
                <input  type="checkbox" name="desabilita" onchange="desabilitar_inputs()" ><span> Editar Ruta</span>
              </td>
              <td  class="col-sm text-right p-3"  >
                <button style="display: none" class="btn btn-primary" id="button_editar" onclick="editar_inputs(<?=$id_ruta?>, '<?=$fecha?>')"><b><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;EDITAR</b></button>
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
                $sql ="SELECT COUNT(*) FROM rutas_historica_alumnos WHERE  id_ruta_h='$id_ruta' and fecha='$fecha';";
                $query = mysqli_query($conexion, $sql);
                if($r = mysqli_fetch_array($query)){
                  $n_alumnos= $r[0];
                }
                 ?>
                <b>Listado de Alumnos registrados: <i id="n_alumnos"><?=$n_alumnos?></i></b>
                <?php
                // include 'componentes/buscador_alumnos.php';
                ?>
               <select id="view" class="form-control" style="width: 200px; display: initial; float: right;" onchange="view_table()" > 
                  <option value = '1' selected>Mañana</option>
                  <option value = '2'>Tarde</option>
                  <option value = '3'>Mañana-Tarde</option>
               </select> 
              </h4><br>
            </td>
          </tr>
        </table>
        <div class="table-responsive" >
        <table class="table"  class="text-center"  WIDTH="100%" >
          <thead>
            <td  class="view_m" style="min-width: 10px;" colspan="1"><b>#M</b></td>
            <td  class="view_r"  style="min-width: 10px;" colspan="1"><b>#T</b></td>
            <td   colspan="2"><b>Nombre</b></td>
            <td  class="view_m" colspan="3"><b>Domicilio(Mañana)</b></td>
            <td  class="view_r m_t" colspan="3"><b>Domicilio(Tarde)</b></td>
            <td   colspan="2"><b>Grado</b></td>
            <td   colspan="2"><b>Grupo</b></td>
            <td   class="view_m"  colspan="2"><b>Hora(Mañana)</b></td>
            <td  class="view_r" colspan="2"><b>Hora(Tarde)</b></td>
            <!-- <td colspan="2"><b>Hora(Vie)</b></td> -->
            <td   colspan="1"><b>Acciones</b></td>
          </thead>
          <tbody id="lista_alumnos">
            <!-- Lista de alumnos-->
            <?php
            $c=-1;
            $sql ="SELECT rb.id_alumno, rb.domicilio, rb.domicilio_s, rb.hora_manana, rb.hora_regreso, ac.nombre, ac.grupo, ac.grado, rb.orden_in , rb.orden_out FROM rutas_historica_alumnos rb LEFT JOIN alumnoschmd ac ON ac.id = rb.id_alumno WHERE  rb.id_ruta_h='$id_ruta' and. rb.fecha='$fecha' ORDER BY rb.orden_in ;";
            $query = mysqli_query ($conexion, $sql);
            while ($row = mysqli_fetch_assoc($query)){
              $id_alumno = $row['id_alumno'];
              $nombre = $row['nombre'];
              $grupo = $row['grupo'];
              $grado = $row['grado'];
              $domicilio = $row['domicilio'];
              $domicilio_s = $row['domicilio_s'];
              $hora_manana = $row['hora_manana'];
              $hora_regreso = $row['hora_regreso'];
              $orden_in =$row['orden_in'];
              $orden_out =$row['orden_out'];
              $c++;
             ?>
               <tr class="enlistado" id="selected_<?=$id_alumno?>" data-id="<?=$id_alumno?>" data-orden="<?=$orden?>" style="border-bottom: 1px solid #ddd">
                <td   class="view_m" id="orden_in<?=$id_alumno?>"><?=$orden_in?></td>
                <td  class="view_r" id="orden_out<?=$id_alumno?>"><?=$orden_out?></td>
                <td hidden class="id_selected"  id="idt_<?=$id_alumno?>"><?=$id_alumno?></td>
                <td colspan="2" id ="nombret_<?=$id_alumno?>"><?=$nombre?></td>
                <td  class="view_m" colspan="3" id ="domiciliot_<?=$id_alumno?>"><?=$domicilio?></td>
                <td  class="view_r m_t"  colspan="3" id ="domicilio_s_t<?=$id_alumno?>"><?=$domicilio_s?></td>
                <td colspan="2" id ="gradot_<?=$id_alumno?>" ><?=$grado?></td>
                <td colspan="2" id ="grupot_<?=$id_alumno?>"><?=$grupo?></td>
                <td  class="view_m" colspan="2" id ="hora_mananat_<?=$id_alumno?>">
                <input id="hora_m<?=$id_alumno?>" type="text" class="form-control timepicker hora_m text-center" data-id="<?=$id_alumno?>" data-orden_in="<?=$orden_in?>" placeholder="Mañana" onclick="mostrar_timepicker_ma(this,<?=$id_alumno?>)"  onKeyPress="return solo_select(event)" onchange="ordenar(<?=$id_alumno?>)"  maxlength="5" value="<?=$hora_manana?>" >
                </td>
                <td class="view_r" colspan="2" id ="hora_regresot<?=$id_alumno?>">
                <input id="hora_re<?=$id_alumno?>" type="text" class="form-control timepicker text-center hora_r" data-id="<?=$id_alumno?>" data-orden_out="<?=$orden_out?>"  placeholder="Regreso"  onclick="mostrar_timepicker_re(this,<?=$id_alumno?>)" onKeyPress="return solo_select(event)" onchange="ordenar(<?=$id_alumno?>)" maxlength="5" value="<?=$hora_regreso?>" >
                </td>
                <!-- <td colspan="2" id ="hora_viet_<?=$id_alumno?>">
                <input id="hora_vie<?=$id_alumno?>" type="text" class="form-control timepicker" placeholder="Viernes" onclick="mostrar_timepicker_vi(this,<?=$id_alumno?>)" onKeyPress="return solo_select(event)"  maxlength="5" value="">
                </td> -->
                <td colspan="1">
                  <a class="cambio_ruta" type="button" data-id="<?=$id_alumno?>" data-nombre_alumno="<?=$nombre?>" data-domicilio="<?=$domicilio?>"  data-toggle="modal" data-target="#modal_cambio_ruta">
                    <?php include 'componentes/btn_ver.php'; ?>
                  </a>
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
          <button type="button" class="btn btn-primary" onclick="enviar_formulario(<?=$id_ruta?>, '<?=$fecha?>')"><b>GUARDAR</b></button>
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
  <script type="text/javascript" src="js/control_ruta_diaria.js"></script>
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
    //Orden - Marcan en ROjo 
        $('.enlistado').each(function(){
        // alert('id:');
        var id = $(this).data('id');
        var orden_in = $('td#orden_in' + id).text();
        var orden_out = $('td#orden_out' + id).text();
        if (orden_in >900 || orden_out>900){
          $(this).css("background", "#ff717129");
        }
       });
  });
</script>
</body>
</html>
<!---- Modal --->
<div id="modal_cambio_ruta" class="modal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog" role="document"  style="max-width:95vw;"  >
    <div class="modal-content">
      <div class="modal-header d-block">
        <h5 class="modal-title" width="100%" id="ModalCenterTitle">Cambiar de ruta del día al alumno: <i id="nombre_alumno">nombre</i></h5>
        <small>Domicilio: <i id="domicilio_alumno">domicilio</i></small>
        <input width="100%" type="text" class="form-control filter"
        placeholder="Buscar Solicitud..." onkeyup="filter(this)">
      </div>
      <div class="modal-body" style="height:60vh ; overflow-y: scroll;">
        <table class="table" width="100%"  style="font-size: 14px;"  >
          <thead style="border-bottom: 2px solid #333">
              <th>Ruta</th>
              <th>Prefecto(a)</th>
              <th>Camión</th>
              <th>Cupos(Ocupados/Total)</th>
              <th style="text-align:center">Acciones</th>
          </thead >
          <tbody id="lista_alumnos_new" class="searchable" >
            <?php
            $sql =  "SELECT id_ruta_h as id_ruta, nombre_ruta, prefecta, camion, cupos 
                     FROM rutas_historica
                     WHERE id_ruta_h!=$id_ruta and fecha='$fecha'";
            $rutas = mysqli_query ($conexion, $sql );
            while($ruta = mysqli_fetch_array($rutas)){

              $id_ruta = $ruta['id_ruta'];
              $nombre_ruta = $ruta['nombre_ruta'];
              $prefecta = $ruta['prefecta'];
              $camion = $ruta['camion'];
              $cupos = $ruta['cupos'];
               //numero de cupos Disponibles
            $sql = "SELECT COUNT(*) FROM rutas_historica_alumnos WHERE id_ruta_h=$id_ruta and fecha='$fecha'; ";
            $query = mysqli_query($conexion, $sql);
            while($r = mysqli_fetch_array($query) ){
              $cupos_disponibles = $r[0];
            }
              ?>
              <tr style="border-bottom: 1px solid #eee" id="tr_<?=$id_ruta?>">
                <td id="nombre_ruta<?=$id_ruta?>"><?=$nombre_ruta?></td>
                <td id="prefecta<?=$id_ruta?>"><?=$prefecta?></td>
                <td id="camion<?=$id_ruta?>"><?php if ($camion<=9) echo '0'.$camion ; else echo $camion;?></td>
                <td id="cupos<?=$id_ruta?>"><span id="cupos_disponibles<?=$id_ruta?>"><?=$cupos_disponibles?></span><?php echo '/'.$cupos?></td>
                <td style="text-align:center">
                <button type="button" class="btn btn-primary" onclick="cambiar_ruta(<?=$id_ruta?> )" style ="font-family: 'Varela Round'" >
                    <span class="glyphicon glyphicon-refresh" ></span> CAMBIAR DE RUTA
                  </button>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <input type="hidden" name="alumno" value="" id="id_alumno">
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> CERRAR</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function filter(element){
//  alert($(element).val());
  var rex = new RegExp($(element).val(), 'i');
  $('.searchable tr').hide();
  $('.searchable tr').filter(function() {
    return rex.test( $(this).text() );
  }).show();
  /*
  */
}
</script>