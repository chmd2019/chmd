<?php
$root = dirname(dirname(__DIR__));
include "{$root}/Persistence/session.php";
require "common/ControlPerfiles.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "{$root}/Secciones/head.php"; ?>
    <title>Perfiles</title>
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
                <h2 class="text-primary">Perfiles</h2>
                <div>
                    <ul class="nav nav-tabs border-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#perfiles" role="tab">
                                Perfiles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#nuevo_perfil" role="tab">
                                Nuevo perfil
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active " id="perfiles" role="tabpanel">
                            <?php include "secciones/lista_perfiles.php"; ?>
                        </div>
                        <div class="tab-pane fade" id="nuevo_perfil" role="tabpanel">
                            <?php include "secciones/nuevo_perfil.php"; ?>
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
    var flag_guardar = null;
    $(document).ready(function () {
        spinnerOut();
        set_menu_hamburguer();

        $('input').tooltip({boundary: 'window'});
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            enviar();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    });
</script>
</body>

</html>