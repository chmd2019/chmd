<?php
include '../sesion_admin.php';
include '../conexion.php';
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$datos = mysqli_query ( $conexion,"SELECT vp.id_permiso,vp.fecha_creacion,
  usu.correo,vp.calle_numero,vp.colonia,
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
  vp.ruta,
  vp.fecha_creacion,
  vp.fecha_respuesta
  from
  Ventana_Permisos vp
  LEFT JOIN usuarios usu on vp.idusuario=usu.id
  where not vp.estatus=3 and vp.archivado=0 and vp.tipo_permiso='2' order by vp.estatus DESC ,vp.id_permiso" );

  if (isset ( $_POST ['nombre_nivel'] )) {

    $nombre = $_POST ['nombre_nivel'];
    $funcion = $_POST ['funcion'];
    $mensaje= $_POST ['mensaje'];
    $estatus= $_POST ['estatus'];

    if ($nombre) {
      header ( 'Content-type: application/json; charset=utf-8' );

      //$existe = mysql_query ( "SELECT * FROM nivel WHERE nombre='$nombre'" );
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
      } elseif ($existe) {
        $json = array (
        'estatus' => '-1'
        );
      }
    } else {
      $json = array (
      'estatus' => '0'
      );
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
      <title>CHMD :: Temporal</title>
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
<?php
$perfil_actual='viaje';
 include ('../menus_dinamicos/perfiles_dinamicos_solicitudes.php'); ?>
</div>
<br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->
<a href="Alta_viaje.php" style="cursor: pointer;" class="btn btn-primary btn-default pull-right btn-nuevo"><span class="glyphicon glyphicon-plus"></span>
</a>
<h2>Solicitudes Temporales:</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
<table class="table" id="niveles_table">
  <thead><td><b>Folio</b></td>
    <td><b>Fecha</b></td>

    <td><b>Estatus</b></td>
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
      $cp=$dato['cp'];

      $responsable=$dato['responsable'];
      $parentesco=$dato['parentesco'];
      $celular=$dato['celular'];
      $telefono=$dato['telefono'];

      $fecha_inicial=$dato['fecha_inicial'];
      $fecha_final=$dato['fecha_final'];

      $comentarios=$dato['comentarios'];

      if($estatus==1){$staus1="Pendiente";}
      if($estatus==2){$staus1="Autorizado";}
      if($estatus==3){$staus1="Declinado";}
      if($estatus==4){$staus1="Cancelado por el usuario";}

      $nfamila= $dato['nfamilia'];
      $calle_numero1=$dato['calle'];
      $colonia1=$dato['colonia1'];
      $mensaje=$dato['mensaje'];
      $familia=$dato['familia'];
      $ruta=$dato['ruta'];
      $fecha_respuesta = $dato['fecha_respuesta'];


      $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
      $array1 = explode(',' , $fecha_inicial );
      $array2= explode(' ',$array1[1]);
      $dia= $array2[1];
      $mes= '';
      switch ($array2[3]) {
            case 'Enero':
            $mes=1;
            break;
            case 'Febrero':
            $mes=2;
            break;
            case 'Marzo':
            $mes=3;
            break;
            case 'Abril':
            $mes=4;
            break;
            case 'Mayo':
            $mes=5;
            break;
            case 'Junio':
            $mes=6;
            break;
            case 'Julio':
            $mes=7;
            break;
            case 'Agosto':
            $mes=8;
            break;
            case 'Septiembre':
            $mes=9;
            break;
            case 'Octubre':
            $mes=10;
            break;
            case 'Noviembre':
            $mes=11;
            break;
            case 'Diciembre':
              $mes=12;
            break;
            default:
            $mes = -1;
          break;
      }
      $anio= $array2[5] % 100;
      $_fecha_inicial= $mes.'/'.$dia.'/'.$anio;
      $fecha_entrada = strtotime($_fecha_inicial);

      if($fecha_actual > $fecha_entrada){
            $otro_dia=false;
      }else{
            $otro_dia=true;
      }

      //alumnos
  /*    $array_alumnos= array();
      $alumnos= mysqli_query($conexion,"SELECT * FROM Ventana_permisos_alumnos where id_permiso='$id'");
      while($alumno = mysqli_fetch_assoc ( $alumnos ) ){
        array_push($array_alumnos, $alumno['id_alumno']);
      }
*/

       if ($otro_dia==true){
        $color = '#ddd';
        $borde= '#ddd';
      }else{
        $color = '#fff';
        $borde= '#ddd';
      }
      if ($estatus==4){
        $color = '#ffd5d5';
        $borde= '#ffb1b1';
      }
      ?>

      <tr  style="background:<?=$color?>; border-bottom:  1px solid <?=$borde?>"  data-row="<?php echo $dato['id_permiso']?>">
        <td><?php echo $id ?></td>
        <td><?php echo $fecha?></td>
        <td><?php echo $staus1?></td>
        <td><?php echo $familia?></td>

        <td class="text-right">

          <!--	<button class="btn-autorizar btn btn-success" type="button"
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
        data-fecha_inicial="<?php echo $fecha_inicial?>"
        data-fecha_final="<?php echo$fecha_final?>"
        data-comentarios="<?php echo $comentarios?>"
        data-calle_numero1="<?php echo $calle_numero1?>"
        data-colonia1="<?php echo $colonia1?>"
        data-mensaje="<?php echo $mensaje?>"
        data-responsable="<?php echo $responsable?>"
        data-parentesco="<?php echo $parentesco?>"
        data-celular="<?php echo $celular?>"
        data-telefono="<?php echo $telefono?>"
        data-ruta="<?php echo $ruta?>"
        data-estatus ="<?php echo $estatus?>">

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
      </a>
    -->
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
  <script type="text/javascript" src="js/PViaje.js"></script>
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
          </table>

        <table id="tabla_alumnos" border="0" WIDTH="700">
          <!----------------------------- Tabla de  Alumnos -------------------------------------------->
        </table>

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Domicilio de Actual:</h4>
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
            <td>Fecha Inicial:
              <input
              name="fecha_inicial" id="fecha_inicial" type="text"
              class="form-control" placeholder="Fecha inicial" readonly>
            </td>
            <td> </td>
            <td>Fecha Final:
              <input
              name="fecha_final" id="fecha_final" type="text"
              class="form-control" placeholder="Añadir Fecha Final" readonly>
            </td>
          </tr>
        </table>
        <table border="0" WIDTH="700">
          <tr>
            <td colspan="2">
              Calle:
              <input
              name="calle_numero" id="calle_numero" type="text"
              class="form-control" placeholder="Calle_numero"  style="width : 500px; heigth : 4px" readonly>
            </td>
            <td>
              CP:
              <input
              name="cp" id="cp" type="text"
              class="form-control" placeholder="Sin CP" readonly>
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

        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Datos responsable:</h4>
            </td>
          </tr>
          <tr>

            <td>Nombre:
              <input
              name="responsable" id="responsable" type="text"
              class="form-control" placeholder="Agrega responsable" readonly>
            </td>
            <td>

            </td>
            <td>Parentesco:
              <input
              name="parentesco" id="parentesco" type="text"
              class="form-control" placeholder="Agrega parentesco" readonly>
            </td>
          </tr>
          <tr>
            <td >Celular:
              <input
              name="celular" id="celular" type="text"
              class="form-control" placeholder="Agrega celular" readonly>
            </td>

            <td></td>

            <td>Telefono:
              <input
              name="telefono" id="telefono" type="text"
              class="form-control" placeholder="Agrega telefono" readonly>
            </td>
          </tr>
        </table>
        <!--
      -->
    </table>
    Comentarios de solicitud:
    <textarea class="form-control"  id="comentarios" name="comentarios"  readonly></textarea>
    Comentarios de respuesta.
    <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
    <input name="funcion" id="funcion" type="text"
    class="form-control" value="0" required style="display: none;"><br>
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
