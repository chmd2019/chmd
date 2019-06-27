<?php
include '../../components/layout_top.php';
include '../../components/navbar.php';
session_start();
require_once('../../../libraries/Google/autoload.php');
require_once '../../../Model/Login.php';
require_once '../../../Model/DBManager.php';
require_once '../../../Model/Config.php';

if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}

$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit;
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
}
if (isset($authUrl)) {
    ?>
    <div class="caja-login" align="center">
        <h5 class="c-azul">Mi Maguen</h5>
        <?php echo '<a href="' . $authUrl . '"><img class = "logo-login" src="../../../images/google.png"/></a>' ?>
    </div>
    <?php
} else {
    $user = $service->userinfo->get(); //get user info
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->Acceso($correo);
    if ($consulta = mysqli_fetch_array($consulta)) {
        $id = $consulta[0];
        $correo = $consulta[1];
        $perfil = $consulta[2];
        $status = $consulta[3];
        $familia = $consulta[4];

        require_once '../posts_gets/Control_temporal.php';
        $control_temporal = new Control_temporal();
        $domicilio = $control_temporal->mostrar_domicilio($familia);
        $domicilio = mysqli_fetch_array($domicilio);

        $papa = $domicilio[0];
        $calle = $domicilio[1];
        $colonia = $domicilio[2];
        $cp = $domicilio[3];
        $time = time();
        //manejo de fechas
        $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $arrayDias = array('Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado');
        ?>
        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
                <br>
                <br>
                <h5 class="center-align c-azul">Nuevo permiso temporal</h5>
                <br>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <label for="fecha_solicitud_permiso_temporal" style="margin-left: 1rem">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" readonly  id="fecha_solicitud_permiso_temporal" style="font-size: 1rem" type="text" >               
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <label for="solicitante_permiso_temporal" style="margin-left: 1rem">Solicitante</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $correo; ?>" readonly  id="solicitante_permiso_temporal" style="font-size: 1rem" type="text" >               
                        </div>
                    </div>    
                    <br>
                    <div class="col s12">
                        <h5 class="c-azul text-center">Alumnos</h5>
                        <?php
                        $consulta1 = $objCliente->mostrar_alumnos($familia);
                        if ($consulta1) {
                            $counter = 0;
                            // $numero = mysql_num_rows($consulta);
                            while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                $counter++;
                                ?>
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">school</i>
                                    <textarea class="materialize-textarea"
                                              readonly  
                                              id="nombre_nuevo_permiso_temporal_<?php echo $counter; ?>"
                                              style="font-size: 1rem">  
                                    </textarea>
                                </div>
                                <div class="switch col s12">
                                    <label class="checks-alumnos">
                                        <input type="checkbox" 
                                               id="alumno_permiso_temporal_<?php echo $counter; ?>" 
                                               value="<?php echo $cliente1['nombre']; ?>">
                                        <span class="lever"></span>
                                    </label>
                                </div>
                                <br>
                                <input id="id_alumno_permiso_temporal_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                <br>
                                <br>
                                <script>
                                    $('#nombre_nuevo_permiso_temporal_<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                                    M.textareaAutoResize($('#nombre_nuevo_permiso_temporal_<?php echo $counter; ?>'));
                                </script>
                                <?php
                                $talumnos = $counter;
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <h5 class="center-align c-azul">Dirección de Casa</h5>
                    <br>
                    <div class="col s12">
                        <label for="calle_guardada_nuevo" style="margin-left: 1rem">Calle y número</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="calle_guardada_temporal" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                        <br>
                        <label for="colonia_guardada_nuevo" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="colonia_guardada_temporal"
                                      style="font-size: .9rem"></textarea>      
                        </div>
                        <br>
                        <label for="cp_guardada_temporal" style="margin-left: 1rem">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  
                                   id="cp_guardada_temporal"
                                   style="font-size: .9rem"
                                   value="">       
                        </div>
                    </div>                
                    <br>
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <select id="reside" class="input-field" onchange="cambiar_direccion('<?php echo $id; ?>')">
                        </select>
                        <label style="margin-left: 1rem">Direcciones guardadas</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <textarea id="calle_nuevo_permiso_temporal" 
                                  class="materialize-textarea"                                
                                  placeholder="INGRESE CALLE Y NUMERO"></textarea>    
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <textarea class="materialize-textarea"  
                                  id="colonia_nuevo_permiso_temporal" 
                                  placeholder="INGRESE COLONIA"></textarea> 
                    </div>
                    <input name="cp" type="hidden" id="cp" value="00000"  />  
                    <div class="input-field col s12">     
                        <p>
                            <label>
                                <input type="checkbox" 
                                       class="filled-in c-azul" 
                                       id="recordar_direccion" 
                                       onchange="recordar_direccion()"
                                       />
                                <span>Rercordar dirección</span>
                            </label>
                        </p>    

                    </div>
                    <br>
                    <div id="container_descripcion_recordar_direccion" hidden>
                        <div class="input-field col s12" id="container_descripcion_recordar_direccion">
                            <i class="material-icons prefix c-azul">store_mall_directory</i>
                            <input id="descripcion_recordar_direccion" 
                                   placeholder="Descripción de la dirección"
                                   autocomplete="off" />
                            <button type="button" class="btn white-text b-azul w-100" onclick="">Guardar</button>
                        </div>
                    </div>  
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person</i>
                        <textarea id="nombre_nuevo_permiso_temporal" 
                                  class="materialize-textarea"                                
                                  placeholder="Nombre"></textarea>    
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons c-azul">people</i>
                        <input placeholder="Parentesco" id="parentesco_nuevo_permiso_temporal" type="text">
                        <label for="first_name">Parentesco</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons c-azul">smartphone</i>
                        <input placeholder="Celular" id="celular_nuevo_permiso_temporal" type="text">
                        <label for="first_name">Celular</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons c-azul">phone_in_talk</i>
                        <input placeholder="Teléfono" id="telefono_nuevo_permiso_temporal" type="text">
                        <label for="first_name">Teléfono</label>
                    </div>                
                    <br>
                    <h5 class="col s12 center-align c-azul">Fecha de cambio</h5>
                    <br>

                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>                    
                            <label for="fecha_inicio_nuevo_permiso_temporal" style="font-size:.8rem">Fecha inicial </label>
                            <input type="text" 
                                   style="font-size:1rem"
                                   id="fecha_inicio_nuevo_permiso_temporal" 
                                   class="datepicker"
                                   autocomplete="off">
                        </div>
                        <script>
                            var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                            var monthsShort = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                            var weekdays = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                            var weekdaysShort = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
                            var weekdaysAbbrev = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
                            var day = new Date("");
                            real_day = day.getDate();
                            var disbaleDays = function (day) {
                                var dates = [
                                    new Date(day.getFullYear(), day.getMonth(), real_day).toDateString()
                                ];
                                if (dates.indexOf(day.toDateString()) >= 0) {
                                    return true; // Disables date.
                                }
                                return false; // Date is availble.
                            }
                            $('.datepicker').datepicker({
                                firstDay: true,
                                disableWeekends: true,
                                minDate: new Date(),
                                format: 'dddd, dd De mmmm De yyyy',
                                disableDayFn: disbaleDays,
                                i18n: {
                                    cancel: 'Cancelar',
                                    clear: 'Limpar',
                                    done: 'Aceptar',
                                    months,
                                    monthsShort,
                                    weekdays,
                                    weekdaysShort,
                                    weekdaysAbbrev,
                                }
                            });
                        </script>
                        <br>
                        <br>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>                    
                            <label for="fecha_final_nuevo_permiso_temporal" style="font-size:.8rem">Fecha final </label>
                            <input type="text" 
                                   style="font-size:1rem"
                                   id="fecha_final_nuevo_permiso_temporal" 
                                   class="datepicker"
                                   autocomplete="off">
                        </div>
                        <script>
                            var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                            var monthsShort = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                            var weekdays = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                            var weekdaysShort = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
                            var weekdaysAbbrev = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
                            var day = new Date("");
                            real_day = day.getDate();
                            var disbaleDays = function (day) {
                                var dates = [
                                    new Date(day.getFullYear(), day.getMonth(), real_day).toDateString()
                                ];
                                if (dates.indexOf(day.toDateString()) >= 0) {
                                    return true; // Disables date.
                                }
                                return false; // Date is availble.
                            }
                            $('.datepicker').datepicker({
                                firstDay: true,
                                disableWeekends: true,
                                minDate: new Date(),
                                format: 'dddd, dd De mmmm De yyyy',
                                disableDayFn: disbaleDays,
                                i18n: {
                                    cancel: 'Cancelar',
                                    clear: 'Limpar',
                                    done: 'Aceptar',
                                    months,
                                    monthsShort,
                                    weekdays,
                                    weekdaysShort,
                                    weekdaysAbbrev,
                                }
                            });
                        </script>
                        <br>
                        <br>
                    </div>
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">departure_board</i>
                        <select class="input-field" id="ruta_diario" >
                            <option value="">Seleccione ruta</option>
                            <option value="General 2:50 PM">General 2:50 PM</option>
                            <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                        </select>
                    </div> 
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">comment</i>
                        <textarea id="comentarios_nuevo_permiso_temporal" 
                                  class="materialize-textarea"                                
                                  placeholder="Comentarios"></textarea>    
                    </div>
                    <div class="col s12 l6" style="float: none;margin: 0 auto;">
                        <button class="btn waves-effect waves-light b-azul white-text w-100" 
                                type="button" 
                                onclick="enviar_formulario()">Enviar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    $(document).ready(function () {
        //redimenciona el tamaño y el value de los textareas
        $('#calle_guardada_temporal').val('<?php echo $calle; ?>');
        M.textareaAutoResize($('#calle_guardada_temporal'));
        $('#colonia_guardada_temporal').val('<?php echo $colonia; ?>');
        M.textareaAutoResize($('#colonia_guardada_temporal'));
        $('#cp_guardada_temporal').val('<?php echo $cp; ?>');
        M.textareaAutoResize($('#cp_guardada_temporal'));
        M.textareaAutoResize($('#nombre_nuevo_permiso_temporal'));
        //inicia select
        $('select').formSelect();
        //consulta de direcciones
        consultar_direcciones();
    });
    function consultar_direcciones() {
        var data = [];
        $.ajax({
            url: "../posts_gets/get_consultar_direcciones.php",
            type: "GET",
            data: {"id_usuario": "<?php echo $id; ?>"},
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
                $('select').formSelect();
            }
        });
        return data;
    }
    function recordar_direccion() {
        if ($('#recordar_direccion').is(":checked")) {
            $('#container_descripcion_recordar_direccion').show();
            consultar_direcciones();
            return;
        }
        $('#container_descripcion_recordar_direccion').hide();
        $('#descripcion_recordar_direccion').val("");
        $('#calle_nuevo_permiso_temporal').focus();
    }
    function cambiar_direccion(id) {
        var dato = $('select[id=reside]').val();
        if (dato == '0') {
            $("#calle_nuevo_permiso_temporal").val("");
            $("#colonia_nuevo_permiso_temporal").val("");
            $("#cp_nuevo_permiso_temporal").val("");
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
        }
        if (dato == '1') {
            $("#calle_nuevo_permiso_temporal").val("Periferico Boulevard Manuel Avila Camacho 620");
            $("#colonia_nuevo_permiso_temporal").val("Lomas de Sotelo");
            $("#cp_nuevo_permiso_temporal").val("53538");
            //limpia recordar direccion
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
        }
        if (dato !== "0" && dato !== "1") {
            var data = [];
            $.ajax({
                url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/get_consultar_direcciones.php",
                type: "GET",
                data: {"id_usuario": id},
                success: function (res) {
                    res = JSON.parse(res);
                    for (var key in res) {
                        data.push(res[key]);
                    }
                    for (var key in data) {
                        if (data[key].id_direccion === dato) {
                            $("#calle_nuevo_permiso_temporal").val(data[key].calle);
                            $("#colonia_nuevo_permiso_temporal").val(data[key].colonia);
                        }
                    }
                }
            });
            //limpia recordar direccion
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
        }

    }   
    function validar_regex(reg, val) {
        var regex = new RegExp(reg);
        if (regex.test(val)) {
            return true;
        }
        return false;
    }
    function validar_formulario() {
        //validar fecha 
        /*var fecha_disabled = ' ?php echo "$fecha_disabled"; ?>';
        if (fecha_disabled.length > 0 ||
                fecha_disabled !== null ||
                fecha_disabled !== "") {
            var mes = new Date().getMonth() + 1 < 10 ? `0${new Date().getMonth() + 1}` : new Date().getMonth() + 1;
            var fecha_actual = `${new Date().getDate()}-${mes}-${new Date().getFullYear()}`;
            var fecha_permiso_nuevo = $("#fecha_permiso_nuevo");
            if (fecha_actual === formatear_fecha_calendario(fecha_permiso_nuevo.val())) {
                swal("Información", "Debe seleccionar una fecha posterior a la actual, hora límite alcanzada", "error");
                fecha_permiso_nuevo.val("");
                fecha_permiso_nuevo.focus();
                return false;
            }
            if (fecha_permiso_nuevo.val() === "" || fecha_permiso_nuevo.val() === null) {
                swal("Información", "Debe seleccionar una fecha válida", "error");
                return false;
            }
        }
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
        //valida calle y colonia
        //valida calle
        */
        var calle = $("#calle_nuevo_permiso_temporal");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            calle.focus();
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_temporal");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            swal("Error en colonia", "Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres", "error");
            validar_regex.focus();
            return false;
        }
        //valida nombre*
        var nombre_nuevo_permiso_temporal = $("#nombre_nuevo_permiso_temporal");
        var regex_nombre_nuevo_permiso_temporal = "[A-Za-z ]{5,256}";
        if (!validar_regex(regex_nombre_nuevo_permiso_temporal, nombre_nuevo_permiso_temporal.val())) {
            swal("Error en nombre", "Agregue nombre sin acentos ni signos especiales", "error");
            nombre_nuevo_permiso_temporal.focus();
            return false;
        }
        //valida parentesco*
        var parentesco_nuevo_permiso_temporal = $("#parentesco_nuevo_permiso_temporal");
        var regex_parentesco_nuevo_permiso_temporal = "[A-Za-z ]{5,256}";
        if (!validar_regex(regex_parentesco_nuevo_permiso_temporal, parentesco_nuevo_permiso_temporal.val())) {
            swal("Error en parentesco", "Agregue parentesco sin acentos ni signos especiales", "error");
            parentesco_nuevo_permiso_temporal.focus();
            return false;
        }
        //valida celular*
        var celular_nuevo_permiso_temporal = $("#celular_nuevo_permiso_temporal");        
        if ($('#celular_nuevo_permiso_temporal').val().length == 8 || 
                $('#celular_nuevo_permiso_temporal').val().length == 10)
        {
            return;
        } else {
            celular_nuevo_permiso_temporal.focus();
            swal("Error en celular", "Agregue celular con 8 o 10 dígitos", "error");
            return false;
        }
        //valida seleccion de ruta   telefono_nuevo_permiso_temporal
        if ($("#ruta_diario").val() === "") {
            swal("Información", "Debes seleccionar una ruta", "error");
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
                fecha_permiso_nuevo: formatear_fecha_calendario(comentarios_nuevo.val()),
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
                            history.back();
                        }, 1500);
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

<?php include '../../components/layout_bottom.php'; ?>

