<?php
$control_modulos = new ControlModulo();
$modulos = $control_modulos->select_modulos();
?>
<section class="border p-3">
    <h5 class="text-primary">Listado de modulos</h5>
    <br>
    <div class="col-md-8">
        <table class="table-striped" id="tabla_modulos">
            <thead>
            <tr>
                <th>ID Modulo</th>
                <th>Modulo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($modulos

                     as $modulo):
                ?>
                <tr>
                    <td><?= str_pad($modulo['id_modulo'], 2, "0", STR_PAD_LEFT); ?></td>
                    <td><?= $modulo['modulo']; ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-info btn-squared dropdown-toggle w-100"
                                    type="button"
                                    data-toggle="dropdown">
                                Acciones
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="vistas/vista_editar_modulo.php?id_modulo=<?= $modulo['id_modulo']; ?>">
                                    <i class="fas fa-edit text-warning"></i> &nbsp; Editar
                                </a>
                                <a class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#modal_borrar"
                                   href="#!"
                                   onclick="id_modulo = <?= $modulo['id_modulo']; ?>;"
                                >
                                    <i class="fas fa-trash text-danger"></i> &nbsp; Borrar
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_borrar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">¿Está seguro de ésto?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Está a punto de eliminar este modulo
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-danger btn-squared"
                            data-dismiss="modal">Cancelar
                    </button>
                    <button type="button"
                            class="btn btn-success btn-squared"
                            onclick="borrarModulo();">Sí
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    var id_modulo = null;
    $(document).ready(function () {
        set_table('tabla_modulos');
    });

    function borrarModulo() {
        $('.modal').modal('hide');
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/admin/usuariosymodulos/modulos/common/post_borrar_modulo.php',
            type: 'post',
            dataType: 'json',
            beforeSend: () => {
                spinnerIn();
            },
            data: {id_modulo: id_modulo}
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