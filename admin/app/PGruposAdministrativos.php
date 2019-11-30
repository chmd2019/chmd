<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('31', $capacidades)) {
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
ob_start();

$sql = "SELECT * from App_grupos_administrativos";
$datos = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
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
                    <div class="masthead">

                    </div>
                    <br>
                    <center><?php echo isset($_POST['guardar']) ? $verificar : ''; ?></center>
                    <!-- Button trigger modal -->
                    <a href="../menu.php" style="cursor: pointer;margin: 2px" class="pull-right">
                        <!-- Boton de Atras -->
                        <?php include 'componentes/btn_atras.php'; ?>
                    </a>
                    <h2 class="text-primary">Grupos Administrativos</h2>

                    <div class="table-responsive">

                        <a class="btn btn-success btn-xs" href="PNuevoGrupoAdmin.php">
                            <span class="glyphicon glyphicon-plus"></a></td>
                        <br><br>

                        <table class="table" id="grupos_table">
                            <thead>
                            <td><b>ID</b></td>
                            <td><b>Nombre del grupo</b></td>
                            <td><b>Descripci&oacute;n</b></td>
                            <td><b>Acciones</b></td>
                            </thead>
                            <tbody class="searchable" style="overflow: auto; max-height: 500px;">
                                <?php
                                while ($dato = mysqli_fetch_assoc($datos)) :
                                    $id = $dato['id'];
                                    $grupo = $dato['grupo'];
                                    $descripcion = $dato['descripcion'];
                                    ?>
                                    <tr style="background:<?= $color ?>; border-bottom: 1px solid <?= $borde ?>"  data-row="<?php //echo $dato['id_permiso']                     ?>">
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $grupo; ?></td>
                                        <td><?php echo $descripcion; ?></td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="PEditarGrupoAdmin.php?id=<?echo $id;?>">
                                                <span class="glyphicon glyphicon-pencil"></span></a>
                                            <form method="POST" action="common/eliminarGrupoAdmin.php" onsubmit="return confirm('¿Seguro que desea eliminar este grupo administrativo?');">
                                                <button type="submit" class="glyphicon glyphicon-trash btn-danger btn">
                                                    <input type="hidden" name="idgrupo" value="<?= $id; ?>">
                                                </button></form>
                                        </td>


                                        <?php
                                    endwhile;
                                    ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Site footer -->
                <?php include_once '../components/footer.php'; ?>
            </div>
            <div class="overlay"></div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#grupos_table').DataTable({
                    "order": [[1, "desc"]],
                    paging: true,
                    ordering: true,
                    searching: true,
                    "language": {
                        "lengthMenu": "Se muestran _MENU_ registros por pagina",
                        "zeroRecords": "No hay registros",
                        "info": "Mostrando _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay registros",
                        "infoFiltered": "(filtrados de _MAX_ registros)"
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
