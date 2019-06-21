
<!-- Modal -->
<div class="modal fade" id="modal_form_diario_alta" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header white-text b-azul">
                <h5 class="modal-title white-text" id="exampleModalLabel">Nuevo permiso diario</h5>
                <button type="button" class="close white-text" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4 class="text-warning">Información importante</h4>
                Los cambios para el mismo día deberán solicitarse antes de las 11:30 horas,
                ya que el sistema no permitirá realizar solicitudes después del horario establecido,
                sin embargo podrá hacer solicitudes para fechas posteriores.<br>
                <strong>NOTA:!</strong> Todas las solicitudes están sujetas a disponibilidad.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>    

            <div class="modal-body">
                <div class="md-form mb-5">
                    <i class="fas fa-calendar-check prefix grey-text"></i>      
                    <input style="font-size: 1.4rem" type="text" class="form-control" name="fecha" readonly
                           value="<?php
                           echo $arrayDias[date('w')] . " , " . date('d') .
                           " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') .
                           ", " . date("h:i a");
                           ?>" />
                    <label data-error="wrong" data-success="right" for="form3">Fecha de solicitud</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" name="correo" value="<?php echo " $correo "; ?>"
                           readonly autocomplete="off" />
                    <label data-error="wrong" data-success="right" for="form3">Solicitante</label>
                </div>
                <label class="grey-text ml-5" style="font-size: .85rem;">Fecha del permiso</label>
                <div class="md-form mb-3" style="margin-top: -12px">
                    <i class="fa fa-calendar prefix grey-text"></i>
                    <div class="input-group date ml-3 w-100 p-3" id="fecha-permiso" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input ml-3" data-target="#fecha-permiso" autocomplete="off" name="fecha1" />
                        <div class="input-group-append" data-target="#fecha-permiso" data-toggle="datetimepicker" style="height: 40px">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>  

                    <script type="text/javascript">
                        $(function () {
                            $('#fecha-permiso').datetimepicker({
                                locale: 'es',
                                daysOfWeekDisabled: [0, 6],
                                minDate: new Date(new Date().getTime() + (0 * 24 * 60 * 60 * 1000)),
                                weekStart: 1,
                                forceParse: 0,
                                format: 'DD-MM-YYYY'
                                        //disabledDates:[]
                            });
                        });
                    </script>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">Dirección de la casa</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" name="calle1"
                                       value="<?php echo " $calle1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">Calle y número</label>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" name="colonia1"
                                       value="<?php echo " $colonia1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">Colonia</label>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" name="cp1"
                                       value="<?php echo " $cp1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">CP</label>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="md-form mb-3">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th bgcolor="#CDCDCD">Alumno</th>
                                <th bgcolor="#CDCDCD">Grupo</th>
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
                                    <td>
                                        <div class="form-group form-check float-right" id="checks-alumnos">
                                            <input type="checkbox" class="form-check-input" id="alumno<?php echo $counter; ?>">
                                            <label class="form-check-label" for="alumno<?php echo $counter; ?>"></label>
                                        </div>  
                                    </td>
                                </tr>
                                <?php
                            }
                            $talumnos = $counter;
                        }
                        ?>
                    </table>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-header">Dirección de permiso</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <div class="input-group-prepend mb-3">
                                <span class="input-group-text">Dirección guardada</span>
                                <select class="browser-default custom-select" name="reside" id="reside" onchange="cambiar_direccion()">
                                </select>
                            </div>
                            <div class="md-form mb-3">
                                <i class="fas fa-map prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" id="calle_nuevo" name="calle"
                                       placeholder="Agrega calle y número" value="" minlength="5" maxlength="40"
                                       onkeyup="this.value = this.value.toUpperCase()" required
                                       pattern="[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}"
                                       title="Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales"
                                       autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">Calle y número</label>
                            </div>
                            <div class="md-form mb-3">
                                <i class="fas fa-map-marked-alt prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" id="colonia_nuevo" name="colonia"
                                       placeholder="Agrega colonia" onkeyup="this.value = this.value.toUpperCase()"
                                       minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}"
                                       title="Agrega colinia sin acentos ni signos especiales" required
                                       autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="colonia_nuevo">Colonia</label>
                            </div>
                            <input name="cp" type="hidden" id="cp" value="00000"  />  
                            <div>     
                                <div class="custom-control custom-checkbox float-right mb-5">
                                    <input type="checkbox" class="custom-control-input" name="recordar_direccion"
                                           id="recordar_direccion" onchange="recordar_direccion()">
                                    <label class="custom-control-label" for="recordar_direccion">Rercordar dirección</label>
                                </div>
                            </div>
                            <br>
                            <div class="md-form mb-3 d-none" id="container_descripcion_recordar_direccion">
                                <i class="fas fa-atlas prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" 
                                       id="descripcion_recordar_direccion" name="descripcion_recordar_direccion"
                                       placeholder="Agrega una descripción" onkeyup="this.value = this.value.toUpperCase()"
                                       minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}"
                                       required
                                       autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="descripcion_recordar_direccion">Descripción de la dirección</label>
                                <button type="button" class="btn white-text bg-success w-100" onclick="guardar_direccion()">Guardar</button>  
                            </div>
                        </span>
                    </div>
                </div>

                <div class="input-group-prepend mb-3">
                    <span class="input-group-text">Ruta</span>
                    <select class="browser-default custom-select" id="ruta_diario" name="ruta_diario">
                        <option value="">Seleccione ruta</option>
                        <option value="General 2:50 PM">General 2:50 PM</option>
                        <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                    </select>
                </div>
                <div class="md-form mb-3">
                    <div class="md-form amber-textarea active-amber-textarea">
                        <i class="fas fa-comment prefix grey-text"></i>
                        <textarea style="font-size: 1.4rem" class="md-textarea form-control" rows="2" id="comentarios" name="comentarios"
                                  onkeyup="this.value = this.value.toUpperCase()"></textarea>
                        <label for="comentarios">Comentarios</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning w-100" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn white-text b-azul w-100" onclick="validar_formulario()">Enviar</button>
                    PENDIENTE POR TERMINAR!!!!! 
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        consultar_direcciones("<?php echo "$id_usuario"; ?>");
    });
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
    function cambiar_direccion() {
        var dato = $('select[id=reside]').val();
        if (dato == '0') {
            $("#calle_nuevo").val("");
            $("#colonia_nuevo").val("");
            $("#cp_nuevo").val("");
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').removeClass("show");
            $('#container_descripcion_recordar_direccion').addClass("d-none");
            $('#descripcion_recordar_direccion').val("");
        }
        if (dato == '1') {
            $("#calle_nuevo").val("Periferico Boulevard Manuel Avila Camacho 620");
            $("#colonia_nuevo").val("Lomas de Sotelo");
            $("#cp_nuevo").val("53538");
            //limpia recordar direccion
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').removeClass("show");
            $('#container_descripcion_recordar_direccion').addClass("d-none");
            $('#descripcion_recordar_direccion').val("");
        }
        if (dato !== "0" && dato !== "1") {
            var data = [];
            $.ajax({
                url: "get_consultar_direcciones.php",
                type: "GET",
                data: {"id_usuario":<?php echo "$id"; ?>},
                success: function (res) {
                    res = JSON.parse(res);
                    for (var key in res) {
                        data.push(res[key]);
                    }
                    for (var key in data) {
                        if (data[key].id_direccion === dato) {
                            $("#calle_nuevo").val(data[key].calle);
                            $("#colonia_nuevo").val(data[key].colonia);
                        }
                    }
                }
            });
            //limpia recordar direccion
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').removeClass("show");
            $('#container_descripcion_recordar_direccion').addClass("d-none");
            $('#descripcion_recordar_direccion').val("");
        }

        /*
         $("#calle_nuevo").val('eeeeee');
         $("#colonia_nuevo").val('rrrrr');
         $("#cp_nuevo").val('uuuuuuuu');
         $('#recordar_direccion').prop("checked", false);
         $('#container_descripcion_recordar_direccion').removeClass("show");
         $('#container_descripcion_recordar_direccion').addClass("d-none");
         $('#descripcion_recordar_direccion').val("");*/
    }
    function recordar_direccion() {
        if ($('#recordar_direccion').is(":checked")) {
            $('#container_descripcion_recordar_direccion').removeClass("d-none");
            $('#container_descripcion_recordar_direccion').addClass("show");
            return;
        }
        $('#container_descripcion_recordar_direccion').removeClass("show");
        $('#container_descripcion_recordar_direccion').addClass("d-none");
        $('#descripcion_recordar_direccion').val("");
    }
    function guardar_direccion() {
        var calle = $('#calle_nuevo').val();
        var colonia = $('#colonia_nuevo').val();
        var descripcion = $('#descripcion_recordar_direccion').val();

        if (calle.length > 0 && colonia.length > 0 && descripcion.length > 0) {
            var data = {
                "calle": calle,
                "colonia": colonia,
                "descripcion": descripcion,
                "id_usuario":<?php echo "$id"; ?>
            }
            $.ajax({
                url: "post_nueva_direccion.php",
                type: "POST",
                data: data,
                success: function () {
                    swal("Información", `Registro exitoso!, puedes seleccionar tu nueva dirección en la lista desplegable con la descripción ${data.descripcion}`, "success");
                    $('#calle_nuevo').val("");
                    $('#colonia_nuevo').val("");
                    $('#descripcion_recordar_direccion').val("");
                    consultar_direcciones();
                }
            });
            return;
        }
        swal("Información", "Debe llenar todos los campos!", "error");
        if (calle.length == 0) {
            $('#calle_nuevo').focus();
        }
        if (colonia.length == 0) {
            $('#colonia_nuevo').focus();
        }
        if (descripcion.length == 0) {
            $('#descripcion_recordar_direccion').focus();
        }
    }
    function consultar_direcciones() {
        var data = [];
        $.ajax({
            url: "get_consultar_direcciones.php",
            type: "GET",
            data: {"id_usuario":<?php echo "$id"; ?>},
            success: function (res) {
                res = JSON.parse(res);
                var options = `<option selected value="0">Seleccione dirección</option><option value="1">Deportivo CDI</option>`;
                for (var key in res) {
                    data.push(res[key]);
                }
                for (var key in data) {
                    options += `<option value="${data[key].id_direccion}">${data[key].descripcion}</options>`;
                }
                $("#reside").html(options);
            }
        });
        return data;
    }
    function validar_formulario() {
        //valida checks de alumnos
        var selected = '';
        $('#checks-alumnos input[type=checkbox]').each(function () {
            if (this.checked) {
                selected += $(this).val() + ', ';
            }
        });
        if (selected === '') {
            swal("Información", "Debes seleccionar al menos un alumno para continuar", "error");
            return;
        }
        //valida seleccion de ruta
        if ($("#ruta_diario").val() === "") {
            swal("Información", "Debes seleccionar una ruta", "error");
            return;
        }
    }
</script>