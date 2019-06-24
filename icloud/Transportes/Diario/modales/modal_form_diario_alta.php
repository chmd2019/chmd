
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
            <?php
            $hora_limite = $objDateHelper->obtener_hora_limite();
            $d_btn_fecha_permiso;
            $text_btn_fecha_permiso;
            $calendario_fecha_permiso;
            $fecha_disabled;
            if ($hora_limite) {
                $d_btn_fecha_permiso = "d-none";
                $calendario_fecha_permiso = "";
                $fecha_disabled = date("m-d-Y");
            } else {
                $d_btn_fecha_permiso = "";
                $text_btn_fecha_permiso = "ESTABLECER FECHA DE HOY";
                $calendario_fecha_permiso = "d-none";
            }
            ?>            
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
                    <input style="font-size: 1.4rem" type="text" class="form-control" id="fecha_solicitud_nuevo" name="fecha" readonly
                           value="<?php
                           echo $arrayDias[date('w')] . " , " . date('d') .
                           " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') .
                           ", " . date("h:i a");
                           ?>" />
                    <label data-error="wrong" data-success="right">Fecha de solicitud</label>
                </div>

                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" id="correo_nuevo" name="correo" value="<?php echo " $correo "; ?>"
                           readonly autocomplete="off" />
                    <label data-error="wrong" data-success="right">Solicitante</label>
                </div>

                <div class="text-center mb-3 <?php echo $d_btn_fecha_permiso; ?>">
                    <button type="button" class="btn b-azul white-text w-75" id="btn-display-fecha-permiso" 
                            onclick="mostrar_ocultar_calendario_permiso()" ><?php echo $text_btn_fecha_permiso; ?></button>
                </div>

                <div class="<?php echo $d_none; ?>" id="display-fecha-permiso">
                    <label class="grey-text ml-5" style="font-size: .85rem;">Fecha del permiso</label>
                    <div class="md-form mb-0" style="margin-top: -10px">                    
                        <i class="fa fa-calendar prefix grey-text"></i>
                        <div class="input-group date ml-3 w-100 p-3" id="fecha-permiso" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input ml-3 p-0" 
                                   data-target="#fecha-permiso" autocomplete="off" id="fecha_permiso_nuevo"
                                   style="font-size: 20px"/>
                            <div class="input-group-append" data-target="#fecha-permiso" data-toggle="datetimepicker" style="height: 31px">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>  

                        <script type="text/javascript">
                            $(function () {
                                $('#fecha-permiso').datetimepicker({
                                    locale: 'es',
                                    daysOfWeekDisabled: [0, 6],
                                    minDate: moment(new Date()).format("MM-DD-YYYY"),
                                    weekStart: 1,
                                    forceParse: 0,
                                    format: 'DD-MM-YYYY',
                                    disabledDates: [
                                        "<?php echo $fecha_disabled; ?>"
                                    ]
                                });
                            });
                        </script>
                    </div>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-header">Dirección de la casa</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" name="calle1"
                                       value="<?php echo " $calle1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right">Calle y número</label>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control"
                                       value="<?php echo " $colonia1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right">Colonia</label>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control"
                                       value="<?php echo " $cp1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right">CP</label>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-header">Alumnos</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <?php
                            $consulta1 = $objCliente->mostrar_alumnos($familia);
                            if ($consulta1) {
                                $counter = 0;
                                // $numero = mysql_num_rows($consulta);
                                while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                    $counter++;
                                    ?>
                                    <div class="md-form">
                                        <i class="fas fa-graduation-cap prefix grey-text"></i>
                                        <input style="font-size: 1.4rem" type="text" class="form-control"
                                               value="<?php echo $cliente1['nombre']; ?>" readonly autocomplete="off"
                                               id="nombre_nuevo<?php echo $counter; ?>"/>
                                        <label data-error="wrong" data-success="right">Alumno</label>
                                    </div>
                                    <div class="custom-control custom-switch checks-alumnos">
                                        <input type="checkbox" class="custom-control-input" id="alumno_<?php echo $counter; ?>" value="<?php echo $cliente1['nombre']; ?>">
                                        <label class="custom-control-label" for="alumno_<?php echo $counter; ?>">Seleccionar este alumno</label>
                                    </div>
                                    <hr class="barra-separadora">
                                    <input id="id_alumno_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                    <?php
                                    $talumnos = $counter;
                                }
                            }
                            ?>
                        </span>
                    </div>
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
                                       autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="calle_nuevo">Calle y número</label>
                            </div>
                            <div class="md-form mb-3">
                                <i class="fas fa-map-marked-alt prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" id="colonia_nuevo" name="colonia"
                                       placeholder="Agrega colonia" onkeyup="this.value = this.value.toUpperCase()"
                                       required autocomplete="off" />
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
                                       id="descripcion_recordar_direccion" 
                                       placeholder="Agrega una descripción" 
                                       onkeyup="this.value = this.value.toUpperCase()"
                                       required
                                       autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="descripcion_recordar_direccion">Descripción de la dirección</label>
                                <button type="button" class="btn white-text bg-success w-100" onclick="enviar_direccion()">Guardar</button>  
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
                        <textarea style="font-size: 1.4rem" class="md-textarea form-control" rows="2" 
                                  id="comentarios_nuevo" name="comentarios_nuevo"
                                  onkeyup="this.value = this.value.toUpperCase()"></textarea>
                        <label for="comentarios_nuevo">Comentarios</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning w-100" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn white-text b-azul w-100" onclick="enviar_formulario()">Enviar</button>
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
    function mostrar_ocultar_calendario_permiso() {

        var display_fecha_permiso = $("#display-fecha-permiso");
        var btn_display_fecha_permiso = $("#btn-display-fecha-permiso");

        if (display_fecha_permiso.hasClass("d-none")) {
            display_fecha_permiso.removeClass("d-none");
            btn_display_fecha_permiso.text("ESTABLECER FECHA DE HOY");
        } else {
            display_fecha_permiso.addClass("d-none");
            btn_display_fecha_permiso.text("CAMBIAR FECHA DE PERMISO");
        }
    }
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
                url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/get_consultar_direcciones.php",
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
    function validar_recordar_direccion() {
        //valida calle
        var calle = $("#calle_nuevo");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            calle.focus();
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            swal("Error en colonia", "Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres", "error");
            validar_regex.focus();
            return false;
        }
        return true;
    }
    function enviar_direccion() {
        var calle = $('#calle_nuevo').val();
        var colonia = $('#colonia_nuevo').val();
        var descripcion = $('#descripcion_recordar_direccion').val();
        var validacion = validar_recordar_direccion();
        if (!validacion)
            return;
        if (calle.length > 0 && colonia.length > 0 && descripcion.length > 0) {
            var data = {
                "calle": calle,
                "colonia": colonia,
                "descripcion": descripcion,
                "id_usuario":<?php echo "$id"; ?>
            }
            $.ajax({
                url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/post_nueva_direccion.php",
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
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/get_consultar_direcciones.php",
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
    function validar_regex(reg, val) {
        var regex = new RegExp(reg);
        if (regex.test(val)) {
            return true;
        }
        return false;
    }
    function validar_formulario() {
        //valida checks de alumnos
        var selected = '';
        $('.checks-alumnos input[type=checkbox]').each(function () {
            if (this.checked) {
                selected += $(this).val() + ', ';
            }
        });
        if (selected === '') {
            swal("Información", "Debes seleccionar al menos un alumno para continuar", "error");
            return false;
        }
        //valida seleccion de ruta
        if ($("#ruta_diario").val() === "") {
            swal("Información", "Debes seleccionar una ruta", "error");
            return false;
        }
        //valida calle y colonia
        //valida calle
        var calle = $("#calle_nuevo");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            calle.focus();
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            swal("Error en colonia", "Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres", "error");
            validar_regex.focus();
            return false;
        }
        return true;
    }
    function enviar_formulario() {
        if (validar_formulario()) {
            //fecha solicitud, solicitante, fecha del permiso, nombre del alumno, alumnos, calle, colonia
            var fecha_solicitud_nuevo = $("#fecha_solicitud_nuevo");
            var correo_nuevo = $("#correo_nuevo");
            var fecha_permiso_nuevo = $("#fecha_permiso_nuevo");
            var alumno_1 = $("#id_alumno_1");
            var alumno_2 = $("#id_alumno_2");
            var alumno_3 = $("#id_alumno_3");
            var alumno_4 = $("#id_alumno_4");
            var alumno_5 = $("#id_alumno_5");
            var calle_nuevo = $("#calle_nuevo");
            var colonia_nuevo = $("#colonia_nuevo");
            var comentarios_nuevo = $("#comentarios_nuevo");
            var cp = $("#cp");
            var ruta_diario = $("#ruta_diario");
            var model = {
                idusuario:<?php echo $id; ?>,
                fecha_solicitud_nuevo: fecha_solicitud_nuevo.val(),
                correo_nuevo: correo_nuevo.val(),
                fecha_permiso_nuevo: fecha_permiso_nuevo.val(),
                alumno_1: "",
                alumno_2: "",
                alumno_3: "",
                alumno_4: "",
                alumno_5: "",
                calle_nuevo: calle_nuevo.val(),
                colonia_nuevo: colonia_nuevo.val(),
                cp: cp.val(),
                comentarios_nuevo: comentarios_nuevo.val(),
                ruta_diario: ruta_diario.val(),
                talumnos: <?php echo $talumnos; ?>,
                familia: <?php echo $familia; ?>
            };
            if ($("#alumno_1").prop("checked")) {
                model.alumno_1 = alumno_1.val();
            }
            if ($("#alumno_2").prop("checked")) {
                model.alumno_2 = alumno_2.val();
            }
            if ($("#alumno_3").prop("checked")) {
                model.alumno_3 = alumno_3.val();
            }
            if ($("#alumno_4").prop("checked")) {
                model.alumno_4 = alumno_4.val();
            }
            if ($("#alumno_5").prop("checked")) {
                model.alumno_5 = alumno_5.val();
            }
            $.ajax({
                url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/post_nuevo_permiso_diario.php",
                type: "POST",
                data: model,
                success: function (res) {
                    if (res == 0) {
                        swal("Información", "No puede solicitar un permiso para el dia actual, después de 11:30 AM", "error");
                        setInterval(() => {
                            location.reload();
                        }, 4000);
                    } else if (res == 1) {
                        swal("Información", "Registro exitoso!", "success");
                        setInterval(() => {
                            location.reload();
                        }, 3000);
                    } else {
                        swal("Información", res, "error");
                        setInterval(() => {
                            location.reload();
                        }, 10000);
                    }
                }
            });
        }
    }
</script>