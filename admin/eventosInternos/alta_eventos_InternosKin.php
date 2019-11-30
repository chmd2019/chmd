
<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('27', $capacidades)){
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

if(isset($_POST['submit']))
{

  $idusuario= htmlspecialchars(trim($_POST['idusuario']));
  $calle = htmlspecialchars(trim($_POST['calle']));
  $colonia = htmlspecialchars(trim($_POST['colonia']));
  $cp = htmlspecialchars(trim($_POST['cp']));
  $ruta = htmlspecialchars(trim($_POST['ruta']));
  $comentarios = htmlspecialchars(trim($_POST['comentarios']));
  $talumnos = htmlspecialchars(trim($_POST['suma']));
  $nfamilia = htmlspecialchars(trim($_POST['nfamilia']));
  $fecha = htmlspecialchars(trim($_POST['fecha']));
  $fecha_permiso = htmlspecialchars(trim($_POST['fecha_permiso']));
  $alumnos= htmlspecialchars(trim($_POST['alumnos']));
  $tipo_permiso=1 ; //permiso Diario.
  $alumnos_array = explode('|', $alumnos);

  //crear permiso
  $query = "INSERT INTO Ventana_Permisos(
    idusuario,
    calle_numero,
    colonia,
    cp,
    ruta,
    comentarios,
    nfamilia,
    tipo_permiso,
    fecha_creacion,
    fecha_cambio)
    VALUES (
    '".$idusuario."',
    '".$calle."',
    '".$colonia."',
    '".$cp."',
    '".$ruta."',
    '".$comentarios."',
    '".$nfamilia."',
    '".$tipo_permiso."',
    '".$fecha."',
    '".$fecha_permiso."')";
    mysqli_query ($conexion, $query );

    $ultimo_id = mysqli_insert_id($conexion);
    $id_permiso= $ultimo_id; // Por resolver (1)
    //almacenar Alumno
    foreach($alumnos_array as $id_alumno){
      $sql = "INSERT INTO Ventana_permisos_alumnos(
      id_permiso, id_alumno
      ) VALUES ('".$id_permiso."','".$id_alumno."' )";

      mysqli_query ($conexion, $sql );

    }

    echo 'Solicitud Guardada';

  }
  else
  {

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
      <title>CHMD :: Alta Internos</title>
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
            <h3>INTERNOS</h3>
        </div>
        
      <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_permisos_internos.php'); ?>
      
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
    <a href="PeventosInternosKin.php" style="cursor: pointer;" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Nueva solicitud de Permiso Interno:</h2>
    </center>
    <?php
    //  $familia=$_GET["nfamilia"];
    //  $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
    $solicitante_admin = $user_session;
    $solicitante_id = $id_user_session;

    $datos = mysqli_query ($conexion, "SELECT adm.id, adm.usuario, usu.id as id_usuario, usu.correo  from usuarios usu INNER JOIN Administrador_usuarios adm ON usu.perfil_admin =adm.id  WHERE usu.id='$solicitante_id' LIMIT 1" );
    ?>
    <center>
      <form id="eventos"  name="eventos" class="form-signin save-nivel"   >
        <div class="alert-save"></div>
        <div class="modal-body">

          <table border="0" WIDTH="100%" >
            <tr>
              <td colspan="1" WIDTH="50%">Fecha de solicitud:
                <input name="fecha_solicitud" id="fecha_solicitud" type="text" class="form-control" placeholder="fecha_solicitud"  value="<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').", ".date("h:i a");?>" readonly="readonly">
              </td>
              <td colspan="1" WIDTH="50%">
                Solicitante:
                <select class="form-control"id="solicitante"  name="solicitante">
                  <?php
                  while ($rows=mysqli_fetch_array($datos))
                  {
                    $id_admin=$rows['id'];
                    $nombre= $rows['usuario'];
                    $correo = $rows['correo'];
                    $id_usuario = $rows['id_usuario'];
                    ?>
                    <option value="<?=$id_usuario?>"><?=ucwords($nombre)?>( <?=$correo?> )</option>
                    <?php
                  }
                  ?>
                </select>
              </td>
            </tr>
          </table>
          <br>

          <table border="0" WIDTH="100%">
            <tr>
              <td colspan="1" WIDTH="50%">Fecha de Permiso:
                <div class="input-group date datepicker"   >
                  <input class="form-control " size="15"   id="fecha_permiso"  onchange="remover_timepicker()" name="fecha_permiso"    placeholder="Seleccione una fecha" type="text"   disabled required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </td>
              <td colspan="1" WIDTH="50%" >Nombre de Evento:
                <div class="input-group">
                  <input class="form-control" name="tipo_evento" id="tipo_evento" type="text" placeholder="Agregar el Tipo de Evento" value="Permiso Interno" disabled>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                </div>
              </td>
            </tr>
          </table>
          <br>

          <table>
            <tr>
              <td colspan="1" width = "100%" >
                <input id="regresan_check"  type="checkbox" name="" value="" onchange="mostrar_regreso()">
                <span>Los alumnos regresan a la Institución.</span>
              </td>
            </tr>
          </table>

          <table border="0" WIDTH="100%">
            <tr class="horas" id='horas'>
              <td WIDTH="50%" colspan="1" >Hora de Salida:
                <div class="input-group date ">
                  <input class="form-control timepicker timepicker salida"
                  autocomplete="off"   id="hora_salida"
                  name="salida" placeholder="Seleccione una hora de salida"
                  type="text"
                  onclick="mostrar_timepicker_salida(this,'1')"
                  onkeypress="return validar_solo_numeros(event, this.id, 4)"
                  onchange="reinicia_hora_regreso()" required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </td>
              <td id="tr_regreso" WIDTH="50%" colspan="1" style="display:none">Hora de Regreso:
                <div class="input-group date">
                  <input class="form-control timepicker timepicker regreso"   id="hora_regreso"  name="regreso" placeholder="Seleccione una hora de regreso" type="text"   onclick="mostrar_timepicker_regreso(this, '1')"     onkeypress="return validar_solo_numeros(event, this.id, 4)" onchange="valida_hora_mayor()" required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </td>
            </tr>
          </table>


          <table border="0" WIDTH="100%">
            <tr id="new_responsable">
              <td  colspan="1" WIDTH="50%" >
                Responsable:
                <input class="form-control" id="responsable" type="text" name="nombre_nuevo" value="" placeholder="Agrege un nombre" >
              </td>
              <td  colspan="1" WIDTH="50%">
                Cargo:
                <input class="form-control" id="parentesco_responsable" type="text" name="parentesco_nuevo" value="" placeholder="Agrege un Cargo" >
              </td>
            </tr>
          </table>
          <br>
          <b>Descripción del Evento o Motivo:</b>
          <textarea  class="form-control"  id="motivos"  name="motivos" placeholder="Descripción del Evento o Motivo"  ></textarea>
          <!--  <input type="hidden" name="idusuario" id="idusuario"  value="<?php //echo $idusuario ?>" />
          <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php // echo $familia ?>" />
          <input type="hidden" name="talumnos" id="talumnos"  value="<?php //echo $talumnos ?>" />
          -->
          <br>
        <table border="0" WIDTH="100%">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4 class="">
                <b>Listado de Alumnos registrados:</b>
                <?php 
                $nivel_or_area = '1';
                include 'componentes/buscador_alumnos.php'; ?>
              </h4><br>
            </td>
          </tr>
        </table>
        <div class="table-responsive" >
        <table class="table"  class="text-center"  WIDTH="100%" >
          <thead>
            <td  WIDTH="10%" colspan="1"><b>Id</b></td>
            <td  WIDTH="40%" colspan="4"><b>Alumno</b></td>
            <td  WIDTH="30%" colspan="3" ><b>Grado</b></td>
            <td  WIDTH="10%" colspan="1"><b>Grupo</b></td>
            <td  WIDTH="10%" colspan="2"><b>Acciones</b></td>
          </thead>
          <tbody id="lista_alumnos" >
            <!-- Lista de alumnos-->
          </tbody>
        </table>
        </div>
      </div>
          

        <div class="modal-footer" style="border:none">
          <button type="button" class="btn btn-danger" onclick="cancelar()">CANCELAR</button>
          <button type="button" class="btn btn-primary" onclick="enviar_formulario(null,6,<?=$nivel_or_area?>)"><b>ENVIAR</b></button>
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
  <script type="text/javascript" src="js/alta_eventos_internos.js"></script>
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

  <?php
  $i = 0;
  $lista_fechas;
  $sql = "SELECT * FROM Calendario_escolar";
  $fecha_calendario_escolar = mysqli_query($conexion, $sql);
  if ($fecha_calendario_escolar) {
    while ($respuesta_calendario_escolar = mysqli_fetch_array($fecha_calendario_escolar)) {
      $lista_fechas[$i] = $respuesta_calendario_escolar[1];
      $i++;
    }
  }
  ?>
  <script type="text/javascript">
    var calendario_escolar = <?php echo json_encode($lista_fechas) ;?>;
    $('.datepicker').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 0,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      startDate: '+0d',
      daysOfWeekDisabled: [0, 6],
      datesDisabled: calendario_escolar,
      forceParse: 0,
      format: "DD, dd MM yyyy"
    });
  </script>
</body>
</html>
<?php
}
