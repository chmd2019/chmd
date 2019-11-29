<?php
session_start();

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";

$idseccion = $_GET['idseccion'];

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
    header("Location: $redirect_uri?logout=1");
} else {
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    $hora_limite = $date_helper->obtener_hora_limite();
    if ($hora_limite) {
        $fecha_disabled = date("m-d-Y");
        $msj_hora_limite = "- Seleccione desde la siguiente fecha disponible";
    }
    if ($consulta = mysqli_fetch_array($consulta)) {
        $id = $consulta[0];
        $nombre = $consulta[1];
        $familia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);
        require_once "$root_icloud/Transportes/common/ControlTransportes.php";
        $control_temporal = new ControlTransportes();
        $domicilio = $control_temporal->mostrar_domicilio($familia);
        $domicilio = mysqli_fetch_array($domicilio);
        $calle = $domicilio[0];
        $colonia = $domicilio[1];
        $cp = $domicilio[2];
        $time = time();
        //manejo de fechas
        $arrayMeses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

        $arrayDias = array('Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado');
        $fecha_minima = date("Y-m-d");
        $fecha_hoy = $arrayDias[date('w')] . ", " . date('d') .
                " de " . $arrayMeses[date('m') - 1] . " de " . date('Y');
        $btn_fecha = true;
        if ($date_helper->obtener_hora_limite()) {
            $fecha_minima = strtotime("+1 day", strtotime($fecha_minima));
            $fecha_minima = date("m/d/Y", $fecha_minima);
            $fecha_hoy = "";
            $btn_fecha = false;
        } else {
            $fecha_minima = date("m/d/Y");
            $btn_fecha = true;
        }
        $rutas = $control_temporal->consulta_rutas();
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d MYH:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        include "$root_icloud/components/navbar.php";
        ?>
        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
                <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
                    <a class="waves-effect waves-light"
                       href="<?php echo $redirect_uri ?>Transportes/Diario/PDiario.php?idseccion=<?php echo $idseccion; ?>">
                        <img src='../../../images/Atras.svg' style="width: 110px">
                    </a>
                </div>
                <h5 class="center-align c-azul">Cambio del día</h5>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php
                            echo $arrayDias[date('w')] . ", " . date('d') .
                            " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') .
                            ", " . date("h:i a");
                            ?>" readonly  id="fecha_creacion" style="font-size: 1rem" type="text" >
                            <label for="fecha_creacion" style="margin-left: 1rem">Fecha de solicitud</label>
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="responsable" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo " $nombre "; ?>" readonly  id="responsable" style="font-size: 1rem" type="text" >
                        </div>
                    </div>
                    <?php
                    if ($btn_fecha) {
                        $hidden = "hidden";
                        ?>
                        <div class="text-center">
                            <a href="#!" class="waves-effect waves-light" onclick="mostrar_fecha_para()">
                                Si su permiso es para otro día seleccione aquí<br>
                                <i class="material-icons prefix c-azul">calendar_today</i>
                            </a>
                        </div>
                        <?php
                    } else {
                        $hidden = "";
                        echo "$btn_fecha";
                    }
                    ?>
                    <div class="col s12" id="fecha_para" <?php echo $hidden; ?>>
                        <link rel='stylesheet' href='../../common/css/calendario.css'>
                        <script src='../../common/js/calendario.js'></script>
                        <script src="../../common/js/common.js"></script>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input
                                value ="<?php echo $fecha_hoy; ?>"
                                type="text"
                                class="datepicker"
                                id="fecha_solicitud_nuevo"
                                placeholder="Para el día"
                                onchange="fecha_minusculas(this.value, 'fecha_solicitud_nuevo');asigna_ruta_viernes(this.value);">
                            <label for="fecha_solicitud_nuevo" style="margin-left: 1rem">Para el día</label>
                        </div>
                    </div>
                    <script>
                        //obtiene el calendario escolar en db
                        var calendario_escolar = obtener_calendario_escolar();
                        //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
                        calendario_escolar.push(6);
                        calendario_escolar.push(7);
                        //fix de error al mostrar calendario (se oculta inmediatamente se abre)
                        $(".datepicker").on('mousedown', function (event) {
                            event.preventDefault();
                        });
                        $('.datepicker').pickadate({
                            format: 'dddd, dd De mmmm De yyyy',
                            today: false,
                            clear: false,
                            close: 'Aceptar',
                            closeOnSelect: false,
                            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                            weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
                            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                            weekdaysLetter: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                            disable: calendario_escolar,
                            firstDay: 1,
                            disableWeekends: true,
                            min: new Date('<?php echo $fecha_minima; ?>')
                        });
                    </script>
                    <div class="col s12">
                        <h5 class="c-azul text-center">Selecciona Alumnos</h5>
                        <?php
                        $consulta1 = $objCliente->mostrar_alumnos($familia);
                        if ($consulta1) {
                            $counter = 0;
                            // $numero = mysql_num_rows($consulta);
                            while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                $counter++;
                                ?>
                                <div class="input-field">
                                    <div class="switch col s1">
                                        <label class="checks-alumnos">
                                            <input type="checkbox"
                                                   id="alumno_permiso_temporal_<?php echo $counter; ?>"
                                                   value="<?php echo $cliente1['id']; ?>"/>
                                            <span class="lever" style="margin-top:1rem;margin-left: 0px;"></span>
                                        </label>
                                    </div>
                                    <textarea class="materialize-textarea col s10 l11"
                                              readonly
                                              id="nombre_nuevo_permiso_temporal_<?php echo $counter; ?>"
                                              style="font-size: 1rem;float: right;"></textarea>
                                </div>
                                <br style="clear:both">
                                <input id="id_alumno_permiso_temporal_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
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
                    <span class="col s12"><br></span>
                    <h5 class="center-align c-azul">Dirección de Casa</h5>
                    <div class="col s12">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="calle_guardada"
                                      style="font-size: .9rem"></textarea>
                            <label for="calle_guardada" style="margin-left: 1rem">Calle y Número</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="colonia_guardada"
                                      style="font-size: .9rem"></textarea>
                            <label for="colonia_guardada" style="margin-left: 1rem">Colonia</label>
                        </div>
                        <div class="input-field" hidden>
                            <label for="cp_guardada" style="margin-left: 1rem">CP</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly
                                   id="cp_guardada"
                                   style="font-size: .9rem"
                                   value=""/>
                        </div>
                        <h5 class="center-align c-azul">Dirección de cambio</h5>

                        <label style="margin-left: 1rem">
                            <i class="material-icons c-azul prefix">person_pin_circle</i>Dirección Guardada
                        </label>
                        <div class="input-field col s12">
                            <select id="reside" 
                                    class="browser-default border-azul" 
                                    onchange="cambiar_direccion('<?php echo $id; ?>')">
                            </select>
                        </div>
                        <div class="input-field col s12">
                            <label for="calle_nuevo_permiso" style="margin-left: 1rem">Calle y Número</label>
                            <i class="material-icons c-azul prefix">person_pin_circle</i>
                            <textarea id="calle_nuevo_permiso"
                                      class="materialize-textarea"
                                      onkeyup ="capitaliza_primer_letra(this.id)"
                                      placeholder="INGRESE CALLE Y NUMERO"></textarea>
                        </div>
                        <div class="input-field col s12" style="margin-top: -.3rem">
                            <label for="colonia_nuevo_permiso" style="margin-left: 1rem">Colonia</label>
                            <i class="material-icons c-azul prefix">person_pin_circle</i>
                            <textarea class="materialize-textarea"
                                      id="colonia_nuevo_permiso"
                                      onkeyup ="capitaliza_primer_letra(this.id)"
                                      placeholder="INGRESE COLONIA"></textarea>
                        </div>
                        <div class="input-field col s12" hidden>
                            <label for="cp " style="margin-left: 1rem">CP</label>
                            <i class="material-icons c-azul prefix">person_pin_circle</i>
                            <input placeholder="INGRESE CP"
                                   autocomplete="off"
                                   id="cp"
                                   type="tel"
                                   onkeypress="return validar_solo_numeros(event)">
                        </div>
                        <div class="switch col s12">
                            <label>
                                <input type="checkbox"
                                       id="recordar_direccion"
                                       onchange="recordar_direccion()"/>
                                <span>Rercordar dirección </span>
                            </label>
                        </div>
                        <br>
                        <div id="container_descripcion_recordar_direccion" hidden>
                            <div class="input-field col s12" id="container_descripcion_recordar_direccion">
                                <i class="material-icons prefix c-azul">store_mall_directory</i>
                                <input id="descripcion_recordar_direccion"
                                       onkeyup ="capitaliza_primer_letra(this.id)"
                                       placeholder="Descripción de la dirección"
                                       autocomplete="off" />
                                <button type="button"
                                        class="btn waves-effect waves-light white-text b-azul w-100"
                                        onclick="enviar_direccion()">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <span class="col s12"><br></span>
                    <?php if (date("N") == 5): ?>
                        <label>
                            &nbsp;&nbsp;&nbsp;<i class="material-icons c-azul prefix">departure_board</i>Ruta
                        </label>
                        <div class="input-field col s12">
                            <select class="browser-default border-azul" 
                                    id="ruta" 
                                    title="Selecciona tu ruta"
                                    disabled>
                                        <?php
                                        if (mysqli_num_rows($rutas)):
                                            while ($row = mysqli_fetch_array($rutas)):
                                                if ($row[2]):
                                                    ?>
                                            <option value="<?php echo $row[0]; ?>" selected><?php echo $row[1]; ?></option>
                                            <?php
                                        endif;
                                    endwhile;
                                endif;
                                ?>
                            </select>
                        </div>
                    <?php else: ?>   
                        <label>
                            &nbsp;&nbsp;&nbsp;<i class="material-icons c-azul prefix">departure_board</i>Ruta
                        </label>   
                        <div class="input-field col s12">                      
                            <select class="browser-default border-azul" 
                                    id="ruta">
                                <option value="" selected>Selecciona tu ruta</option>
                                <?php
                                if (mysqli_num_rows($rutas)):
                                    while ($row = mysqli_fetch_array($rutas)):
                                        ?>
                                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                        <?php
                                    endwhile;
                                endif;
                                ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul prefix">comment</i>
                        <textarea id="comentarios_nuevo_permiso"
                                  class="materialize-textarea"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  placeholder="Comentarios"></textarea>
                        <label>Comentarios</label>
                        <div class="col s12 l6" style="float: none;margin: 0 auto;">
                            <button class="btn efecto-btn b-azul white-text w-100"
                                    id="btn_enviar_formulario"
                                    type="button"
                                    onclick="enviar_formulario('<?php echo $id; ?>', '<?php echo $familia; ?>', 1)">Enviar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div class="loading" id="loading" >
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var coleccion_ids = [];
    $(document).ready(function () {
        $("#loading").hide();
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        var instance = M.Modal.getInstance($("#modal_alerta"));
        instance.open();
        //inicia select
        $('select').formSelect();
        //consulta de direcciones
        consultar_direcciones("<?php echo $id; ?>");
        $('#calle_guardada').val('<?php echo $calle; ?>');
        M.textareaAutoResize($('#calle_guardada'));
        $('#colonia_guardada').val('<?php echo $colonia; ?>');
        M.textareaAutoResize($('#colonia_guardada'));
        $('#cp_guardada').val('<?php echo $cp; ?>');
    });
    //oculta o muestra el calendario en funcion de la hora límite para realizar solicitudes
    function mostrar_fecha_para() {
        if ($("#fecha_para").prop("hidden")) {
            $("#fecha_para").prop("hidden", false);
            $("#fecha_solicitud_nuevo").val("");
        } else {
            $("#fecha_para").prop("hidden", true);
            $("#fecha_solicitud_nuevo").val("<?php
echo $arrayDias[date('w')] . ", " . date('d') .
 " de " . $arrayMeses[date('m') - 1] . " de " . date('Y');
?>");
        }
    }
    function cambiar_direccion(id) {
        var dato = $('select[id=reside]').val();
        if (dato === '0') {
            $("#calle_nuevo_permiso").val("");
            $("#colonia_nuevo_permiso").val("");
            $("#cp_nuevo_permiso").val("");
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
            $('#cp').val("");
        }
        if (dato === '1') {
            $("#calle_nuevo_permiso").val("Periferico Boulevard Manuel Avila Camacho 620");
            M.textareaAutoResize($('#calle_nuevo_permiso'));
            $("#colonia_nuevo_permiso").val("Lomas de Sotelo");
            M.textareaAutoResize($('#colonia_nuevo_permiso'));
            $("#cp").val("53538");
            //limpia recordar direccion
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
        }
        if (dato !== "0" && dato !== "1") {
            var data = [];
            $.ajax({
                url: "/pruebascd/icloud/Transportes/common/get_consultar_direcciones.php",
                type: "GET",
                data: {"id_usuario": id},
                beforeSend: function () {
                    $("#loading").fadeIn("slow");
                },
                success: function (res) {
                    res = JSON.parse(res);
                    for (var key in res) {
                        data.push(res[key]);
                    }
                    for (var key in data) {
                        if (data[key].id_direccion === dato) {
                            $("#calle_nuevo_permiso").val(data[key].calle);
                            M.textareaAutoResize($('#calle_nuevo_permiso'));
                            $("#colonia_nuevo_permiso").val(data[key].colonia);
                            M.textareaAutoResize($('#colonia_nuevo_permiso'));
                            $("#cp").val(data[key].cp);
                        }
                    }
                }
            }).always(function () {
                setInterval(function () {
                    $("#loading").fadeOut("slow");
                }, 1000);
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
            consultar_direcciones("<?php echo $id; ?>");
            return;
        }
        $('#container_descripcion_recordar_direccion').hide();
        $('#descripcion_recordar_direccion').val("");
        $('#calle_nuevo_permiso').focus();
    }
    function validar_recordar_direccion() {
        //valida calle
        var calle = $("#calle_nuevo_permiso");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            M.toast({
                html: 'Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            M.toast({
                html: 'Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida DESCRIPCION*
        var descripcion = $("#descripcion_recordar_direccion");
        if (descripcion.val().length === 0) {
            M.toast({
                html: 'Agrega descripción',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    function enviar_direccion() {
        var calle = $('#calle_nuevo_permiso').val();
        var colonia = $('#colonia_nuevo_permiso').val();
        var descripcion = $('#descripcion_recordar_direccion').val();
        var cp = $('#cp').val();
        var validacion = validar_recordar_direccion();
        if (!validacion)
            return;
        if (calle.length > 0 && colonia.length > 0 && descripcion.length > 0) {
            var data = {
                "calle": calle,
                "colonia": colonia,
                "descripcion": descripcion,
                "cp": cp,
                "id_usuario":<?php echo $id; ?>,
                "familia":<?php echo $familia; ?>
            }
            $.ajax({
                url: "/pruebascd/icloud/Transportes/common/post_nueva_direccion.php",
                type: "POST",
                data: data,
                beforeSend: function () {
                    $("#loading").fadeIn("slow");
                },
                success: function () {
                    M.toast({
                        html: `Registro exitoso!, puedes seleccionar tu nueva dirección en la lista desplegable con la descripción ${data.descripcion}`,
                        classes: 'green accent-4 c-blanco'
                    });
                    $('#calle_nuevo_permiso').val("");
                    $('#colonia_nuevo_permiso').val("");
                    $('#descripcion_recordar_direccion').val("");
                    consultar_direcciones(data.id_usuario);
                    cambiar_direccion(data.id_usuario);
                }
            }).always(function () {
                setInterval(function () {
                    $("#loading").fadeOut("slow");
                }, 1000);
            });

            return;
        }
        M.toast({
            html: '¡Debe llenar todos los campos!',
            classes: 'deep-orange c-blanco'
        });
        if (calle.length === 0) {
            $('#calle_nuevo').focus();
        }
        if (colonia.length === 0) {
            $('#colonia_nuevo').focus();
        }
        if (descripcion.length === 0) {
            $('#descripcion_recordar_direccion').focus();
        }
    }
    function validar_formulario() {
        //valida callefecha_solicitud_nuevo
        var fecha_solicitud_nuevo = $("#fecha_solicitud_nuevo");
        if (fecha_solicitud_nuevo.val() === "") {
            M.toast({
                html: '¡Debe seleccionar una fecha válida!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida checks de alumnos
        var selected = '';
        $('.checks-alumnos input[type=checkbox]').each(function () {
            if (this.checked) {
                selected += $(this).val() + ', ';
            }
        });
        if (selected === '') {
            M.toast({
                html: '¡Debes seleccionar al menos un alumno para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida calle y colonia
        //valida calle
        var calle = $("#calle_nuevo_permiso");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            M.toast({
                html: '¡Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            M.toast({
                html: '¡Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida nombre*
        var nombre_nuevo_permiso_temporal = $("#nombre_nuevo_permiso");
        var regex_nombre_nuevo_permiso_temporal = "[A-Za-z ]{1,256}";
        if (!validar_regex(regex_nombre_nuevo_permiso_temporal, nombre_nuevo_permiso_temporal.val())) {
            M.toast({
                html: '¡Agregue nombre sin acentos ni signos especiales!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida seleccion de ruta
        if ($("#ruta").val() === "" || $("#ruta").val() === null) {
            M.toast({
                html: '¡Debes seleccionar una ruta!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    function asigna_ruta_viernes(value) {
        var ruta = $("#ruta");
        if (value.indexOf('Viernes') === 0) {
            ruta.prop('selectedIndex', 1);
            ruta.prop('disabled', true);
        } else {
            ruta.prop('disabled', false);
            ruta.prop('selectedIndex', 0);
        }
    }
    function enviar_formulario(id, familia, tipo_permiso) {
        if (validar_formulario()) {
            //fecha solicitud, solicitante, fecha del permiso, nombre del alumno, alumnos, calle, colonia
            var calle = $("#calle_nuevo_permiso").val();
            var colonia = $("#colonia_nuevo_permiso").val();
            var cp = $("#cp").val() !== "" ? $("#cp").val() : "00000";
            var responsable = $("#responsable").val();
            var ruta = $("#ruta").val();
            var comentarios = $("#comentarios_nuevo_permiso").val();
            var fecha_creacion = $("#fecha_creacion").val();
            var fecha_permiso = $("#fecha_solicitud_nuevo").val();
            //toma los id de alumnos
            var selected = '';
            $('.checks-alumnos input[type=checkbox]').each(function () {
                if (this.checked) {
                    selected += $(this).val() + ',';
                }
            });
            var ids = selected.split(",");
            for (var item in ids) {
                if (ids[item] !== "") {
                    coleccion_ids.push(ids[item]);
                }
            }

            var model = {
                idusuario: id,
                calle_numero: calle,
                colonia: colonia,
                cp: cp,
                responsable: responsable,
                nfamilia: familia,
                ruta: ruta,
                comentarios: comentarios,
                tipo_permiso: tipo_permiso,
                coleccion_ids: coleccion_ids,
                fecha_creacion: fecha_creacion,
                fecha_permiso: fecha_permiso
            };
            $.ajax({
                url: "/pruebascd/icloud/Transportes/common/post_nuevo_permiso.php",
                type: "POST",
                data: model,
                dataType: 'json',
                beforeSend: function () {
                    $("#btn_enviar_formulario").prop("disabled", true);
                    $("#loading").fadeIn("slow");
                }
            }).done((res) => {
                if (res === true) {
                    M.toast({
                        html: '¡Solicitud realizada con éxito!',
                        classes: 'green accent-4 c-blanco'
                    });
                    setInterval(() => {
                        window.location = "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/PDiario.php?idseccion=<?php echo $idseccion; ?>";
                    }, 1500);
                } else {
                    M.toast({
                        html: res,
                        classes: 'red c-blanco'
                    });
                }
            }).always(function () {
                $("#btn_enviar_formulario").prop("disabled", false);
                setInterval(function () {
                    $("#loading").fadeOut("slow");
                }, 1000);
            });
            coleccion_ids = [];
        }
    }
</script>
<?php include "$root_icloud/Transportes/Diario/modales/modal_informacion_importante_hora_limite.php"; ?>
<?php include "$root_icloud/components/layout_bottom.php"; ?>
