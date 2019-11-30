<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('0', $capacidades)){
    header('Location: ../menu.php');
}

$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion,$db );
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
  vp.mensaje, usu.familia,
  vp.responsable,
  vp.parentesco,
  usu.celular,
  usu.telefono,
  vp.fecha_inicial,
  vp.fecha_final,
  vp.turno,
  vp.ruta,
  vp.lunes,
  vp.martes,
  vp.miercoles,
  vp.jueves,
  vp.viernes,
  vp.id_ruta
  from
  Ventana_Permisos vp
LEFT JOIN usuarios usu on vp.idusuario=usu.id
  where not vp.estatus=3 and vp.archivado=0 and vp.tipo_permiso='3'   order by vp.estatus DESC ,vp.id_permiso" );

  if (isset ( $_POST ['nombre_nivel'] )) {
    $nombre = $_POST ['nombre_nivel'];
    $funcion = $_POST ['funcion'];
    $mensaje= $_POST ['mensaje'];
    $id_camion= $_POST ['id_camion'];
    $estatus= $_POST ['estatus'];
    $fecha_inicial = $_POST['fecha_inicial'];

    if ($nombre) {
      header ( 'Content-type: application/json; charset=utf-8' );
      //$existe = mysql_query ( "SELECT * FROM nivel WHERE nombre='$nombre'" );
      //$existe = mysql_fetch_array ( $existe );
      if ($estatus==3) {
        $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=3, archivado=1 WHERE id_permiso=$funcion";
        mysqli_query ($conexion, $query );
        //Cambio de Ruta los alumnos del Permiso a la ruta de cancelados.
        $fecha = date('Y-m-d');
        $orden='995';
        $id_ruta='999'; //ruta de Cancelados Pendientes
        $sql ="SELECT  vpa.id_alumno, vp.nfamilia FROM Ventana_permisos_alumnos vpa
              LEFT JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso
              WHERE vpa.id_permiso='$funcion'";
        $query_search = mysqli_query($conexion, $sql);
        while($r = mysqli_fetch_array($query_search)){
          $id_alumno = $r[0];
          $nfamilia = $r[1];
          $sql_domicilio ="SELECT  CONCAT(colonia, ', ', calle) as domicilio FROM usuarios WHERE numero='$nfamilia' and (responsable ='PADRE' or responsable='MADRE') LIMIT 1";
          $query_domicilio = mysqli_query($conexion,  $sql_domicilio);
          if ($w=mysqli_fetch_array($query_domicilio)){
            $domicilio = $w[0];
          }
          //ejecuto la actualizacion
          $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h_s='$id_ruta', orden_out='$orden' , domicilio_s='$domicilio', estatus='4'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
          $query_update = mysqli_query($conexion, $sql_update);
        }

        $json = array (
        'estatus' => '0'
        );
      } else if ($estatus==2)  {
        $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=2, archivado=1, id_camion='$id_camion', fecha_inicial='$fecha_inicial' WHERE id_permiso=$funcion";
        mysqli_query ($conexion, $query );
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
    <title>CHMD :: Permanente</title>
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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

          <?php
          $perfil_actual='3';
          include ('../menus_dinamicos/perfiles_dinamicos_solicitudes.php'); ?>

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
  <a href="Alta_permanente.php" style="cursor: pointer;" class="pull-right">
      <!-- Boton de Nuevo -->
  <?php include 'componentes/btn_nuevo.php'; ?>
  </a>
<a href="../menu.php" style="cursor: pointer;" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>

  <h2 class="text-primary">Solicitudes Permanentes</h2>
  <input type="text" class="form-control filter"
  placeholder="Buscar Solicitud..."><br> <br>
    <div class="table-responsive-lg">
  <table class="table" id="niveles_table">
    <thead><td><b>Folio</b></td>
      <td><b>Fecha<b></td>

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
          $ruta = $dato['ruta'];
          $id_ruta = $dato['id_ruta'];
          $comentarios=$dato['comentarios'];
          $celular=$dato['celular'];
          $telefono=$dato['telefono'];
          $fecha_inicial=$dato['fecha_inicial'];
          if($fecha_inicial=='0') $fecha_inicial='';
          //recomendacion cambiar por un switch
          if($estatus==1){$staus1="Pendiente";}
          if($estatus==2){$staus1="Autorizado";}
          if($estatus==3){$staus1="Declinado";}
          if($estatus==4){$staus1="Cancelado por el usuario";}
          /***************************************/

          $nfamila= $dato['nfamilia'];
          $calle_numero1=$dato['calle'];
          $colonia1=$dato['colonia1'];

          $mensaje=$dato['mensaje'];
          $familia=$dato['familia'];

          $lunes=$dato['lunes'];
          if($lunes=='0' || $lunes==''){
              $lunes= '   -   ';
          }
          $martes=$dato['martes'];
          if($martes=='0' || $martes==''){
              $martes= '   -   ';
          }
          $miercoles=$dato['miercoles'];
          if($miercoles=='0' || $miercoles==''){
              $miercoles= '   -   ';
          }
          $jueves=$dato['jueves'];
          if($jueves=='0' || $jueves==''){
              $jueves= '   -   ';
          }
          $viernes=$dato['viernes'];
          if($viernes=='0' || $viernes==''){
              $viernes= '   -   ';
          }
          /************************************/
          $color = '#fff';
          $borde= '#ddd';
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
            <td class="text-center">
              <!--
              <button class="btn-autorizar btn btn-success" type="button"
              data-id="<?php echo $id?>"
              data-nombre="<?php echo $nfamila?>">
              <span class="glyphicon glyphicon-cloud">Autorizar</span>
            </button>-->

            <a data-target="#agregarNivel" data-toggle="modal"
            class="btn-editar" type="button"
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
            data-estatus ="<?php echo $estatus?>"
            data-mensaje="<?php echo $mensaje?>"
            data-lunes="<?php echo $lunes?>"
            data-martes="<?php echo $martes?>"
            data-miercoles="<?php echo $miercoles?>"
            data-jueves="<?php echo $jueves?>"
            data-viernes="<?php echo $viernes?>"
            data-telefono="<?php echo $telefono?>"
            data-celular="<?php echo $celular?>"
            data-fecha_inicial="<?php echo $fecha_inicial?>"
            data-id_ruta="<?php echo $id_ruta?>"
            >
           <?php include 'componentes/btn_ver.php'; ?>
          </a>

          <a class="btn-borrar" type="button"
          data-id="<?php echo $id?>"
          data-nombre="<?php echo $nfamila ?>">
          <?php include 'componentes/btn_eliminar.php'; ?>
        </a>

        <!--
        <a href="grado.php?qwert=<?php echo $dato['id']?>&amp;nombre=<?php echo $dato['nombre']?>"
        style="cursor: pointer;"><img src="img/pdf.png" width="40" height="40"/>
      </a>-->
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
                class="form-control" placeholder="folio" readonly="">

              </td>

              <td WIDTH="30%">Fecha de solicitud:
                <input
                name="nombre_nivel" id="nombre_nivel" type="text"
                class="form-control" placeholder="Fecha" readonly="" >
              </td>

              <td  WIDTH="60%">Solicitante:
                <input
                name="nombre_nivel1" id="nombre_nivel1" type="text"
                class="form-control" placeholder="Correo"  readonly="">
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

          <h4>Días de cambio:</h4>
          <table  border="0" WIDTH="700">
            <tr>
              <td> <input
                name="lunes" id="lunes" type="text"
                class="form-control" placeholder="sin dia" readonly>  </td>
                <td><input
                  name="martes" id="martes" type="text"
                  class="form-control" placeholder="sin dia" readonly>  </td>
                  <td><input
                    name="miercoles" id="miercoles" type="text"
                    class="form-control" placeholder="sin dia" readonly>  </td>
                    <td><input
                      name="jueves" id="jueves" type="text"
                      class="form-control" placeholder="sin dia" readonly> </td>
                      <td><input
                        name="viernes" id="viernes" type="text"
                        class="form-control" placeholder="sin dia" readonly> </td>


                      </tr>
                    </table>

                 <table  border="0" WIDTH="700">
                  <tr>
                    <td WIDTH="100%" colspan="10">
                      <h4>Datos de Contacto:</h4>
                    </td>
                  </tr>
                  <tr>
                    <td  WIDTH="50%" colspan="5">Celular:
                      <input
                      name="celular" id="celular" type="text"
                      class="form-control" placeholder="Agrega celular" readonly>
                    </td>

                    <td  WIDTH="50%" colspan="5">Telefono:
                      <input
                      name="telefono" id="telefono" type="text"
                      class="form-control" placeholder="Agrega telefono" readonly>
                    </td>
                  </tr>
                </table>
                <br>

                  Comentarios de solicitud:
                  <textarea class="form-control"  id="comentarios" name="comentarios"  readonly></textarea>
                  <br>
                  Fecha de Inicio del Permiso:
                    <div class="input-group date datepicker" data-date-format="dd/mm/yyyy">
                      <input class="form-control" size="15" id="fecha_inicial_permiso" name="fecha_inicial_permiso" placeholder="Seleccione una fecha" type="text" disabled required/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  <br>

                  Comentarios de respuesta:
                  <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
                  <input name="funcion" id="funcion" type="text"
                  class="form-control" value="0" required style="display: none;">
                  <br>
                  Rutas:
                  <select class="form-control" name="ruta" id="id_camion">
                    <option value="99999" selected>EN ESPERA DE PRODUCCION...</option>
                    <!-- <option value="0" disabled selected>Seleccione una Ruta</option> -->
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
                       $sql = "SELECT COUNT(*) FROM rutas_base_alumnos WHERE id_ruta_base_t=$id_ruta";
                       $query_disponibles = mysqli_query($conexion, $sql);
                       while($r = mysqli_fetch_array($query_disponibles) ){
                         $cupos_disponibles = $r[0];
                       }
                       ?>
                       <option value="<?=$id_ruta?>"><?=strtoupper($nombre_ruta)?>(<?=$cupos_disponibles?>/<?=$cupos?>) - <?=strtoupper($auxiliar)?></option>
                       <?php
                     }
                     ?>
                        <option id="ruta_cancelada"  value="999" style="display:none">RUTA CANCELADA</option>
                  </select>
                  <br>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="js/PPermanente.js"></script>
  <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
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
