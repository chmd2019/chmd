<?php
$root = dirname(__DIR__);
require "{$root}/Administrativos/common/ControlAdministrativos.php";
include "{$root}/Persistence/session.php";
$control_administrativo = new ControlAdministrativos();
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <?php include "{$root}/Secciones/head.php"; ?>
        <title>Administrativos</title>
    </head>

    <body style="font-size: .85rem;">        
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav class="navbar" id="sidebar">
                <div id="dismiss">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="sidebar-header">
                    <h3 class="text-white">APP</h3>
                </div>
                <?php
                $perfil_actual = '38';
                include "{$root}/menus_dinamicos/perfiles_dinamicos_app.php";
                ?>
            </nav>
            <div id="content" style="overflow: hidden">
                <?php include "{$root}/components/navbar.php"; ?>
                <div class="p-3">
                    <div class="masthead">

                    </div>
                    <center>
                        <?php echo isset($_POST['guardar']) ? $verificar : ''; ?>
                    </center>
                    <div class="p-3">
                        <ul class="nav nav-tabs border-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#administrativo" role="tab">Usuarios administrativos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#nuevo_administrativo" role="tab">Nuevo usuario administrativo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#grupos_administrativos" role="tab">Grupos administrativos</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active " id="administrativo" role="tabpanel">        
                                <?php include "./secciones/listado_administrativo.php"; ?>
                            </div>
                            <div class="tab-pane fade" id="nuevo_administrativo" role="tabpanel">        
                                <?php include "./secciones/nuevo_administrativo.php"; ?>
                            </div>
                            <div class="tab-pane fade" id="grupos_administrativos" role="tabpanel">        
                                <?php include "./secciones/grupos_administrativos.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Site footer -->
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <?php
                include "{$root}/Secciones/scripts.php";
                include "{$root}/components/footer.php";
                ?>
            </div>
            <div class="overlay"></div>
        </div>

        <?php
        include "{$root}/Secciones/spinner.php";
        include "{$root}/Secciones/notificaciones.php";
        ?>

        <script type="text/javascript">
            $(document).ready(function () {
                spinnerOut();
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#admin_table').DataTable({
                    "language": {
                        "lengthMenu": "_MENU_",
                        "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
                        "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
                        "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
                        "infoFiltered": "(filtrado de _MAX_ total de registros)",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
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