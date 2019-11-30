<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)) {
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
ob_start();

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$sql = "SELECT * from App_circulares order by id desc";
$datos = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../dist/js/bootstrap.js"></script>
        <!-- jQuery Custom Scroller CDN -->
        <script type="text/javascript" src="js/Ppadres.js"></script>
        <script type="text/javascript" src="../js/1min_inactivo.js" ></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
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
                    <div class="masthead"></div>
                    <br>
                    <center><?php echo isset($_POST['guardar']) ? $verificar : ''; ?></center>
                    <!-- Button trigger modal -->
                    <a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
                        <!-- Boton de Atras -->
                        <?php include 'componentes/btn_atras.php'; ?>
                    </a>
                    <h2 class="text-primary">Circulares</h2>
                    <div class="table-responsive">
                        <a class="btn btn-success btn-xs" href="PNuevaCircular.php">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                        <br><br>
                        <table class="table" id="circulares_table">
                            <thead>
                            <td><b>Titulo</b></td>
                            <td><b>Descripci&oacute;n</b></td>
                            <td><b>Acciones</b></td>
                            </thead>
                            <tbody class="searchable" style="overflow: auto; max-height: 500px;">
                                <?php
                                while ($dato = mysqli_fetch_assoc($datos)) :
                                    $id = $dato['id'];
                                    $titulo = $dato['titulo'];
                                    $descripcion = $dato['descripcion'];
                                    ?>
                                    <tr style="background:<?= $color ?>; border-bottom: 1px solid <?= $borde ?>"  data-row="<?php //echo $dato['id_permiso']             ?>">
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
                                    </tr>
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

        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
                $('#circulares_table').DataTable({
                    "order": [[1, "desc"]],
                    paging: true,
                    ordering: true,
                    searching: true,
                    language: {
                        "url": "dataTables.spanish.lang",
                        paginate: {
                            first: "Primera",
                            previous: "Anterior",
                            next: "Siguiente",
                            last: "U&acute;ltima"
                        },
                        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 ",
                        sSearch: "Buscar",
                        sLengthMenu: "Mostrar _MENU_ registros",
                        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    }
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
