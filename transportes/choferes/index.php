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
$datos = mysqli_query ( $conexion," SELECT id,nombre,numero,fecha,
  familia,estatus,tipo,correo,celular
  FROM usuarios usu WHERE tipo='7' ");
  /*"SELECT vp.id_permiso,vp.fecha_creacion,
  usu.correo,vp.calle_numero,vp.colonia,vp.cp,vp.comentarios,vp.estatus,vp.nfamilia,
  usu.calle,usu.colonia as colonia1,vp.mensaje,usu.familia,
  vp.responsable,vp.parentesco,vp.celular, vp.telefono,vp.turno,vp.ruta,
  vp.fecha_creacion, vp.fecha_cambio, vp.fecha_respuesta from Ventana_Permisos vp
  LEFT JOIN usuarios usu on vp.idusuario=usu.id
  where not vp.estatus=3 and vp.archivado=0 and vp.tipo_permiso='1' order by vp.estatus DESC ,vp.id_permiso"
*/
  /*if (isset ( $_POST ['nombre_nivel'] ))
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
        $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje', estatus=3, archivado=1 WHERE id_permiso=$funcion";
        mysqli_query ( $conexion, $query );
        $json = array (
          'estatus' => '0'
        );
      }
      else if ($estatus==2)
      {
        $query = "UPDATE Ventana_Permisos SET mensaje = '$mensaje',estatus=2, archivado=1 WHERE id_permiso=$funcion";
        mysqli_query ($conexion,  $query );
        $json = array (
        'estatus' => '0'
        );
      } else if ($existe)
      {
        $json = array (
        'estatus' => '-1'
        );
      }
    }
    echo json_encode ( $json );
    exit ();
  }*/
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
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
  </head>
  <body>
    <div class="reload"></div>
    <div class="container" id='principal'>
      <div class="masthead">
        <a href="cerrar_sesion.php" style="float: right; cursor: pointer;"
          role="button" class="btn btnfamilia-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a> &nbsp
        <a href="../menu.php">
          <button style="float: right; cursor: pointer;" type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-th"></span> Menu
          </button>
        </a>
        <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
        <hr>
        <?php $perfil_actual='diario'; include ('perfiles_dinamicos.php'); ?>
      </div>
    <br/>
    <center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
  <!-- Button trigger modal -->
  <a href="Alta_diario.php" style="cursor: pointer;" class="btn btn-primary btn-default pull-right btn-nuevo">
    <span class="glyphicon glyphicon-plus"></span>
  </a>
  </button>
    <h2>Solicitudes de choferes:</h2>
    <input type="text" class="form-control filter" placeholder="Buscar Choferes...">
    <br><br>
    <table class="table" id="niveles_table">
      <thead><td><b>ID Usuario</b></td>
        <td><b>Fecha de Solicitud</b></td>
        <td><b>Estatus</b></td>
        <td><b>Nombre</b></td>
        <td><b>Celular</b></td>
        <td class="text-right"><b>Acciones</b></td>
      </thead>
    <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) ){
      $id= $dato['id'];
      $nombre=$dato['nombre'];
      $num_familia=$dato['numero'];
      $fecha= $dato['fecha'];
      $familia=$dato['familia'];
      $correo= $dato['correo'];
      $estatus= $dato['estatus'];
      $celular=$dato['celular'];

      if($estatus==1){$staus1="Pendiente";}
      if($estatus==2){$staus1="Autorizado";}
      if($estatus==3){$staus1="Declinado";}
      if($estatus==4){$staus1="Cancelado por el usuario";}

      /*$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
      //$array1 = explode(',' , $fecha_cambio );
      $array1 = explode(',' , $fecha );
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
      $fecha= $mes.'/'.$dia.'/'.$anio;*/

      /*$fecha_entrada = strtotime ($fecha);
      if($fecha_actual > $fecha_entrada){
        $otro_dia=false;
      }else{
        $otro_dia=true;
      }*/

      //  $telefonomama=$dato['telefonomama'];
      /*
      if($fecha_inicial==0)
      {
        $fpermiso=$fecha;
      }
      else
      {
        $fpermiso= $fecha_inicial;
      }
      */
      /*if ($otro_dia==true){
          $color = '#ddd';
          $borde= '#ddd';
        }else{
          $color = '#fff';
          $borde= '#ddd';
        }*/
      if ($estatus==4){
        $color = '#ffd5d5';
        $borde= '#ffb1b1';
      }
      ?>
      <tr style="background:<?=$color?>; border-bottom: 1px solid <?=$borde?>"  data-row="<?php //echo $dato['id_permiso']?>">
        <td><?php echo $id;?></td>
        <td><?php echo $fecha;?></td>
        <td><?php echo $staus1?></td>
        <td><?php echo $nombre?></td>
        <td><?php echo $celular?></td>

        <td class="text-right">
          <!--
          <button class="btn-autorizar btn btn-success" type="button"
          data-id="<?php //echo $id?>"
          data-nombre="<?php// echo $nfamila?>">
          <span class="glyphicon glyphicon-cloud">Autorizar</span>
          </button>
          -->
            <button data-target="#agregarNivel" data-toggle="modal"
              class="btn-editar btn btn-primary" type="button"
              data-id="<?php echo $id?>"
              data-fecha_solicitud="<?php echo $fecha?>"
              data-correo="<?php echo $correo?>"
              data-nfamilia="<?php echo $num_familia;?>"
              data-estatus ="<?php echo $estatus?>">
              <span class="glyphicon glyphicon-pencil">Ver</span>
            </button>
          <button class="btn-borrar btn btn-danger" type="button"
            data-id="<?php echo $id?>"
            data-nombre="<?php echo $num_familia ?>">
            <span class="glyphicon glyphicon-trash">Archivar</span>
          </button>
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
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="js/choferes.js"></script>
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
            <td WIDTH="10%">Id:
              <input name="id" id="id" type="text" style="width:100px;heigth:4px" class="form-control" placeholder="id" readonly>
            </td>
            <td WIDTH="30%">Fecha de solicitud:
              <input name="fecha_solicitud" id="fecha_solicitud" type="text" style="width:200px;heigth:4px" class="form-control" placeholder="Fecha" readonly>
            </td>
            <td  WIDTH="60%">Correo:
              <input name="correo" id="correo" type="text" class="form-control" placeholder="Correo"  style="width:400px;heigth:4px" readonly>
            </td>
          </tr>
        </table>
        <table>
          <tr>
            <td WIDTH="100%" colspan="3">
              <h4>Familia asociada al chofer:</h4>
            </td>
          </tr>
        </table>
        <table  border="0" WIDTH="700">
          <tr>
            <td>Nombre</td>
            <td>Parentesco</td>
            <td>Correo</td>
          </tr>
        </table>
        <table id="tabla_solicitantes" border="0" WIDTH="700"> <!-- antes tabla_alumnos -->
        </table>
        Accion:
        <select name="estatus" id="estatus">
          <option value="0" >Selecciona</option>
          <option value="2" style="color:white;background-color:#0b1d3f;">Autorizado</option>
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
