<?php
$root = dirname(dirname(__DIR__));
require "{$root}/usuariosymodulos/permisos/common/ControlPermisos.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "{$root}/Secciones/head.php"; ?>
    <title>Permisos</title>
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
        $id_seccion = 10;
        include "{$root}/menus_dinamicos/perfiles_dinamicos.php";
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
            <div>
                <h2 class="text-primary">Permisos</h2>
                <div>
                    <ul class="nav nav-tabs border-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#permisos" role="tab">
                                Permisos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#asociar_permisos" role="tab">
                                Asociar permisos
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active " id="permisos" role="tabpanel">
                            <?php //include "secciones/lista_perfiles.php"; ?>
                        </div>
                        <div class="tab-pane fade" id="asociar_permisos" role="tabpanel">
                            <?php include "secciones/asociar_permisos.php"; ?>
                        </div>
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
        set_menu_hamburguer();
    });
</script>
</body>
</html>
