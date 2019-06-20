<?php
//si han pasado las 11:30 am el campo fecha del permiso se asigna vacio para que el usuario lo cambie
$fecha_permiso = "";
if (!$objDateHelper->obtener_hora_limite()) {
    $fecha_permiso = date("d-m-Y");
} else {
    $fecha_permiso = "";
}
?>
<button type="button" id="botonModalInformacionPermiso" class="btn btn-info" data-toggle="modal"
    data-target="#modalInformacionPermiso" hidden></button>

<div class="modal fade" id="modalNuevoPermiso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo permiso del día</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="c-blanco">Información importante</h4>
                    Los cambios para el mismo día deberán solicitarse antes de las 11:30 horas,
                    ya que el sistema no permitirá realizar solicitudes después del horario establecido,
                    sin embargo podrá hacer solicitudes para fechas posteriores.<br>
                    <strong>NOTA:!</strong> Todas las solicitudes están sujetas a disponibilidad.
                </div>
                <form action="" id="form_nuevo_permiso_diario" method="post" class="needs-validation" novalidate>
                    <div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="font-size: 1.4rem">Fecha de solicitud</span>
                            </div>
                            <input style="font-size: 1.4rem" type="text" class="form-control" name="fecha" readonly
                                value="<?php echo $arrayDias[date('w')] . " , " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" />
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="font-size: 1.4rem">Solicitante</span>
                            </div>
                            <input style="font-size: 1.4rem" type="text" class="form-control" name="correo" value="<?php echo " $correo "; ?>"
                                readonly autocomplete="off" />
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="font-size: 1.4rem">* Fecha del permiso</span>
                            </div>
                            <input style="font-size: 1.4rem" type="text" class="form-control" id="fecha1" name="fecha1" autocomplete="off"
                                value="<?php echo $fecha_permiso; ?>" autocomplete="off" required />
                            <div class="invalid-feedback">
                                Campo obligatorio
                            </div>
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <table id="gradient-style" summary="Meeting Results">
                                <thead>
                                    <tr>
                                        <!--<th bgcolor="#CDCDCD">Id</th>-->
                                        <th bgcolor="#CDCDCD">Alumno</th>
                                        <th bgcolor="#CDCDCD">Grupo</th>
                                        <!--<th bgcolor="#CDCDCD">Grado</th>-->
                                        <th bgcolor="#CDCDCD">Activar</th>
                                    </tr>
                                </thead>
                                <?php
                                $consulta1 = $objCliente->mostrar_alumnos($familia);
                                if ($consulta1) {
                                    $counter = 0;
                                    // $numero = mysql_num_rows($consulta);
                                    while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                        $counter = $counter + 1;
                                        ?>
                                <tr id="fila-<?php echo $cliente['id'] ?>">
                                    <!--<td bgcolor="#ffffff"><?php echo $cliente1['id'] ?></td>-->
                                    <td bgcolor="#ffffff">
                                        <?php echo $cliente1['nombre'] ?>
                                    </td>
                                    <td bgcolor="#ffffff">
                                        <?php echo $cliente1['grupo'] ?>
                                    </td>
                                    <!--<td bgcolor="#ffffff"><?php echo $cliente1['grado'] ?></td>-->
                                    <td>
                                        <label>
                                            <input type="checkbox" id="alumno<?php echo $counter ?>"
                                                    name="alumno[]" value="<?php echo $cliente1[id]; ?> " required
                                                    title="Selecciona un alumno"/></center>
                                            <div class="invalid-feedback">Campo obligatorio</div>
                                            <label>
                                    </td>
                                </tr>
                                <?php
                                    }
                                    $talumnos = $counter;
                                }
                            ?>
                            </table>
                        </div>
                        <br>
                        <div class="card w-100  mb-3">
                            <div class="card-header">
                                Dirección de casa
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 1.4rem" class="input-group-text">Calle y Número</span>
                                        </div>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" name="calle1"
                                            value="<?php echo " $calle1 "; ?>" readonly autocomplete="off" />
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 1.4rem" class="input-group-text">Colonia</span>
                                        </div>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" name="colonia1"
                                            value="<?php echo " $colonia1 "; ?>" readonly autocomplete="off" />
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 1.4rem" class="input-group-text">CP</span>
                                        </div>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" name="cp1"
                                            value="<?php echo " $cp1 "; ?>" readonly autocomplete="off" />
                                    </div>
                                    <br>
                                </li>
                            </ul>
                        </div>
                        <br>
                        <div class="card w-100 mb-3">
                            <div class="card-header">
                                Dirección de cambio
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Dirección guardada</span>
                                        </div>
                                        <select class="custom-select" name="reside" id="reside"
                                            onchange="cambio_residencia()">
                                            <option selected value="0">Seleccione</option>
                                            <option value="1">Deportivo CDI</option>
                                            <option value="2">CASA</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 1.4rem" class="input-group-text">Calle y Número</span>
                                        </div>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" id="calle_nuevo" name="calle"
                                            placeholder="Agrega calle y número" value="" minlength="5" maxlength="40"
                                            onkeyup="this.value = this.value.toUpperCase()" required
                                            pattern="[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}"
                                            title="Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales"
                                            autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Campo obligatorio
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 1.4rem" class="input-group-text">Colonia</span>
                                        </div>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" id="colonia_nuevo" name="colonia"
                                            placeholder="Agrega colonia" onkeyup="this.value = this.value.toUpperCase()"
                                            minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}"
                                            title="Agrega colinia sin acentos ni signos especiales" required
                                            autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Campo obligatorio
                                        </div>
                                    </div>
                                    <input name="cp" type="hidden" id="cp_nuevo" value="00000"
                                        placeholder="Agrega CP" />
                                    <br>
                                </li>
                            </ul>
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Ruta</span>
                            </div>
                            <select class="custom-select" name="ruta" required>
                                <option value="">Seleccione ruta</option>
                                <option value="General 2:50 PM">General 2:50 PM</option>
                                <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                            </select>
                            <div class="invalid-feedback">Campo obligatorio</div>
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span style="font-size: 1.4rem" class="input-group-text">Comentarios</span>
                            </div>
                            <textarea style="font-size: 1.4rem" class="form-control" name="comentarios"
                                onkeyup="this.value = this.value.toUpperCase()"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Aceptar</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<script>
    function cambio_residencia() {
        var dato = $('select[id=reside]').val();
        if (dato == '1') {
            $("#calle_nuevo").val("Periferico Boulevard Manuel Avila Camacho 620");
            $("#colonia_nuevo").val("Lomas de Sotelo");
            $("#cp_nuevo").val("53538");
        }
        if (dato == '2') {
            $("#calle_nuevo").val('<?php echo $calle1; ?>');
            $("#colonia_nuevo").val('<?php echo $colonia1; ?>');
            $("#cp_nuevo").val('<?php echo $cp1; ?>');
        }
        if (dato == '0') {
            $("#calle_nuevo").val("");
            $("#colonia_nuevo").val("");
            $("#cp_nuevo").val("");
        }
    }

    // validador de campos obligatorios del formulario
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
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    $('form').submit(function (e) {
        // si la cantidad de checkboxes "chequeados" es cero,
        // entonces se evita que se envíe el formulario y se
        // muestra una alerta al usuario
        if ($('input[type=checkbox]:checked').length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un valor');
        }
    });
</script>