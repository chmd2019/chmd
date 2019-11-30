<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('4', $capacidades)){
    header('Location: ../menu.php');
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
      <title>CHMD :: Inscripción a Eventos</title>
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
       <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>EVENTOS</h3>
        </div>
        
                <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_eventos.php'); ?>
        
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
    <a href="Peventos.php" style="cursor: pointer;margin: 2px" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Inscripción a Eventos por Familia</h2>
    </center>
    <?php
    if (!$_GET)
    {
      ?>
       <form class="" role="search" method='get' action="inscripcion_eventos.php">
         <div class="form-row">
           <div class="col-sm-4 p-2">
             <input type="text" class="form-control"  name="nfamilia" id="nfamilia" placeholder="Número de Familia" size="30"  minlength="4" required>
           </div>
           <div class = "col-sm-4 p-2">
             <input type="text" class="form-control" name="codigo_evento" id="codigo_evento"  placeholder="Codigo de Eventos" size="30"  minlength="6" maxlength="6" required>
           </div>
           <div class="col-sm-3 p-2 text-center">
             <button type="submit" class="btn btn-primary">
               <span class="glyphicon glyphicon-search"></span>
               <b> BUSCAR</b>
             </button>
           </div>
         </div>
       </form>

      <hr width="100%">

      <?php
    }else {
      $familia=$_GET["nfamilia"];
      $codigo_evento=$_GET["codigo_evento"];
      $datos_eventos = mysqli_query ($conexion, "SELECT id_permiso,  fecha_cambio, codigo_invitacion, tipo_evento, responsable, parentesco, empresa_transporte, comentarios, idusuario FROM Ventana_Permisos WHERE  codigo_invitacion='$codigo_evento' LIMIT 1; ");
      if ($permiso_evento = mysqli_fetch_assoc($datos_eventos)){
          $id_permiso = $permiso_evento['id_permiso'];
          $fecha_evento = $permiso_evento['fecha_cambio'];
          $codigo_evento  = $permiso_evento['codigo_invitacion'];
          $tipo_evento  =  $permiso_evento['tipo_evento'];
          $responsable = $permiso_evento['responsable'];
          $parentesco = $permiso_evento['parentesco'];
          $empresa_transporte = $permiso_evento['empresa_transporte'];
          $comentarios = $permiso_evento['comentarios'];
          $id_usuario = $permiso_evento['idusuario'];

          //Datos de usuario
          $datos_usuario = mysqli_query ($conexion, "SELECT nombre,familia  from usuarios WHERE id = '$id_usuario'" );
          if ($usuario  = mysqli_fetch_assoc($datos_usuario) ){
              $solicitante = $usuario['nombre'];
              $familia_anfitiona  = $usuario['familia'];
          }
          ?>

      <center>
        <form id="eventos"  name="eventos" class="form-signin save-nivel"   >
          <div class="alert-save"></div>
          <div class="modal-body">

            <table border="0" WIDTH="100%" >
              <tr>
                <td colspan="1" WIDTH="50%">Fecha del Evento:
                  <div class="input-group"   >
                    <input name="fecha_evento" id="fecha_evento" type="text" class="form-control" placeholder="fecha del evento"  value="<?=$fecha_evento?>" readonly="readonly">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </td>
                <td colspan="1" WIDTH="50%">Codigo del Evento:
                  <input class="form-control" type="text" name="codigo_evento" value="<?=$codigo_evento?>" disabled>
                </td>
              </tr>
              <tr>
                <td colspan="1" WIDTH="50%">Familia Anfitriona:
                  <input name="familia_anfitiona" id="familia_anfitiona" type="text" class="form-control" placeholder="Familia Anfitriona"  value="<?=$familia_anfitiona?>" readonly="readonly">
                </td>
                <td colspan="1" WIDTH="50%">Tipo de Evento:
                    <div class="input-group"   >
                      <input class="form-control" type="text" name="tipo_evento" value="<?=$tipo_evento?>" disabled>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></span>
                  </div>
                </td>
              </tr>
              </table>
              <br>

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

            <table    WIDTH="100%" >
              <tr>
                <td WIDTH="100%" colspan="10">
                  <h4 class=""><b>Alumnos Inscritos:</b></h4><br>
                </td>
              </tr>
              </table>
              <table class="table">
              <thead>
              <tr>
                <th WIDTH="90%" colspan="9">Alumno</th>
                <th WIDTH="10%" colspan="1" style="">Inscripción</th>
              </tr>
              </thead>
                
              <?php
              $counter=-1;
              $lista_alumnos_inscritos=array();
              $sql="SELECT alu.nombre, vpa.id_alumno,alu.id_nivel FROM Ventana_permisos_alumnos vpa
              INNER JOIN alumnoschmd alu ON alu.id=vpa.id_alumno
              Where vpa.codigo_invitacion='$codigo_evento' and  vpa.familia=$familia";
              $alumnos_inscriptos = mysqli_query ($conexion, $sql );
              while($alumno=mysqli_fetch_array($alumnos_inscriptos))
              {
                $counter = $counter + 1;
                $id_alumno = $alumno['id_alumno'];
                $id_nivel= $alumno['id_nivel'];
                $nombre_alumno= $alumno['nombre'];
                array_push($lista_alumnos_inscritos, $id_alumno);

                $show=false;
                //kinder
                if (in_array('19', $capacidades) && $id_nivel=='1') $show=true;
                //Primaria
                if (in_array('20', $capacidades) && $id_nivel=='2') $show=true;
                //bachillerato
                if (in_array('21', $capacidades) && $id_nivel=='3') $show=true;
                //mostrar
                if ($show){
                  ?>
                  <input hidden value="<?php echo $idcursar; ?>" id="idcursar_alumno_<?php echo $counter; ?>">
                  <tr id="fila-<?php echo $alumno['id'] ?>">
                    <td  WIDTH="90%" colspan="9"><?=$nombre_alumno?></td>
                    <td  class="" WIDTH="10%" colspan="1">
                      <button class="form-control btn btn-danger" type="button" name="button" onclick="cancelar_inscripcion( <?=$id_permiso?>,<?=$id_alumno?>)">CANCELAR</button>
                    </td>
                  </tr>
                  <?php
                }
              }
              if ($counter=='-1'){
                ?>
              <tr>
                  <td WIDTH="100%" colspan="10" > Sin alumnos Inscritos Para este Evento.</td>
              </tr>
                <?php
              }
              $talumnos=$counter;
              ?>
            </table>
            <table border="0" WIDTH="100%">
              <tr>
                <td WIDTH="100%" colspan="3">
                    <h4 class=""><b>Alumnos para Inscribir:</b></h4><br>
                </td>
              </tr>
            </table>
            <div class="table-responsive">
            <table  class="table"   WIDTH="100%" >
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
              $alumnos_inscriptos = mysqli_query ($conexion, "SELECT * FROM alumnoschmd where idfamilia=$familia" );
              while($alumno=mysqli_fetch_array($alumnos_inscriptos) )
              {
                $id_alumno = $alumno['id'];
                if (!in_array($id_alumno, $lista_alumnos_inscritos)){
                  $counter = $counter + 1;
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
                  $show=false;
                  //kinder
                  if (in_array('19', $capacidades) && $id_nivel=='1') $show=true;
                  //Primaria
                  if (in_array('20', $capacidades) && $id_nivel=='2') $show=true;
                  //bachillerato
                  if (in_array('21', $capacidades) && $id_nivel=='3') $show=true;
                  //mostrar
                  if ($show){
                  ?>
                  <input hidden value="<?php echo $idcursar; ?>" id="idcursar_alumno_<?php echo $counter; ?>">
                  <tr id="fila-<?php echo $alumno['id'] ?>">
                    <td  WIDTH="40%" colspan="4"><?php echo $alumno['nombre']?></td>
                    <td  WIDTH="30%" colspan="3"><?php echo $alumno['grado']?></td>
                    <td  WIDTH="20%" colspan="2"><?php echo $alumno['grupo'] ?></td>
                    <td  class="checks-alumnos" WIDTH="10%" colspan="1">
                      <input class="form-control micheckbox" type="checkbox"   id="alumno_<?php echo $counter; ?>" name="alumno[]"   value="<?php echo $alumno['id']; ?>">
                    </td>
                  </tr>
                  
                  <?php
                  }
                }
              }
              if ($counter=='-1'){
                ?>
              <tr>
                  <td WIDTH="100%" > Sin Alumnos para Inscribir.</td>
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
                  <td  colspan="1" WIDTH="50%" >
                    Solicitante:
                    <input class="form-control" id="solicitante" type="text" name="solicitante" value="<?=$solicitante?>" placeholder="Sin solicitante" disabled>
                  </td>
                  <td  colspan="1" WIDTH="50%">
                    Empresa de Transporte:
                    <input class="form-control" id="empresa_transporte" type="text" name="empresa_transporte" value="<?=$empresa_transporte?>" placeholder="Sin empresa de Transporte" disabled>
                  </td>
                </tr>
              <tr>
                <td  colspan="1" WIDTH="50%" >
                  Nombre de Responsable:
                  <input class="form-control" id="responsable" type="text" name="responsable" value="<?=$responsable?>" placeholder="Sin responsable" disabled>
                </td>
                <td  colspan="1" WIDTH="50%">
                  Parentesco de Responsable:
                  <input class="form-control" id="parentesco_responsable" type="text" name="parentesco_nuevo" value="<?=$parentesco?>" placeholder="Sin Parentesco" disabled>
                </td>
              </tr>
              </table>

            <br><b>Motivo de la solicitud:</b>
            <textarea  class="form-control"  id="motivos"  name="motivos" placeholder="Motivo(s) del Permiso"  disabled><?=$comentarios?></textarea>
          <!--  <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $idusuario ?>" />  -->
            <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
            <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />
          </div>
          <div class="modal-footer">
            <button type="button" onclick="Cancelar();return false;" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
            <button   id="btn_enviar_formulario" type="button" class="btn btn-primary" name="guardar"   onclick="enviar_formulario('<?php echo $codigo_evento; ?>', '<?php echo $familia; ?>','<?php echo $id_permiso; ?>' )"><b>GUARDAR</b></button>
          </div>
        </form>
      </center>

      <?php
    }else{
      ?>
      <p class="text-danger text-center">No existe Evento registrado con el codigo insertado, <a class="text-info" href="inscripcion_eventos.php">Volver</a>.</p>
      <?php
    }
    ?>
      <?php
    }
    ?>

  </div>

 <!-- Site footer -->
    <?php include_once "../components/footer.php"; ?>
 </div>
    <div class="overlay"></div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script type="text/javascript" src="js/inscripcion_eventos.js"></script>

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
<?php
}
