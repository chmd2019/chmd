<?php
$alumnos = $control_alumnos->select_alumnos();
$grupos_especiales = $control_alumnos->select_grupos_especiales();
?>
<div class="row justify-content-around">
    <div class="card col-sm-12 col-md-7 border panel-personalizado">
        <div class="card-body p-0 pt-5">
            <h6 class="text-primary border-bottom">
                <i class="material-icons">person_add</i>&nbsp;&nbsp;AGREGAR A GRUPO ESPECIAL
            </h6>
            <br>
            <div class="row justify-content-around">
                <select class="selectpicker border col-8 p-0 rounded-lg"  
                        data-live-search="true"
                        title="Seleccione grupo especial"
                        multiple
                        id="grupos">
                            <?php while ($row = mysqli_fetch_array($grupos_especiales)) : ?>
                        <option value="<?php echo $row[0]; ?>"><?php echo strtoupper($row[1]); ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="button" 
                        class="btn btn-primary"
                        onclick="enviar(this)">
                    Guardar&nbsp;&nbsp;<i class="material-icons">save</i>
                </button>
            </div>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="alumnos_sin_agregar_table">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Grupo</th>
                            <th>Grado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($alumnos)) :
                            $alumno = strtoupper($row[2]);
                            $id_alumno = $row[0];
                            $grupo = $row[3];
                            $grado = $row[4];
                            ?>
                            <tr>
                                <td><?php echo $alumno; ?></td>
                                <td><?php echo $grupo; ?></td>
                                <td><?php echo $grado; ?></td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-success btn-squared btn-sm"
                                            onclick="add_alumno('<?php echo $alumno; ?>', <?php echo $id_alumno; ?>, this)">
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
    <div class="card col-sm-12 col-md-4 border panel-personalizado">
        <div class="card-body p-0 pt-5">
            <h6 class="text-primary border-bottom">
                Alumnos agregados
            </h6>
            <br>
            <div class="table-responsive">
                <table class="stripe row-border order-column" id="add_alumnos_table">
                    <thead>
                        <tr>
                            <th>Alumno</th>
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
    var alumnos_agregados = [];
    var coleccion_td_quitados = [];
    $(document).ready(function () {
        set_table('alumnos_sin_agregar_table');
        set_table('add_alumnos_table');
    });

    function add_alumno(alumno, id_alumno, el) {
        var set = new Set([...alumnos_agregados]);
        if (!set.has(id_alumno)) {
            $("#add_alumnos_table").DataTable().row.add(
                    [
                        alumno,
                        `<button type="button" 
                        class="btn btn-danger btn-squared btn-sm" 
                        onclick="remove_alumno(this,${id_alumno})"> 
                        Quitar &nbsp;&nbsp;<i class="material-icons">remove</i>
                        </button>`
                    ]).draw().node();
            alumnos_agregados.push(id_alumno);
            $("#alumnos_sin_agregar_table").DataTable().row($(el).parents('tr')).remove().draw();
            coleccion_td_quitados.push({id_alumno: id_alumno, el: $(el).parents('tr')});
        } else {
            fail_alerta("Ya en lista");
        }

    }
    function remove_alumno(el, id_alumno) {
        $("#add_alumnos_table").DataTable().row($(el).parents('tr')).remove().draw();
        var set = new Set([...alumnos_agregados]);
        set.delete(id_alumno);
        for (var item in coleccion_td_quitados) {
            if (coleccion_td_quitados[item].id_alumno === id_alumno) {
                $("#alumnos_sin_agregar_table").DataTable().row.add(coleccion_td_quitados[item].el).draw().node();
                var set_td = new Set([...coleccion_td_quitados]);
                set_td.delete(coleccion_td_quitados[item]);
            }
        }
        coleccion_td_quitados = Array.from(set_td);
        alumnos_agregados = Array.from(set);
    }
    function enviar(el) {
        var grupos = $("#grupos").val();
        var alumnos = alumnos_agregados;
        if (grupos.length === 0) {
            fail_alerta("Debe agregar al menos un grupo");
            return;
        }
        if (alumnos.length === 0) {
            fail_alerta("Debe agregar al menos un usuario");
            return;
        }
        $.ajax({
            url: "/pruebascd/admin/app/Alumnos/common/post_agrega_alumno_grupo_especial.php",
            beforeSend: () => {
                spinnerIn();
                $(el).prop("disabled", true);
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