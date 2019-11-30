
<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('14', $capacidades)){
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
      <title>CHMD :: Alta Eventos</title>
      <link href="../dist/css/bootstrap.css" rel="stylesheet">
      <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <link href="../css/menu.css" rel="stylesheet">
      <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.css">
   <!-- CSS Dependencies -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap">

    </head>
    <body>
       <?php include_once "../components/navbar.php"; ?>
        <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_eventos.php'); ?>
      <div class="container-fluid">
        <div class="masthead">
      </div>
    <br>
    <center><?php // echo isset($_POST['guardar']) ? $verificar=1 : '' ; ?></center>
    <!-- Button trigger modal -->
     <a href="Peventos.php" style="cursor: pointer;margin: 2px" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Nueva solicitud de Eventos de bachillerato:</h2>
    </center>
    <?php
    //  $familia=$_GET["nfamilia"];
    //  $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
    $solicitante = $user_session;
    $datos = mysqli_query ($conexion, "SELECT id, usuario  from Administrador_usuarios WHERE id='$solicitante' LIMIT 1" );
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
                    $idusuario=$rows['id'];
                    $nombre= $rows['usuario'];
                    ?>
                    <option value="<?=$idusuario?>"><?=$nombre?></option>
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
              <td colspan="1" WIDTH="50%">Fecha del Evento:
                <div class="input-group date datepicker"   >
                  <input class="form-control " size="15"   id="fecha_permiso"  name="fecha_permiso"    placeholder="Seleccione una fecha" type="text"   disabled required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </td>
              <td colspan="1" WIDTH="50%">Tipo de Evento:
                <div class="input-group"   >
                  <input class="form-control" name="tipo_evento" id="tipo_evento" type="text" placeholder="Agregar el Tipo de Evento" value="">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                </div>
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
                  onclick="mostrar_timepicker_salida(this,'<?php //echo $horario_permitido; ?>')"
                  onkeypress="return validar_solo_numeros(event, this.id, 4)" required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </td>
              <?php
              // if ($grado_escolaridad >= 11 && $grado_escolaridad <= 17) {
              ?>
              <td  WIDTH="50%" colspan="1">Hora de Regreso:
                <div class="input-group date ">
                  <input class="form-control timepicker timepicker regreso"   id="hora_regreso"  name="regreso" placeholder="Seleccione una hora de regreso" type="text"   onclick="mostrar_timepicker_regreso(this, '<?php// echo $horario_permitido; ?>')"     onkeypress="return validar_solo_numeros(event, this.id, 4)" required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </td>
              <?php
              //  }
              ?>

            </tr>
          </table>


          <table border="0" WIDTH="100%">
            <tr id="new_responsable">
              <td  colspan="1" WIDTH="50%" >
                Responsable:
                <input class="form-control" id="responsable" type="text" name="nombre_nuevo" value="" placeholder="Agrege un nombre" >
              </td>
              <td  colspan="1" WIDTH="50%">
                Parentesco:
                <input class="form-control" id="parentesco_responsable" type="text" name="parentesco_nuevo" value="" placeholder="Agrege un parentesco" >
              </td>
            </tr>
          </table>

          <br>
          <table border="0" WIDTH="100%">
            <tr>
              <td colspan="2" WIDTH="100%">
                <input id="chbox2"  type="checkbox" name="ingresa_transporte" value="1" onchange="mostrar_transporte()"> Ingresar Transporte
              </td>
            </tr>

            <tr id="new_transporte" hidden>
              <td  colspan="1" WIDTH="100%" >
                Empresa:
                <input class="form-control" id="empresa" type="text" name="empresa" value="" placeholder="Agregar empresa" >
              </td>
            </tr>
          </table>

          <br><b>Motivo de la solicitud:</b>
          <textarea  class="form-control"  id="motivos"  name="motivos" placeholder="Motivo(s) del Permiso"  ></textarea>
          <!--  <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $idusuario ?>" />  -->
          <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
          <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />
        </div>

        <table border="0" WIDTH="100%">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4 class=""><b>Lstado de Alumnos registrados:</b></h4><br>
            </td>
          </tr>
        </table>
        <table  class="text-center"  WIDTH="100%" style="border:1px solid #ddd" >
          <thead style="background:#eee" >
            <td  style="border-left: 2px solid #fff" WIDTH="10%" colspan="1"><b>Id</b></td>
            <td style="border-left: 2px solid #fff" WIDTH="40%" colspan="4"><b>Alumno</b></td>
            <td style="border-left: 2px solid #fff" WIDTH="30%" colspan="3" ><b>Grado</b></td>
            <td style="border-left: 2px solid #fff" WIDTH="20%" colspan="2"><b>Grupo</b></td>
          </thead>
          <tbody id="lista_alumnos" >
            <!-- Lista de alumnos-->
          </tbody>
        </table>

        <div class="modal-footer" style="border:none">
          <button type="button" class="btn btn-danger" onclick="cancelar()">CANCELAR</button>
          <button type="button" class="btn btn-primary" onclick="enviar_formulario(1,1,1)"><b>GUARDAR</b></button>
        </div>
        <br>
        <table border="0" WIDTH="100%">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4 class=""><b>Seleccionar Alumnos:</b></h4><br>
            </td>
          </tr>
        </table>

        <input type="text" class="form-control filter"
        placeholder="Buscar Solicitud..."><br> <br>

        <table WIDTH="100%" >
          <thead>
            <th WIDTH="40%" colspan="4">Alumno</th>
            <th WIDTH="30%" colspan="3" style="">Grado</th>
            <th WIDTH="20%" colspan="2" style="">Grupo</th>
            <th WIDTH="10%" colspan="1" style="">Selección</th>
          </thead>
          <tbody class="searchable " >
            <tr>
              <td WIDTH="100%" colspan="10"><hr> </td>
            </tr>
          <?php
          $counter=-1;
          $sql =  "SELECT * FROM alumnoschmd WHERE  id_nivel='3' order by idcursar limit 10";
          $existe = mysqli_query ($conexion, $sql );
          while($alumno = mysqli_fetch_array($existe))
          {
            $counter = $counter + 1;
            $id_alumno = $alumno['id'];
            $id_nivel = $alumno['id_nivel'];
            $idcursar = $alumno['idcursar'];
            $grado_escolaridad = $alumno['idcursar'];
            $foto= $alumno['foto'];
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

            //fotografia
            $foto = str_replace("C:\IDCARDDESIGN\CREDENCIALES\alumnos\\", '', $foto);
            $foto="$root_imagenes/CREDENCIALES/alumnos/$foto";

            $foto1="Con Foto";
            if($foto==null || is_file($foto)){
              $foto="sinfoto.png";
              $foto1="Sin foto";
            }

            ?>
            <tr id="fila-<?php echo $alumno['id'] ?>">
              <td id="nombre_<?=$alumno['id']?>"  WIDTH="40%" colspan="4"><?php echo $alumno['nombre']?></td>
              <td id="grado_<?=$alumno['id']?>" WIDTH="30%" colspan="3"><?php echo $alumno['grado']?></td>
              <td id="grupo_<?=$alumno['id']?>" WIDTH="20%" colspan="2"><?php echo $alumno['grupo'] ?></td>
              <td  class="checks-alumnos" WIDTH="10%" colspan="1" id="imagen_<?=$alumno['id']?>"  onclick="enlistar_alumno(<?php echo $alumno['id'] ?>)">
                <img style="border: 1px solid #aaa; padding: 2px" src='<?php echo $foto ?>' alt="<?=$foto1?>" width="150px">
              </td>
            </tr>
            <tr>
              <td WIDTH="100%" colspan="10"><hr> </td>
            </tr>
            <input  hidden value="<?php echo $idcursar; ?>" id="idcursar_alumno_<?php echo $counter; ?>">
            <?php
          }
          $talumnos=$counter;
          ?>
          </tbody>
        </table>
      </form>
    </center>

  </div>

   <!-- Site footer -->
    <?php include_once "../components/footer.php"; ?>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">


  </script>
  <script type="text/javascript"
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="js/alta_eventos_bachillerato.js"></script>
  <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
  <script src="https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.min.js"></script>

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
