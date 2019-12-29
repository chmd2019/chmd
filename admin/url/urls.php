<?php
$root = dirname(__DIR__);
require "{$root}/url/common/ControlUrls.php";
include "{$root}/Persistence/session.php";
$control_urls = new ControlUrls();
$dominio = $control_urls->select_url();
$url = count($dominio['url']) == 0 ? "Ninguno" : $dominio['url'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "{$root}/Secciones/head.php"; ?>
    <title>Urls</title>
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
        $id_seccion = 0;
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
            <div class="p-3">
                <h5 class="text-primary">Dominio de aplicaciones CHMD</h5>
                <br>
                <div class="card w-50">
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-globe"></i>
                            El dominio utilizado actualmente es:
                            <span><b><?= $url; ?></b></span>
                        </div>
                        <form class="needs-validation" novalidate>
                            <div class="col-md-12">
                                <label>Url: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-globe"></i>
                                        </span>
                                    </div>
                                    <input type="url"
                                           name="url"
                                           class="form-control"
                                           placeholder="Ingrese nuevo dominio"
                                           autofocus
                                           autocomplete="off"
                                           required
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="Debe ingresar la url completa, ej:https://www.miurl.com">
                                    <div class="invalid-feedback">
                                        Url inválida.
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <button type="submit"
                                        class="btn btn-primary btn-squared float-right">
                                    Guardar &nbsp;
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
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

        set_table_desordenada('circulares_table');

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
            url: 'https://www.chmd.edu.mx/pruebascd/admin/url/common/post_nueva_url.php',
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