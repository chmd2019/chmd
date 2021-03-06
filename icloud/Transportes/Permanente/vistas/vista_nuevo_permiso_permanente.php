<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

session_start();

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
    $user = $service->userinfo->get(); //get user info
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
        require_once '../../common/ControlTransportes.php';
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
        $rutas = $control_temporal->consulta_rutas();
        include "$root_icloud/components/navbar.php";
        ?>
        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
                <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
                    <a class="waves-effect waves-light"
                       href="<?php echo $redirect_uri ?>Transportes/Permanente/PPermanente.php?idseccion=<?php echo $idseccion; ?>">
                        <img src='../../../images/Atras.svg' style="width: 110px">
                    </a>
                </div>
                <h5 class="center-align c-azul">Cambio Permanente</h5>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_solicitud_permiso_permanente" style="margin-left: 1rem">Fecha de solicitud</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" readonly  id="fecha_solicitud_permiso_permanente" style="font-size: 1rem" type="text" />
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="solicitante_permiso_permanente" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $nombre; ?>" readonly  id="solicitante_permiso_permanente" style="font-size: 1rem" type="text" />
                        </div>
                    </div>
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
                                                   id="alumno_permiso_permanente_<?php echo $counter; ?>"
                                                   value="<?php echo $cliente1['id']; ?>"/>
                                            <span class="lever" style="margin-top: 1rem;margin-left: 0px;"></span>
                                        </label>
                                    </div>
                                    <textarea class="materialize-textarea col s10 l11"
                                              readonly
                                              id="nombre_nuevo_permiso_permanente_<?php echo $counter; ?>"
                                              style="font-size: 1rem;float: right;"></textarea>
                                    <br style="clear: both;">
                                    <input id="id_alumno_permiso_permanente_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                    <script>
                                        $('#nombre_nuevo_permiso_permanente_<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                                        M.textareaAutoResize($('#nombre_nuevo_permiso_permanente_<?php echo $counter; ?>'));
                                    </script>
                                </div>
                                <?php
                                $talumnos = $counter;
                            }
                        }
                        ?>
                    </div>
                    <h5 class="center-align c-azul">Dirección de Casa</h5>
                    <div class="col s12">
                        <div class="input-field">
                            <label for="calle_guardada_permanente">Calle y número</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="calle_guardada_permanente"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field">
                            <label for="colonia_guardada_permanente" style="margin-left: 1rem">Colonia</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="colonia_guardada_permanente"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field" hidden>
                            <label for="cp_guardada_permanente" style="margin-left: 1rem">CP</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly
                                   id="cp_guardada_permanente"
                                   style="font-size: .9rem"
                                   value=""/>
                        </div>
                    </div>
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <div class="col s12">
                        <label style="margin-left: 1rem">
                            &nbsp;&nbsp;<i class="material-icons c-azul prefix">person_pin_circle</i>Dirección Guardada
                        </label>
                        <select id="reside" 
                                class="browser-default border-azul" 
                                onchange="cambiar_direccion('<?php echo $id; ?>')">
                        </select>
                        <br>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul prefix">person_pin_circle</i>
                        <textarea id="calle_nuevo_permiso_permanente"
                                  class="materialize-textarea"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  placeholder="Agrega calle número"></textarea>
                        <label>Calle y Número</label>
                    </div>
                    <div class="input-field col s12" style="margin-top: -.3rem">
                        <i class="material-icons c-azul prefix">person_pin_circle</i>
                        <textarea class="materialize-textarea"
                                  id="colonia_nuevo_permiso_permanente"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  placeholder="Agrega colonia"></textarea>
                        <label>Colonia</label>
                    </div>
                    <div class="input-field col s12" hidden>
                        <i class="material-icons c-azul prefix">person_pin_circle</i>
                        <input placeholder="Ingrese CP"
                               id="cp"
                               type="tel"
                               onkeypress="return validar_solo_numeros(event)" autocomplete="off">
                        <label>CP</label>
                    </div>
                    <div class="switch col s12">
                        <label>
                            <input type="checkbox"
                                   id="recordar_direccion"
                                   onchange="recordar_direccion()"/>
                            <span>Rercordar dirección </span>
                        </label>
                    </div>
                    <div id="container_descripcion_recordar_direccion" hidden>
                        <div class="input-field col s12">
                            <i class="material-icons prefix c-azul prefix">store_mall_directory</i>
                            <input id="descripcion_recordar_direccion"
                                   placeholder="Descripción de la dirección"
                                   onkeyup ="capitaliza_primer_letra(this.id)"
                                   autocomplete="off" />
                            <button type="button" class="btn waves-effect waves-light white-text b-azul w-100" onclick="enviar_direccion()">Guardar</button>
                        </div>
                    </div>
                    <h5 class="center-align c-azul">Días de cambio</h5>
                    <div>
                        <div class="switch col s2" style="float:none;text-align: center;display: inline-block">
                            <label class="checks-alumnos-dias-cambio">
                                <input type="checkbox"
                                       id="lunes"
                                       value="Lunes"/>
                                <span class="lever"></span>Lunes
                            </label>
                        </div>
                        <div class="switch col s2" style="float:none;text-align: center;display: inline-block">
                            <label class="checks-alumnos-dias-cambio">
                                <input type="checkbox"
                                       id="martes"
                                       value="Martes"/>
                                <span class="lever"></span>Martes
                            </label>
                        </div>
                        <div class="switch col s2" style="float:none;text-align: center;display: inline-block">
                            <label class="checks-alumnos-dias-cambio">
                                <input type="checkbox"
                                       id="miercoles"
                                       value="Miércoles"/>
                                <span class="lever"></span>Miércoles
                            </label>
                        </div>
                        <div class="switch col s2" style="float:none;text-align: center;display: inline-block">
                            <label class="checks-alumnos-dias-cambio">
                                <input type="checkbox"
                                       id="jueves"
                                       value="Jueves"/>
                                <span class="lever"></span>Jueves
                            </label>
                        </div>
                        <div class="switch col s2" style="float:none;text-align: center;display: inline-block">
                            <label class="checks-alumnos-dias-cambio">
                                <input type="checkbox"
                                       id="viernes"
                                       value="Viernes"/>
                                <span class="lever"></span>Viernes
                            </label>
                        </div>
                    </div>
                    <div>
                        <div class="col s12">
                            <br>
                            <br>
                            <label>
                                &nbsp;&nbsp;<i class="material-icons c-azul prefix">departure_board</i>Ruta
                            </label>
                            <select class="browser-default border-azul" id="ruta_nuevo_permiso_permanente" >
                                <option value="" selected disabled>Selecciona tu ruta</option>
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
                            <br>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul prefix">comment</i>
                        <textarea id="comentarios_nuevo_permiso_permanente"
                                  class="materialize-textarea"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  placeholder="Comentarios"></textarea>
                        <label for="comentarios_nuevo_permiso_permanente">Comentarios</label>
                    </div>
                    <div class="col s12 l6" style="float: none;margin: 0 auto;">
                        <button class="btn efecto-btn b-azul white-text w-100"
                                id="btn_enviar_formulario"
                                type="button"
                                onclick="enviar_formulario('<?php echo $id; ?>', '<?php echo $familia; ?>', 3)">Enviar
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
    //arreglo global de ids de los alumnos seleccionados para el permiso
    var coleccion_ids = [];
    $(document).ready(function () {
        $("#loading").hide();
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        var instance = M.Modal.getInstance($("#modal_alerta"));
        instance.open();
        //redimenciona el tamaño y el value de los textareas
        $('#calle_guardada_permanente').val('<?php echo $calle; ?>');
        $('#calle_guardada_permanente').focus();
        M.textareaAutoResize($('#calle_guardada_permanente'));
        $('#colonia_guardada_permanente').val('<?php echo $colonia; ?>');
        $('#colonia_guardada_permanente').focus();
        M.textareaAutoResize($('#colonia_guardada_permanente'));
        $('#cp_guardada_permanente').val('<?php echo $cp; ?>');
        M.textareaAutoResize($('#cp_guardada_permanente'));
        //M.textareaAutoResize($('#nombre_nuevo_permiso_permanente'));
        //inicia select
        $('select').formSelect();
        //consulta de direcciones
        consultar_direcciones("<?php echo $id; ?>");
    });
    function cambiar_direccion(id) {
        var dato = $('select[id=reside]').val();
        if (dato == '0') {
            $("#calle_nuevo_permiso_permanente").val("");
            $("#colonia_nuevo_permiso_permanente").val("");
            $("#cp_nuevo_permiso_permanente").val("");
            $('#recordar_direccion').prop("checked", false);
            $('#container_descripcion_recordar_direccion').hide();
            $('#descripcion_recordar_direccion').val("");
            $('#cp').val("");
        }
        if (dato == '1') {
            $("#calle_nuevo_permiso_permanente").val("Periferico Boulevard Manuel Avila Camacho 620");
            M.textareaAutoResize($('#calle_nuevo_permiso_permanente'));
            $("#colonia_nuevo_permiso_permanente").val("Lomas de Sotelo");
            M.textareaAutoResize($('#colonia_nuevo_permiso_permanente'));
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
                            $("#calle_nuevo_permiso_permanente").val(data[key].calle);
                            M.textareaAutoResize($('#calle_nuevo_permiso_permanente'));
                            $("#colonia_nuevo_permiso_permanente").val(data[key].colonia);
                            M.textareaAutoResize($('#colonia_nuevo_permiso_permanente'));
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
        $('#calle_nuevo_permiso_permanente').focus();
    }
    function validar_recordar_direccion() {
        //valida calle
        var calle = $("#calle_nuevo_permiso_permanente");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            M.toast({
                html: '¡Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_permanente");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            M.toast({
                html: '¡Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida DESCRIPCION*
        var descripcion = $("#descripcion_recordar_direccion");
        if (descripcion.val().length === 0) {
            M.toast({
                html: '¡Agrega descripción!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    function enviar_direccion() {
        var calle = $('#calle_nuevo_permiso_permanente').val();
        var colonia = $('#colonia_nuevo_permiso_permanente').val();
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
                        classes: 'deep-orange c-blanco'
                    });
                    $('#calle_nuevo_permiso_permanente').val("");
                    $('#colonia_nuevo_permiso_permanente').val("");
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
    function validar_formulario() {
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
        var calle = $("#calle_nuevo_permiso_permanente");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            M.toast({
                html: '¡Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_permanente");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            M.toast({
                html: '¡Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida dias de cambio
        var selected_dias_cambio = '';
        $('.checks-alumnos-dias-cambio input[type=checkbox]').each(function () {
            if (this.checked) {
                selected_dias_cambio += $(this).val() + ', ';
            }
        });
        if (selected_dias_cambio === '') {
            M.toast({
                html: '¡Debes seleccionar al menos un día de cambio para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        //valida seleccion de ruta
        if ($("#ruta_nuevo_permiso_permanente").val() === "" || $("#ruta_nuevo_permiso_permanente").val() === null) {
            M.toast({
                html: '¡Debes seleccionar una ruta!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    function enviar_formulario(id, familia, tipo_permiso) {
        if (validar_formulario()) {
            //fecha solicitud, solicitante, fecha del permiso, nombre del alumno, alumnos, calle, colonia
            var calle_nuevo_permiso_permanente = $("#calle_nuevo_permiso_permanente").val();
            var colonia_nuevo_permiso_permanente = $("#colonia_nuevo_permiso_permanente").val();
            var cp = $("#cp").val() !== "" ? $("#cp").val() : "00000";
            var responsable = $("#solicitante_permiso_permanente").val();
            var lunes = $("#lunes").prop("checked") ? $("#lunes").val() : "";
            var martes = $("#martes").prop("checked") ? $("#martes").val() : "";
            var miercoles = $("#miercoles").prop("checked") ? $("#miercoles").val() : "";
            var jueves = $("#jueves").prop("checked") ? $("#jueves").val() : "";
            var viernes = $("#viernes").prop("checked") ? $("#viernes").val() : "";
            var ruta = $("#ruta_nuevo_permiso_permanente").val();
            var comentarios = $("#comentarios_nuevo_permiso_permanente").val();
            var fecha_creacion = $("#fecha_solicitud_permiso_permanente").val();
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
            console.log(coleccion_ids);
            var model = {
                idusuario: id,
                calle_numero: calle_nuevo_permiso_permanente,
                colonia: colonia_nuevo_permiso_permanente,
                cp: cp,
                lunes: lunes,
                martes: martes,
                miercoles: miercoles,
                jueves: jueves,
                viernes: viernes,
                ruta: ruta,
                comentarios: comentarios,
                nfamilia: familia,
                fecha_creacion: fecha_creacion,
                tipo_permiso: tipo_permiso,
                responsable: responsable,
                coleccion_ids: coleccion_ids,
            };
            $.ajax({
                url: "/pruebascd/icloud/Transportes/common/post_nuevo_permiso.php",
                type: "POST",
                data: model,
                beforeSend: function () {
                    $("#btn_enviar_formulario").prop("disabled", true);
                    $("#loading").fadeIn("slow");
                },
                success: function (res) {
                    if (res == 1) {
                        M.toast({
                            html: '¡Registro exitoso!',
                            classes: 'green accent-4 c-blanco'
                        });
                        setInterval(() => {
                            window.location = "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Permanente/PPermanente.php?idseccion=<?php echo $idseccion; ?>";
                        }, 1500);
                    } else {
                        M.toast({
                            html: `¡${res}!`,
                            classes: 'deep-orange c-blanco'
                        });
                        setInterval(() => {
                            location.reload();
                        }, 10000);
                    }
                }
            }).always(function () {
                setInterval(function () {
                    $("#loading").fadeOut("slow");
                    $("#btn_enviar_formulario").prop("disabled", false);
                }, 1000);
            });
            ;
            coleccion_ids = [];
        }
    }
</script>

<?php include "$root_icloud/Transportes/Permanente/modales/modal_informacion_importante_hora_limite.php"; ?>
<?php include_once "$root_icloud/components/layout_bottom.php"; ?>
