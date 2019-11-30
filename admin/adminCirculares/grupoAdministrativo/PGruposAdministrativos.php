<?php
include '../../sesion_admin.php';
include '../../conexion.php';

if (!in_array('2', $capacidades)){
    header('Location: ../../menu.php');
}
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$datos = mysqli_query ( $conexion,"SELECT * from App_grupos_administrativos");

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
    <title>CHMD (Administrador de circulares) :: Grupos Administrativos</title>
    <link href="../../dist/css/bootstrap.css" rel="stylesheet">
   
  </head>
  <body>


  <div class="reload"></div>
    <div class="container" id='principal'>
      <div class="masthead">
        <a href="../../cerrar_sesion.php" style="float: right; cursor: pointer;"
          role="button" class="btn btnfamilia-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a> &nbsp
        <a href="../../menu.php">
          <button style="float: right; cursor: pointer;" type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-th"></span> Menu
          </button>
        </a>
        <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
        <hr>
       
      </div>


      <h2>Mantenimiento de grupos administrativos</h2>
   
      <div class="input-group">
        <form method="POST" action="PGrupoAdministrativoBuscar.php">

        <input type="text" name="q" placeholder="Buscar por nombre"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
        </form>

    </div>


    <br>
    <a class="btn btn-success btn-xs" href="nuevo.php">
                <span class="glyphicon glyphicon-plus"></a></td>
    <br><br>
    <table class="table" id="niveles_table">
      <thead>
        <td><b>ID</b></td>
        <td><b>Nombre del grupo</b></td>
         <td><b>Descripci&oacute;n</b></td>
             <td><b>Acciones</b></td>
      </thead>
    <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ($dato = mysqli_fetch_assoc ($datos)){
        $id= $dato['id'];
        $grupo=$dato['grupo'];
        $descripcion=$dato['descripcion'];
        ?>
        <tr style="background:<?=$color?>; border-bottom: 1px solid <?=$borde?>"  data-row="<?php //echo $dato['id_permiso']?>">
        <td><?php echo $id;?></td>
        <td><?php echo $grupo;?></td>
        <td><?php echo $descripcion;?></td>
        <td colspan="2">
                <a class="btn btn-primary btn-xs" href="editar.php?id=<?echo $id;?>">
                <span class="glyphicon glyphicon-pencil"></a>
   
                 <a class="btn btn-danger btn-xs" href="common/eliminar.php?id=<?echo $id;?>">
                 <span class="glyphicon glyphicon-trash"></a>
      
		  </td>
        
    
    <?
    }
    ?>
    </tbody>
    </table>

    <div class="footer">
  <p>&copy; Aplicaciones CHMD 2019</p>
</div>
</div>
<!-- /container -->
<!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
    function descargarpdf(id){
      setTimeout(() => {
         window.location='./common/pdf_chofer.php?idchofer='+id;
       }, 1000);
    }
  </script>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../dist/js/bootstrap.js"></script>
   <script type="text/javascript" src="../../js/1min_inactivo.js" ></script>
</body>

    </div>
    


  </body>
  </html>