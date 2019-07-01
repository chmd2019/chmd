<?php
include 'sesion_admin.php';
include 'conexion.php';

$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$arrayDias = array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');

$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'");
require_once ('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
//$datos = mysql_query ( "select papa,calle,colonia,cp from usuarios where password='$fam'" );

if(isset($_POST['submit']))
{

  $idusuario= htmlspecialchars(trim($_POST['idusuario']));
  /*
  $alumno1 = htmlspecialchars(trim($_POST['alumno1']));
  $alumno2 = htmlspecialchars(trim($_POST['alumno2']));
  $alumno3 = htmlspecialchars(trim($_POST['alumno3']));
  $alumno4 = htmlspecialchars(trim($_POST['alumno4']));
  $alumno5 = htmlspecialchars(trim($_POST['alumno5']));
  */
  $calle = htmlspecialchars(trim($_POST['calle']));
  $colonia = htmlspecialchars(trim($_POST['colonia']));
  $cp = htmlspecialchars(trim($_POST['cp']));
  /********************/
  $responsable = htmlspecialchars(trim($_POST['responsable']));
  $parentesco = htmlspecialchars(trim($_POST['parentesco']));
  $celular = htmlspecialchars(trim($_POST['celular']));
  $telefono = htmlspecialchars(trim($_POST['telefono']));
  $fechaini = htmlspecialchars(trim($_POST['fechaini']));
  $fechater = htmlspecialchars(trim($_POST['fechater']));
  /****************/
  $ruta = htmlspecialchars(trim($_POST['ruta']));
  $comentarios = htmlspecialchars(trim($_POST['comentarios']));
  $talumnos = htmlspecialchars(trim($_POST['suma']));
  $nfamilia = htmlspecialchars(trim($_POST['nfamilia']));
  $fecha = htmlspecialchars(trim($_POST['fecha']));
  $alumnos= htmlspecialchars(trim($_POST['alumnos']));

  $tipo_permiso=2 ; //permiso Viaje.
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
  responsable,
  parentesco,
  celular,
  telefono,
  fecha_inicial,
  fecha_final
  )
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
  '".$responsable."',
  '".$parentesco."',
  '".$celular."',
  '".$telefono."',
  '".$fechaini."',
  '".$fechater."')";
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
    <title>CHMD :: Alta Diario</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
      <div class="masthead">
        <a href="cerrar_sesion.php" style="float: right; cursor: pointer;"
        role="button" class="btn btn-default btn-sm"> <span
        class="glyphicon glyphicon-user"></span> Cerrar Sesión
      </a> &nbsp <a href="menu.php">
        <button style="float: right; cursor: pointer;" type="button"
        class="btn btn-default btn-sm">
        <span class="glyphicon glyphicon-th"></span> Menu
      </button>
    </a>

    <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
    <hr>
    <?php
    $perfil_actual='viaje';
    include ('perfiles_dinamicos.php'); ?>
  </div>
  <br>
  <center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
  <!-- Button trigger modal -->
  <center>
    <h2>Nueva solicitud de Viaje:</h2>
  </center>
  <?php
  if (!$_GET)
  {
    ?>
    <form  method='get' action="Alta_viaje.php" >
      <input type="text" name="nfamilia" id="nfamilia"  placeholder="Agregar numero" size="5"  minlength="4" required>
      <input type="submit" value="Aceptar">
    </form>
    <?php
  }
  else {
    $familia=$_GET["nfamilia"];

    $datos = mysqli_query ($conexion, "SELECT id,papa,calle,colonia,cp from usuarios where password='$familia'" );
    if($rows=mysqli_fetch_array($datos))
    {
      $papa=$rows['papa'];
      $calle=$rows['calle'];
      $colonia=$rows['colonia'];
      $cp=$rows['cp'];
      $idusuario=$rows['id'];
      //$idusuario=40;
    }
    ?>
    <center>
      <form id="viaje"  name="viaje" class="form-signin save-nivel" method='post'   onsubmit='Alta_viaje(); return false'>
        <div class="alert-save"></div>
        <div class="modal-body">
          <table border="0" WIDTH="800" >
            <tr>
              <td colspan="2" WIDTH="60%">Fecha de solicitud:
                <input name="fecha" id="fecha" type="text" class="form-control" placeholder="Fecha"  value="<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>" readonly="readonly">
              </td>
              <td  WIDTH="50%">Solicitante:
                <input
                name="papa" id="papa" type="text"
                class="form-control" placeholder="Correo"  value="<?php echo $papa ?>" readonly>
              </td>
            </tr>
            <tr>
              <td WIDTH="100%" colspan="3">
                <h4>Alumnos Solicitantes:</h4><br>
              </td>
            </tr>
          </table>
          <table  style="border-style: dotted"  WIDTH="800" >
            <tr>
              <td style="text-align:center;border-style: groove">Alumno</td>
              <td style="text-align:center;border-style: groove">Grado</td>
              <td style="text-align:center;border-style: groove">Grupo</td>
              <td style="text-align:center;border-style: groove; ">Selección</td>
            </tr>
            <?php
            $counter=0;
            $existe = mysqli_query ($conexion,  "SELECT * FROM alumnoschmd where idfamilia=$familia" );
            while($cliente=mysqli_fetch_array($existe))
            {
              $counter = $counter + 1;
              ?>
              <tr id="fila-<?php echo $cliente['id'] ?>">
                <td style="border-style: outset"><?php echo $cliente['nombre']?></td>
                <td style="border-style: outset"><?php echo $cliente['grupo']?></td>
                <td style="border-style: outset"><?php echo $cliente['grado'] ?></td>
    <td style="border-style: outset"><input type="checkbox"  id="alumno<?php echo $counter?>" name="alumno[]" class="form-control" value="<?php echo $cliente['id']; ?>"></td>
              </tr>
              <?php
            }
            $talumnos=$counter;
            ?>
          </table>

          <table border="0" WIDTH="800">
            <tr>
              <td WIDTH="100%" colspan="3"><br>
                <h4><b>Dirección de Actual:</b></h4><br>
              </td>
            </tr>
            <tr>
              <td >
                Calle y Número: :
                <input
                name="calle1" id="calle1" type="text"
                class="form-control" placeholder="Calle_numero"  style="width : 500px; heigth : 4px" value="<?php echo $calle ?>" readonly="" >
              </td>
              <td>
                Colonia:
                <input
                name="cp1" id="colonia1" type="text"
                class="form-control" placeholder="Colonia1" value="<?php echo $colonia ?>" readonly="" >
              </td>

              <td>
                CP:
                <input
                name="cp1" id="cp1" type="text"
                class="form-control" placeholder="cp" value="<?php echo $cp ?>" readonly="" >
              </td>

            </tr>


            <tr>
              <td WIDTH="100%" colspan="3"><br>
                <h4><b>Dirección de cambio:</b></h4>
              </td>
            </tr>
            <tr>
              <td >
                Calle:
                <input
                name="calle" id="calle" type="text"
                class="form-control" placeholder="Calle_numero"  style="width : 500px; heigth : 4px" >
              </td>
              <td colspan="2">
                CP:
                <input
                name="cp" id="cp" type="text"
                class="form-control" placeholder="Agrega cp" style="width : 300px; heigth : 4px" >
              </td>
            </tr>
            <tr>
              <td colspan="2"><br>Colonia:
                <input
                name="colonia" id="colonia" type="text"
                class="form-control" placeholder="Colonia" >
              </td>

              <td><br>Ruta:
                <select type="select" name="ruta"  id="ruta" class="form-control">
                  <option value="0">selecciona opción </option>
                  <option value="General 2:50 PM">General 2:50 PM</option>
                  <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                </td>
              </tr>
            </table>
            <h4><b>Datos Responsable:</b></h4>
            <table border="0" WIDTH="800">
              <tr>
                <td>
                  Nombre:
                  <input class="form-control"  name="responsable" type="text"  id="responsable" placeholder="Obligatorio" required />
                </td>

                <td>
                  Parentesco:
                  <input class="form-control"  name="parentesco" type="text"  id="parentesco" placeholder="Obligatorio" required />
                </td>

              </tr>
              <tr>
                <td>
                  Celular:
                  <input class="form-control"  name="celular" type="number"  id="celular"  pattern="[0-9]{10}" placeholder="Agrega 10 digitos" required />
                </td>

                <td>
                  Telefono:
                  <input class="form-control"  name="telefono" type="number"  id="telefono"   pattern="[0-9]{8}" placeholder="Agrega 8"digitos required />
                </td>
              </tr>

              <tr>
                <td>
                  Fecha Inicial:
                  <input class="form-control" id="fechaini" name="fechaini" type="date" min="2017-08-20" max="2018-07-20" required/>
                </td>
                <td>
                  Fecha Final:
                  <input class="form-control" id="fechater" name="fechater" type="date" min="2017-08-20" max="2018-07-20" required/>
                </td>
              </tr>
            </table>

            <br><b>Comentarios de solicitud:</b>
            <textarea class="form-control"  id="Comentarios" name="comentarios"  ></textarea>

            <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $idusuario ?>" />
            <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
            <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />

          </div>
          <div class="modal-footer">
            <button type="button" onclick="Cancelar();return false;" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
          </div>
        </form>
      </center>

      <?php
    }
    ?>



    <!-- Site footer -->
    <div class="footer">
      <p>&copy; Aplicaciones CHMD 2017</p>
    </div>

  </div>


  <!-- /container -->


  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript"
    src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/Alta_viaje.js"></script>
  </body>
  </html>
  <?php
}
?>
