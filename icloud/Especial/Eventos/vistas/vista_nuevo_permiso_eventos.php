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
        if ($date_helper->comprobar_hora_limite("11:30") || $fin_semana == "Sabado" || $fin_semana == "Domingo") {
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
                <h5 class="center-align c-azul">Cumpleaños o Bar Mitzvá</h5>
                <br>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $fecha_creacion; ?>" 
                                   readonly  
                                   id="fecha_solicitud" 
                                   style="font-size: 1rem" 
                                   type="text" />               
                        </div>
                    </div> 
                    <div class="col s12 l6">
                        <label for="solicitante" style="margin-left: 1rem">Solicitante</label>
                        <div class="input-field">
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
                        <h5 class="c-azul text-center">Fecha del evento</h5>
                        <br>
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
                        <span class="col s12">&nbsp;</span>
                    </div>
                    <br>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">cake</i>
                            <select id="tipo_evento"> 
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Bar Mitzvá">Bar Mitzvá</option>
                            </select>
                            <label>Tipo de evento</label>
                        </div>
                    </div>
                    <br>                    
                    <div class="col s12">
                        <h5 class="c-azul text-center">Selecciona Alumnos</h5>
                        <?php
                        $alumnos = $objCliente->mostrar_alumnos($nfamilia);
                        if ($alumnos) {
                            $counter = 0;
                            // $numero = mysql_num_rows($consulta);
                            while ($alumno = mysqli_fetch_array($alumnos)) {
                                $counter++;
                                ?>
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">school</i>
                                    <textarea class="materialize-textarea"
                                              readonly  
                                              id="nombre_alumno_<?php echo $counter; ?>"
                                              style="font-size: 1rem"></textarea>
                                </div>
                                <div class="switch col s12">
                                    <label class="checks-alumnos">
                                        <input type="checkbox" 
                                               id="alumno_<?php echo $counter; ?>" 
                                               value="<?php echo $alumno['id']; ?>"/>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                                <br>
                                <input id="id_alumno_<?php echo $counter; ?>" hidden value="<?php echo $alumno['id']; ?>"/>
                                <script>
                                    $('#nombre_alumno_<?php echo $counter; ?>').val('<?php echo $alumno['nombre']; ?>');
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
                        <div class="col s12 l6">
                            <div class="input-field">
                                <i class="material-icons prefix c-azul">person</i>
                                <select id="select_responsable" onchange="seleccion_responsable(this.value)">                          
                                </select>
                                <label>Responsable</label>
                            </div>
                        </div>
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
                        <div id="nuevo_responsable" hidden>
                            <div class="col s12 l6">
                                <label style="margin-left: 3rem">Nombre del responsable</label>
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">person</i>
                                    <input type="text" id="responsable" autocomplete="off"> 
                                </div>
                            </div>
                            <div class="col s12 l6">
                                <label style="margin-left: 3rem">Parentesco del responsable</label>
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">person</i>
                                    <input type="text" id="parentesco_responsable" autocomplete="off"> 
                                </div>
                            </div>
                            <a class="waves-effect waves-light btn col s12 b-azul c-blanco" 
                               onclick="post_nuevo_responsable()"
                               id="btn_agregar_nuevo_responsable"> 
                                <i class="material-icons right">send</i>Guardar
                            </a>
                        </div>
                        <br>               
                        <div class="input-field col s12">        
                            <label>
                                <input type="checkbox"
                                       class="filled-in" 
                                       id="check_tranpsorte"
                                       onchange = "mostrar_tranpsorte()"/>
                                <span>Ingresa transporte</span>
                            </label>
                            <br>
                            <br>
                        </div>                   
                        <div id="caja_transporte" hidden>    
                            <div class="col s12">
                                <label style="margin-left: 3rem">Empresa</label>
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">time_to_leave</i>
                                    <input type="text" id="empresa" autocomplete="off"> 
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons c-azul">chrome_reader_mode</i>
                            <textarea id="comentarios" 
                                      class="materialize-textarea"                                
                                      placeholder="Comentarios"></textarea>    
                        </div>     
                    </div> 
                    <div class="col s12 l6" style="float: none;margin: 0 auto;">
                        <button class="btn waves-effect waves-light b-azul white-text w-100" 
                                id="btn_enviar_formulario"
                                type="button"
                                onclick="enviar_formulario('<?php echo $idusuario; ?>', '<?php echo $nfamilia; ?>', 5)">Enviar
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

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
       href="<?php echo $redirect_uri ?>Especial/Eventos/PEventos.php?idseccion=<?php echo $idseccion; ?>">
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

<div id="modal_codigo_invitacion" class="modal bottom-sheet">
    <div class="modal-content">
        <h4 class="c-azul">Código de invitación</h4>
        <p>Su código de invitación al evento es: <br>
            <span id="span_codigo_verificacion" class="c-azul" style="font-size: 1.8rem"></span>
        </p>
    </div>
    <div class="modal-footer">
        <a href="<?php echo $redirect_uri ?>Especial/Eventos/PEventos.php?idseccion=<?php echo $idseccion; ?>" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
</div>


<script>
    var responsables = [];
    var coleccion_ids = [];
    $(document).ready(function () {
        //$("#loading").hide();
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        cargar_responsables();
        //M.textareaAutoResize($('#motivos'));
    });

    function mostrar_fecha_para() {
        if ($("#fecha_para").prop("hidden")) {
            $("#fecha_para").prop("hidden", false);
            $("#fecha_permiso").val("");
        } else {
            $("#fecha_para").prop("hidden", true);
            $("#fecha_permiso").val("<?php echo $fecha_hoy; ?>");
        }
    }
    //responsables
    function cargar_responsables() {
        responsables = obtener_responsables('<?php echo $nfamilia; ?>');
        opciones_select_padres(responsables, "select_responsable");
        $('select').formSelect();
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

    function mostrar_nuevo_responsable() {
        if ($("#nuevo_responsable").prop("hidden")) {
            $("#nuevo_responsable").prop("hidden", false);
            $("#nuevo_responsable").val("");
            $("#select_responsable").val("0");
            $("#select_responsable").change();
        } else {
            $("#nuevo_responsable").prop("hidden", true);
            $("#responsable").val("");
            $("#parentesco_responsable").val("");
            cargar_responsables();
        }
    }

    function mostrar_tranpsorte() {
        if ($("#caja_transporte").prop("hidden")) {
            $("#caja_transporte").prop("hidden", false);
            /*$("#nuevo_transporte").val("");
             $("#select_transporte").val("0");
             $("#select_transporte").change();*/
        } else {
            $("#caja_transporte").prop("hidden", true);
            //$("#nuevo_transporte").val("");
            //cargar_responsables();
        }
    }

    function mostrar_nuevo_tranpsorte() {
        if ($("#caja_nuevo_transporte").prop("hidden")) {
            $("#caja_nuevo_transporte").prop("hidden", false);
            /*$("#nuevo_transporte").val("");
             $("#select_transporte").val("0");
             $("#select_transporte").change();*/
        } else {
            $("#caja_nuevo_transporte").prop("hidden", true);
            //$("#nuevo_transporte").val("");
            //cargar_responsables();
        }

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
    //validacion transporte
    function validar_transporte() {
        if ($("#empresa").val() === "") {
            M.toast({
                html: 'Debe ingresar una empresa transportadora válida!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    //validacion de fecha vacia    
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
    //valida tipo de evento
    function validar_tipo_evento() {
        if ($("#tipo_evento").val() === "" ||
                $("#tipo_evento").val() === null ||
                $("#tipo_evento").val() === undefined) {
            M.toast({
                html: 'Debe seleccionar un tipo de evento válido para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    //validar alumnos
    function validar_alumnos() {
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
        if (selected === "") {
            M.toast({
                html: 'Debe seleccionar al menos un alumno antes de continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    //valida responsable
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
    //valida ransporte
    function validar_transporte() {
        var check = $("#check_tranpsorte")[0].checked;
        if (check === true && $("#empresa").val() === "") {
            M.toast({
                html: 'Debe ingresar una empresa de transporte válida!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    //valida comentarios    
    function validar_comentarios() {
        if ($("#comentarios").val() === "") {
            M.toast({
                html: 'Debe ingresar un comentario válido!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    //enviar formulario
    function enviar_formulario(idusuario, familia, tipo_permiso) {
        if (!validar_fecha_vacia())
            return;
        if (!validar_tipo_evento())
            return;
        if (!validar_alumnos())
            return;
        if (!validar_responsable())
            return;
        if (!validar_transporte())
            return;
        //if(!validar_comentarios())
        //    return;

        var fecha_creacion = $("#fecha_solicitud").val();
        var solicitante = $("#solicitante").val();
        var fecha_cambio = $("#fecha_permiso").val();
        var tipo_evento = $("#tipo_evento").val();
        var responsable = $("#responsable").val();
        var parentesco = $("#parentesco_responsable").val();
        var empresa = $("#empresa").val();
        var comentarios = $("#comentarios").val();
        var estatus = 1;

        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_evento.php',
            type: 'POST',
            beforeSend: () => {
                $("#btn_enviar_formulario").prop("disabled", true);
                $("#loading").fadeIn("slow");
            },
            data: {
                "idusuario": idusuario,
                "comentarios": comentarios,
                "nfamilia": familia,
                "responsable": responsable,
                "parentesco": parentesco,
                "fecha_creacion": fecha_creacion,
                "fecha_cambio": fecha_cambio,
                "tipo_permiso": tipo_permiso,
                "estatus": estatus,
                "empresa_transporte": empresa,
                "tipo_evento": tipo_evento,
                "alumnos": coleccion_ids
            }
        }).done((res) => {
            res = JSON.parse(res);
            var modal_codigo_invitacion = M.Modal.getInstance($("#modal_codigo_invitacion"));
            modal_codigo_invitacion.open();
            $("#span_codigo_verificacion").text(res);

        }).always(() => {
            $("#loading").fadeOut("slow");
        });

        coleccion_ids = [];
    }
</script>

<?php include "$root_icloud/components/layout_bottom.php"; ?>