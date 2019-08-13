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
                            <select onchange="mostrar_caja_fecha(this.value); reset_check_requiero_personal()" id="tipo_evento">
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
                                onchange="fecha_minusculas(this.value, 'fecha_permiso_cafe'); reset_check_requiero_personal()">            
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
                                onchange="fecha_minusculas(this.value, 'fecha_evento_interno');
                                        reset_check_requiero_personal()">            
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
                                onchange="fecha_minusculas(this.value, 'fecha_evento_combinado_externo');
                                        reset_check_requiero_personal()">            
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
                                onchange="fecha_minusculas(this.value, 'fecha_servicio_especial');
                                        reset_check_requiero_personal()">            
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
                    <input readonly id="fecha_evento_hidden" hidden>
                    <div class="input-field col s12 l6" hidden id="check_servicio_cafe">
                        <i class="material-icons prefix c-azul">free_breakfast</i>
                        <label>
                            <input type="checkbox" class="filled-in" />
                            <span>Servicio de café</span>
                        </label>
                        <br>
                        <br>
                    </div>  

                    <span class="col s12"><br></span>              
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">access_time</i>
                        <label style="margin-left: 1rem">Horario inicial del evento</label>
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
                        <i class="material-icons prefix c-azul">access_time</i>
                        <label style="margin-left: 1rem">Horario final del evento</label>
                        <input 
                            type="text"
                            id="horario_final_evento"
                            class="timepicker"
                            onkeypress="return validar_solo_numeros(event, this.id, 1)"
                            onchange="validar_horario_final_ensayo(this, 'horario_evento')"
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
                               onkeyup="calcular_parking(this)"
                               onkeypress="return validar_solo_numeros(event, this.id, 3)">
                    </div>           
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">drive_eta</i>
                        <label style="margin-left: 1rem">Valet Parking</label>
                        <input id="valet_parking"
                               placeholder="Valet Parking" 
                               autocomplete="off"
                               type="text"
                               disabled>
                    </div>                      
                    <div class="file-field input-field col s12 l6">
                        <div class="waves-effect waves-light btn b-azul" style="margin-top: 1.5rem">
                            <span><i class="material-icons c-blanco">attach_file</i></span>
                            <input type="file" 
                                   onchange ="return validar_file(this)" >
                        </div>
                        <div class="file-path-wrapper">
                            <label>Anexa programa minuto a minuto</label>
                            <input class="file-path validate" 
                                   type="text" 
                                   placeholder="Anexar archivo"
                                   style="font-size: .8rem"> 
                        </div>
                        <div class="chip blue white-text">
                            <span>Formatos permitidos: .txt .docx .pptx .pdf</span>
                        </div>
                        <div class="chip blue white-text">
                            <span>Tamaño máx:3mb</span>
                        </div>
                    </div>
                    <br><h5 class="col s12 c-azul text-center">Lugar y mobiliario del evento</h5>
                    <br>    
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">place</i>
                        <select onchange="cargar_inventarios_montaje(this.value)" id="lugar_evento">

                        </select>
                        <label style="margin-left: 1rem">Lugar del evento</label>
                    </div> 
                    <div class="input-field col s12" hidden id="mobiliario">
                        <h5 class="col s12 c-azul text-center">Mobiliario</h5>
                        <div id="tabla_inventario"></div>         
                        <div class="input-field col s12" id="caja_asignacion_manteles" hidden>  
                            <h5 class="col s12 c-azul text-center">Asignación de manteles</h5>
                            <br>
                            <div style="text-align: center" id="badge_mantel_seleccion">               
                                <span class="new badge blue" 
                                      data-badge-caption="Debe seleccionar el lugar del evento para asignar manteles"
                                      style="float:none;padding:.3rem">
                                </span>
                            </div>
                            <div style="text-align: center" id="badge_mantel_no_asignacion" hidden>               
                                <div class="chip red white-text">
                                    No es posible asignación de manteles para el lugar del evento seleccionado
                                </div>
                            </div>
                            <div class="input-field col s12" hidden id="manteles">
                                <div id="tabla_manteles"></div>
                            </div>
                        </div>  
                    </div>    
                    <h5 class="col s12 c-azul text-center">Asignación de equipo personal y técnico</h5>
                    <br>                
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">settings_input_composite</i>
                        <label>
                            <input type="checkbox" id="check_equipo_tecnico" class="filled-in" onchange="cargar_equipo_tecnico(this)"/>
                            <span>Requiero equipo técnico</span>
                        </label>
                        <br>
                    </div>   
                    <div class="input-field col s12" id="caja_equipo_tecnico" hidden>   
                        <br>
                        <h5 class="col s12 c-azul text-center">Equipo técnico</h5>
                        <div id="tabla_equipo_tecnico"></div>
                    </div>  

                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">group_add</i>
                        <label>
                            <input id="check_requiero_personal" 
                                   type="checkbox" 
                                   class="filled-in" 
                                   onchange="cargar_personal_montaje(this)"/>
                            <span>Requiero personal</span>
                        </label>
                    </div>   
                    <span class="col s12"><br></span>   
                    <div id="caja_personal_evento" hidden>
                        <br>
                        <h5 class="col s12 c-azul text-center">Selección de personal para el evento</h5>
                        <br>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">build</i>
                            <select id="select_personal_montaje"></select>
                            <label style="margin-left: 1rem">Personal de montaje</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">build</i>
                            <select id="select_personal_cabina_auditorio"></select>
                            <label style="margin-left: 1rem">Personal de cabina de auditorio</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">build</i>
                            <select id="select_personal_limpieza"></select>
                            <label style="margin-left: 1rem">Personal de limpieza</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">build</i>
                            <select id="select_personal_vigilancia"></select>
                            <label style="margin-left: 1rem">Personal de vigilancia</label>
                        </div>
                        <div class="input-field col s12" style="text-align: center" id="reserva_personal">
                            <button class="waves-effect waves-light btn col l3"                                     
                                    onclick="actualizar_personal('select_personal_montaje', 'select_personal_cabina_auditorio', 'select_personal_limpieza', 'select_personal_vigilancia')"
                                    type="button" 
                                    style="background-color: #00C2EE;float: none">Reservar personal
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
                        <div class="input-field col s12" style="text-align: center;" hidden id="anular_reserva_personal">
                            <button class="waves-effect waves-light btn red col l3" style="float: none"                                 
                                    type="button"
                                    onclick="anular_reserva_personal('#select_personal_montaje', '#select_personal_cabina_auditorio', '#select_personal_limpieza', '#select_personal_vigilancia')">Anular reserva
                                <i class="material-icons right">delete</i>
                            </button>
                        </div>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">donut_large</i>
                        <label>
                            <input type="checkbox" class="filled-in" onchange="mostrar_tipo_repliegue()"/>
                            <span>Requiero repliegue</span>
                        </label>
                        <br>
                        <br>
                    </div> 
                    <div class="input-field col s12 l6" hidden id="caja_tipo_repliegue">
                        <i class="material-icons prefix c-azul">donut_small</i>
                        <select>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="1">Estacionamiento maestros</option>
                            <option value="2">Patio de camiones 1/2</option>
                            <option value="3">Patio de completo</option>
                        </select>
                        <label style="margin-left: 1rem">Tipo de repliegue</label>
                    </div>  
                    <br>
                    <h5 class="col s12 c-azul text-center">Solicitud de ensayo</h5>
                    <br>   
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">compare_arrows</i>
                        <label>
                            <input type="checkbox"
                                   id="requiero_ensayo"
                                   class="filled-in" 
                                   onchange="check_requiero_ensayo(this)"/>
                            <span>Requiero de ensayo</span>
                        </label>
                        <br>
                        <br>
                        <br>
                    </div>  
                    <div hidden id="caja_select_ensayo">
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">looks_6</i>
                            <select onchange="mostrar_caja_ensayos(this)" id="select_ensayos">
                                <option value="0" disabled selected>Selelccione una opción</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                            <label style="margin-left: 1rem">Cantidad de ensayos</label>
                        </div>
                        <span class="col s12"></span>
                        <div id="caja_ensayos"></div>                        
                    </div>
                    <h5 class="col s12 c-azul text-center">Adicionales</h5>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">list_alt</i>
                        <textarea class="materialize-textarea"
                                  id="requerimientos_especiales"
                                  placeholder="Requerimientos especiales"></textarea>  
                    </div>
                    <span class="col s12"><br></span>
                    <div class="input-field col s12">
                        <div style="text-align: center">
                            <button class="waves-effect waves-light btn col s12 l4" 
                                    type="button" 
                                    style="background-color: #00C2EE;float: none">PREVISUALIZAR
                                <i class="material-icons right">search</i>
                            </button>
                            <span class="col s12 hide-on-med-and-up"><br></span>
                            <button class="waves-effect waves-light btn b-azul white-text col s12 l4" 
                                    id="btn_enviar_formulario"
                                    type="button" 
                                    onclick="enviar_formulario()"
                                    style="background-color: #00C2EE;float: none">Enviar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
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
    <a class="btn-floating btn-large waves-effect waves-light light-blue">
        <i class="large material-icons">save</i>
    </a>
    <br>
    <br>
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
    var id_lugar = 0;
    var archivo_cargado = null;
    var nfamilia = '<?php echo $nfamilia; ?>';
    //push
    var pusher = null;
    var channel = null;
    var token = '<?php echo uniqid(); ?>';
    var timestamp_personal_montaje = null;
    var timestamp_personal_montaje_ensayos = [];

    $(document).ready(function () {
        $("#loading").fadeOut("slow");
        $('select').formSelect();
        M.textareaAutoResize($('textarea'));
        $('.timepicker').timepicker({
            'step': 15,
            'minTime': '08:00',
            'maxTime': '18:00',
            'timeFormat': 'H:i:s'
        });
        $("#horario_evento").change(function () {
            reset_check_requiero_personal();
        });
        $("#horario_final_evento").change(function () {
            reset_check_requiero_personal();
        });
        cargar_lugares();
        //pusher        
        pusher = new Pusher('d71baadb1789d7f0cd64', {
            cluster: 'us3',
            forceTLS: true
        });
        channel = pusher.subscribe('canal_personal');
        channel.bind('actualiza_personal', function (res) {
            if (res.actualizar_personal.push && res.actualizar_personal.token !== token) {
                M.toast({
                    html: 'El personal disponible ha sido modificado por otro usuario',
                    classes: 'blue c-blanco',
                });
            }
        });
    });
    //checks

    function reset_check_requiero_personal() {
        var check_requiero_personal = $("#check_requiero_personal");
        if (check_requiero_personal.prop("checked")) {
            check_requiero_personal.click();
            M.toast({
                html: 'Debe asignar el personal requerido nuevamente',
                classes: 'blue c-blanco',
            }, 5000);
        }
    }

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
        reset_check_requiero_personal();
        switch (value) {
            case "1":
                $("#caja_servicio_cafe").prop("hidden", false);
                $("#caja_evento_interno").prop("hidden", true);
                $("#caja_evento_combinado_externo").prop("hidden", true);
                $("#caja_servicio_especial").prop("hidden", true);
                $("#check_servicio_cafe").prop("hidden", true);
                $("#fecha_evento_interno").val("");
                $("#fecha_evento_combinado_externo").val("");
                $("#fecha_servicio_especial").val("");
                break;
            case "2":
                $("#caja_evento_interno").prop("hidden", false);
                $("#caja_servicio_cafe").prop("hidden", true);
                $("#caja_evento_combinado_externo").prop("hidden", true);
                $("#caja_servicio_especial").prop("hidden", true);
                $("#check_servicio_cafe").prop("hidden", false);
                $("#fecha_permiso_cafe").val("");
                $("#fecha_evento_combinado_externo").val("");
                $("#fecha_servicio_especial").val("");
                break;
            case "3":
                $("#caja_evento_combinado_externo").prop("hidden", false);
                $("#caja_servicio_cafe").prop("hidden", true);
                $("#caja_evento_interno").prop("hidden", true);
                $("#caja_servicio_especial").prop("hidden", true);
                $("#check_servicio_cafe").prop("hidden", false);
                $("#fecha_permiso_cafe").val("");
                $("#fecha_evento_interno").val("");
                $("#fecha_servicio_especial").val("");
                break;
            case "4":
                $("#caja_servicio_especial").prop("hidden", false);
                $("#caja_servicio_cafe").prop("hidden", true);
                $("#caja_evento_interno").prop("hidden", true);
                $("#caja_evento_combinado_externo").prop("hidden", true);
                $("#check_servicio_cafe").prop("hidden", false);
                $("#fecha_permiso_cafe").val("");
                $("#fecha_evento_interno").val("");
                $("#fecha_evento_combinado_externo").val("");
                break;
        }
    }

    function mostrar_caja_ensayos(el) {
        var codigo_ensayo = "";
        for (var i = 0; i < el.value; i++) {
            var codigo = `<div class="col s12 card"> <div class="card-content" style="color:#00C2EE;"> <h5>Ensayo N° ${i + 1}</h5> </div><div class="card-tabs"> <ul class="tabs tabs-fixed-width"> <li class="tab blue white-text active"><a href="#tab_1_${i + 1}">Información de ensayo</a> </li><li class="tab blue white-text" onclick="cargar_personal_ensayo(${i})"><a href="#tab_2_${i + 1}">Personal</a> </li></ul> </div><div class="card-content"> <div id="tab_1_${i + 1}"> <div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Fecha del ensayo</label> <div class="input-field"> <i class="material-icons prefix c-azul">calendar_today</i> <input type="text" class="datepicker" id="fecha_ensayo_${i}" autocomplete="off" placeholder="Escoja fecha" onchange="fecha_minusculas(this.value, 'fecha_permiso')" style="font-size: 1rem"> </div></div><div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Horario inicial</label> <div class="input-field"> <i class="material-icons prefix c-azul">access_time</i> <input type="text" id="horario_inicial_ensayo_${i}" class="timepicker" onkeypress="return validar_solo_numeros(event, this.id, 1)" autocomplete="off" onfocus="blur();" placeholder="Seleccione horario"> </div></div><div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Horario final</label> <div class="input-field"> <i class="material-icons prefix c-azul">access_time</i> <input type="text" id="horario_final_ensayo_${i}" class="timepicker" onkeypress="return validar_solo_numeros(event, this.id, 1)" onchange="validar_horario_final_ensayo(this,'horario_inicial_ensayo_${i}')" autocomplete="off" onfocus="blur();" placeholder="Seleccione horario"> </div></div><div class="input-field col s12"> <i class="material-icons prefix c-azul">list_alt</i> <textarea class="materialize-textarea" id="requerimientos_especiales_ensayo_${i}" placeholder="Requerimientos especiales"></textarea> </div></div><div id="tab_2_${i + 1}"> <div id="caja_select_${i}"> <div class="input-field col s12 l6"> <i class="material-icons prefix c-azul">build</i> <select id="select_montaje_ensayo_${i}"></select> <label style="margin-left: 1rem;color:#00C2EE">Personal de montaje</label> </div><div class="input-field col s12 l6"> <i class="material-icons prefix c-azul">build</i> <select id="select_cabina_auditorio_ensayo_${i}"></select> <label style="margin-left: 1rem;color:#00C2EE">Personal de cabina de auditorio</label> </div><div class="input-field col s12 l6"> <i class="material-icons prefix c-azul">build</i> <select id="select_limpieza_ensayo_${i}"></select> <label style="margin-left: 1rem;color:#00C2EE">Personal de limpieza</label> </div><div class="input-field col s12" style="text-align: center" id="reserva_personal_${i}"> <button class="waves-effect waves-light btn col l4" onclick="actualizar_personal_ensayo('select_montaje_ensayo_${i}', 'select_cabina_auditorio_ensayo_${i}', 'select_limpieza_ensayo_${i}', 'fecha_ensayo_${i}','horario_inicial_ensayo_${i}','horario_final_ensayo_${i}', '#reserva_personal_${i}', '#anular_reserva_personal_${i}',${i})" type="button" style="background-color: #00C2EE;float: none">Reservar personal <i class="material-icons right">save</i> </button> </div><div class="input-field col s12" style="text-align: center;" hidden id="anular_reserva_personal_${i}"> <button class="waves-effect waves-light btn red col l3" style="float: none" type="button" onclick="anular_reserva_personal_ensayo('#select_montaje_ensayo_${i}','#select_cabina_auditorio_ensayo_${i}','#select_limpieza_ensayo_${i}','#anular_reserva_personal_${i}','#reserva_personal_${i}',${i})">Anular reserva <i class="material-icons right">delete</i> </button> </div></div><span class="col s12"><br></span> <div class="chip orange col s12 white-text" style="text-align: center" id="validacion_ensayo_${i}"> <span>Debe seleccionar una fecha y horarios válidos para continuar!</span> </div><span class="col s12 hide-on-med-and-down"><br><br></span> </div></div></div>`;
            codigo_ensayo += `${codigo}`;
        }

        $("#caja_ensayos").html(codigo_ensayo);
        $('.tabs').tabs();
        $('select').formSelect();
        M.textareaAutoResize($('textarea'));
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
            'timeFormat': 'H:i:s'
        });
    }

    function mostrar_caja_personal_ensayo(el, i) {
        if ($("#caja_personal_evento_" + i).prop("hidden")) {
            $("#caja_personal_evento_" + i).prop("hidden", false);
            $("#caja_personal_evento_" + i).fadeIn();
            $("select").formSelect();
            M.textareaAutoResize($('textarea'));
            return;
        }
        $("#caja_personal_evento_" + i).prop("hidden", true);
        $("#caja_personal_evento_" + i).fadeOut();
    }

    function mostrar_tipo_repliegue() {
        if ($("#caja_tipo_repliegue").prop("hidden")) {
            $("#caja_tipo_repliegue").fadeIn();
            $("#caja_tipo_repliegue").prop("hidden", false);
        } else {
            $("#caja_tipo_repliegue").fadeOut();
            $("#caja_tipo_repliegue").prop("hidden", true);
        }
    }

    function calcular_parking(el) {
        var value = el.value;
        $("#valet_parking").val(parseInt(value * .6));
    }

    function validar_file(el) {
        var tipos_permitidos = /(.txt|.doc|.docx|.pptx|.ppt|.pdf)$/i;
        if (el === null) {
            M.toast({
                html: 'Debe seleccionar un archivo con formato válido!',
                classes: 'deep-orange c-blanco',
            }, 15000);
            return false;
        }
        if (!tipos_permitidos.exec(el.value) || el.value === null || el.value === "") {
            el.value = "";
            el.focus();
            M.toast({
                html: 'Debe seleccionar un archivo con formato válido!',
                classes: 'deep-orange c-blanco',
            }, 15000);
            return false;
        }

        var max_size = el.files[0].size / 1048576;
        if (max_size > 3) {
            M.toast({
                html: 'El archivo debe tener un tamaño máximo de 3mb!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            el.value = "";
            el.focus();
            return false;
        }
        archivo_cargado = el;
        return true;
    }

    function cargar_archivo_programa(archivo) {
        if (!validar_file(archivo))
            return;
        archivo = archivo.files[0];
        var datos = new FormData();
        datos.append('archivo', archivo);
        datos.append('nfamilia', nfamilia);
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_archivo_programa.php',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            }
        }).done((res) => {
            res = JSON.parse(res);
            if (typeof res.success !== 'undefined') {
                M.toast({
                    html: 'El archivo debe tener un tamaño máximo de 3mb!',
                    classes: 'deep-orange c-blanco',
                }, 5000);
                archivo.value = "";
                return;
            }
            console.log(res);
        }).always(() => {
            $("#loading").fadeOut();
        });
    }

    function cargar_lugares() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_lugares_evento.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn();
            }
        }).done((res) => {
            res = JSON.parse(res);
            var aux = {};
            //Recorremos el res 
            res.forEach(x => {
                //Si no existe lo creamos 
                if (!aux.hasOwnProperty(x.patio)) {
                    aux[x.patio] = [];
                }
                //Agregamos los datos. 
                aux[x.patio].push({
                    id: x.id,
                    descripcion: x.descripcion
                });
            });
            var options = "";
            var optgroup = "";
            for (var item in aux) {
                var res_item = aux[item];
                for (var item2 in res_item) {
                    var res_item2 = res_item[item2];
                    options += `<option value="${res_item2.id}">${res_item2.descripcion}</option>`;
                }
                optgroup += `<optgroup label="${item}">${options}</optgroup>`;
                options = "";
            }
            $("#lugar_evento").html(`<option value="0" disabled selected>Seleccione lugar del evento</option>${optgroup}`);
            $("#lugar_evento").formSelect();
        }).always(() => {
            $("#loading").fadeOut();
        });
    }

    function cargar_inventarios_montaje(id_lugar_evento) {
        if ($("#check_equipo_tecnico").prop("checked")) {
            $("#check_equipo_tecnico").click();
        }
        id_lugar = id_lugar_evento;
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_capacidad_mobiliario.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {"id_lugar_evento": id_lugar_evento}
        }).done((res) => {
            res = JSON.parse(res);
            cargar_inventario_manteles(id_lugar_evento, res);
            $("#badge_mantel_seleccion").prop("hidden", true);
            $("#badge_mantel_no_asignacion").prop("hidden", true);
            $("#caja_asignacion_manteles").prop("hidden", false);
            $("#caja_asignacion_manteles").fadeIn();
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }

    function cargar_equipo_tecnico(el) {
        if (id_lugar === 0) {
            el.checked = false;
            M.toast({
                html: 'Debe seleccionar un lugar del evento válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return;
        }
        if (el.checked) {
            $.ajax({

                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_capacidad_equipo_tecnico.php',
                type: 'GET',
                beforeSend: () => {
                    $("#loading").fadeIn("slow");
                },
                data: {"id_lugar": id_lugar}
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

    function cargar_inventario_manteles(id_lugar_evento, inventario) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_capacidad_manteles.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {"id_lugar": id_lugar_evento}
        }).done((res) => {
            $("#tabla_manteles").html("");
            res = JSON.parse(res);
            mostrar_inventario(inventario);
            mostrar_manteles(res);
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }

    function cargar_personal_montaje(el) {

        var fecha_formateada = obtener_fecha();
        var horario_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        if (fecha_formateada === null) {
            M.toast({
                html: 'Debe seleccionar el tipo de evento y una fecha válida para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            el.checked = false;
            return;
        }

        if (horario_evento === "" || horario_final_evento === "") {
            M.toast({
                html: 'Debe seleccionar un horario válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            el.checked = false;
            return;
        }

        if ($("#caja_personal_evento").prop('hidden')) {
            $("#caja_personal_evento").fadeIn();
            $("#caja_personal_evento").prop('hidden', false);
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_personal_montaje.php',
                type: 'GET',
                beforeSend: () => {
                    $("#loading").fadeIn();
                },
                data: {
                    "fecha": fecha_formateada,
                    "horario_inicial": horario_evento,
                    "horario_final": horario_final_evento
                }
            }).done((res) => {
                res = JSON.parse(res);
                //toma cantidad del personal
                var personal_montaje = res.personal_montaje.total_disponible;
                var personal_cabina_auditorio = res.personal_cabina_auditorio.total_disponible;
                var personal_limpieza = res.personal_limpieza.total_disponible;
                var personal_vigilancia = res.personal_vigilancia.total_disponible;
                //llena select con la cantidad disponible de empleados
                llenar_select_personal($("#select_personal_montaje"), personal_montaje);
                llenar_select_personal($("#select_personal_cabina_auditorio"), personal_cabina_auditorio);
                llenar_select_personal($("#select_personal_limpieza"), personal_limpieza);
                llenar_select_personal($("#select_personal_vigilancia"), personal_vigilancia);
            }).always(() => {
                $("#loading").fadeOut();
            });
        } else {
            $("#caja_personal_evento").fadeOut();
            $("#caja_personal_evento").prop('hidden', true);
        }

    }

    function mostrar_inventario(inventario) {
        _push_inventario.abort();
        abortar_ajax();
        $("#mobiliario").show();
        var tr = "";
        var id_lugar = 0;
        for (var item in inventario) {
            id_lugar = inventario[item].lugar;
            tr += ` <li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">done</i> <span class="title"><b>Artículo: </b> ${inventario[item].articulo}</span> <p> <b>Capacidad del lugar: </b> ${inventario[item].capacidad}<br><b>Disponible para el evento: </b>${inventario[item].disponible}</p><b>Cantidad para el evento: </b> <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i><input placeholder="Ingrese cantidad deseada" class="cantidad_mobiliario" id="cantidad_mobiliario_${inventario[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" type="tel"></div> </div><div class="col s12 l6 text-center"> <a href="${inventario[item].ruta_img}" data-fancybox data-caption="${inventario[item].articulo}"> <br><img src="${inventario[item].ruta_img}" width="150"/> </a> </div></li>`;
        }
        $("#tabla_inventario").html(`<ul class="collection row">${tr}</ul>`);
        push_inventario(id_lugar);
    }

    function mostrar_equipo_tecnico(equipo_tecnico) {
        $("#caja_equipo_tecnico").show();
        var tr = "";
        for (var item in equipo_tecnico) {
            tr += ` <li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">done</i> <span class="title"><b>Artículo: </b> ${equipo_tecnico[item].articulo}</span> <p> <b>Capacidad del lugar: </b> ${equipo_tecnico[item].capacidad}<br><b>Disponible para el evento: </b>${equipo_tecnico[item].disponible}</p><b>Cantidad para el evento: </b> <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i><input placeholder="Ingrese cantidad deseada" class="cantidad_mobiliario" id="cantidad_equipo_tecnico_${equipo_tecnico[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" type="tel"></div> </div><div class="col s12 l6 text-center"> <a href="${equipo_tecnico[item].ruta_img}" data-fancybox data-caption="${equipo_tecnico[item].articulo}"><br> <img src="${equipo_tecnico[item].ruta_img}" width="150"/> </a> </div></li>`;
        }
        $("#tabla_equipo_tecnico").html(`<ul class="collection row">${tr}</ul>`);
    }

    function mostrar_manteles(manteles) {
        var tr = "";
        if (manteles.length === 0) {
            $("#badge_mantel_no_asignacion").prop("hidden", false);
            $("#tabla_manteles").html("");
            return;
        }
        for (var item in manteles) {
            tr += ` <li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">done</i> <span class="title"><b>Artículo: </b> ${manteles[item].articulo}</span> <p> <b>Capacidad del lugar: </b> ${manteles[item].capacidad}<br><b>Disponible para el evento: </b>${manteles[item].disponible}</p><b>Cantidad para el evento: </b> <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i><input placeholder="Ingrese cantidad deseada" class="cantidad_mobiliario" id="cantidad_manteles_${manteles[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" type="tel"></div> </div><div class="col s12 l6 text-center"> <a href="${manteles[item].ruta_img}" data-fancybox data-caption="${manteles[item].articulo}"> <br><img src="${manteles[item].ruta_img}" width="150"/> </a> </div></li>`;
        }
        $("#manteles").show();
        $("#tabla_manteles").html(`<ul class="collection row">${tr}</ul>`);
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
        cargar_archivo_programa(archivo_cargado);
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
    //ensayo    
    function cargar_personal_ensayo(i) {
        if ($("#fecha_ensayo_" + i).val() === "" ||
                $("#horario_inicial_ensayo_" + i).val() === "" ||
                $("#horario_final_ensayo_" + i).val() === "") {
            M.toast({
                html: 'Debe seleccionar una fecha y horarios válidos para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            $("#caja_select_" + i).hide();
            $("#validacion_ensayo_" + i).fadeIn();
            return;
        }
        $("#caja_select_" + i).fadeIn();
        $("#validacion_ensayo_" + i).hide();
        var fecha_ensayo = formatear_fecha_calendario_formato_a_m_d_guion($("#fecha_ensayo_" + i).val());
        var horario_inicial_ensayo = $("#horario_inicial_ensayo_" + i).val();
        var horario_final_ensayo = $("#horario_final_ensayo_" + i).val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_personal_montaje.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                "fecha": fecha_ensayo,
                "horario_inicial": horario_inicial_ensayo,
                "horario_final": horario_final_ensayo
            }
        }).done((res) => {
            res = JSON.parse(res);
            //toma cantidad del personal
            var personal_montaje = res.personal_montaje.total_disponible;
            var personal_cabina_auditorio = res.personal_cabina_auditorio.total_disponible;
            var personal_limpieza = res.personal_limpieza.total_disponible;
            //llena select con la cantidad disponible de empleados
            llenar_select_personal($("#select_montaje_ensayo_" + i), personal_montaje);
            llenar_select_personal($("#select_cabina_auditorio_ensayo_" + i), personal_cabina_auditorio);
            llenar_select_personal($("#select_limpieza_ensayo_" + i), personal_limpieza);
        }).always(() => {
            $("#loading").fadeOut();
        });
    }

    function validar_horario_final_ensayo(el, id_hora_inicial) {
        var hora_inicial = $("#" + id_hora_inicial).val();
        var hora_final = el.value;
        hora_inicial = hora_inicial.split(":");
        hora_final = hora_final.split(":");
        hora_inicial = (parseInt(hora_inicial[0]) * 60 * 60) + parseInt(hora_inicial[1] * 60);
        hora_final = (parseInt(hora_final[0]) * 60 * 60) + parseInt(hora_final[1] * 60);
        if (hora_inicial >= hora_final || $("#" + id_hora_inicial).val() === "") {
            $("#" + el.id).timepicker('remove');
            el.value = '';
            $("#" + el.id).timepicker({
                'step': 15,
                'minTime': '08:00',
                'maxTime': '18:00',
                'timeFormat': 'H:i:s'
            });
            M.toast({
                html: 'Debe elegir una hora final posterior a la hora inicial!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return;
        }
    }

    function llenar_select_personal(el, cantidad_disponible) {
        var options = "<option value='0' disabled selected>Cantidad de personal</option>";
        if (parseInt(cantidad_disponible) === 0)
            options += `<option value="0">0</option>`;
        else
            for (var i = 1, max = cantidad_disponible; i <= max; i++) {
                options += `<option value="${i}">${i}</option>`;
            }
        el.html(options);
        $('select').formSelect();
    }

    function actualizar_personal(select_personal_montaje, select_personal_cabina_auditorio,
            select_personal_limpieza, select_personal_vigilancia) {

        if ($("#" + select_personal_montaje).val() === null &&
                $("#" + select_personal_cabina_auditorio).val() === null &&
                $("#" + select_personal_limpieza).val() === null &&
                $("#" + select_personal_vigilancia).val() === null) {
            M.toast({
                html: 'La selección de personal es requerida para continuar!',
                classes: 'blue c-blanco',
            });
            return;
        }

        var fecha_formateada = obtener_fecha();
        var horario_inicial_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        //personal
        var personal_montaje = {"tipo": 1, cantidad: $("#" + select_personal_montaje).val()};
        var personal_cabina_auditorio = {"tipo": 2, cantidad: $("#" + select_personal_cabina_auditorio).val()};
        var personal_limpieza = {"tipo": 3, cantidad: $("#" + select_personal_limpieza).val()};
        var personal_vigilancia = {"tipo": 4, cantidad: $("#" + select_personal_vigilancia).val()};
        var personal = {
            "personal_montaje": personal_montaje,
            "personal_cabina_auditorio": personal_cabina_auditorio,
            "personal_limpieza": personal_limpieza,
            "personal_vigilancia": personal_vigilancia
        };
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_personal.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                personal,
                fecha_montaje: fecha_formateada,
                horario_inicial_evento,
                horario_final_evento,
                token: token,
                socket_id: pusher.connection.socket_id
            }
        }).done((res) => {
            if (res.respuesta) {
                M.toast({
                    html: 'El personal seleccionado ha sido asignado correctamente',
                    classes: 'green c-blanco',
                });
                $("#" + select_personal_montaje).prop("disabled", true);
                $("#" + select_personal_cabina_auditorio).prop("disabled", true);
                $("#" + select_personal_limpieza).prop("disabled", true);
                $("#" + select_personal_vigilancia).prop("disabled", true);
                $("#check_requiero_personal").prop("disabled", true);
                $('select').formSelect();
                $("#anular_reserva_personal").prop("hidden", false);
                $("#reserva_personal").prop("hidden", true);
                timestamp_personal_montaje = res.timestamp;
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }

    function anular_reserva_personal(select_personal_montaje, select_personal_cabina_auditorio,
            select_personal_limpieza, select_personal_vigilancia) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_anula_personal_asignado.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {timestamp: timestamp_personal_montaje}
        }).done((res) => {
            if (res) {
                M.toast({
                    html: 'Ha sido anulada la selección del personal!',
                    classes: 'blue c-blanco',
                });
                $(select_personal_montaje).prop("disabled", false);
                $(select_personal_cabina_auditorio).prop("disabled", false);
                $(select_personal_limpieza).prop("disabled", false);
                $(select_personal_vigilancia).prop("disabled", false);
                $('select').formSelect();
                $("#check_requiero_personal").prop("disabled", false);
                timestamp_personal_montaje = null;
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    //añadir fecha, y horarios
    function actualizar_personal_ensayo(select_montaje_ensayo, select_cabina_auditorio_ensayo,
            select_limpieza_ensayo, fecha, hora_inicial, hora_final, reserva_personal, anular_personal_ensayo, i) {

        if ($("#" + select_montaje_ensayo).val() === null &&
                $("#" + select_cabina_auditorio_ensayo).val() === null &&
                $("#" + select_limpieza_ensayo).val() === null) {
            M.toast({
                html: 'La selección de personal es requerida para continuar!',
                classes: 'blue c-blanco',
            });
            return;
        }

        var fecha_formateada = formatear_fecha_calendario_formato_a_m_d_guion($("#" + fecha).val());
        var horario_inicial_evento = $("#" + hora_inicial).val();
        var horario_final_evento = $("#" + hora_final).val();
        //personal
        var personal_montaje = {"tipo": 1, cantidad: $("#" + select_montaje_ensayo).val()};
        var personal_cabina_auditorio = {"tipo": 2, cantidad: $("#" + select_cabina_auditorio_ensayo).val()};
        var personal_limpieza = {"tipo": 3, cantidad: $("#" + select_limpieza_ensayo).val()};
        var personal = {
            "personal_montaje": personal_montaje,
            "personal_cabina_auditorio": personal_cabina_auditorio,
            "personal_limpieza": personal_limpieza,
        };

        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_personal.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                personal,
                fecha_montaje: fecha_formateada,
                horario_inicial_evento,
                horario_final_evento,
                token: token,
                socket_id: pusher.connection.socket_id
            }
        }).done((res) => {
            if (res.respuesta) {
                M.toast({
                    html: 'El personal seleccionado ha sido asignado correctamente',
                    classes: 'green c-blanco',
                });
                $("#" + select_montaje_ensayo).prop("disabled", true);
                $("#" + select_cabina_auditorio_ensayo).prop("disabled", true);
                $("#" + select_limpieza_ensayo).prop("disabled", true);
                $("#select_ensayos").prop("disabled", true);
                $('select').formSelect();
                $("#requiero_ensayo").prop("disabled", true);
                $(reserva_personal).prop("hidden", true);
                $(anular_personal_ensayo).prop("hidden", false);
                timestamp_personal_montaje_ensayos.push({timestamp: res.timestamp, i: i});
                console.log(timestamp_personal_montaje_ensayos);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }

    function anular_reserva_personal_ensayo(select_personal_montaje, select_personal_cabina_auditorio,
            select_personal_limpieza, btn_anular, btn_asignar, i) {
        for (var item in timestamp_personal_montaje_ensayos) {
            if (timestamp_personal_montaje_ensayos[item].i === i) {
                $.ajax({
                    url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_anula_personal_asignado.php',
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: () => {
                        $("#loading").fadeIn();
                    },
                    data: {timestamp: timestamp_personal_montaje_ensayos[item].timestamp}
                }).done((res) => {
                    if (res) {
                        M.toast({
                            html: 'Ha sido anulada la selección del personal!',
                            classes: 'blue c-blanco',
                        });
                        $(select_personal_montaje).prop("disabled", false);
                        $(select_personal_cabina_auditorio).prop("disabled", false);
                        $(select_personal_limpieza).prop("disabled", false);
                        $('select').formSelect();
                        $(btn_anular).prop("hidden", true);
                        $(btn_asignar).prop("hidden", false);
                        var index = timestamp_personal_montaje_ensayos.indexOf(timestamp_personal_montaje_ensayos[item]);
                        var borrado = null;
                        if (index > -1) {
                            borrado=timestamp_personal_montaje_ensayos.splice(index-1, 1);
                        }
                        console.log(borrado);
                    }
                }).always(() => {
                    $("#loading").fadeOut();
                    console.log(timestamp_personal_montaje_ensayos);
                });
            }
        }
    }

    function obtener_fecha() {
        var fecha_formateada = null;
        var fecha_permiso_cafe = $("#fecha_permiso_cafe").val();
        var fecha_evento_interno = $("#fecha_evento_interno").val();
        var fecha_evento_combinado_externo = $("#fecha_evento_combinado_externo").val();
        var fecha_servicio_especial = $("#fecha_servicio_especial").val();
        if (fecha_permiso_cafe !== "") {
            fecha_formateada = formatear_fecha_calendario_formato_a_m_d_guion(fecha_permiso_cafe);
        } else if (fecha_evento_interno !== "") {
            fecha_formateada = formatear_fecha_calendario_formato_a_m_d_guion(fecha_evento_interno);
        } else if (fecha_evento_combinado_externo !== "") {
            fecha_formateada = formatear_fecha_calendario_formato_a_m_d_guion(fecha_evento_combinado_externo);
        } else if (fecha_servicio_especial !== "") {
            fecha_formateada = formatear_fecha_calendario_formato_a_m_d_guion(fecha_servicio_especial);
        }
        return fecha_formateada;
    }

</script>

<?php include "$root_icloud/componeAnts/layout_bottom.php"; ?>