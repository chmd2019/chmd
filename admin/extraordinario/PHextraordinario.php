<?php
include '../sesion_admin.php';
include '../conexion.php';
$year=date('Y');
$mes=date('m');
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'");
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';

if (isset ( $_POST ['nombre_nivel'] ))
{
  $nombre = $_POST ['nombre_nivel'];
  $funcion = $_POST ['funcion'];
  $mensaje= $_POST ['mensaje'];
  $estatus= $_POST ['estatus'];
  if ($nombre) {
    header ( 'Content-type: application/json; charset=utf-8' );
    //$existe = mysql_query ( "SELECT * FROM Ventana_Permiso_diario WHERE id='1'" );
    //$existe = mysql_fetch_array ( $existe );
    if ($estatus==3)
    {
      $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=3 WHERE id_permiso=$funcion";
      mysqli_query ( $conexion, $query );
      $json = array (
      'estatus' => '0'
      );
    }
    else if ($estatus==2)
    {
      $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=2 WHERE id_permiso=$funcion";
      mysqli_query ( $conexion, $query );
      $json = array (
      'estatus' => '0'
      );
    } elseif ($existe)
    {
      $json = array (
      'estatus' => '-1'
      );
    }
  }
  echo json_encode ( $json );
  exit ();
}

$sql = "SELECT vp.id_permiso, vp.fecha_creacion, usu.correo,
vp.responsable, vp.parentesco,
vp.comentarios, vp.estatus, vp.nfamilia,
vp.mensaje, usu.familia, vp.fecha_cambio, vp.fecha_respuesta
from
Ventana_Permisos vp
LEFT JOIN usuarios usu on vp.idusuario=usu.id
where vp.tipo_permiso='4' and vp.archivado=1 and YEAR(vp.fecha_respuesta)='$year' and MONTH(vp.fecha_respuesta)='$mes'  order by vp.id_permiso desc";
$datos = mysqli_query ($conexion, $sql );
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
  <title>CHMD :: Historial Kinder</title>
  <link href="../dist/css/bootstrap.css" rel="stylesheet">
  <link href="../css/menu.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="masthead">
    <a href="../cerrar_sesion.php" style="float: right; cursor: pointer;"
    role="button" class="btn btn-default btn-sm"> <span
    class="glyphicon glyphicon-user"></span> Cerrar Sesión
  </a> &nbsp <a href="../menu.php">
    <button style="float: right; cursor: pointer;" type="button"
    class="btn btn-default btn-sm">
    <span class="glyphicon glyphicon-th"></span> Menu
  </button>
</a>
<h3 class="text-muted">Colegio Hebreo Maguén David</h3>
<hr>
<?php $perfil_actual='Historial de Extraordinarios';
      include ("../menus_dinamicos/perfiles_dinamicos_historico.php");
 ?>
</div>
<br>
<center><?php echo isset($_POST['guardar']) ? $verificar : '' ; ?></center>
<!-- Button trigger modal -->
</a>
</button>
<h2>Historial de Extraordinarios</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
<table class="table table-striped" id="niveles_table">
  <thead>
    <td><b>Folio</b></td>
    <td><b>Nfamilia</b></td>
    <td><b>Fecha</b></td>
    <td><b>Estatus</b></td>
    <td><b>Fecha Programada</b></td>
    <td><b>Familia</b></td>
    <td class="text-right"><b>Acciones</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
      <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id= $dato['id_permiso'];
      $nfamilia= $dato['nfamilia'];
      $familia=$dato['familia'];
      $correo= $dato['correo'];
      $fecha= $dato['fecha_creacion'];
      $responsable =$dato['responsable'];
      $parentesco=$dato['parentesco'];

      $estatus= $dato['estatus'];
      if($estatus==1){$staus1="Pendiente";}
      if($estatus==2){$staus1="Autorizado";}
      if($estatus==3){$staus1="Declinado";}
      if($estatus==4){$staus1="Cancelado por el usuario";}

      $comentarios=$dato['comentarios'];
      $mensaje=$dato['mensaje'];

      $fecha_cambio=$dato['fecha_cambio'];
      $frespuesta=$dato['fecha_respuesta'];

  /*  if($fecha_cambio==0)
      {
        $ppermiso=$fecha;
      }
      else
      {
        $ppermiso= $fecha_cambio;
      }*/

      $ppermiso= $fecha_cambio;
      ?>
      <tr data-row="<?php echo $dato['id_permiso']?>">
        <td><?php echo $id ?></td>
        <td><?php echo $nfamilia ?></td>
        <td><?php echo $fecha?></td>
        <td><?php echo $staus1?></td>
        <td><?php echo $ppermiso?></td>
        <td><?php echo $familia?></td>
        <td class="text-right">
          <!--
            <button class="btn-autorizar btn btn-success" type="button"
            data-id="<?php echo $id?>"
            data-nombre="<?php echo $nfamila?>">
            <span class="glyphicon glyphicon-cloud">Autorizar</span>
          </button>
        -->
        <button data-target="#agregarNivel" data-toggle="modal"
        class="btn-editar btn btn-primary" type="button"
        data-id="<?php echo $id?>"
        data-nombre="<?php echo $fecha?>"
        data-correo="<?php echo $correo?>"
        data-fechacambio="<?php echo $ppermiso?>"

        data-responsable="<?php echo $responsable?>"
        data-parentesco="<?php echo $parentesco?>"
        data-comentarios="<?php echo $comentarios?>"

        data-mensaje="<?php echo $mensaje?>"
        data-frespuesta="<?php echo $frespuesta?>"
        data-estatus="<?php echo $estatus?>">
        <span class="glyphicon glyphicon-pencil">Ver</span>
      </button>
      <!--
        <button class="btn-borrar btn btn-danger" type="button"
        data-id="<?php echo $id?>"
        data-nombre="<?php echo $nfamila ?>">
        <span class="glyphicon glyphicon-trash">Cancelar</span>
      </button>

      <!--
        <a href="grado.php?qwert=<?php echo $dato['id']?>&amp;nombre=<?php echo $dato['nombre']?>"
          style="cursor: pointer;"><img src="img/pdf.png" width="40" height="40"/>
        </a>-->
      </td>
    </tr>
  <?php }?>
</tbody>
</table>
<!-- Site footer -->
<div class="footer">
  <p>&copy; Aplicaciones CHMD 2019</p>
</div>

</div>
<!-- /container -->


<!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript"
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="js/PHextraordinario.js"></script>
<script type="text/javascript" src="../js/1min_inactivo.js" ></script>
</body>
</html>

<!-- Modal -->
<div class="modal fade" id="agregarNivel" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="width: 800px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="modalNivelTitulo">Agrega Solicitud</h4>
    </div>
    <form class="form-signin save-nivel" method='post'>
      <div class="alert-save"></div>
      <div class="modal-body">
        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="10%" colspan="1" >Folio:
              <input
              name="folio" id="folio" type="text"
              class="form-control" placeholder="folio"  readonly>
            </td>
            <td WIDTH="90%" colspan="9">Fecha de solicitud:
              <input
              name="nombre_nivel" id="nombre_nivel" type="text"
              class="form-control" placeholder="Fecha" readonly>
            </td>
          </tr>
          <tr>
              <td WIDTH="50%" colspan="5">Fecha del Permiso:
                <input
                name="fechacambio" id="fechacambio" type="text"
                class="form-control" placeholder="Fecha" readonly>
              </td>
            <td WIDTH="50%" colspan="5">Solicitante:
              <input
              name="solicitante" id="solicitante" type="text"
              class="form-control" placeholder="Correo"  readonly>
            </td>
          </tr>
        </table>

        <table>

          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Solicitantes:</h4>
            </td>
          </tr>

        </table>
        <table border="0" WIDTH="700">
          <tr style="background:#eee;">
            <th  WIDTH="40%" colspan="4">Alumno</th>
            <th  WIDTH="30%" colspan="3">Nivel</th>
            <th  WIDTH="30%" colspan="3">Estatus</th>
          </tr>
          <!------------------------------------------------------------------------->
        </table>
        <table id="tabla_alumnos" border="0" WIDTH="700">
          <!-------------------------- Tabla de  Alumnos ----------------------------------------------->
        </table>
        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="2">
              <h4>Información Adicional:</h4>
            </td>
          </tr>
          <tr>
            <td width="50%" colspan="1">
              Responsable:
              <input
              name="responsable" id="responsable" type="text"
              class="form-control" placeholder="Sin responsable"   readonly>
            </td>
            <td width="50%" colspan="1">
              Parentesco:
              <input
              name="parentesco" id="parentesco" type="text"
              class="form-control" placeholder="Sin parentesco"   readonly>
            </td>
          </tr>
        </table>

      </table>
      Motivo:
      <textarea class="form-control"  id="comentarios" name="comentarios"  readonly></textarea>
      Comentarios de respuesta.
      <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
      <input name="funcion" id="funcion" type="text"
      class="form-control" value="0" required style="display: none;"><br>

      Fecha de Respuesta:
      <input name="frespuesta" id="frespuesta" type="text"
      class="form-control" placeholder="frespuesta" readonly><br>
      Accion:
      <select name="estatus" id="estatus">
        <option value="0">Selecciona</option>
        <option value="2"style="color:white;background-color:#0b1d3f;">Autorizado</option>
        <option value="3" style="color:red;background-color:yellow;">Declinado</option>
      </select>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
    </div>
  </form>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
