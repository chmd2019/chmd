<?php
include 'sesion_admin.php';
include 'conexion.php';
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$datos = mysqli_query ( $conexion,"SELECT vp.id_permiso,vp.fecha_creacion,
vs.correo,vp.calle_numero,vp.colonia,
vp.cp,
vp.comentarios,vp.estatus,vp.nfamilia,
usu.calle,usu.colonia as colonia1,
vp.mensaje,usu.familia,
vp.responsable,
vp.parentesco,
vp.celular,
vp.telefono,
vp.fecha_inicial,
vp.fecha_final,
vp.turno,
vp.ruta,
vp.fecha_creacion,
vp.fecha_cambio,
usu.telefonomama
from
Ventana_Permisos vp
LEFT JOIN Ventana_user vs on vp.idusuario=vs.id
LEFT JOIN usuarios usu on vp.nfamilia=usu.`password`
where not vp.estatus=3 and vp.archivado=0 and vp.tipo_permiso='diario'   order by vp.id_permiso" );

if (isset ( $_POST ['nombre_nivel'] ))
{
  $nombre = $_POST ['nombre_nivel'];
  $funcion = $_POST ['funcion'];
  $mensaje= $_POST ['mensaje'];
  $status= $_POST ['status'];

  if ($nombre) {
    header ( 'Content-type: application/json; charset=utf-8' );

    //$existe = mysql_query ( "SELECT * FROM Ventana_Permiso_diario WHERE id='1'" );
    //$existe = mysql_fetch_array ( $existe );
    if ($status==3)
    {
      $query = "UPDATE Ventana_Permiso_diario SET mensaje = '$mensaje',estatus=3,archivado=1 WHERE id=$funcion";
      mysqli_query ( $query );
      $json = array (
      'estatus' => '0'
      );
    }
    else if ($status==2)
    {
      $query = "UPDATE Ventana_Permiso_diario SET mensaje = '$mensaje',estatus=2,archivado=1 WHERE id=$funcion";
      mysqli_query ( $query );
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
  <title>CHMD :: Diario</title>
  <link href="dist/css/bootstrap.css" rel="stylesheet">
  <link href="css/menu.css" rel="stylesheet">


</head>

<body>


<div class="container" id='principal'>

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
<?php $perfil_actual='diario'; include ('perfiles_dinamicos.php'); ?>
</div>
<br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->
<a href="Alta_diario.php" style="cursor: pointer;" class="btn btn-primary btn-default pull-right btn-nuevo"><span class="glyphicon glyphicon-plus"></span>
</a>
</button>
<h2>Solicitudes de diario:</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
<table class="table table-striped" id="niveles_table">
  <thead><td><b>Folio</b></td>
    <td>Fecha de Solicitud</td>

    <td><b>Estatus</b></td>
    <td><b>Fecha de permiso</b></td>
    <td><b>Familia</b></td>
    <td class="text-right"><b>Acciones</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {
      $id= $dato['id_permiso'];
      $fecha= $dato['fecha_creacion'];
      $correo= $dato['correo'];
      $estatus= $dato['estatus'];
      $calle_numero=$dato['calle_numero'];
      $colonia=$dato['colonia'];
      $cp=$dato['telefonomama'];
      $ruta=$dato['ruta'];
      $comentarios=$dato['comentarios'];

      if($estatus==1){$staus1="Pendiente";}
      if($estatus==2){$staus1="Autorizado";}
      if($estatus==3){$staus1="Cancelado";}

      $nfamila= $dato['nfamilia'];
      $calle_numero1=$dato['calle'];
      $colonia1=$dato['colonia1'];
      /*
      $alumno1=$dato['alumno1'];
      $grado1=$dato['grado1'];
      $grupo1=$dato['grupo1'];
      $alumno2=$dato['alumno2'];
      $grado2=$dato['grado2'];
      $grupo2=$dato['grupo2'];
      $alumno3=$dato['alumno3'];
      $grado3=$dato['grado3'];
      $grupo3=$dato['grupo3'];
      $alumno4=$dato['alumno4'];
      $grado4=$dato['grado4'];
      $grupo4=$dato['grupo4'];
      $alumno5=$dato['alumno5'];
      $grado5=$dato['grado5'];
      $grupo5=$dato['grupo5'];
      */
      $mensaje=$dato['mensaje'];
      $familia=$dato['familia'];
      $fecha1=$dato['fecha_inicial'];
      $frespuesta=$dato['fecha_cambio'];
      //$telefonomama=$dato['telefonomama'];
      if($fecha1==0)
      {
        $ppermiso=$fecha;
      }
      else
      {
        $ppermiso= $fecha1;
      }




      ?>
      <tr data-row="<?php echo $dato['id_permiso']?>">
        <td><?php echo $id ?></td>
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
        data-nombre1="<?php echo $correo?>"
        data-calle_numero="<?php echo $calle_numero?>"
        data-colonia="<?php echo $colonia?>"
        data-cp="<?php echo $cp?>"
        data-ruta="<?php echo $ruta?>"
        data-comentarios="<?php echo $comentarios?>"
        data-calle_numero1="<?php echo $calle_numero1?>"
        data-colonia1="<?php echo $colonia1?>"
        data-alumno1="<?php echo $alumno1?>"
        data-grado1="<?php echo $grado1?>"
        data-grupo1="<?php echo $grupo1?>"
        data-alumno2="<?php echo $alumno2?>"
        data-grado2="<?php echo $grado2?>"
        data-grupo2 ="<?php echo $grupo2?>"
        data-alumno3="<?php echo $alumno3?>"
        data-grado3="<?php echo $grado3?>"
        data-grupo3="<?php echo $grupo3?>"
        data-alumno4="<?php echo $alumno4?>"
        data-grado4="<?php echo $grado4?>"
        data-grupo4="<?php echo $grupo4?>"
        data-alumno5="<?php echo $alumno5?>"
        data-grado5="<?php echo $grado5?>"
        data-grupo5="<?php echo $grupo5?>"
        data-mensaje="<?php echo $mensaje?>"
        data-fecha1="<?php echo $ppermiso?>"
        data-frespuesta="<?php echo $frespuesta?>">
        <span class="glyphicon glyphicon-pencil">Ver</span>
      </button>

      <button class="btn-borrar btn btn-danger" type="button"
      data-id="<?php echo $id?>"
      data-nombre="<?php echo $nfamila ?>">
      <span class="glyphicon glyphicon-trash">Archivar</span>
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
  <script type="text/javascript" src="js/PDiario.js"></script>
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
            <td WIDTH="10%" >Folio:
              <input
              name="folio" id="folio" type="text" style="width : 100px; heigth : 4px"
              class="form-control" placeholder="folio"  readonly>

            </td>

            <td WIDTH="30%">Fecha de solicitud:
              <input
              name="nombre_nivel" id="nombre_nivel" type="text" style="width : 200px; heigth : 4px"
              class="form-control" placeholder="Fecha" readonly>
            </td>

            <td  WIDTH="60%">Solicitante:
              <input
              name="nombre_nivel1" id="nombre_nivel1" type="text"
              class="form-control" placeholder="Correo"  style="width : 400px; heigth : 4px" readonly>
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
          <tr>
            <td>Alumno</td>
            <td>Grado</td>
            <td>Grupo</td>
          </tr>
          <tr>

            <td>

              <input
              name="alumno1" id="alumno1" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>

            <td>
              <input
              name="grado1" id="grado1" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>
            <td>
              <input
              name="grupo1" id="grupo1" type="text"
              class="form-control" placeholder="sin datos" readonly>

            </td>
          </tr>
          <!------------------------------------------------------->
          <tr>

            <td>

              <input
              name="alumno2" id="alumno2" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>

            <td>
              <input
              name="grado2" id="grado2" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>
            <td>
              <input
              name="grupo2" id="grupo2" type="text"
              class="form-control" placeholder="sin datos" readonly>

            </td>
          </tr>
          <!-------------------------------------------------------------------->
          <tr>

            <td>

              <input
              name="alumno3" id="alumno3" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>

            <td>
              <input
              name="grado3" id="grado3" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>
            <td>
              <input
              name="grupo3" id="grupo3" type="text"
              class="form-control" placeholder="sin datos" readonly>

            </td>
          </tr>
          <!------------------------------------------------------------------>
          <tr>

            <td>

              <input
              name="alumno4" id="alumno4" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>

            <td>
              <input
              name="grado4" id="grado4" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>
            <td>
              <input
              name="grupo4" id="grupo4" type="text"
              class="form-control" placeholder="sin datos" readonly>

            </td>
          </tr>
          <!------------------------------------------------------------------------->
          <!------------------------------------------------------------------>
          <tr>

            <td>

              <input
              name="alumno5" id="alumno5" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>

            <td>
              <input
              name="grado5" id="grado5" type="text"
              class="form-control" placeholder="sin datos" readonly>
            </td>
            <td>
              <input
              name="grupo5" id="grupo5" type="text"
              class="form-control" placeholder="sin datos" readonly>

            </td>
          </tr>
          <!------------------------------------------------------------------------->
        </table>

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Domicilio de Actual:</h4>
            </td>

          </tr>
          <tr>
            <td colspan="3">
              fecha de permiso:
              <input
              name="fecha1" id="fecha1" type="text"
              class="form-control" placeholder="Calle_numero1"  style="width : 500px; heigth : 4px" readonly>
            </td>
          </tr>

        </table>
        <table border="0" WIDTH="700">
          <tr>
            <td colspan="2">
              Calle:
              <input
              name="calle_numero1" id="calle_numero1" type="text"
              class="form-control" placeholder="Calle_numero1"  style="width : 500px; heigth : 4px" readonly>
            </td>
            <td>
              Colonia:
              <input
              name="colonia1" id="colonia1" type="text"
              class="form-control" placeholder="Colonia1" readonly>
            </td>

          </tr>

        </table>

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Domicilio de cambio:</h4>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              Calle:
              <input
              name="calle_numero" id="calle_numero" type="text"
              class="form-control" placeholder="Calle_numero"  style="width : 500px; heigth : 4px" readonly>
            </td>
            <td>
              telefono mama:
              <input
              name="cp" id="cp" type="text"
              class="form-control" placeholder="Agrega cp" readonly>
            </td>

          </tr>

        </table>

        <table border="0" WIDTH="700">
          <tr>
            <td colspan="2">Colonia:
              <input
              name="colonia" id="colonia" type="text"
              class="form-control" placeholder="Colonia" readonly>
            </td>




            <td>Ruta:
              <input
              name="ruta" id="ruta" type="text"
              class="form-control" placeholder="Agrega Ruta" readonly>
            </td>
          </tr>

        </table>
        <!--



        -->

        Comentarios de solicitud:
        <textarea class="form-control"  id="comentarios" name="comentarios"  readonly></textarea>
        Comentarios de respuesta.
        <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
        <input name="funcion" id="funcion" type="text"
        class="form-control" value="0" required style="display: none;"><br>

        Fecha de Respuesta:
        <input name="frespuesta" id="frespuesta" type="text"
        class="form-control" placeholder="frespuesta" readonly>

        Accion:
        <select name="status" id="status">
          <option value="0">Selecciona</option>
          <option value="2"style="color:white;background-color:#0b1d3f;">Autotizado</option>
          <option value="3" style="color:red;background-color:yellow;">Rechazado</option>
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
