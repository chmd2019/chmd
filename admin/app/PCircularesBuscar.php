<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)) {
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
ob_start();
if (isset($_GET['nb'])) {
    $nb = $_GET["nb"];
} else {
    $nb = $_POST["q"];
}

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 20;
$offset = ($pageno - 1) * $no_of_records_per_page;
$total_pages_sql = "SELECT COUNT(*) FROM App_circulares WHERE titulo LIKE '%$nb%'";
$result = mysqli_query($conexion, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$sql = "SELECT * from App_circulares WHERE titulo LIKE '%$nb%' order by id desc LIMIT $offset, $no_of_records_per_page";
$datos = mysqli_query($conexion, $sql);
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
        <title>CHMD :: App</title>
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
                    <h3>APP</h3>
                </div>
                <?php
                $perfil_actual = '40';
                include ("../menus_dinamicos/perfiles_dinamicos_app.php");
                ?>
            </nav>

            <!-- Page Content  -->
            <div id="content">
                <?php include_once "../components/navbar.php"; ?>
                <div class="container-fluid">
                    <div class="masthead">
                    </div>
                    <br>
                    <center><?php echo isset($_POST['guardar']) ? $verificar : ''; ?></center>
                    <!-- Button trigger modal -->
                    <a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
                        <!-- Boton de Atras -->
                        <?php include 'componentes/btn_atras.php'; ?>
                    </a>
                    <h2 class="text-primary">Circulares</h2>
                    <div class="table-responsive">
                        <table class="table" id="niveles_table">
                            <thead>
                                <tr>
                                    <th><b>ID</b></th>
                                    <th><b>Titulo</b></th>
                                    <th><b>Descripci&oacute;n</b></th>
                                    <th><b>Acciones</b></th>
                                </tr>        
                            </thead>
                            <tbody class="searchable" style="overflow: auto; max-height: 500px;">
                                <?php
                                while ($dato = mysqli_fetch_assoc($datos)) :
                                    $id = $dato['id'];
                                    $titulo = $dato['titulo'];
                                    $descripcion = $dato['descripcion'];
                                    ?>
                                    <tr style="background:<?= $color ?>; border-bottom: 1px solid <?= $borde ?>"  data-row="<?php //echo $dato['id_permiso']               ?>">
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $titulo; ?></td>
                                        <td><?php echo $descripcion; ?></td>    
                                        <td colspan="2">
                                            <a class="btn btn-primary btn-xs" href="editar.php?id=<?echo $id;?>">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>   
                                            <a class="btn btn-danger btn-xs" href="common/eliminar.php?id=<?echo $id;?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </td>
                                        <td colspan="6">
                                            <ul class="pagination">
                                                <li style="padding-left:5em"><a href="?pageno=1">Primera</a></li>

                                                <li style="padding-left:5em" class="<?php
                                                if ($pageno <= 1) {
                                                    echo 'disabled';
                                                }
                                                ?>">
                                                    <a href="<?php
                                                    if ($pageno <= 1) {
                                                        echo '#';
                                                    } else {
                                                        echo "?pageno=" . ($pageno - 1);
                                                    }
                                                    ?>">Anterior</a>
                                                </li>
                                                <li style="padding-left:5em" class="<?php
                                                if ($pageno >= $total_pages) {
                                                    echo 'disabled';
                                                }
                                                ?>">
                                                    <a href="<?php
                                                    if ($pageno >= $total_pages) {
                                                        echo '#';
                                                    } else {
                                                        echo "?pageno=" . ($pageno + 1);
                                                    }
                                                    ?>">Siguiente</a>
                                                </li>
                                                <li style="padding-left:5em"><a href="?pageno=<?php echo $total_pages; ?>">Última</a></li>
                                            </ul>
                                        </td>
                                    <tr>
                                    <?php endwhile; ?>    
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
        <script type="text/javascript" src="js/Ppadres.js"></script>
        <script type="text/javascript" src="../js/1min_inactivo.js" ></script>
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
