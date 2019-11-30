<div class="table-responsive p-4 border">
    <h2 class="text-primary">Alumnos</h2>
    <br>
    <table class="table table-striped table-bordered" id="alumnos_table">
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Grupo</th>
                <th>Grado</th>
                <th>Email</th>
                <th>Grupos especiales</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "{$root}/Helpers/Helper.php";
            $control_alumnos = new ControlAlumnos();
            $consulta_alumnos = $control_alumnos->select_alumnos();
            $grupos_asignados = array();
            $coleccion_alumnos_grupos = array();
            while ($row = mysqli_fetch_array($consulta_alumnos)):
                $id_alumno = $row[0];
                $alumno = $row[2];
                $grupo = $row[3];
                $grado = $row[4];
                $correo = $row[11];
                $consulta_grupo_especial = $control_alumnos->select_grupos_especiales_segun_id_usuario($id_alumno);
                foreach ($consulta_grupo_especial as $value) :
                    array_push($coleccion_alumnos_grupos, $value['grupo']);
                endforeach;
                array_push($grupos_asignados, ["id_usuario" => $id_alumno, "grupos_especiales" => $coleccion_alumnos_grupos]);
                $coleccion_alumnos_grupos = array();
                ?>
                <tr>
                    <td><?php echo $id_alumno; ?></td>
                    <td><?php echo $alumno; ?></td>
                    <td><?php echo $grupo; ?></td>
                    <td><?php echo $grado; ?></td>
                    <td><?php echo $correo; ?></td>
                    <td>  
                        <button type="button" 
                                class="btn btn-info btn-squared btn-sm"
                                onclick="ver_grupos('<?php echo $id_alumno; ?>', '<?php echo $alumno; ?>')">
                            <i class="material-icons">search</i>
                        </button>
                    </td>
                </tr>
                <?php
            endwhile;
            $alumnos = $control_alumnos->select_alumnos();
            $grupos_especiales = $control_alumnos->select_grupos_especiales();
            ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="grupos_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="titulo"></span></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="input_id_alumno" hidden/>
                <div id="body_grupo"></div>
                <div class = "row">                    
                    <select class="selectpicker border col-6 p-0 rounded-lg"  
                            data-live-search="true"
                            name="grupo"
                            title="Seleccione grupo especial"
                            multiple
                            id="add_grupos">
                                <?php while ($row = mysqli_fetch_array($grupos_especiales)) : ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo strtoupper($row[1]); ?></option>
                        <?php endwhile; ?>
                    </select>
                    &nbsp;&nbsp;
                    <button type="button" 
                            class="btn btn-success btn-sm btn-squared"
                            onclick="add_grupo(this)">
                        Aceptar &nbsp;&nbsp;<i class="material-icons">add</i>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var grupos_asignados = <?php echo json_encode($grupos_asignados); ?>;
    function ver_grupos(id_alumno, alumno) {
        $("#body_grupo").html('');
        for (var item in grupos_asignados) {
            if (grupos_asignados[item].id_usuario === id_alumno) {
                $("#titulo").text(alumno);
                var grupos = grupos_asignados[item].grupos_especiales;
                if (grupos.length === 0) {
                    $("#body_grupo").append(`<div class="alert alert-danger" role="alert">Sin grupos especiales asignados</div>`);
                }
                for (var item_grupo in grupos) {
                    $("#body_grupo").append(`<div class="alert alert-light row justify-content-between" role="alert">
                        ${grupos[item_grupo]}
                        <button type="button" 
                        class="btn btn-danger btn-squared btn-sm" 
                        onclick="cancelar_grupo(${id_alumno},'${grupos[item_grupo]}', this)"> 
                        <i class="material-icons">remove</i> 
                        </button>
                        </div>`);
                }
                $("#input_id_alumno").val(id_alumno);
                $("#grupos_modal").modal();
            }
        }
    }
    function cancelar_grupo(id_alumno, grupo, el) {
        $.ajax({
            url: "/pruebascd/admin/app/Alumnos/common/post_eliminar_grupo.php",
            beforeSend: () => {
                spinnerIn();
                $(el).prop("disabled", true);
            },
            type: 'POST',
            dataType: 'json',
            data: {"grupo": grupo, "id_alumno": id_alumno}
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
    function add_grupo(el) {
        var grupos = $("#add_grupos").val();
        var alumnos = [$("#input_id_alumno").val()];

        $.ajax({
            url: "/pruebascd/admin/app/Alumnos/common/post_agrega_alumno_grupo_especial.php",
            beforeSend: () => {
                spinnerIn();
                el.disabled = true;
            },
            type: 'POST',
            dataType: 'json',
            data: {"grupos": grupos, "alumnos": alumnos}
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