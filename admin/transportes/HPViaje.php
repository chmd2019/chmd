
<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('1', $capacidades)){
    header('Location: ../menu.php');
}
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'");
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$sql= "SELECT vp.id_permiso,vp.fecha_creacion,
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
vp.turno,
vp.id_ruta,
vp.id_camion
from
Ventana_Permisos vp
LEFT JOIN usuarios usu on vp.idusuario=usu.id
where  vp.archivado=1 and vp.tipo_permiso='2'  order by vp.id_permiso desc";

$datos =mysqli_query ($conexion, $sql );

if (isset ( $_POST ['nombre_nivel'] )) {
  $nombre = $_POST ['nombre_nivel'];
  $funcion = $_POST ['funcion'];
  $mensaje= $_POST ['mensaje'];
  $estatus= $_POST ['estatus'];
  $id_camion = $_POST ['id_camion'];
  if ($nombre) {
    header ( 'Content-type: application/json; charset=utf-8' );

    //$existe =mysqli_query ($conexion, "SELECT * FROM nivel WHERE nombre='$nombre'" );
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
      $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=2,id_camion='$id_camion' WHERE id_permiso=$funcion";
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
  <title>CHMD :: Historial Temporal</title>
  <link href="../dist/css/bootstrap.css" rel="stylesheet">
  <link href="../css/menu.css" rel="stylesheet">
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
            <h3>TRANSPORTES</h3>
        </div>

  <?php $perfil_actual='5';
        include ("../menus_dinamicos/perfiles_dinamicos_solicitudes.php");
   ?>

    </nav>

    <!-- Page Content  -->
    <div id="content">
  <?php include_once "../components/navbar.php"; ?>
<div class="container-fluid">
  <div class="masthead">
</div>
<br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->

<a href="../menu.php" style="cursor: pointer;" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
<h2 class="text-primary">Historial de solicitides Temporal</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
  <div class="table-responsive-lg">
<table class="table table-striped" id="niveles_table">
  <thead><td><b>Folio</b></td>
    <td><b>Fecha</b></td>

    <td><b>Estatus</b></td>
    <td><b>Familia</b></td>
    <td class="text-center"><b>Acciones</b></td>
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
      $turno = $dato['turno'];
      if($estatus==1){$staus1="Pendiente";}
      if($estatus==2){$staus1="Autorizado";}
      if($estatus==3){$staus1="Declinado";}
      if($estatus==4){$staus1="Cancelado por el usuario";}
      $famila= $dato['familia'];
      $nfamila= $dato['nfamilia'];
      $calle_numero1=$dato['calle'];
      $colonia1=$dato['colonia1'];
      $id_ruta=$dato['id_ruta'];
      $id_camion=$dato['id_camion'];

      $mensaje=$dato['mensaje'];
      $familia=$dato['familia'];
      $ruta= $dato['turno'];
      ?>
      <tr data-row="<?php echo $dato['id_permiso']?>">
        <td><?php echo $id ?></td>
        <td><?php echo $fecha?></td>
        <td><?php echo $staus1?></td>
        <td><?php echo $famila?></td>
        <td class="text-center">
          <!--	<button class="btn-autorizar btn btn-success" type="button"
            data-id="<?php echo $id?>"
            data-nombre="<?php echo $nfamila?>">
            <span class="glyphicon glyphicon-cloud">Autorizar</span>
          </button>
        -->
        <a data-target="#agregarNivel" data-toggle="modal"
        class="btn-editar" type="button"
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
        data-ruta="<?php echo $ruta?>"
        data-turno="<?php echo $turno?>"
        data-mensaje="<?php echo $mensaje?>"
        data-responsable="<?php echo $responsable?>"
        data-parentesco="<?php echo $parentesco?>"
        data-celular="<?php echo $celular?>"
        data-estatus="<?php echo $estatus?>"
        data-id_ruta="<?php echo $id_ruta?>"
         data-id_camion="<?php echo $id_camion?>"
        data-telefono="<?php echo $telefono?>">
       <?php include 'componentes/btn_ver.php'; ?>
      </a>
      <!--
        <button class="btn-borrar btn btn-danger" type="button"
        data-id="<?php //echo $id?>"
        data-nombre="<?php // echo $nfamila ?>">
        <span class="glyphicon glyphicon-trash">Cancelar</span>
      </button>

      <!--
        <a href="grado.php?qwert=<? //php echo $dato['id']?>&amp;nombre=<?php //echo $dato['nombre']?>"
          style="cursor: pointer;"><img src="img/pdf.png" width="40" height="40"/>
        </a>
      -->
    </td>
  </tr>
<?php }?>
</tbody>
</table>

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
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="js/PViaje.js"></script>
<!-- <script type="text/javascript" src="../js/1min_inactivo.js" ></script> -->
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
</body>
</html>

<!-- Modal -->
<div class="modal" id="agregarNivel" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="max-width: 750px">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="modalNivelTitulo">Agrega Solicitud</h4>
      <button type="button" class="close" data-dismiss="modal"
      aria-hidden="true">&times;</button>
    </div>
    <form class="form-signin save-nivel" method='post'>
      <div class="alert-save"></div>
      <div class="modal-body">
        <table border="0" WIDTH="700">
          <tr>
            <td WIDTH="10%" >Folio:
              <input
              name="folio" id="folio" type="text"
              class="form-control" placeholder="folio"  readonly>
            </td>
            <td WIDTH="30%">Fecha de solicitud:
              <input
              name="nombre_nivel" id="nombre_nivel" type="text"
              class="form-control" placeholder="Fecha" readonly>
            </td>

            <td  WIDTH="60%">Solicitante:
              <input
              name="nombre_nivel1" id="nombre_nivel1" type="text"
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
          <tr>
            <td>Alumno</td>
            <td>Grado</td>
            <td>Grupo</td>
          </tr>
          <!------------------------------------------------------------------------->
        </table>
        <table id="tabla_alumnos" border="0" WIDTH="700">
          <!-------------------------- Tabla de  Alumnos ----------------------------------------------->
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
              class="form-control" placeholder="Calle_numero1"   readonly>
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
              class="form-control" placeholder="Calle_numero"   readonly>
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
      <br>
      Comentarios de respuesta:
      <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
      <input name="funcion" id="funcion" type="text"
      class="form-control" value="0" required style="display: none;"><br>
                     <span id="ruta_p">
                     Rutas:
                     </span>
                      <select class="form-control" name="ruta" id="id_camion">
                        <option value="0" disabled selected>Seleccione una Ruta</option>
                        <?php
                         $sql_rutas = "SELECT r.*, u.nombre FROM rutas r INNER JOIN usuarios u ON u.id=r.auxiliar WHERE r.id_ruta>0  ORDER BY r.camion";
                         $query = mysqli_query($conexion, $sql_rutas);
                         while ($r  = mysqli_fetch_array($query) ){
                           $id_ruta= $r['id_ruta'];
                           $nombre_ruta = $r['nombre_ruta'];
                           $camion = $r['camion'];
                           $cupos = $r['cupos'];
                           $auxiliar = $r['nombre'];
                           //numero de cupos Disponibles
                           $sql = "SELECT COUNT(*) FROM rutas_base_alumnos WHERE id_ruta_base_m=$id_ruta ";
                           $query_disponibles = mysqli_query($conexion, $sql);
                           while($r = mysqli_fetch_array($query_disponibles) ){
                             $cupos_disponibles = $r[0];
                           }
                           ?>
                           ?>
                           <option value="<?=$id_ruta?>"><?=strtoupper($nombre_ruta)?>(<?=$cupos_disponibles?>/<?=$cupos?>) - <?=strtoupper($auxiliar)?></option>
                           <?php
                         }
                         ?>
                        <!-- <option value="" disabled>NAGUANAGUA(35/35) - LUISA PEREZ</option> -->
                      </select>
                    <br>
<div id="vista_s" style="display: none">
                    <span class="rutas_s" style="display: none">
                    Ruta(Tarde):
                    </span>
                    <select class="form-control rutas_s" name="ruta" id="id_camion_s" style="display: none">
                        <option value="0" disabled selected>Seleccione una Ruta</option>
                        <?php
                         $sql_rutas = "SELECT r.*, u.nombre FROM rutas r INNER JOIN usuarios u ON u.id=r.auxiliar WHERE r.id_ruta>0  ORDER BY r.camion";
                         $query = mysqli_query($conexion, $sql_rutas);
                         while ($r  = mysqli_fetch_array($query) ){
                           $id_ruta= $r['id_ruta'];
                           $nombre_ruta = $r['nombre_ruta'];
                           $camion = $r['camion'];
                           $cupos = $r['cupos'];
                           $auxiliar = $r['nombre'];
                           //numero de cupos Disponibles
                           $sql = "SELECT COUNT(*) FROM rutas_base_alumnos WHERE id_ruta_base_t=$id_ruta ";
                           $query_disponibles = mysqli_query($conexion, $sql);
                           while($r = mysqli_fetch_array($query_disponibles) ){
                             $cupos_disponibles = $r[0];
                           }
                           ?>
                           ?>
                           <option value="<?=$id_ruta?>"><?=strtoupper($nombre_ruta)?>(<?=$cupos_disponibles?>/<?=$cupos?>) - <?=strtoupper($auxiliar)?></option>
                           <?php
                         }
                         ?>
                        <!-- <option value="" disabled>NAGUANAGUA(35/35) - LUISA PEREZ</option> -->
                      </select>


                      <input type="checkbox" name="" id="dos_rutas" onchange="show_dos_rutas()"> La ruta de la Tarde es distinta a la Mañana.
                      <br>
                      <br>
</div>

      Accion:
      <select name="estatus" id="estatus">
        <option value="0">Selecciona</option>
        <option value="2"style="color:white;background-color:#0b1d3f;">Autorizado</option>
        <option value="3" style="color:red;background-color:yellow;">Declinado</option>
      </select>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
      <button type="submit" class="btn btn-primary" name="guardar"><b>GUARDAR</b></button>
    </div>
  </form>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
