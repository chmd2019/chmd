<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

session_start();

include "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";
require_once "$root_icloud/Evento/common/ControlEvento.php";

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

    $control = new ControlEvento();

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
        //se obtienen el numero de dias hábiles a sumar para realizar la solicitud de eventos
        $dias_habiles_para_montaje = $control->obtener_dias_habiles();
        $dias_habiles = array();

        while ($row = mysqli_fetch_array($dias_habiles_para_montaje)) {
            array_push($dias_habiles, ["tipo_tiempo" => $row['tipo_tiempo'],
                "numero_dias" => $row['numero_dias']]);
        }

        $dias_servicio_cafe = $dias_habiles[0];
        $dias_servicio_cafe = $dias_servicio_cafe['numero_dias'];

        $dias_evento_interno = $dias_habiles[1];
        $dias_evento_interno = $dias_evento_interno['numero_dias'];

        $dias_evento_combinado_externo = $dias_habiles[2];
        $dias_evento_combinado_externo = $dias_evento_combinado_externo['numero_dias'];
        // se asignan fechas minimas para realizar solicitud
        $fecha_minima_servicio_cafe = $date_helper->suma_dia_habil(date("d-m-Y"), $dias_servicio_cafe);
        $fecha_evento_interno = $date_helper->suma_dia_habil(date("d-m-Y"), $dias_evento_interno);
        $fecha_evento_combinado_externo = $date_helper->suma_dia_habil(date("d-m-Y"), $dias_evento_combinado_externo);        
        $fecha_actual = strtotime(date('d-m-Y'));
        $fecha_evento_especial = date('Y-m-d', strtotime("+2 month", $fecha_actual));
                
        $fecha_minima_ensayo = $date_helper->suma_dia_habil(date("d-m-Y"), 1);
        
        ?>
        <link rel='stylesheet' href='/pruebascd/icloud/materialkit/css/calendario.css'> 
        <script src='/pruebascd/icloud/materialkit/js/calendario.js'></script>
        <script src="/pruebascd/icloud/materialkit/js/common.js"></script>
        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
                <br>
                <br>
                <h5 class="center-align c-azul">Solicitud de requerimientos de montaje</h5>
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
                    <div class="col s12 l6">
                        <label  style="margin-left: 1rem">Tipo de evento</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">room_service</i>
                            <select onchange="mostrar_caja_fecha(this.value)" id="tipo_evento">
                                <option value="0" disabled selected>Selelccione una opción</option>
                                <option value="1">Servicio de café</option>
                                <option value="2">Montaje de evento interno</option>
                                <option value="3">Montaje de evento combinado o externo</option>
                                <option value="4">Montaje de evento especial</option>
                            </select>
                        </div>
                    </div>

                    <div class="col s12 l6" id="caja_servicio_cafe" hidden>
                        <label  style="margin-left: 1rem">Fecha del montaje</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_permiso_cafe" 
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
                            var fecha_minima = new Date('<?php echo $fecha_minima_servicio_cafe; ?>');
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
                                min: fecha_minima
                            });
                        </script>  
                    </div>
                    <div class="col s12 l6" id="caja_evento_interno" hidden>
                        <label  style="margin-left: 1rem">Fecha del montaje</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_evento_interno" 
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
                            var fecha_minima = new Date('<?php echo $fecha_evento_interno; ?>');
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
                                min: fecha_minima
                            });
                        </script>  
                    </div>
                    <div class="col s12 l6" id="caja_evento_combinado_externo" hidden>
                        <label  style="margin-left: 1rem">Fecha del montaje</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_evento_combinado_externo" 
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
                            var fecha_minima = new Date('<?php echo $fecha_evento_combinado_externo; ?>');
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
                                min: fecha_minima
                            });
                        </script>  
                    </div>   
                    <div class="col s12 l6" id="caja_servicio_especial" hidden>
                        <label  style="margin-left: 1rem">Fecha del montaje</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_servicio_especial" 
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
                            var fecha_minima = new Date('<?php echo $fecha_evento_especial; ?>'.replace(/-/g, "/"));
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
                                min: fecha_minima
                            });
                        </script>  
                    </div>

                    <span class="col s12"><br></span>              
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">access_time</i>
                        <label style="margin-left: 1rem">Horario del evento</label>
                        <input 
                            type="text"
                            id="horario_evento"
                            class="timepicker"
                            onkeypress="return validar_solo_numeros(event, this.id, 1)"
                            autocomplete="off"
                            onfocus="blur();"
                            placeholder="Seleccione horario">  
                    </div>                     
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">restaurant_menu</i>
                        <label for="nombre_evento" style="margin-left: 1rem">Nombre del evento</label>
                        <input id="nombre_evento"
                               placeholder="Nombre del evento" 
                               autocomplete="off"
                               type="text">
                    </div>              
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">person</i>
                        <label for="responsable_evento" style="margin-left: 1rem">Responsable del evento del area solicitante</label>
                        <input id="responsable_evento"
                               placeholder="Responsable" 
                               autocomplete="off"
                               type="text">
                    </div>  
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">sentiment_very_satisfied</i>
                        <label for="cantidad_invitados" style="margin-left: 1rem">Cantidad de invitados</label>
                        <input placeholder="Cantidad de invitados" 
                               autocomplete="off"
                               id="cantidad_invitados" 
                               type="tel"
                               onblur="maxima_cantidad(this.id, 2000)"
                               onkeypress="return validar_solo_numeros(event, this.id, 3)">
                    </div>   

                    <br>
                    <h5 class="col s12 c-azul text-center">Selección de ensayo</h5>
                    <br>   
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">play_circle_outline</i>
                        <label>
                            <input type="checkbox" class="filled-in" onchange="check_requiero_ensayo(this)"/>
                            <span>Requiero de ensayo</span>
                        </label>
                        <br>
                        <br>
                        <br>
                    </div>  
                    <div hidden id="caja_select_ensayo">
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">looks_3</i>
                            <select onchange="mostrar_caja_ensayos(this)" id="select_ensayos">
                                <option value="0" disabled selected>Selelccione una opción</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <label style="margin-left: 1rem">Cantidad de ensayos</label>
                        </div>
                        <span class="col s12"></span>
                        <div id="caja_ensayos"></div>                        
                    </div>
                    <span class="col s12"></span>  
                    <h5 class="col s12 c-azul text-center">Lugar y mobiliario del evento</h5>
                    <br>    

                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">place</i>
                        <select onchange="cargar_inventarios_montaje(this.value)" id="lugar_evento">
                            <option value="0" disabled selected>Seleccione lugar del evento</option>
                            <optgroup label="SABA">
                                <option value="1">Lobby Segundo Nivel</option>
                                <option value="2">Terraza</option>
                                <option value="3">Escenario</option>
                            </optgroup>
                            <optgroup label="KINDER">
                                <option value="4">Terraza techada</option>
                                <option value="5">Terraza Grande aun lado de salon de Pupi</option>
                                <option value="6">Terraza superior</option>
                            </optgroup>                            <optgroup label="PRIMARIA">
                                <option value="9">Patio central</option>
                                <option value="10">Cancha sintética de Pimaria</option>
                                <option value="11">Patio de Primaria</option>
                            </optgroup>	
                            <optgroup label="CCH">
                                <option value="12">Patio de CCH y Secundaria</option>
                                <option value="13">Cancha sintética de Secundaria</option>
                                <option value="14">CCH Abanico</option>
                                <option value="16">Gimnasio</option>
                                <option value="8">Terraza de Cafetería</option>
                            </optgroup>
                            <optgroup label="OTROS">
                                <option value="7">Auditorio Cojab Muebles incluidos</option>
                                <option value="15">Salón de Bailes</option>
                            </optgroup>
                        </select>
                        <label style="margin-left: 1rem">Lugar del evento</label>
                    </div> 

                    <div class="input-field col s12" hidden id="mobiliario">
                        <h5 class="col s12 c-azul text-center">Mobiliario</h5>
                        <table id="tabla_inventario"></table>
                    </div>     
                    <br>
                    <h5 class="col s12 c-azul text-center">Asignación de equipo técnico</h5>
                    <br>                
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">toys</i>
                        <label>
                            <input type="checkbox" id="check_equipo_tecnico" class="filled-in" onchange="cargar_equipo_tecnico()"/>
                            <span>Necesito equipo técnico</span>
                        </label>
                        <br>
                    </div>   
                    <div class="input-field col s12" id="caja_equipo_tecnico" hidden>   
                        <br>
                        <h5 class="col s12 c-azul text-center">Equipo técnico</h5>
                        <table id="tabla_equipo_tecnico"></table>
                    </div>  

                    <br>
                    <h5 class="col s12 c-azul text-center">Manteles</h5>
                    <br>
                    <div class="input-field col s12">
                        <table>
                            <tr>
                                <th>Artículo</th>
                                <th >Disponible</th>
                                <th style="text-align:center">Solicitar</th>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>
                                    <input 
                                        type="tel" 
                                        tabindex="-1" 
                                        value ="123" 
                                        readonly style="border:none">
                                </td>
                                <td> 
                                    <input placeholder="Cantidad" 
                                           autocomplete="off" 
                                           onkeypress="return validar_solo_numeros(event, this.id, 1)" 
                                           type="tel" 
                                           style="width:70%;float:right"> 
                                </td>
                            </tr>
                        </table>
                    </div>
                    <span class="col s12"><br><br></span>
                    <div class="col s12 l6" style="float: none;margin: 0 auto;">
                        <button class="waves-effect waves-light btn b-azul white-text w-100" 
                                id="btn_enviar_formulario"
                                type="button" 
                                onclick="enviar_formulario()">Enviar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <span class="col s12"><br></span>
                </div>  
            </div>    
        </div>  
        <?php
    }
}
?>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul" href="<?php echo $redirect_uri ?>Evento/montajes/PMontajes.php?idseccion=<?php echo $idseccion; ?>">
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
<style>
    @media screen and (min-width: 280px) and (max-width:960px){
        #toast-container {
            top: auto !important;
            right: auto !important;
            bottom: 40%;
            left: auto !important;  
        }
    }
</style>
<script>

    var timestamp = "";
    var _push_inventario = $.ajax({});
    var codigo_ensayo = "";

    $(document).ready(function () {
        $("#loading").fadeOut("slow");
        $('select').formSelect();
        $('.timepicker').timepicker({
            'step': 15,
            'minTime': '08:00',
            'maxTime': '18:00',
            'timeFormat': 'H:i'
        });
    });

    //checks

    function check_requiero_ensayo(el) {
        if (el.checked) {
            $("#caja_select_ensayo").fadeIn();
            return;
        }
        $("#select_ensayos").prop('selectedIndex', 0);
        $('#select_ensayos').formSelect();
        $("#caja_select_ensayo").fadeOut();
        codigo_ensayo = "";
        $("#caja_ensayos").html(codigo_ensayo);
    }

    function mostrar_caja_fecha(value) {
        switch (value) {
            case "1":
                $("#caja_servicio_cafe").prop("hidden", false);
                $("#caja_evento_interno").prop("hidden", true);
                $("#caja_evento_combinado_externo").prop("hidden", true);
                $("#fecha_evento_interno").val("");
                $("#fecha_evento_combinado_externo").val("");
                $("#fecha_servicio_especial").val("");
                break;
            case "2":
                $("#caja_evento_interno").prop("hidden", false);
                $("#caja_servicio_cafe").prop("hidden", true);
                $("#caja_evento_combinado_externo").prop("hidden", true);
                $("#fecha_permiso_cafe").val("");
                $("#fecha_evento_combinado_externo").val("");
                $("#fecha_servicio_especial").val("");
                break;
            case "3":
                $("#caja_evento_combinado_externo").prop("hidden", false);
                $("#caja_servicio_cafe").prop("hidden", true);
                $("#caja_evento_interno").prop("hidden", true);
                $("#fecha_permiso_cafe").val("");
                $("#fecha_evento_interno").val("");
                $("#fecha_servicio_especial").val("");
                break;
            case "4":
                $("#caja_servicio_especial").prop("hidden", false);
                $("#caja_servicio_cafe").prop("hidden", true);
                $("#caja_evento_interno").prop("hidden", true);
                $("#fecha_permiso_cafe").val("");
                $("#fecha_evento_interno").val("");
                $("#fecha_evento_combinado_externo").val("");                
                break;
        }
    }

    function mostrar_caja_ensayos(el) {
        codigo_ensayo = "";

        for (var i = 0; i < el.value; i++) {
            codigo_ensayo += ` <div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Fecha del ensayo # ${i + 1}</label> <div class="input-field"> <i class="material-icons prefix c-azul">calendar_today</i> <input type="text" class="datepicker" id="fecha_ensayo_${el.value}" autocomplete="off" placeholder="Escoja fecha" onchange="fecha_minusculas(this.value, 'fecha_permiso')"> </div></div><div class="col s12 l6"> <label style="margin-left: 1rem;">Horario de ensayo # ${i + 1}</label> <div class="input-field"> <i class="material-icons prefix c-azul">access_time</i> <input type="text" id="horario_ensayo_${i + 1}" class="timepicker" onkeypress="return validar_solo_numeros(event, this.id, 1)" autocomplete="off" onfocus="blur();" placeholder="Seleccione horario"> </div></div>`;
        }

        $("#caja_ensayos").html(codigo_ensayo);

        var calendario_escolar = obtener_calendario_escolar();
        calendario_escolar.push(6);
        calendario_escolar.push(7);
        var fecha_minima = new Date('<?php echo $fecha_minima_ensayo; ?>'.replace(/-/g, "/"));
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
            firstDay: 1,
            disableWeekends: true,
            min: fecha_minima
        });
        $('.timepicker').timepicker({
            'step': 15,
            'minTime': '08:00',
            'maxTime': '18:00',
            'timeFormat': 'H:i'
        });
    }

    function cargar_inventarios_montaje(id_lugar_evento) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_inventario_montajes.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {"id_lugar_evento": id_lugar_evento}
        }).done((res) => {
            res = JSON.parse(res);
            mostrar_inventario(res);
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }

    function cargar_equipo_tecnico() {
        if ($("#check_equipo_tecnico").prop("checked")) {
            $.ajax({

                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_equipo_tecnico.php',
                type: 'GET',
                beforeSend: () => {
                    $("#loading").fadeIn("slow");
                }
            }).done((res) => {
                res = JSON.parse(res);
                mostrar_equipo_tecnico(res);
            }).always(() => {
                $("#loading").fadeOut("slow");
            });
        } else {
            $("#caja_equipo_tecnico").fadeOut();
        }
    }

    function mostrar_inventario(inventario) {
        _push_inventario.abort();
        abortar_ajax();
        $("#mobiliario").show();
        var tr = `<tr> <th>Artículo</th> <th >Disponible</th> <th style="text-align:center">Solicitar</th> </tr>`;
        var id_lugar = 0;
        for (var item in inventario) {
            id_lugar = inventario[item].lugar;
            tr += `<tr> <td>${inventario[item].articulo}</td><td><input type="tel" id="inventario_disponible_${inventario[item].id}" tabindex="-1" value ="${inventario[item].disponible}" readonly style="border:none"></td><td> <input placeholder="Cantidad" class="cantidad_mobiliario" id="cantidad_mobiliario_${inventario[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" onblur="validar_inventario_mobiliario_cantidad_mayor_a_disponible(this)" type="tel" style="width:70%;float:right"> </td></tr>`;
        }
        $("#tabla_inventario").html(tr);
        push_inventario(id_lugar);
    }

    function mostrar_equipo_tecnico(equipo_tecnico) {
        $("#caja_equipo_tecnico").show();
        var tr = `<tr> <th>Artículo</th> <th >Disponible</th> <th style="text-align:center">Solicitar</th> </tr>`;
        for (var item in equipo_tecnico) {
            tr += `<tr> <td>${equipo_tecnico[item].articulo}</td><td><input type="tel" id="equipo_tecnico_disponible_${equipo_tecnico[item].id}" tabindex="-1" value ="${equipo_tecnico[item].disponible}" readonly style="border:none"></td><td> <input placeholder="Cantidad" class ="cantidad_equipo_tecnico" id="cantidad_equipo_tecnico_${equipo_tecnico[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" onblur="validar_equipo_tecnico_cantidad_mayor_a_disponible(this)" type="tel" style="width:70%;float:right"> </td></tr>`;
        }
        $("#tabla_equipo_tecnico").html(tr);
    }
    //validaciones
    function validar_inventario_mobiliario_cantidad_mayor_a_disponible(el) {
        var id = el.id.split("_")[2];
        var inventario_disponible = $("#inventario_disponible_" + id);
        if (el.value === "")
            return;
        var diferencia = parseInt(inventario_disponible.val()) - parseInt(el.value);
        if (diferencia < 0) {
            M.toast({
                html: 'La cantidad a solicitar no puede exceder la cantidad disponible de éste artículo!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            el.value = "";
            el.focus();
            return;
        }
    }

    function validar_equipo_tecnico_cantidad_mayor_a_disponible(el) {
        var id = el.id.split("_")[3];
        var equipo_tecnico_disponible = $("#equipo_tecnico_disponible_" + id);
        if (el.value === "")
            return;
        var diferencia = parseInt(equipo_tecnico_disponible.val()) - parseInt(el.value);
        if (diferencia < 0) {
            M.toast({
                html: 'La cantidad a solicitar no puede exceder la cantidad disponible de éste artículo!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            el.value = "";
            el.focus();
            return;
        }
    }

    function validar_inventario() {
        var mobiliario = $("#mobiliario");
        if (mobiliario.find(".cantidad_mobiliario").length === 0) {
            M.toast({
                html: 'Debe seleccionar al menos un lugar para el evento!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_tipo_evento() {
        var tipo_evento = $("#tipo_evento").val();
        if (tipo_evento === "0" || tipo_evento === null || tipo_evento === undefined || tipo_evento === "") {
            M.toast({
                html: 'Debe seleccionar un tipo de evento válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false
        }
        return true;
    }

    function validar_fecha_montaje() {
        var fecha_permiso_cafe = $("#fecha_permiso_cafe");
        var fecha_evento_interno = $("#fecha_evento_interno");
        var fecha_evento_combinado_externo = $("#fecha_evento_combinado_externo");
        if (fecha_permiso_cafe.val() === "" &&
                fecha_evento_interno.val() === "" &&
                fecha_evento_combinado_externo.val() === "") {
            M.toast({
                html: 'Debe seleccionar una fecha de montaje válida para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_nombre_evento() {
        var nombre_evento = $("#nombre_evento");
        if (nombre_evento.val() === "") {
            M.toast({
                html: 'Debe ingresar un nombre del evento válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_numero_invitados() {
        var cantidad_invitados = $("#cantidad_invitados");
        if (cantidad_invitados.val() === "") {
            M.toast({
                html: 'Debe ingresar la cantidad de invitados al evento para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_horario_evento() {
        var horario_evento = $("#horario_evento");
        if (horario_evento.val() === "") {
            M.toast({
                html: 'Debe seleccionar un horario para el evento válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_fecha_ensayo() {
        var fecha_ensayo = $("#fecha_ensayo");
        if (fecha_ensayo.val() === "") {
            M.toast({
                html: 'Debe seleccionar una fecha de ensayo válida para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_horario_ensayo() {
        var horario_ensayo = $("#horario_ensayo");
        if (horario_ensayo.val() === "") {
            M.toast({
                html: 'Debe seleccionar un horario de ensayo válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function validar_responsable_evento() {
        var responsable_evento = $("#responsable_evento");
        if (responsable_evento.val() === "") {
            M.toast({
                html: 'Debe ingresar un responsable del evento válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }

    function maxima_cantidad(id, cantidad) {
        if (!validar_maxima_cantidad(id, cantidad)) {
            $("#" + id).val("");
            $("#" + id).focus();
            M.toast({
                html: 'Máximo dosmil invitados!',
                classes: 'deep-orange c-blanco',
            }, 5000);
        }
        console.log(validar_maxima_cantidad(id, cantidad));
    }
    //recorrido de values
    function recorrido_inventario_disponible() {
        var mobiliario = $("#mobiliario");
        var cantidades = [];
        mobiliario.find(".cantidad_mobiliario").each(function () {
            var el = this;
            var data = {
                "id": parseInt(el.id.split("_")[2]),
                "asignado": el.value != "" ? parseInt(el.value) : 0
            };
            cantidades.push(data);
        });
        return cantidades;
    }

    function recorrido_equipo_tecnico() {
        var tabla_equipo_tecnico = $("#tabla_equipo_tecnico");
        var inventario_cantidad_equipo_tecnico = [];
        tabla_equipo_tecnico.find(".cantidad_equipo_tecnico").each(function () {
            var el = this;
            var data = {
                "id": parseInt(el.id.split("_")[3]),
                "asignado": el.value != "" ? parseInt(el.value) : 0
            };
            inventario_cantidad_equipo_tecnico.push(data);
        });
        return inventario_cantidad_equipo_tecnico;
    }

    function enviar_formulario() {
        var inventario_disponible = [];
        var inventario_equipo_tecnico = [];
        if (!validar_tipo_evento())
            return;
        if (!validar_fecha_montaje())
            return;
        if (!validar_horario_evento())
            return;
        if (!validar_nombre_evento())
            return;
        if (!validar_responsable_evento())
            return;
        if (!validar_numero_invitados())
            return;
        if (!validar_fecha_ensayo())
            return;
        if (!validar_horario_ensayo())
            return;
        if (!validar_inventario())
            return;
        var fecha_permiso_cafe = $("#fecha_permiso_cafe").val();
        var fecha_evento_interno = $("#fecha_evento_interno").val();
        var fecha_evento_combinado_externo = $("#fecha_evento_combinado_externo").val();
        var fecha_montaje = "";
        if (fecha_permiso_cafe != "") {
            fecha_montaje = fecha_permiso_cafe;
        }
        if (fecha_evento_interno != "") {
            fecha_montaje = fecha_evento_interno;
        }
        if (fecha_evento_combinado_externo != "") {
            fecha_montaje = fecha_evento_combinado_externo;
        }

        var fecha_solicitud = $("#fecha_solicitud").val();
        var solicitante = $("#solicitante").val();
        var tipo_evento = $("#tipo_evento").val();
        switch (tipo_evento) {
            case "1":
                tipo_evento = "Servicio de café";
                break;
            case "2":
                tipo_evento = "Montaje de evento interno";
                break;
            case "3":
                tipo_evento = "Montaje de evento combinado o externo";
                break;
        }
        //fecha_montaje
        var nombre_evento = $("#nombre_evento").val();
        var id_lugar_evento = $("#lugar_evento").val();
        var cantidad_invitados = $("#cantidad_invitados").val();
        var horario_evento = $("#horario_evento").val();
        var fecha_ensayo = $("#fecha_ensayo").val();
        var horario_ensayo = $("#horario_ensayo").val();
        var responsable_evento = $("#responsable_evento").val();
        inventario_disponible = recorrido_inventario_disponible();
        inventario_equipo_tecnico = recorrido_equipo_tecnico();

        var data = {
            "fecha_solicitud": fecha_solicitud,
            "solicitante": solicitante,
            "tipo_evento": tipo_evento,
            "fecha_montaje": fecha_montaje,
            "nombre_evento": nombre_evento,
            "id_lugar_evento": id_lugar_evento,
            "inventario_evento": inventario_disponible,
            "inventario_equipo_tecnico_evento": inventario_equipo_tecnico,
            "cantidad_invitados": cantidad_invitados,
            "horario_evento": horario_evento,
            "fecha_ensayo": fecha_ensayo,
            "horario_ensayo": horario_ensayo,
            "responsable_evento": responsable_evento
        };
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_nuevo_evento_montaje.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: data
        }).done((res) => {

        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }

    function push_inventario(id_lugar) {
        abortar_ajax();
        _push_inventario = $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/push_inventario_disponible.php',
            type: 'GET',
            data: {"timestamp": timestamp, "id_lugar": id_lugar}
        }).done((res) => {
            res = JSON.parse(res);
            timestamp = res.timestamp;
            var inventario = res.inventario_disponible;

            if (res.timestamp === timestamp) {
                if (inventario.length > 0) {
                    mostrar_inventario(inventario);
                }
                setTimeout(`push_inventario(${id_lugar})`, 1000);
            }
        });
    }

    //aborta todas las peticiones ajax para recargar el inventario
    function abortar_ajax() {
        var xhr = new XMLHttpRequest(),
                method = "GET",
                url = "https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/push_inventario_disponible.php";
        xhr.open(method, url, true);
        xhr.send();
        xhr.abort();
    }
</script>