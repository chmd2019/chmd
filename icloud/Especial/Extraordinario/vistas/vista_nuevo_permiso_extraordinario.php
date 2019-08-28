<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

session_start();

include "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";

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
    $idseccion = $_GET['idseccion'];
    //usaurio
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    //manejo de fechas y tiempo
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    $meses = $date_helper->obtener_meses();
    $dias = $date_helper->obtener_dias();
    if ($consulta = mysqli_fetch_array($consulta)) {
        //campos necesarios en tabla Ventana_permisos
        $idusuario = $consulta[0];
        $nombre = $consulta[1];
        $nfamilia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);
        //se estableció 4 para permisos extraordinarios
        $tipo_permiso = 4;
        $fecha_creacion = $dias[date("w")]
                . ", " . date("d")
                . " de " . $meses[date("m") - 1]
                . " de "
                . date("Y")
                . ", "
                . date("h:i a");

        $fecha_minima = date("Y-m-d");
        $fecha_hoy = $dias[date('w')] . ", " . date('d') .
                " de " . $meses[date('m') - 1] . " de " . date('Y');
        //se establece hora limite a 2:30 PM

        $btn_fecha = true;
        $fin_semana = $dias[date('w')];
        if ($date_helper->comprobar_hora_limite("14:30") || $fin_semana == "Sabado" || $fin_semana == "Domingo") {
            $fecha_minima = strtotime("+1 day", strtotime($fecha_minima));
            $fecha_minima = date("m/d/Y", $fecha_minima);
            $fecha_hoy = "";
            $btn_fecha = false;
        } else {
            $fecha_minima = date("m/d/Y");
            $btn_fecha = true;
        }
        include "$root_icloud/components/navbar.php";
        ?>
        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
                <br>
                <br>
                <h5 class="center-align c-azul">Permiso extraordinario</h5>
                <br>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $fecha_creacion; ?>" 
                                   readonly  
                                   id="fecha_solicitud" 
                                   style="font-size: 1rem" 
                                   type="text" />               
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="solicitante" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $nombre; ?>" 
                                   readonly  
                                   id="solicitante" 
                                   style="font-size: 1rem" 
                                   type="text" />               
                        </div>
                    </div> 
                    <?php
                    if ($btn_fecha) {
                        $hidden = "hidden";
                        ?>
                        <div class="switch" style="text-align: center">
                            <label>
                                Si su permiso es para otro día seleccione aquí
                                <input type="checkbox" onchange="mostrar_fecha_para()">
                                <span class="lever"></span>
                            </label>
                        </div>
                        <?php
                    } else {
                        $hidden = "";
                        echo "$btn_fecha";
                    }
                    ?> 
                    <div class="col s12">&nbsp;</div>
                    <div id="fecha_para" <?php echo $hidden; ?>>
                        <br>
                        <h5 class="c-azul text-center">Fecha de salida</h5>
                        <div class="col s12 l6">
                            <link rel='stylesheet' href='/pruebascd/icloud/materialkit/css/calendario.css'> 
                            <script src='/pruebascd/icloud/materialkit/js/calendario.js'></script>
                            <script src="/pruebascd/icloud/materialkit/js/common.js"></script>
                            <div class="input-field">
                                <i class="material-icons prefix c-azul">calendar_today</i>
                                <input 
                                    value="<?php echo $fecha_hoy; ?>"
                                    type="text" 
                                    class="datepicker" 
                                    id="fecha_permiso" 
                                    autocomplete="off"
                                    placeholder="Para el día"
                                    onclick="remover_timepicker()"
                                    onchange="fecha_minusculas(this.value, 'fecha_permiso')">            
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
                        </div>
                        <div class="col s12 l6">&nbsp;</div>
                    </div>


                    <div class="col s12">
                        <h5 class="c-azul text-center">Selecciona Alumnos</h5>
                        <?php
                        $alumnos = $objCliente->mostrar_alumnos($nfamilia);
                        $alumnos_sin_responsable = array();
                        $flag_no_sale_solo = false;
                        if ($alumnos) {
                            $counter = 0;
                            // $numero = mysql_num_rows($consulta);
                            while ($alumno = mysqli_fetch_array($alumnos)) {
                                $counter++;
                                $grado_escolaridad = $alumno[6];
                                $nivel_escolaridad = $alumno[9];
                                //cambiar a grado_escolaridad a 17 
                                if ($grado_escolaridad != 17)
                                    $flag_no_sale_solo = true;
                                $horario_permitido = "";
                                if ($grado_escolaridad >= 1 && $grado_escolaridad <= 4) {
                                    $horario_permitido = 1; //kinder
                                } else if ($grado_escolaridad >= 5 && $grado_escolaridad <= 6) {
                                    $horario_permitido = 2; //primaria baja
                                } else if ($grado_escolaridad >= 7 && $grado_escolaridad <= 10) {
                                    $horario_permitido = 3; //primaria alta
                                } else if ($grado_escolaridad >= 11 && $grado_escolaridad <= 17) {
                                    $horario_permitido = 1; //bachillerato
                                }
                                $id_alumno = $alumno['id'];
                                $idcursar = $alumno['idcursar'];
                                ?>
                                <input hidden value="<?php echo $idcursar; ?>" id="idcursar_alumno_<?php echo $counter; ?>">
                                <div>
                                    <span class="col s12"><br></span>                                    
                                    <div class="switch col s1 l1">
                                        <label class="checks-alumnos">
                                            <input type="checkbox" 
                                                   id="alumno_<?php echo $counter; ?>" 
                                                   value="<?php echo $alumno['id']; ?>"
                                                   onchange="mostrar_ocultar_caja_horarios('caja_horarios_<?php echo $counter; ?>', '<?php echo $id_alumno; ?>', '<?php echo $idcursar; ?>')"/>
                                            <span class="lever" style="margin-top: 1rem"></span>
                                        </label>         
                                    </div>
                                    <textarea class="materialize-textarea col s10 l11"
                                              readonly  
                                              id="nombre_alumno_<?php echo $counter; ?>"
                                              style="font-size: 1rem;float: right;"></textarea>                                    
                                </div>
                                <div id="caja_horarios_<?php echo $counter; ?>" hidden>  
                                    <span class="col s12"><br></span>                
                                    <div class="col s12 l5" style="margin-top: -25px;">                        
                                        <div class="input-field">
                                            <i class="material-icons prefix c-azul">access_time</i>
                                            <input 
                                                type="text" 
                                                class="timepicker timepicker_<?php echo $counter; ?> salida_<?php echo $counter; ?>"
                                                onkeypress="return validar_solo_numeros(event, this.id, 4)"
                                                id="hora_salida_<?php echo $counter; ?>" 
                                                autocomplete="off"
                                                placeholder="Salida"
                                                onclick="mostrar_timepicker_salida(this, '<?php echo $counter; ?>', '<?php echo $horario_permitido; ?>')">            
                                        </div>
                                    </div>

                                    <?php if ($grado_escolaridad >= 11 && $grado_escolaridad <= 17) : ?>
                                        <span class="col s12"><br></span>          
                                        <div class="col s12 l7" style="margin-top: -25px;">  
                                            <label class="input-field col s12 l3" style="margin-top: 2rem">
                                                <input type="checkbox" 
                                                       class="filled-in" 
                                                       id="check_regreso_<?php echo $counter; ?>"
                                                       onchange="check_regresa('hora_regreso_<?php echo $counter; ?>', 'caja_regresa_<?php echo $counter; ?>')" />
                                                <span>Regresa</span>
                                            </label>                      
                                            <div class="input-field col s12 l9" id="caja_regresa_<?php echo $counter; ?>" hidden>
                                                <i class="material-icons prefix c-azul">access_time</i>
                                                <input 
                                                    type="text" 
                                                    class="timepicker timepicker_<?php echo $counter; ?> regreso_<?php echo $counter; ?>" 
                                                    onkeypress="return validar_solo_numeros(event, this.id, 4)"
                                                    id="hora_regreso_<?php echo $counter; ?>" 
                                                    autocomplete="off"
                                                    placeholder="Regreso"
                                                    onclick="mostrar_timepicker_regreso(this, '<?php echo $counter; ?>', '<?php echo $horario_permitido; ?>')">          
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <input id="id_alumno_<?php echo $counter; ?>" hidden value="<?php echo $alumno['id']; ?>"/>
                                <script>
                                    $('#nombre_alumno_<?php echo $counter; ?>')
                                            .val('<?php echo $alumno['nombre']; ?>\nNivel: <?php echo $nivel_escolaridad; ?>');
                                                M.textareaAutoResize($('#nombre_alumno_<?php echo $counter; ?>'));
                                </script>
                                <?php
                                $talumnos = $counter;
                            }
                        }
                        ?>
                    </div>
                    <div>
                        <h5 class="c-azul text-center col s12">Información adicional</h5>
                        <br>                        
                        <div class="col s12">
                            <label>
                                <input 
                                    type="checkbox" 
                                    id="check_nuevo_responsable" 
                                    onchange="mostrar_nuevo_responsable()"
                                    class="filled-in" />
                                <span>Agregar un responsable</span>
                            </label>
                        </div>
                        <span class="col s12"><br></span>
                        <div class="col s12 l6">
                            <div class="input-field">
                                <i class="material-icons prefix c-azul">person</i>
                                <select id="select_responsable" onchange="seleccion_responsable(this.value)">                          
                                </select>
                                <label>Responsable</label>
                            </div>
                        </div>
                        <div id="nuevo_responsable" hidden>
                            <div class="input-field col s12 l6" id="nuevo_responsable_nombre">
                                <i class="material-icons prefix c-azul">person</i>
                                <input id="responsable" type="text" autocomplete="off">
                                <label for="responsable">Nombre del responsable</label>
                            </div> 
                            <div class="input-field col s12 l6">
                                <i class="material-icons prefix c-azul">person</i>
                                <input id="parentesco_responsable" type="text" autocomplete="off">
                                <label for="parentesco_responsable">Parentesco del responsable</label>
                            </div> 
                            <a class="waves-effect waves-light btn col s12 b-azul c-blanco" 
                               onclick="post_nuevo_responsable()"
                               id="btn_agregar_nuevo_responsable"> 
                                <i class="material-icons right">send</i>Guardar
                            </a>
                        </div>
                        <br>
                        <div class="input-field col s12">
                            <label for="motivos">Motivos</label>
                            <i class="material-icons c-azul prefix">chrome_reader_mode</i>
                            <textarea id="motivos" 
                                      class="materialize-textarea"                                
                                      placeholder="Motivos"></textarea>    
                        </div>
                    </div>
                </div>  
                <div class="col s12 l6" style="float: none;margin: 0 auto;">
                    <button class="btn waves-effect waves-light b-azul white-text w-100" 
                            id="btn_enviar_formulario"
                            type="button" 
                            onclick="enviar_formulario('<?php echo $idusuario; ?>', '<?php echo $nfamilia; ?>', 4)">Enviar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                <br>
            </div>  
        </div>  
        <?php
    }
}
?>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
       href="<?php echo $redirect_uri ?>Especial/Extraordinario/PExtraordinario.php?idseccion=<?php echo $idseccion; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>

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
<?php include '../modales/modal_aviso_tercer_permiso.php'; ?>
<script>
    var responsables = [];
    var flag_no_sale_solo = '<?php echo "$flag_no_sale_solo" ?>';
    flag_no_sale_solo = flag_no_sale_solo === "1" ? true : false;
    var ids = [];
    var coleccion_ids = [];
    var coleccion_checkbox_values = [];
    var coleccion_alumnos = [];
    var coleccion_data_alumnos = [];

    $(document).ready(function () {
        $("#loading").hide();
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        cargar_responsables();
        M.textareaAutoResize($('#motivos'));
    });

    function validar_fecha_vacia() {
        var fecha_permiso = $("#fecha_permiso").val();
        if (fecha_permiso === "") {
            M.toast({
                html: 'Debe seleccionar una fecha válida antes de tomar un horario!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }

    function cargar_responsables() {
        responsables = obtener_responsables('<?php echo $nfamilia; ?>');
        opciones_select_padres(responsables, "select_responsable");
        $('select').formSelect();
    }

    function mostrar_fecha_para() {
        if ($("#fecha_para").prop("hidden")) {
            $("#fecha_para").prop("hidden", false);
            $("#fecha_permiso").val("");
        } else {
            $("#fecha_para").prop("hidden", true);
            $("#fecha_permiso").val("<?php echo $fecha_hoy; ?>");
        }
    }

    function mostrar_timepicker_salida(el, counter, horario_permitido) {
        $(document.activeElement).filter(':input:focus').blur();
        if (!validar_fecha_vacia())
            return;
        var hora_maxima_del_dia = '';
        var fecha_permiso = $("#fecha_permiso").val();
        //BACHILLERATO Y KINDER
        fecha_permiso = fecha_permiso.split(",");
        //BACHILLERATO Y KINDER
        // de lunes a jueves
        if (fecha_permiso[0] !== "Viernes" && horario_permitido === "1") {
            hora_maxima_del_dia = '14:50';
            $('#hora_salida_' + counter).timepicker({
                'step': 5,
                'minTime': '07:40',
                'maxTime': hora_maxima_del_dia,
                'timeFormat': 'H:i'
            });
            $('#hora_salida_' + counter).timepicker('show');
        }
        // los viernes
        else if (fecha_permiso[0] === "Viernes" && horario_permitido === "1") {
            hora_maxima_del_dia = '14:00';
            $('#hora_salida_' + counter).timepicker({
                'step': 5,
                'minTime': '07:40',
                'maxTime': hora_maxima_del_dia,
                'timeFormat': 'H:i'
            });
            $('#hora_salida_' + counter).timepicker('show');
        }
        //PRIMARIA BAJA (1 y 2) 
        //de lunes a jueves
        if (fecha_permiso[0] !== "Viernes" && horario_permitido === "2") {
            hora_maxima_del_dia = '13:15';
            $('#hora_salida_' + counter).timepicker({
                'step': 5,
                'minTime': '10:50',
                'maxTime': hora_maxima_del_dia,
                'disableTimeRanges': [
                    ['11:20', '12:50']
                ],
                'timeFormat': 'H:i'
            });
            $('#hora_salida_' + counter).timepicker('show');
        }
        // viernes
        else if (fecha_permiso[0] === "Viernes" && horario_permitido === "2") {
            hora_maxima_del_dia = '12:35';
            $('#hora_salida_' + counter).timepicker({
                'step': 5,
                'minTime': '10:35',
                'maxTime': hora_maxima_del_dia,
                'disableTimeRanges': [
                    ['11:00', '12:20']
                ],
                'timeFormat': 'H:i'
            });
            $('#hora_salida_' + counter).timepicker('show');
        }
        //PRIMARIA ALTA (3, 4, 5 y 6) 
        //de lunes a jueves
        if (fecha_permiso[0] !== "Viernes" && horario_permitido === "3") {
            hora_maxima_del_dia = '13:15';
            $('#hora_salida_' + counter).timepicker({
                'step': 5,
                'minTime': '10:05',
                'maxTime': hora_maxima_del_dia,
                'disableTimeRanges': [
                    ['10:45', '12:55']
                ],
                'timeFormat': 'H:i'
            });
            $('#hora_salida_' + counter).timepicker('show');
        }
        // viernes
        else if (fecha_permiso[0] === "Viernes" && horario_permitido === "3") {
            hora_maxima_del_dia = '12:35';
            $('#hora_salida_' + counter).timepicker({
                'step': 5,
                'minTime': '09:55',
                'maxTime': hora_maxima_del_dia,
                'disableTimeRanges': [
                    ['10:20', '12:20']
                ],
                'timeFormat': 'H:i'
            });
            $('#hora_salida_' + counter).timepicker('show');
        }
        if ($("#check_regreso_" + counter).prop('checked')) {
            $("#check_regreso_" + counter).click();
        }
        ids.push(el.id);
    }

    function mostrar_timepicker_regreso(el, counter, horario_permitido) {
        $(document.activeElement).filter(':input:focus').blur();
        if (!validar_fecha_vacia())
            return;

        if ($("#hora_salida_" + counter).val() === "") {
            M.toast({
                html: 'Debe seleccionar un horario de salida antes de tomar un horario de entrada!',
                classes: 'deep-orange c-blanco'
            });
            $('.timepicker_' + counter).timepicker('remove');
            $('.timepicker_' + counter).val("");
            return;
        }

        $('#hora_regreso_' + counter).timepicker('remove');
        var hora_maxima_del_dia = '';
        var fecha_permiso = $("#fecha_permiso").val();
        //BACHILLERATO Y KINDER
        fecha_permiso = fecha_permiso.split(",");
        //BACHILLERATO Y KINDER
        // de lunes a jueves
        if (fecha_permiso[0] !== "Viernes" && horario_permitido === "1") {
            var hora_minima_respecto_salida = `${parseInt($("#hora_salida_" + counter).val().split(":")[0]) + 1}:${$("#hora_salida_" + counter).val().split(":")[1]}`;
            hora_maxima_del_dia = '14:50';
            $('#hora_regreso_' + counter).timepicker({
                'step': 5,
                'minTime': $("#hora_salida_" + counter).val().split(":")[0] === hora_maxima_del_dia.split(":")[0] ? $("#hora_salida_" + counter).val() : hora_minima_respecto_salida,
                'maxTime': hora_maxima_del_dia,
                'timeFormat': 'H:i'
            });
            $('#hora_regreso_' + counter).timepicker('show');
        }
        // los viernes
        else if (fecha_permiso[0] === "Viernes" && horario_permitido === "1") {
            var hora_minima_respecto_salida = `${parseInt($("#hora_salida_" + counter).val().split(":")[0]) + 1}:${$("#hora_salida_" + counter).val().split(":")[1]}`;
            hora_maxima_del_dia = '14:00';
            $('#hora_regreso_' + counter).timepicker({
                'step': 5,
                'minTime': $("#hora_salida_" + counter).val().split(":")[0] === hora_maxima_del_dia.split(":")[0] ? $("#hora_salida_" + counter).val() : hora_minima_respecto_salida,
                'maxTime': hora_maxima_del_dia,
                'timeFormat': 'H:i'
            });
            $('#hora_regreso_' + counter).timepicker('show');
        }
        ids.push(el.id);
    }

    function remover_timepicker() {
        var ids_timepicker = [...new Set(ids)];
        for (var item in ids_timepicker) {
            $("#" + ids_timepicker[item]).timepicker('remove');
            $("#" + ids_timepicker[item]).val("");
        }
    }

    function mostrar_ocultar_caja_horarios(id, id_alumno, idcursar) {
        if ($("#" + id).prop("hidden")) {
            $("#" + id).prop("hidden", false);
            aviso_tercer_permiso(id_alumno, idcursar);
        } else {
            coleccion_ids = [];
            $("#" + id).prop("hidden", true);
            $('#hora_regreso_' + counter).timepicker('remove');
        }
    }

    function aviso_tercer_permiso(id_alumno, idcursar) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_aviso_tercer_permiso.php',
            type: 'GET',
            data: {"id_alumno": id_alumno, "idcursar": idcursar},
            beforeSend: function () {
                $("#loading").fadeIn("slow");
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res) {
                    var modal_aviso_tercer_permiso = M.Modal.getInstance($("#modal_aviso_tercer_permiso"));
                    modal_aviso_tercer_permiso.open();
                }
            }
        }).always(function () {
            $("#loading").fadeOut("slow");
        });
    }

    function opciones_select_padres(val, id) {
        var select = $(`#${id}`);
        var options = "<option value='0' selected>Seleccione una opción</option>";
        for (var key in val) {
            options += `<option value="${val[key].id}">${val[key].nombre}</option>`;
        }
        select.html(options);
    }

    function mostrar_nuevo_responsable() {
        if ($("#nuevo_responsable").prop("hidden")) {
            $("#nuevo_responsable").prop("hidden", false);
            $("#nuevo_responsable").val("");
            $("#select_responsable").val("0");
            $("#nuevo_responsable_nombre").show();
            $("#parentesco_responsable").focusout();
            $("#select_responsable").change();
        } else {
            $("#nuevo_responsable").prop("hidden", true);
            $("#responsable").val("");
            $("#parentesco_responsable").val("");
            cargar_responsables();
        }
    }

    function post_nuevo_responsable() {
        var responsable = $("#responsable").val();
        var parentesco_responsable = $("#parentesco_responsable").val();
        if (validar_responsable()) {
            nuevo_responsable(responsable, parentesco_responsable, '<?php echo $nfamilia; ?>');
            cargar_responsables();
        }
    }

    function seleccion_responsable(val) {
        if (val === "0") {
            $("#parentesco_responsable").val("");
            $("#responsable").val("");
            $("#btn_agregar_nuevo_responsable").show();
            $("#check_nuevo_responsable").click();
            return;
        }
        $("#nuevo_responsable").prop("hidden", false);
        $("#nuevo_responsable_nombre").hide();
        $("#parentesco_responsable").focus();
        $("#btn_agregar_nuevo_responsable").hide();
        $("#check_nuevo_responsable").prop("checked", true);
        for (var item in responsables) {
            if (responsables[item].id === val) {
                //$("#nuevo_responsable").prop("hidden", false);
                /*se verifica el parentesco a través del tipo en tabla usuarios
                 y si no cumple con la condición se establece el parentesco en tabla Responsables*/
                var parentesco = responsables[item].tipo === "3" ? "Padre" :
                        responsables[item].tipo === "4" ? "Madre" : responsables[item].parentesco;
                $("#parentesco_responsable").val(parentesco);
                $("#responsable").val(responsables[item].nombre);
                //$("#check_nuevo_responsable").prop('checked', true);
            }
        }
    }

    function enviar_formulario(id, familia, tipo_permiso) {
        if ($("#fecha_permiso").val() === "") {
            M.toast({
                html: 'Debe seleccionar una fecha válida!',
                classes: 'deep-orange c-blanco'
            });
            return;
        }
        if (!validar_fecha_vacia())
            return;
        coleccion_data_alumnos = [];
        validar_alumnos();
        coleccion_ids = [... new Set(coleccion_ids)];
        coleccion_checkbox_values = [... new Set(coleccion_checkbox_values)];
        if (coleccion_ids.length === 0) {
            M.toast({
                html: 'Debe seleccionar al menos un alumno para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return;
        }
        for (var item in coleccion_ids) {
            var counter_alumno = coleccion_ids[item].split("_")[1];
            var hora_salida = $(".salida_" + counter_alumno).val();
            if (hora_salida === "") {
                M.toast({
                    html: 'Debe seleccionar un horario de salida!',
                    classes: 'deep-orange c-blanco'
                });
                return;
            }
            var hora_regreso = $(".regreso_" + counter_alumno).val();
            var data_alumnos = {
                "id_alumno": $("#alumno_" + counter_alumno).val(),
                "hora_salida": $(".salida_" + counter_alumno).val(),
                "hora_regreso": hora_regreso !== undefined ? hora_regreso : "0",
                "regresa": $(".regreso_" + counter_alumno).val() !== ""
                        && $(".regreso_" + counter_alumno).val() !== undefined ? 1 : 0,
                "estatus": 1,
                "idcursar": $("#idcursar_alumno_" + counter_alumno).val()
            }
            coleccion_data_alumnos.push(data_alumnos);
        }
        if (flag_no_sale_solo) {
            if (!validar_responsable())
                return;
        }

        if ($("#motivos").val() === "") {
            M.toast({
                html: 'Debe ingresar un motivo válido!',
                classes: 'deep-orange c-blanco'
            });
            return;
        }
        var fecha_solicitud = $("#fecha_solicitud").val();
        var fecha_cambio = $("#fecha_permiso").val();
        var motivos = $("#motivos").val();
        var responsable = $("#responsable").val();
        var parentesco = $("#parentesco_responsable").val();
        var data = {
            "nfamilia": familia,
            "fecha_creacion": fecha_solicitud,
            "fecha_cambio": fecha_cambio,
            "motivos": motivos,
            "responsable": responsable,
            "parentesco": parentesco,
            "idusuario": id,
            "estatus": 1,
            "alumnos": coleccion_data_alumnos,
        };
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
            type: 'POST',
            data: data,
            beforeSend: function () {
                $("#btn_enviar_formulario").prop("disabled", true);
                $("#loading").fadeIn("slow");
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res === 1) {
                    M.toast({
                        html: 'Registro exitoso',
                        classes: 'green accent-4 c-blanco'
                    });
                    $("#loading").fadeOut("slow");
                    setInterval(() => {
                        $("#btn_enviar_formulario").prop("disabled", false);
                        window.location.href = "https://www.chmd.edu.mx/pruebascd/icloud/Especial/Extraordinario/PExtraordinario.php?idseccion=1";
                    }, 1000);
                }
            }
        });
    }
    //validaciones
    //validaciones responsable
    function validar_responsable() {
        var responsable = $("#responsable").val();
        var parentesco_responsable = $("#parentesco_responsable").val();
        if (responsable === "") {
            M.toast({
                html: 'Debe ingresar un responsable válido!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        if (parentesco_responsable === "") {
            M.toast({
                html: 'Debe ingresar un parentesco válido!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }

    function validar_alumnos() {
        var selected = '';
        var id = '';
        $('.checks-alumnos input[type=checkbox]').each(function () {
            if (this.checked) {
                selected += $(this).val() + ',';
                id += $(this)[0].id + ',';
            }
        });
        var values = selected.split(",");
        for (var item in values) {
            if (values[item] !== "") {
                coleccion_checkbox_values.push(values[item]);
            }
        }
        var ids = id.split(",");
        for (var item in ids) {
            if (ids[item] !== "") {
                coleccion_ids.push(ids[item]);
            }
        }
    }

    function check_regresa(id_hora_regreso, id_caja_regresa) {
        if ($("#" + id_caja_regresa).prop('hidden')) {
            $("#" + id_caja_regresa).prop('hidden', false);
        } else {
            $("#" + id_caja_regresa).prop('hidden', true);
            $("#" + id_hora_regreso).val('')
        }
    }
</script>

<?php include "$root_icloud/components/layout_bottom.php"; ?>