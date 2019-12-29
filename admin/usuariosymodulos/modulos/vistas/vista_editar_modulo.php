<?php
$root = dirname(dirname(dirname(__DIR__)));
include "{$root}/Persistence/session.php";
$id_modulo = $_GET['id_modulo'];
require "../common/ControlModulo.php";
$control_modulo = new ControlModulo();
$modulo = $control_modulo->select_modulo_x_id($id_modulo);
$nombre_modulo = $modulo['modulo'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "{$root}/Secciones/head.php"; ?>
    <title>Edición de Modulos</title>
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
                <h5 class="text-primary">Edición de modulo <?= $nombre_modulo; ?> </h5>
                <section class="border p-3">
                    <form class="needs-validation" novalidate>
                        <div class="col-md-5 mb-3">
                            <label>Nombre modulo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                                <input type="text"
                                       class="form-control"
                                       placeholder="Inserte nombre del modulo"
                                       autofocus
                                       autocomplete="off"
                                       name="modulo"
                                       value="<?= $nombre_modulo; ?>"
                                       onfocus="this.select();"
                                       required/>
                                <input name="id_modulo" value="<?= $id_modulo; ?>" hidden/>
                                <div class="invalid-feedback">
                                    Nombre de modulo inválido.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary btn-squared float-right">
                                Guardar &nbsp; <i class="fas fa-save"></i>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <br>
                </section>

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

    function enviar() {
        let form = $('form');
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/admin/usuariosymodulos/modulos/common/post_editar_modulo.php',
            type: 'post',
            dataType: 'json',
            beforeSend: () => {
                spinnerIn();
            },
            data: form.serialize()
        }).done((res) => {
            if (res === true) {
                success_alerta('Solicitud exitosa');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                fail_alerta(res);
            }
        }).always(() => {
            spinnerOut();
        });
    }
</script>
</body>

</html>