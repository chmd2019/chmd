<?php
$administrativos = $control_administrativo->select_usuarios_administrativos();
$grupos = $control_administrativo->select_grupos_administrativos();
?>
<div class="row justify-content-around">
    <div class="card col-sm-12 col-md-6 border panel-personalizado">
        <div class="card-body p-0 pt-5">
            <h6 class="text-primary border-bottom">
                <i class="material-icons">person_add</i>&nbsp;&nbsp;NUEVO ADMINISTRATIVO
            </h6>
            <br>
            <div class="row justify-content-around">
                <select class="selectpicker border col-8 p-0 rounded-lg"  
                        data-live-search="true"
                        name="grupo"
                        title="Seleccione grupo"
                        multiple
                        id="grupos">
                            <?php while ($row = mysqli_fetch_array($grupos)) : ?>
                        <option value="<?php echo $row[0]; ?>"><?php echo strtoupper($row[1]); ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="button" 
                        class="btn btn-primary"
                        onclick="enviar()">
                    Guardar&nbsp;&nbsp;<i class="material-icons">save</i>
                </button>
            </div>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="usuarios_table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($administrativos)) :
                            $usuario = strtoupper($row[1]);
                            $id_usuario = $row[0];
                            ?>
                            <tr>
                                <td><?php echo $usuario; ?></td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-success btn-squared btn-sm"
                                            onclick="add_usuario('<?php echo $usuario; ?>', <?php echo $id_usuario; ?>, this)">
                                        Agregar &nbsp;&nbsp;<i class="material-icons">add</i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
    </div>
    <div class="card col-sm-12 col-md-5 border panel-personalizado">
        <div class="card-body p-0 pt-5">
            <h6 class="text-primary border-bottom">
                Usuarios agregados
            </h6>
            <br>
            <div class="table-responsive">
                <table class="stripe row-border order-column" id="add_usuarios_table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var usuarios_agregados = [];
    var coleccion_td_quitados = [];
    $(document).ready(function () {
        set_table('usuarios_table');
        set_table('add_usuarios_table');
    });

    function add_usuario(usuario, id_usuario, el) {
        var set = new Set([...usuarios_agregados]);
        if (!set.has(id_usuario)) {
            $("#add_usuarios_table").DataTable().row.add(
                    [
                        usuario,
                        `<button type="button" 
                        class="btn btn-danger btn-squared btn-sm" 
                        onclick="remove_usuario(this,${id_usuario})"> 
                        Quitar &nbsp;&nbsp;<i class="material-icons">remove</i>
                        </button>`
                    ]).draw().node();
            usuarios_agregados.push(id_usuario);
            $("#usuarios_table").DataTable().row($(el).parents('tr')).remove().draw();
            coleccion_td_quitados.push({id_usuario: id_usuario, el: $(el).parents('tr')});
        } else {
            fail_alerta("Ya en lista");
        }

    }
    function remove_usuario(el, id_usuario) {
        $("#add_usuarios_table").DataTable().row($(el).parents('tr')).remove().draw();
        for (var item in coleccion_td_quitados) {
            if (coleccion_td_quitados[item].id_usuario === id_usuario) {
                $("#usuarios_table").DataTable().row.add(coleccion_td_quitados[item].el).draw().node();
                var set_td = new Set([...coleccion_td_quitados]);
                set_td.delete(coleccion_td_quitados[item]);
            }
        }
        var set = new Set([...usuarios_agregados]);
        set.delete(id_usuario);
        usuarios_agregados = Array.from(set);
        coleccion_td_quitados = Array.from(set_td);
    }
    function enviar() {
        var grupos = $("#grupos").val();
        var usuarios = usuarios_agregados;
        if (grupos.length === 0) {
            fail_alerta("Debe agregar al menos un grupo");
            return;
        }
        if (usuarios.length === 0) {
            fail_alerta("Debe agregar al menos un usuario");
            return;
        }
        $.ajax({
            url: "/pruebascd/admin/app/Administrativos/common/post_nuevo_administrativo.php",
            beforeSend: () => {
                spinnerIn();
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