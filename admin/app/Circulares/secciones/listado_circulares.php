<div class="table-responsive p-4">
    <h2 class="text-primary">Circulares</h2>
    <br>
    <table class="table table-striped table-bordered" id="circulares_table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Envia todos</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $url_circulares = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
            $consulta_circulares = $control_circulares->listado_circulares();
            while ($row = mysqli_fetch_array($consulta_circulares)):
                $id_circular = $row[0];
                $titulo = $row[1];
                $descripcion = $row[2];
                $envia_todos = $row[3] == true ? "SI" : "NO";
                $estatus = $row[4];
                $estatus_color = $row[5];
                $id_estatus = $row[6];
                ?>
                <tr data-row="<?php echo $row['id_permiso']; ?>">
                    <td class="p-2"><?php echo $titulo; ?></td>
                    <td class="p-2"><?php echo $descripcion; ?></td>
                    <td class="p-2"><?php echo $envia_todos; ?></td>
                    <td class="p-2"><span class="badge badge-<?php echo $estatus_color; ?>"><?php echo strtoupper($estatus); ?></span></td>
                    <td class="p-2">
                        <div class="dropdown">
                            <button class="btn btn-info btn-squared dropdown-toggle w-100" 
                                    type="button" 
                                    data-toggle="dropdown">
                                Acciones
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" 
                                   href="<?= $url_circulares; ?>/vistas/vista_info_circular.php?id_circular=<?= $id_circular; ?>">
                                    <i class="material-icons text-info">info</i>&nbsp;&nbsp;Info
                                </a>
                                <?php if ($id_estatus != 4): ?>
                                    <a class="dropdown-item" 
                                       href="<?= $url_circulares; ?>/vistas/vista_editar_circular.php?id_circular=<?= $id_circular; ?>">
                                        <i class="material-icons text-warning">edit</i>&nbsp;&nbsp;Editar
                                    </a>
                                <?php endif; ?>
                                <a class="dropdown-item" 
                                   href="<?= $url_circulares; ?>/vistas/vista_duplicado_circular.php?id_circular=<?= $id_circular; ?>">
                                    <i class="material-icons text-secondary">file_copy</i>&nbsp;&nbsp;Duplicar
                                </a>
                                <?php if ($id_estatus != 4): ?>
                                    <a class="dropdown-item" 
                                       href="#!" 
                                       data-toggle="modal" 
                                       data-target="#id_modal_cancelar_circular"
                                       onclick="id_circular = <?= $id_circular; ?>;">
                                        <i class="material-icons text-info text-danger">delete</i>&nbsp;&nbsp;Eliminar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Modal para cancelar circular -->
<div class="modal fade" id="id_modal_cancelar_circular" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="material-icons text-warning">warning</i>&nbsp;¡Peligro!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>¿En verdad desea eliminar la curcular seleccionada?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="material-icons">cancel</i>&nbsp;No
                </button>
                <button type="button" class="btn btn-success"
                        onclick="cancelar_circular();">
                    Sí&nbsp;<i class="material-icons">done</i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var id_circular = null;
    function cancelar_circular() {
        $.ajax({
            url: '/pruebascd/admin/app/Circulares/common/post_cancelar_circular.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                spinnerIn();
            },
            data: {id_circular: id_circular}
        }).done((res) => {
            if (res === true) {
                success_alerta('Solicitud exitosa');
                setTimeout(() => window.location.href = '/pruebascd/admin/app/Circulares/Circulares.php', 2000);
            } else {
                fail_alerta('Ha ocurrido un problema');
            }
        }).always(() => {
            spinnerOut();
            $("#id_modal_cancelar_circular").modal('hide');
        });
    }
</script>
