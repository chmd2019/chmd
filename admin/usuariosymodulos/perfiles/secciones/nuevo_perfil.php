<?php
?>

<section class="border p-3">
    <h5 class="text-primary">Nuevo perfil</h5>
    <form class="needs-validation" novalidate>
        <div class="col-md-5 mb-3">
            <label>Nombre perfil</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-edit"></i>
                    </span>
                </div>
                <input type="text"
                       class="form-control"
                       placeholder="Inserte nombre del perfil"
                       autofocus
                       autocomplete="off"
                       name="perfil"
                       required>
                <div class="invalid-feedback">
                    Nombre de perfil inválido.
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

<script>
    function enviar() {
        let form = $('form');
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/admin/usuariosymodulos/perfiles/common/post_nuevo_perfil.php',
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