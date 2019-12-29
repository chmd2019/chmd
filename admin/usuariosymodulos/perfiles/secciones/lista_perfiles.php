<?php
$control_perfiles = new ControlPerfiles();
$perfiles = $control_perfiles->select_perfiles();
?>
<section class="border p-3">
    <h5 class="text-primary">Listado de perfiles</h5>
    <br>
    <div class="col-md-6">
        <table class="table-striped" id="tabla_perfiles">
            <thead>
            <tr>
                <th>ID Perfil</th>
                <th>Perfil</th>
                <th>Activo</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($perfil = mysqli_fetch_assoc($perfiles)):
                ?>
                <tr>
                    <td><?= str_pad($perfil['id_perfil'], 2,"0",STR_PAD_LEFT); ?></td>
                    <td><?= $perfil['nombre']; ?></td>
                    <td>
                        <div class="custom-control custom-toggle my-2">
                            <input type="checkbox"
                                   id="toggle<?= $perfil['id_perfil']; ?>"
                                   class="custom-control-input"
                                   onchange="cambiar_activo(<?= $perfil['id_perfil']; ?>, this.checked);"
                                <?php if (boolval($perfil['activo']) == true) echo " checked"; ?>
                            >
                            <label class="custom-control-label" for="toggle<?= $perfil['id_perfil']; ?>"></label>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
<script>
    $(document).ready(function () {
        set_table('tabla_perfiles');
    });

    function cambiar_activo(id_perfil, checked) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/admin/usuariosymodulos/perfiles/common/post_cambiar_activo.php',
            type: 'post',
            dataType: 'json',
            beforeSend: () => {
                spinnerIn();
            },
            data: {id_perfil: id_perfil, activo: checked}
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