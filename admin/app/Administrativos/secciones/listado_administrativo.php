<div class="table-responsive p-4 border">
    <h2 class="text-primary">Listado de usuarios administrativos</h2>
    <br>
    <table class="table table-striped table-bordered" id="admin_table">
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>ID Admin</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Grupo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "{$root}/Helpers/Helper.php";
            $control_administrativo = new ControlAdministrativos();
            $consulta_admin = $control_administrativo->select_administrativos();
            $usuarios_agrupados = array();
            $data_sin_duplicados = array();
            $mostrados = array();
            while ($row = mysqli_fetch_array($consulta_admin)):
                $id_usuario = $row[0];
                $id_admin = $row[1];
                $nombre = strtoupper($row[2]);
                $correo = strtoupper($row[3]);
                $grupo = strtoupper($row[4]);
                array_push($usuarios_agrupados, ["nombre" => $nombre, "grupo" => $grupo]);
                array_push($data_sin_duplicados, [
                    "id_usuario" => $id_usuario,
                    "id_admin" => $id_admin,
                    "nombre" => $nombre,
                    "correo" => $correo,
                    "grupo" => $grupo
                ]);
                if (!in_array($id_usuario, $mostrados)):
                    ?>
                    <tr data-row="<?php echo $row['id_permiso']; ?>">
                        <td><?php echo $id_usuario ?></td>
                        <td><?php echo $id_admin ?></td>
                        <td><?php echo $nombre ?></td>
                        <td><?php echo $correo ?></td>
                        <td>  
                            <button type="button" 
                                    class="btn btn-info btn-squared btn-sm"
                                    onclick="ver_grupos('<?php echo $nombre; ?>', <?php echo $id_usuario; ?>)">
                                <i class="material-icons">search</i>
                            </button>
                        </td>
                    </tr>
                    <?php
                    array_push($mostrados, $id_usuario);
                endif;
            endwhile;
            $administrativos = $control_administrativo->select_usuarios_administrativos();
            $grupos = $control_administrativo->select_grupos_administrativos();
            ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="grupos_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Grupos de <span id="grupo_usuario"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="body_grupo"></div>
                <div class = "row">                    
                    <select class="selectpicker border col-6 p-0 rounded-lg"  
                            data-live-search="true"
                            name="grupo"
                            title="Seleccione grupo"
                            multiple
                            id="add_grupos">
                                <?php while ($row = mysqli_fetch_array($grupos)) : ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo strtoupper($row[1]); ?></option>
                        <?php endwhile; ?>
                    </select>
                    &nbsp;&nbsp;
                    <button type="button" 
                            class="btn btn-success btn-sm btn-squared"
                            onclick="add_grupo(<?= $id_usuario; ?>, this)">
                        Aceptar &nbsp;&nbsp;<i class="material-icons">add</i>
                    </button>
                </div>
            </div><!--
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>-->
        </div>
    </div>
</div>

<script>
    var usuarios_agrupados = <?php echo json_encode(Helper::groupArray($usuarios_agrupados, "nombre")); ?>;
    function ver_grupos(nombre, id_usuario) {
        $("#body_grupo").html('');
        for (var item in usuarios_agrupados) {
            if (usuarios_agrupados[item].nombre === nombre) {
                $("#grupo_usuario").text(nombre);
                var grupos = usuarios_agrupados[item].groupeddata;
                for (var item_grupo in grupos) {
                    $("#body_grupo").append(`<div class="alert alert-light row justify-content-between" role="alert">
                    ${grupos[item_grupo].grupo}
                        <button type="button" 
                        class="btn btn-danger btn-squared btn-sm" 
                        onclick="cancelar_grupo(${id_usuario},'${grupos[item_grupo].grupo}', this)"> 
                        <i class="material-icons">remove</i> 
                        </button>
                        </div>`);
                }
                $("#grupos_modal").modal();
            }
        }
    }
    function cancelar_grupo(id_usuario, grupo, el) {
        $.ajax({
            url: '/pruebascd/admin/app/Administrativos/common/post_cancelar_grupo.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                spinnerIn();
                el.disabled = true;
            },
            data: {id_usuario: id_usuario, grupo: grupo}
        }).done((res) => {
            if (res === true) {
                success_alerta('Solicitud exitosa');
                setInterval(function () {
                    window.location.reload();
                }, 2000);
            } else {
                fail_alerta('No fué posible realizar su solicitud');
            }
        }).fail(() => {
            fail_alerta('No fué posible realizar su solicitud');
        }).always(() => {
            spinnerOut();
        });
    }
    function add_grupo(id_grupo, el) {
        var grupos = $("#add_grupos").val();
        var usuarios = [id_grupo];

        $.ajax({
            url: "/pruebascd/admin/app/Administrativos/common/post_nuevo_administrativo.php",
            beforeSend: () => {
                spinnerIn();
                el.disabled = true;
            },
            type: 'POST',
            dataType: 'json',
            data: {"grupos": grupos, "usuarios": usuarios}
        }).done((res) => {
            if (res === true) {
                success_alerta('Solicitud realizada con éxito');
                setInterval(() => {
                    window.location.reload();
                }, 2000);
            } else {
                fail_alerta('No fué posible realizar su solicitud');
            }
        }).fail(() => {
            fail_alerta('No fué posible realizar su solicitud');
        }).always(() => {
            spinnerOut();
        });
    }
</script>