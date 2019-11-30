<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('25', $capacidades)){
    header('Location: ../menu.php');
}

$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';

$datos = mysqli_query ( $conexion,"SELECT DISTINCT ta.idtarjeton, ta.idfamilia FROM tarjeton_automoviles ta   order by idfamilia;");
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
    <title>CHMD :: Emergencias</title>
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">

  <!-- Dependencias Globales -->
  <?php include '../components/header.php'; ?>

  </head>
  <body>
     <?php include_once "../components/navbar.php"; ?>
    <div class="reload"></div>
    <div class="container" id='principal'>
    <center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
    <!-- Button trigger modal -->

  </button>
    <h2 class="text-primary">Lista de tarjetones:</h2>
    <input type="text" class="form-control filter" placeholder="Buscar Choferes...">
    <br><br>
    <table class="table" id="niveles_table">
      <thead>
        <td><b>Nfamilia</b></td>
        <td><b>Idtarjeton</b></td>
      </thead>
    <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) ){
      $idtarjeton= $dato['idtarjeton'];
      $num_familia=$dato['idfamilia'];
      ?>
      <tr style="background:<?=$color?>; border-bottom: 1px solid <?=$borde?>"  data-row="<?php //echo $dato['id_permiso']?>">
        <td><?php echo $num_familia;?></td>
        <td><?php echo $idtarjeton;?></td>

        <!--  <button class="btn-borrar btn btn-danger" type="button"
            data-id="<?php echo $id?>"
            data-nombre="<?php echo $num_familia ?>">
            <span class="glyphicon glyphicon-trash">Archivar</span>
          </button>-->
        </td>
      </tr>
<?php }?>
</tbody>
</table>

</div>
 <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
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
