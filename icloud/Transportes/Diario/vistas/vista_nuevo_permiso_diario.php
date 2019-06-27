<?php
include '../../components/layout_top.php';
include '../../components/navbar.php';
session_start(); //session start
//include_once("Model/DBManager.php");
require_once('../../../libraries/Google/autoload.php');
require_once '../../../Model/Config.php';
require_once '../../../Model/Login.php';
//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}
$service = new Google_Service_Oauth2($client);
//echo "$service";
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
$user = $service->userinfo->get(); //get user info
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
$consulta = mysqli_fetch_array($consulta);
$id = $consulta[0];
$id_usuario = $consulta[4];
$familia = $id_usuario;
//zona horaria para America/Mexico_city 
require '../../../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m-d-Y');
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array('Domingo', 'Lunes', 'Martes',
    'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
$hora_limite = $objDateHelper->obtener_hora_limite();
$d_btn_fecha_permiso;
$text_btn_fecha_permiso;
$calendario_fecha_permiso;
$fecha_disabled;
if ($hora_limite) {
    $d_btn_fecha_permiso = "d-none";
    $calendario_fecha_permiso = "";
    $fecha_disabled = date("m-d-Y");
    $msj_hora_limite = "- Seleccione desde la siguiente fecha disponible";
} else {
    $d_btn_fecha_permiso = "";
    $text_btn_fecha_permiso = "ESTABLECER FECHA DE HOY";
    $calendario_fecha_permiso = "d-none";
}
require('../posts_gets/Control_dia.php');
$objDia = new Control_dia();
$consulta2 = $objDia->mostrar_diario($familia);
$domicilio = $objDia->mostrar_domicilio($familia);
$domicilio = mysqli_fetch_array($domicilio);
$papa = $domicilio[0];
$calle = $domicilio[1];
$colonia = $domicilio[2];
$cp = $domicilio[3];
?>            

<div class="row">
    <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
        <br>
        <br>
        <h4 class="center-align c-azul">Nuevo permiso del día</h4>
        <br>
        <div class="row" style="padding:0rem .5rem;">
            <div class="col s12 l6">
                <label for="fecha_solicitud_nuevo" style="margin-left: 1rem">Fecha de solicitud</label>
                <div class="input-field">
                    <i class="material-icons prefix c-azul">calendar_today</i>
                    <input value="<?php
                    echo $arrayDias[date('w')] . " , " . date('d') .
                    " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') .
                    ", " . date("h:i a");
                    ?>" readonly  id="fecha_solicitud_nuevo" style="font-size: 1rem" type="text" >               
                </div>
            </div>
            <div class="col s12 l6">
                <label for="fecha_solicitud_nuevo" style="margin-left: 1rem">Fecha de solicitud</label>
                <div class="input-field">
                    <i class="material-icons prefix c-azul">mail</i>
                    <input value="<?php echo " $correo "; ?>" readonly  id="fecha_solicitud_nuevo" style="font-size: 1rem" type="text" >               
                </div>
            </div>
            <div class="col s12">
                <div class="input-field">
                    <i class="material-icons prefix c-azul">calendar_today</i>                    
                    <label for="fecha_permiso_nuevo" style="font-size:.8rem">Para <?php echo "$msj_hora_limite"; ?> </label>
                    <input type="text" 
                           style="font-size:1rem"
                           id="fecha_permiso_nuevo" 
                           class="datepicker"
                           autocomplete="off">
                </div>
                <script>
                    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                    var monthsShort = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    var weekdays = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    var weekdaysShort = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
                    var weekdaysAbbrev = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
                    var day = new Date("<?php echo "$fecha_disabled"; ?>");
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
            <h4 class="c-azul text-center">Dirección guardada</h4>
            <div class="col s12">
                <label for="calle_guardada_nuevo_<?php echo "$id"; ?>" style="margin-left: 1rem">Calle y número</label>
                <div class="input-field">
                    <i class="material-icons prefix c-azul">person_pin</i>
                    <textarea class="materialize-textarea"
                              readonly  
                              id="calle_guardada_nuevo_<?php echo "$id"; ?>" 
                              style="font-size: .9rem">      
                    </textarea> 
                </div>
                <br>
                <label for="colonia_guardada_nuevo_<?php echo "$id"; ?>" style="margin-left: 1rem">Colonia</label>
                <div class="input-field">
                    <i class="material-icons prefix c-azul">person_pin</i>
                    <textarea class="materialize-textarea"
                              readonly  
                              id="colonia_guardada_nuevo_<?php echo "$id"; ?>"
                              style="font-size: .9rem"> 
                    </textarea>      
                </div>
                <br>
                <label for="cp_guardada_nuevo_<?php echo "$id"; ?>" style="margin-left: 1rem">CP</label>
                <div class="input-field">
                    <i class="material-icons prefix c-azul">person_pin</i>
                    <input readonly  
                           id="cp_guardada_nuevo_<?php echo "$cp"; ?>"
                           style="font-size: .9rem"
                           value="<?php echo $cp; ?>">       
                </div>
            </div>
            <div class="col s12">
                <h4 class="c-azul text-center">Alumnos</h4>
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
                                      id="nombre_nuevo<?php echo $counter; ?>"
                                      style="font-size: 1rem">  
                            </textarea>
                        </div>
                        <div class="switch col s12">
                            <label class="checks-alumnos">
                                <input type="checkbox" 
                                       id="alumno_<?php echo $counter; ?>" 
                                       value="<?php echo $cliente1['nombre']; ?>">
                                <span class="lever"></span>
                            </label>
                        </div>
                        <br>
                        <input id="id_alumno_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                        <br>
                        <br>
                        <script>
                            $('#nombre_nuevo<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                            M.textareaAutoResize($('#nombre_nuevo<?php echo $counter; ?>'));
                        </script>
                        <?php
                        $talumnos = $counter;
                    }
                }
                ?>
            </div>  
            <br>         
            <h4 class="c-azul text-center">Dirección de permiso</h4>
            <div class="input-field col s12">
                <i class="material-icons c-azul">store_mall_directory</i>
                <select id="reside" class="input-field" onchange="cambiar_direccion('<?php echo $id; ?>')">
                </select>
                <label>Direcciones guardadas</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons c-azul">store_mall_directory</i>
                <textarea id="calle_nuevo" 
                          class="materialize-textarea"                                
                          placeholder="INGRESE CALLE Y NUMERO"></textarea>    
            </div>
            <div class="input-field col s12">
                <i class="material-icons c-azul">store_mall_directory</i>
                <textarea class="materialize-textarea"  
                          id="colonia_nuevo" 
                          placeholder="INGRESE COLONIA"></textarea> 
            </div>
            <input name="cp" type="hidden" id="cp" value="00000"  />  
            <div class="input-field col s12">     
                <p>
                    <label>
                        <input type="checkbox" 
                               class="filled-in c-azul" 
                               id="recordar_direccion" 
                               onchange="recordar_direccion()" />
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
                    <button type="button" class="btn white-text b-azul w-100" onclick="enviar_direccion()">Guardar</button>
                </div>
            </div>  
            <br>
            <div>
                <div class="input-field col s12">
                    <i class="material-icons c-azul">departure_board</i>
                    <select class="input-field" id="ruta_diario" >
                        <option value="">Seleccione ruta</option>
                        <option value="General 2:50 PM">General 2:50 PM</option>
                        <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="input-field col s12">
                <i class="material-icons c-azul">comment</i>
                <textarea id="comentarios_nuevo" 
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
            <br>
        </div>
    </div>
</div>
<!-- Modal advertencia -->
<div id="modal_alerta" class="modal">
    <div class="modal-content orange lighten-2">
        <div>
            <h6 class="">Información importante</h6>
            Los cambios para el mismo día deberán solicitarse antes de las 11:30 horas,
            ya que el sistema no permitirá realizar solicitudes después del horario establecido,
            sin embargo podrá hacer solicitudes para fechas posteriores.<br>
            <strong><b>NOTA:!</b></strong> Todas las solicitudes están sujetas a disponibilidad.
        </div>  
    </div>
    <div class="modal-footer orange accent-1">
        <a href="#!" class="modal-close waves-effect waves-orange btn-flat"><b>Cerrar</b></a>
    </div>
</div>
<!--Botón flotante de acciones-->

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul">
        <i class="large material-icons">edit</i>
    </a>
    <ul>
        <li>
            <a class="btn-floating blue" href="javascript:history.back(0)">
                <i class="material-icons">keyboard_backspace</i>
            </a>
        </li>
        <?php
        echo '<li><a href="' . $redirect_uri . '?logout=1" class="btn-floating red" >'
        . "<i class='material-icons'>exit_to_app</i>Salir</a></li>";
        ?>
    </ul>
</div>

<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        var instance = M.Modal.getInstance($("#modal_alerta"));
        instance.open();
        consultar_direcciones();

        //redimenciona el tamaño y el value de los textareas
        M.textareaAutoResize($('#comentarios_nuevo'));
        M.textareaAutoResize($('#calle_nuevo'));
        M.textareaAutoResize($('#colonia_nuevo'));
        //direccion guardada
        $('#calle_guardada_nuevo_<?php echo "$id"; ?>').val('<?php echo $calle; ?>');
        M.textareaAutoResize($('#calle_guardada_nuevo_<?php echo "$id"; ?>'));
        $('#colonia_guardada_nuevo_<?php echo "$id"; ?>').val('<?php echo $colonia; ?>');
        M.textareaAutoResize($('#colonia_guardada_nuevo_<?php echo "$id"; ?>'));

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
    function cambiar_direccion(id) {
        var dato = $('select[id=reside]').val();
        if (dato == '0') {
            $("#calle_nuevo").val("");
            $("#colonia_nuevo").val("");
            $("#cp_nuevo").val("");
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
        }
        if (dato == '1') {
            $("#calle_nuevo").val("Periferico Boulevard Manuel Avila Camacho 620");
            $("#colonia_nuevo").val("Lomas de Sotelo");
            $("#cp_nuevo").val("53538");
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
                            $("#calle_nuevo").val(data[key].calle);
                            $("#colonia_nuevo").val(data[key].colonia);
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
    function recordar_direccion() {
        if ($('#recordar_direccion').is(":checked")) {
            $('#container_descripcion_recordar_direccion').show();
            consultar_direcciones();
            return;
        }
        $('#container_descripcion_recordar_direccion').hide();
        $('#descripcion_recordar_direccion').val("");
        $('#calle_nuevo').focus();
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
            url: "../posts_gets/get_consultar_direcciones.php",
            type: "GET",
            data: {"id_usuario": <?php echo $id; ?>},
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
    function validar_regex(reg, val) {
        var regex = new RegExp(reg);
        if (regex.test(val)) {
            return true;
        }
        return false;
    }
    function validar_formulario() {
        //validar fecha 
        var fecha_disabled = '<?php echo "$fecha_disabled"; ?>';
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
        //valida seleccion de ruta
        if ($("#ruta_diario").val() === "") {
            swal("Información", "Debes seleccionar una ruta", "error");
            return false;
        }
        return true;
    }
    function formatear_fecha_calendario(fecha) {
        var fecha = $("#fecha_permiso_nuevo").val();
        var dia = fecha.split(" ")[1];
        var mes = fecha.split(" ")[3];
        var anio = fecha.split(" ")[5];
        if (mes === "Enero")
            mes = "01";
        if (mes === "Febrero")
            mes = "02";
        if (mes === "Marzo")
            mes = "03";
        if (mes === "Abril")
            mes = "04";
        if (mes === "Mayo")
            mes = "05";
        if (mes === "Junio")
            mes = "06";
        if (mes === "Julio")
            mes = "07";
        if (mes === "Agosto")
            mes = "08";
        if (mes === "Septiembre")
            mes = "09";
        if (mes === "Octubre")
            mes = "10";
        if (mes === "Noviembre")
            mes = "11";
        if (mes === "Diciembre")
            mes = "12";
        return `${dia}-${mes}-${anio}`;
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