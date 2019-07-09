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
        if ($date_helper->comprobar_hora_limite("14:30")) {
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
                                    M.textareaAutoResize($('#nombre_alumno_<?php echo $counter; ?>'));
                                </script>
                                <?php
                                $talumnos = $counter;
                            }
                        }
                        ?>
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
                        <h5 class="c-azul text-center">Fecha y horario</h5>
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
                        <div class="col s12 l6">                        
                            <div class="input-field">
                                <i class="material-icons prefix c-azul">hourglass_full</i>
                                <input 
                                    type="text" 
                                    class="timepicker" 
                                    id="hora_salida" 
                                    autocomplete="off"
                                    placeholder="Escoja hora de salida">            
                            </div>
                            <script>
                                $(".timepicker").on('mousedown', function (event) {
                                    event.preventDefault();
                                });
                                $('.timepicker').pickatime({
                                    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
                                    fromnow: 0, // set default time to * milliseconds from now (using with default = 'now')
                                    twelvehour: 'AM/PM', // Use AM/PM or 24-hour format
                                    donetext: 'Aceptar', // text for done-button
                                    cleartext: 'Limpiar', // text for clear-button
                                    canceltext: 'Cancelar', // Text for cancel-button,
                                    container: undefined, // ex. 'body' will append picker to body
                                    autoclose: false, // automatic close timepicker
                                    ampmclickable: true, // make AM PM clickable
                                    aftershow: function () {} //Function for after opening timepicker
                                });
                            </script>
                        </div>
                    </div>

                    <div class="col s12">&nbsp;</div>
                    <br>
                    <h5 class="c-azul text-center">Información adicional</h5>
                    <br>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <select id="select_responsable">                          
                            </select>
                            <label>Responsable</label>
                        </div>
                    </div>
                    <br>
                    <div class="col s12">
                        <label>
                            <input type="checkbox" id="check_nuevo_responsable" onchange="mostrar_nuevo_responsable()"/>
                            <span>Agregar un responsable</span>
                        </label>
                    </div>
                    <div class="col s12 l6" id="nuevo_responsable" hidden>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input type="text" id="responsable" autocomplete="off"> 
                            <label>Nuevo responsable</label>
                        </div>
                        <a class="waves-effect waves-light btn col s12 b-azul c-blanco" onclick="post_nuevo_responsable()"> <i class="material-icons right">send</i>Guardar</a>
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
    var responsables = [];
    $(document).ready(function () {
        $("#loading").hide();
        responsables = obtener_responsables('<?php echo $nfamilia; ?>');
        opciones_select_padres(responsables, "select_responsable");
        $('select').formSelect();
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

    function opciones_select_padres(val, id) {
        var select = $(`#${id}`);
        var options = "<option value='0' disabled selected>Seleccione una opción</option>";
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
        }
    }

    function post_nuevo_responsable() {
        var responsable = $("#responsable").val();
        nuevo_responsable(responsable, '<?php echo $nfamilia; ?>');
        var aux = obtener_responsables('<?php echo $nfamilia; ?>');
        opciones_select_padres(aux, "select_responsable");
        $('select').formSelect();
        mostrar_nuevo_responsable();
        $("#check_nuevo_responsable").prop("checked", false);
    }
</script>

<?php include "$root_icloud/components/layout_bottom.php"; ?>