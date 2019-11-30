<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('5', $capacidades)){
    header('Location: PextraordinarioPrimaria.php');
}

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
      <title>CHMD :: Alta Extraordinario</title>
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
            <h3>EXTRAORDINARIOS</h3>
        </div>
        
      <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_extraordinarios.php'); ?>
        
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
      <a href="PextraordinarioKinder.php" style="cursor: pointer;" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Nueva solicitud de extraordinario:</h2>
    </center>
    <?php
    if (!$_GET)
    {
      ?>

      <form class="navbar-form navbar-right" role="search" method='get' action="">
        <div class="form-row">
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="nfamilia" id="nfamilia" placeholder="Número de Familia" size="30"  minlength="4" required>
          </div>
          <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-search"></span>
              <b> BUSCAR</b></button>
            </div>
          </div>
        </form>
        <hr width="100%">

      <?php
    }else {
      $familia=$_GET["nfamilia"];
      $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
      $row_cnt = mysqli_num_rows($datos);
      if ($row_cnt>0){
      ?>
      <center>
        <form id="diario"  name="diario" class="form-signin save-nivel" method='post'   onsubmit='Alta_diario(); return false'>
          <div class="alert-save"></div>
          <div class="modal-body">

            <table border="0" WIDTH="100%" >
              <tr>
                <td colspan="3" WIDTH="100%">Fecha de solicitud:
                  <input name="fecha_solicitud" id="fecha_solicitud" type="text" class="form-control" placeholder="fecha_solicitud"  value="<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').", ".date("h:i a");?>" readonly="readonly">
                </td>
              </tr>
              </table>
              <br>

              <table border="0" WIDTH="100%">
                <tr>
                  <td colspan="1" WIDTH="50%">
                    Solicitante:
                    <select class="form-control"id="solicitante"  name="solicitante">
                      <?php
                     while ($rows=mysqli_fetch_array($datos))
                     {
                       $idusuario=$rows['id'];
                       $nombre= $rows['nombre'];
                       $correo= $rows['correo'];
                       ?>
                       <option value="<?=$idusuario?>"><?=$nombre?></option>
                       <?php
                     }
                     ?>
                    </select>
                </td>
                <td>Fecha de Salida:
                    <div class="input-group date datepicker"   >
                      <input class="form-control " size="15"   id="fecha_permiso"  name="fecha_permiso"    placeholder="Seleccione una fecha" type="text"  onchange="remover_timepicker()" disabled required/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </td>
              </tr>
            </table>


            <table border="0" WIDTH="100%">
              <tr>
                <td>
                    <div class="row">
                       <div class="col-sm-10">

                        </div>
                    </div>
                </td>
              </tr>
            </table>
            <br>
            <table border="0" WIDTH="100%">
              <tr>
                <td WIDTH="100%" colspan="3">
                    <h4 class=""><b>Alumnos Solicitantes:</b></h4><br>
                </td>
              </tr>
            </table>
            <div class="table-responsive">
              
            <table class="table"    WIDTH="100%" >
              <thead>
              <tr>
                <th WIDTH="40%" colspan="4">Alumno</th>
                <th WIDTH="30%" colspan="3" style="">Grado</th>
                <th WIDTH="20%" colspan="2" style="">Grupo</th>
                <th WIDTH="10%" colspan="1" style="">Selección</th>
              </tr>
               </thead>
              <?php
              $counter=-1;
              $existe = mysqli_query ($conexion, "SELECT * FROM alumnoschmd where idfamilia=$familia and id_nivel='1'" );
              while($alumno=mysqli_fetch_array($existe))
              {
                $counter = $counter + 1;
                $id_alumno = $alumno['id'];
                $id_nivel = $alumno['id_nivel'];
                $idcursar = $alumno['idcursar'];
                $grado_escolaridad = $alumno['idcursar'];
                //cambiar a grado_escolaridad a 17
                if ($grado_escolaridad != 17)
                    $flag_no_sale_solo = true;
                $horario_permitido = "";
                if ($grado_escolaridad >= 1 && $grado_escolaridad <= 4) {
                    $horario_permitido = 1; //kinder
                } else if ($grado_escolaridad >= 5 && $grado_escolaridad <= 6) {
                    $horario_permitido = 2; //primaria baja
                } else if ($grado_escolaridad >= 7 && $grado_escolaridad <= 10) {
                    $horario_permitido = 3; //primaria alta
                } else if ($grado_escolaridad >= 11 && $grado_escolaridad <= 17) {
                    $horario_permitido = 1; //bachillerato
                }

                ?>
                <input style = "display:none" value="<?php echo $idcursar; ?>" id="idcursar_alumno_<?php echo $counter; ?>">
                <tr id="fila-<?php echo $alumno['id'] ?>">
                  <td  WIDTH="40%" colspan="4"><?php echo $alumno['nombre']?></td>
                  <td  WIDTH="30%" colspan="3"><?php echo $alumno['grado']?></td>
                  <td  WIDTH="20%" colspan="2"><?php echo $alumno['grupo'] ?></td>
                  <td  class="checks-alumnos" WIDTH="10%" colspan="1">
                    <input class="form-control micheckbox" type="checkbox"   id="alumno_<?php echo $counter; ?>" name="alumno[]" onchange="mostrar_horas(<?=$counter?>, <?php echo $alumno['id']; ?>,<?php echo $idcursar; ?> )"  value="<?php echo $alumno['id']; ?>">
                  </td>
                </tr>
                <tr class="horas" id='horas_<?=$counter?>' style = "display:none">
                  <td WIDTH="50%" colspan="5"  style="border-top: none !important;" >Hora de Salida:
                      <div class="input-group date ">
                        <input class="form-control timepicker timepicker_<?php echo $counter; ?> salida_<?php echo $counter; ?>"
                           autocomplete="off"   id="hora_salida_<?php echo $counter; ?>"
                           name="salida" placeholder="Seleccione una hora de salida"
                           type="text"
                           onclick="mostrar_timepicker_salida(this, '<?php echo $counter; ?>', '<?php echo $horario_permitido; ?>')"
                           onkeypress="return validar_solo_numeros(event, this.id, 4)"   onchange="reinicia_hora_regreso('<?php echo $counter; ?>')" required/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                      </div>
                    </td>
                  <?php if ($grado_escolaridad >= 11 && $grado_escolaridad <= 17) {
                   ?>
                    <td  WIDTH="50%" colspan="5"  style="border-top: none !important;" >Hora de Regreso:
                      <div class="input-group date ">
                        <input class="form-control timepicker timepicker_<?php echo $counter; ?> regreso_<?php echo $counter; ?>"   id="hora_regreso_<?php echo $counter; ?>"  name="regreso" placeholder="Seleccione una hora de regreso" type="text"   onclick="mostrar_timepicker_regreso(this, '<?php echo $counter; ?>', '<?php echo $horario_permitido; ?>')"     onkeypress="return validar_solo_numeros(event, this.id, 4)" onchange="valida_hora_mayor('<?php echo $counter; ?>')" required/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                      </div>
                    </td>
                  <?php
                  } ?>

                </tr>
                <?php
              }
              $talumnos=$counter;
              ?>
            </table>
            </div>

            <table border="0" WIDTH="100%">
              <tr>
                <td WIDTH="100%" colspan="3"><br>
                  <h4><b>Informacion Adicional:</b></h4><br>
                </td>
              </tr>
              </table>

              <table border="0" WIDTH="100%">
                <tr>
                  <td colspan="2" WIDTH="100%">
                    <input id="chbox1"  type="checkbox" name="nuevo_solicitante" value="1" onchange="mostrar_new()"> Nuevo Responsable
                  </td>
                </tr>
                <tr id="old_responsable" >
                  <td colspan="2" WIDTH="100%">
                    Selección de Responsable:
                    <select class="form-control" name="" id="seleccion_responsable"  onchange="cambia_responsable()">
                      <?php
                      $first=0;
                      $first_responsable='';
                      $first_parentesco='';
                      $datos = mysqli_query ($conexion, "SELECT id,nombre,correo,tipo,responsable from usuarios WHERE numero='$familia'" );
                      while ($rows=mysqli_fetch_array($datos))
                      {

                        $idusuario=$rows['id'];
                        $nombre= $rows['nombre'];
                        $correo= $rows['correo'];
                        $responsable=$rows['responsable'];
                        // $tipo=$rows['tipo'];
                        // switch ($tipo) {
                        //   case '3':
                        //   $parentesco='Papa';
                        //     break;
                        //     case '4':
                        //     $parentesco='Mama';
                        //       break;
                        //       case '7':
                        //       $parentesco='Chofer';
                        //         break;
                        //     break;
                        // }

                        if ($first==0){
                          $first=1;
                          $first_responsable=$nombre;
                          $first_parentesco=$responsable;
                        }
                        ?>
                       <option value="<?=$idusuario?>"><?=$nombre?></option>
                       <?php
                     }
                     ?>
                    </select>
                  </td>
              </tr>
              <tr id="new_responsable">
                <td  colspan="1" WIDTH="50%" >
                  Responsable:
                  <input class="form-control" id="responsable" type="text" name="nombre_nuevo" value="<?=$first_responsable?>" placeholder="Agrege un nombre" disabled>
                </td>
                <td  colspan="1" WIDTH="50%">
                  Parentesco:
                  <input class="form-control" id="parentesco_responsable" type="text" name="parentesco_nuevo" value="<?=$first_parentesco?>" placeholder="Agrege un parentesco" disabled>
                </td>
              </tr>
            </table>


            <br><b>Motivo de la solicitud:</b>
            <textarea  class="form-control"  id="motivos"  name="motivos" placeholder="Motivo(s) del Permiso"  ></textarea>
          <!--  <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $idusuario ?>" />  -->
            <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
            <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />
          </div>
          <div class="modal-footer">
            <button type="button" onclick="Cancelar();return false;" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
            <button   id="btn_enviar_formulario" type="submit" class="btn btn-primary" name="guardar"   onclick="enviar_formulario('<?php echo $idusuario; ?>', '<?php echo $familia; ?>', 4)"><b>GUARDAR</b></button>
          </div>
        </form>
      </center>
      <?php
      }else{
      ?>
      <p class="text-danger text-center">No se ha encontrado familia con el número insertado, <a class="text-info" href="alta_extraordinarioKinder.php">Volver</a>.</p>
      <?php
      }
      ?>
      <?php
    }
    ?>

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
  <script type="text/javascript" src="js/alta_extraordinario.js"></script>
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
