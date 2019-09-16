

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
    $service = new Google_Service_Oauth2($client);
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
        $fecha_evento_especial = date('Y-m-d', strtotime("+1 month", $fecha_actual));
        $fecha_minima_ensayo = $date_helper->suma_dia_habil(date("d-m-Y"), 1);
        $privilegio = mysqli_fetch_array($control->consultar_privilegio_usuario($correo));
        $id_privilegio = $privilegio[0];
        ?>
        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">                
                <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
                  <a class="waves-effect waves-light"
                  href="<?php echo $redirect_uri ?>Evento/montajes/PMontajes.php?idseccion=<?php echo $idseccion; ?>">
                      <img src='../../../images/Atras.svg' style="width: 110px">
                  </a>
                </div>
                <h5 class="center-align c-azul">Solicitud de requerimientos de montaje</h5>
                <br>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $fecha_creacion; ?>" 
                                   readonly  
                                   id="fecha_solicitud" 
                                   style="font-size: 1rem" 
                                   type="text" />      
                            <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>         
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $nombre; ?>" 
                                   readonly  
                                   id="solicitante" 
                                   style="font-size: 1rem" 
                                   type="text" />    
                            <label for="solicitante" style="margin-left: 1rem">Solicitante</label>           
                        </div>
                    </div>                  
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">sentiment_very_satisfied</i>
                        <input placeholder="Cantidad de invitados" 
                               autocomplete="off"
                               id="cantidad_invitados" 
                               type="tel"
                               onblur="maxima_cantidad(this.id, 2000)"
                               onkeyup="calcular_parking(this)"
                               onkeypress="return validar_solo_numeros(event, this.id, 3)">
                        <label for="cantidad_invitados" style="margin-left: 1rem">Cantidad de invitados</label>
                    </div>       
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">room_service</i>
                            <select onchange="reset_check_requiero_personal();mostrar_caja_fecha(this.value)" id="tipo_evento">
                                <option value="0" disabled selected>Selelccione una opción</option>
                                <option value="1">Servicio de café</option>
                                <option value="2">Montaje de evento interno</option>
                                <option value="3">Montaje de evento combinado o externo</option>
                                <option value="4">Montaje de evento especial</option>
                            </select>
                            <label  style="margin-left: 1rem">Tipo de evento</label>
                        </div>
                    </div>
                    <span class="col s12"></span>
                    <div class="input-field col s12 l6" id="caja_valet_parking" hidden>
                        <i class="material-icons prefix c-azul">drive_eta</i>
                        <label style="margin-left: 1rem">Estacionamiento</label>
                        <input id="valet_parking"
                               placeholder="Estacionamiento" 
                               autocomplete="off"
                               type="text"
                               disabled>
                    </div> 
                    <div class="col s12 l6" id="caja_servicio_cafe" hidden>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_permiso_cafe" 
                                autocomplete="off"
                                placeholder="Para el día"
                                onchange="reset_check_requiero_personal();fecha_minusculas(this.value, 'fecha_permiso_cafe')">     
                            <label  style="margin-left: 1rem">Fecha del montaje</label>       
                        </div>
                        <script>
                            //obtiene el calendario escolar en db
                            var calendario_escolar = obtener_calendario_escolar();
                            //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
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
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_evento_interno" 
                                autocomplete="off"
                                placeholder="Para el día"
                                onchange="reset_check_requiero_personal();fecha_minusculas(this.value, 'fecha_evento_interno')">  
                            <label  style="margin-left: 1rem">Fecha del montaje</label>          
                        </div>
                        <script>
                            //obtiene el calendario escolar en db
                            var calendario_escolar = obtener_calendario_escolar();
                            //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
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
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_evento_combinado_externo" 
                                autocomplete="off"
                                placeholder="Para el día"
                                onchange="reset_check_requiero_personal();fecha_minusculas(this.value, 'fecha_evento_combinado_externo')"> 
                            <label  style="margin-left: 1rem">Fecha del montaje</label>           
                        </div>
                        <script>
                            //obtiene el calendario escolar en db
                            var calendario_escolar = obtener_calendario_escolar();
                            //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
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
                            <label  style="margin-left: 1rem">Fecha del montaje</label>          
                        </div>
                        <script>
                            //obtiene el calendario escolar en db
                            var calendario_escolar = obtener_calendario_escolar();
                            //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
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
                    <div class="col s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">filter_tilt_shift</i>
                            <select id="tipo_montaje">
                                <option value="0" disabled selected>Selelccione una opción</option>
                                <option value="Auditorio">Auditorio</option>
                                <option value="Escuela &quot;mesa con silla&quot;">Escuela "mesa con silla"</option>
                                <option value="Herradura &quot;una mesa varias sillas&quot;">Herradura "una mesa varias sillas"</option>
                                <option value="Otros">Otros</option>
                            </select>
                            <label  style="margin-left: 1rem">Tipo de montaje</label>
                        </div>
                    </div> 
                    <div class="input-field col s12 l6" hidden id="check_servicio_cafe">
                        <i class="material-icons prefix c-azul">free_breakfast</i>
                        <label>
                            <input type="checkbox" 
                                   class="filled-in" 
                                   id="check_evento_con_cafe"
                                   onchange="evento_con_cafe = this.checked;cargar_evento_con_cafe(this.checked)"/>
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
                               onkeyup="capitaliza_primer_letra(this.id)"
                               type="text">
                    </div>              
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">person</i>
                        <label for="responsable_evento" style="margin-left: 1rem">Responsable del evento del area solicitante</label>
                        <input id="responsable_evento"
                               placeholder="Responsable" 
                               autocomplete="off"
                               onkeyup="capitaliza_primer_letra(this.id)"
                               type="text">
                    </div>                    
                    <div class="input-field col s12 l6" id="caja_lugar_evento">
                        <i class="material-icons prefix c-azul">place</i>
                        <select onchange="id_lugar=this.value;id_lugar_evento_function = this.value;consula_disponibilidad_lugar(this.value, this.id);" id="lugar_evento">
                        </select>
                        <label style="margin-left: 1rem">Lugar del evento</label>
                    </div>
                    <div class="file-field input-field col s12 l6" style="margin-top: -.8rem">
                        <div class="waves-effect waves-light btn b-azul" style="margin-top: 1.5rem">
                            <span><i class="material-icons c-blanco">attach_file</i></span>
                            <input type="file" 
                                   id="anexa_programa"
                                   onchange ="return validar_file(this)" >
                        </div>
                        <div class="file-path-wrapper">
                            <label>Anexa programa minuto a minuto</label>
                            <input class="file-path validate" 
                                   type="text" 
                                   placeholder="Presionar ícono"
                                   readonly
                                   style="font-size: .8rem"> 
                        </div>
                        <div class="chip blue white-text">
                            <span>Formatos permitidos: .pdf</span>
                        </div>
                        <div class="chip blue white-text">
                            <span>Tamaño máx:3mb</span>
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
                        <select id="select_tipo_repliegue">
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="Estacionamiento maestros">Estacionamiento maestros</option>
                            <option value="Patio de camiones 1/2">Patio de camiones 1/2</option>
                            <option value="Patio de completo">Patio de completo</option>
                        </select>
                        <label style="margin-left: 1rem">Tipo de repliegue</label>
                    </div>
                    <span class="col s12"><br></span>
                    <div id="no_cafe">
                        <h5 class="col s12 c-azul text-center">Lugar y mobiliario del evento</h5>
                        <div class="input-field col s12" style="text-align: center;">
                            <button class="waves-effect waves-light btn b-azul c-blanco col l3"
                                    style="float: none"                                 
                                    type="button"
                                    onclick="cargar_inventarios_montaje(id_lugar_evento_function)">
                                <i class="material-icons right">dashboard</i>Agregar inventario
                            </button>
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
                                <button class="waves-effect waves-light btn red col l3" 
                                        id="btn_anular_reserva_personal"
                                        style="float: none"                                 
                                        type="button"
                                        onclick="anular_reserva_personal('#select_personal_montaje', '#select_personal_cabina_auditorio', '#select_personal_limpieza', '#select_personal_vigilancia')">Anular reserva
                                    <i class="material-icons right">delete</i>
                                </button>
                            </div>
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
                    </div>                    
                    <div class="input-field col s12" hidden id="caja_cafe">
                        <div class="input-field col s12 l6" id="select_lugar_evento_solo_cafe">
                            <i class="material-icons prefix c-azul">place</i>
                            <select id="lugar_evento_solo_cafe" 
                                    onchange="lugar_evento_solo_cafe = this.value;consula_disponibilidad_lugar(this.value, this.id);">
                            </select>
                            <label style="margin-left: 1rem">Lugar del evento</label>
                        </div> 
                        <h5 class="col s12 c-azul text-center">Servicio de café</h5>
                        <ul class="collection row" id="ul_servicio_cafe"></ul>
                    </div>
                    <h5 class="col s12 c-azul text-center">Requerimientos especiales</h5>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">list_alt</i>
                        <textarea class="materialize-textarea"
                                  onkeyup="capitaliza_primer_letra(this.id)"
                                  id="requerimientos_especiales"
                                  placeholder="Requerimientos especiales"></textarea>  
                        <label style="margin-left: 1rem">Requerimientos especiales</label>
                    </div>
                    <span class="col s12"><br></span>
                    <div class="input-field col s12">
                        <div style="text-align: center">
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

<div id="modal_recuerde_rentar" class="modal bottom-sheet">
    <div class="modal-content">
        <h4 class="c-azul">Recuerde</h4>
        <p>El inventario disponible actual ha sido sobrepasado, recuerde rentar el número de artículos faltantes</p>
    </div>
    <div class="modal-footer">
        <a href="#!"
           class="modal-close waves-effect waves-light btn-flat green accent-4 c-blanco">Aceptar</a>
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
    var codigo_ensayo = "";
    var id_lugar = 0;
    var archivo_cargado = null;
    var id_lugar_evento_function = "";
    //servicio de cafe
    var solo_cafe = false;
    var lugar_evento_solo_cafe = "";
    var evento_con_cafe = false;
    //push
    var pusher = null;
    var channel_inventario = null;
    var channel_personal = null;
    var channel_manteles = null;
    var channel_equipo_tecnico = null;

    var token = '<?php echo uniqid(); ?>';
    var timestamp_personal_montaje = null;
    var timestamp_personal_montaje_ensayos = [];
    var timestamp_inventario = null;
    var timestamp_inventario_manteles = null;
    var timestamp_equipo_tecnico = null;
    //lugar seleccionado
    var lugar_id_lugar_evento = null;
    var lugar_inventario = [];
    var coleccion_manteles = [];
    var coleccion_inventario = [];
    var coleccion_equipo_tecnico = [];
    //manejo de ensayos
    var lista_ensayos = 0;
    var ensayos = [];
    var botones_anulacion = [];
    $(document).ready(function () {
        $('.modal').modal();
        $("#loading").fadeOut("slow");
        $('select').formSelect();
        M.textareaAutoResize($('textarea'));
        $('.timepicker').timepicker({
            'step': 60,
            'minTime': '06:00',
            'maxTime': '23:59',
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
        channel_inventario = pusher.subscribe('canal_inventario');
        channel_personal = pusher.subscribe('canal_personal');
        channel_manteles = pusher.subscribe('canal_manteles');
        channel_equipo_tecnico = pusher.subscribe('canal_equipo_tecnico');
        channel_inventario.bind('actualiza_inventarios', function (res) {
            if (res.actualiza_inventarios.push && res.actualiza_inventarios.token !== token) {
                if (lugar_id_lugar_evento !== null) {
                    //cargar_inventario_manteles(lugar_id_lugar_evento, lugar_inventario);
                }
                M.toast({
                    html: 'El inventario de manteles disponibles ha sido modificado por otro usuario',
                    classes: 'red accent-3 c-blanco',
                });
            }
        });
        channel_personal.bind('actualiza_personal', function (res) {
            if (res.actualizar_personal.push && res.actualizar_personal.token !== token) {
                M.toast({
                    html: 'El personal disponible ha sido modificado por otro usuario',
                    classes: 'red accent-3 c-blanco',
                });
            }
        });
        channel_manteles.bind('actualiza_manteles', function (res) {
            if (res.actualizar_manteles.push && res.actualizar_manteles.token !== token) {
                if (lugar_id_lugar_evento !== null) {
                    cargar_inventario_manteles(lugar_id_lugar_evento, lugar_inventario);
                }
                M.toast({
                    html: 'El inventario de manteles disponibles ha sido modificado por otro usuario',
                    classes: 'red accent-3 c-blanco',
                });
            }
        });
        channel_equipo_tecnico.bind('actualiza_equipo_tecnico', function (res) {
            if (res.actualiza_equipo_tecnico.push && res.actualiza_equipo_tecnico.token !== token) {
                if (lugar_id_lugar_evento !== null) {
                    //cargar_inventario_manteles(lugar_id_lugar_evento, lugar_inventario);
                }
                M.toast({
                    html: 'El inventario de manteles disponibles ha sido modificado por otro usuario',
                    classes: 'red accent-3 c-blanco',
                });
            }
        });
    });
    //checks
    function reset_check_requiero_personal() {
        var check_requiero_personal = $("#check_requiero_personal");
        if (check_requiero_personal.prop("checked")) {
            check_requiero_personal.click();

            if (!$("#anular_reserva_personal").prop("hidden")) {
                $("#btn_anular_reserva_personal").click();
            }

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
        if (!validar_numero_invitados()) {
            $("#tipo_evento option[value=0]").prop("selected", "selected");
            $("select").formSelect();
            return;
        }
        $("#check_evento_con_cafe").prop("checked", false);
        evento_con_cafe = false;
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
                solo_cafe = true;
                $("#no_cafe").fadeOut();
                $("#caja_lugar_evento").fadeOut();
                cargar_servicio_cafe();
                $("#caja_valet_parking").hide();
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
                $("#no_cafe").fadeIn();
                $("#caja_lugar_evento").fadeIn();
                $("#ul_servicio_cafe").html("");
                $("#caja_cafe").fadeOut();
                reset_check_requiero_personal();
                solo_cafe = false;
                lugar_evento_solo_cafe = "";
                $("#caja_valet_parking").hide();
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
                $("#no_cafe").fadeIn();
                $("#caja_lugar_evento").fadeIn();
                $("#ul_servicio_cafe").html("");
                $("#caja_cafe").fadeOut();
                reset_check_requiero_personal();
                solo_cafe = false;
                lugar_evento_solo_cafe = "";
                $("#caja_valet_parking").show();
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
                $("#no_cafe").fadeIn();
                $("#caja_lugar_evento").fadeIn();
                $("#ul_servicio_cafe").html("");
                $("#caja_cafe").fadeOut();
                reset_check_requiero_personal();
                solo_cafe = false;
                lugar_evento_solo_cafe = "";
                $("#caja_valet_parking").show();
                break;
        }
    }
    function mostrar_caja_ensayos(el) {
        lista_ensayos = el.value;
        var codigo_ensayo = "";
        for (var i = 0; i < el.value; i++) {
            var codigo = `<div class="col s12 card"> <div class="card-content" style="color:#00C2EE;"> <h5>Ensayo N° ${i + 1}</h5> </div><div class="card-tabs"> <ul class="tabs tabs-fixed-width"> <li class="tab blue white-text active"><a href="#tab_1_${i + 1}">Información de ensayo</a> </li><li class="tab blue white-text" onclick="cargar_personal_ensayo(${i})"><a href="#tab_2_${i + 1}">Personal</a> </li></ul> </div><div class="card-content"> <div id="tab_1_${i + 1}"> <div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Fecha del ensayo</label> <div class="input-field"> <i class="material-icons prefix c-azul">calendar_today</i> <input type="text" class="datepicker" id="fecha_ensayo_${i}" autocomplete="off" placeholder="Escoja fecha" onchange="fecha_minusculas(this.value, 'fecha_permiso');validar_fecha_no_posterior_ensayo(this);" style="font-size: 1rem"> </div></div><div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Horario inicial</label> <div class="input-field"> <i class="material-icons prefix c-azul">access_time</i> <input type="text" id="horario_inicial_ensayo_${i}" class="timepicker" onkeypress="return validar_solo_numeros(event, this.id, 1)" autocomplete="off" onfocus="blur();" placeholder="Seleccione horario"> </div></div><div class="col s12 l6"> <label style="margin-left: 1rem;color:#00C2EE">Horario final</label> <div class="input-field"> <i class="material-icons prefix c-azul">access_time</i> <input type="text" id="horario_final_ensayo_${i}" class="timepicker" onkeypress="return validar_solo_numeros(event, this.id, 1)" onchange="validar_horario_final_ensayo(this,'horario_inicial_ensayo_${i}')" autocomplete="off" onfocus="blur();" placeholder="Seleccione horario"> </div></div><div class="input-field col s12"> <i class="material-icons prefix c-azul">list_alt</i> <textarea class="materialize-textarea" id="requerimientos_especiales_ensayo_${i}" placeholder="Requerimientos especiales" onkeyup='capitaliza_primer_letra(this.id)'></textarea> </div></div><div id="tab_2_${i + 1}"> <div id="caja_select_${i}"> <div class="input-field col s12 l6"> <i class="material-icons prefix c-azul">build</i> <select id="select_montaje_ensayo_${i}"></select> <label style="margin-left: 1rem;color:#00C2EE">Personal de montaje</label> </div><div class="input-field col s12 l6"> <i class="material-icons prefix c-azul">build</i> <select id="select_cabina_auditorio_ensayo_${i}"></select> <label style="margin-left: 1rem;color:#00C2EE">Personal de cabina de auditorio</label> </div><div class="input-field col s12 l6"> <i class="material-icons prefix c-azul">build</i> <select id="select_limpieza_ensayo_${i}"></select> <label style="margin-left: 1rem;color:#00C2EE">Personal de limpieza</label> </div><div class="input-field col s12" style="text-align: center" id="reserva_personal_${i}"> <button class="waves-effect waves-light btn col l4" onclick="actualizar_personal_ensayo('select_montaje_ensayo_${i}', 'select_cabina_auditorio_ensayo_${i}', 'select_limpieza_ensayo_${i}', 'fecha_ensayo_${i}','horario_inicial_ensayo_${i}','horario_final_ensayo_${i}', '#reserva_personal_${i}', '#caja_reserva_personal_${i}',${i})" type="button" style="background-color: #00C2EE;float: none">Reservar personal <i class="material-icons right">save</i> </button> </div><div class="input-field col s12" style="text-align: center;" hidden id="caja_reserva_personal_${i}"> <button id="btn_anular_reserva_personal_${i}" class="waves-effect waves-light btn red col l3" style="float: none" type="button" onclick="anular_reserva_personal_ensayo('#select_montaje_ensayo_${i}', '#select_cabina_auditorio_ensayo_${i}','#select_limpieza_ensayo_${i}', '#caja_reserva_personal_${i}','#reserva_personal_${i}',${i})">Anular reserva <i class="material-icons right">delete</i> </button> </div></div><span class="col s12"><br></span> <div class="chip orange col s12 white-text" style="text-align: center" id="validacion_ensayo_${i}"> <span>Debe seleccionar una fecha y horarios válidos para continuar!</span> </div><span class="col s12 hide-on-med-and-down"><br><br></span> </div></div></div>`;
            codigo_ensayo += `${codigo}`;
            botones_anulacion.push({caja: `caja_reserva_personal_${i}`, btn: `btn_anular_reserva_personal_${i}`});
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
            'step': 60,
            'minTime': '06:00',
            'maxTime': '23:59',
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
        var tipos_permitidos = /(pdf)$/i;
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
    function cargar_archivo_programa(archivo, id_montaje) {
        if (!validar_file(archivo))
            return;
        archivo = archivo.files[0];
        var datos = new FormData();
        datos.append('archivo', archivo);
        datos.append('id_montaje', id_montaje);
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
            if (res) {
                window.location.href = "https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/PMontajes.php?idseccion=";
            }
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
            $("#lugar_evento_solo_cafe").html(`<option value="0" disabled selected>Seleccione lugar del evento</option>${optgroup}`);
            $("select").formSelect();
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function cargar_inventarios_montaje(id_lugar_evento) {
        solo_cafe = false;
        lugar_evento_solo_cafe = "";
        // mobiliario
        if ($("#check_equipo_tecnico").prop("checked")) {
            $("#check_equipo_tecnico").click();
        }
        id_lugar = id_lugar_evento;
        var fecha_montaje_simple = obtener_fecha();
        var horario_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();

        if ($("#tipo_evento").val() === null) {
            M.toast({
                html: '¡Debe seleccionar un tipo de evento válido!',
                classes: 'deep-orange c-blanco',
            });
            return;
        }

        if (fecha_montaje_simple === null) {
            M.toast({
                html: '¡Debe seleccionar una fecha para el evento válido!',
                classes: 'deep-orange c-blanco',
            });
            return;
        }

        if (horario_evento === "" || horario_final_evento === "") {
            $("#lugar_evento option[value=0]").prop("selected", "selected");
            $('select').formSelect();
            M.toast({
                html: '¡Debe seleccionar el horario del evento!',
                classes: 'deep-orange c-blanco',
            });
            return;
        }

        if (id_lugar_evento === "") {
            M.toast({
                html: '¡Debe seleccionar un lugar válido para el evento!',
                classes: 'deep-orange c-blanco',
            });
            return;
        }

        if ($("#tipo_evento").val() === "1") {
            solo_cafe = false;
            lugar_evento_solo_cafe = "";
        }

        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_capacidad_mobiliario.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {
                id_lugar_evento: id_lugar_evento,
                fecha_montaje_simple: fecha_montaje_simple,
                horario_evento: horario_evento,
                horario_final_evento: horario_final_evento
            }
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
        var fecha_montaje = obtener_fecha();
        var horario_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
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
                data: {
                    id_lugar: id_lugar,
                    fecha_montaje: fecha_montaje,
                    horario_evento: horario_evento,
                    horario_final_evento: horario_final_evento
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
    function cargar_inventario_manteles(id_lugar_evento, inventario) {
        var fecha_montaje_simple = obtener_fecha();
        var horario_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_capacidad_manteles.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {
                id_lugar: id_lugar_evento,
                horario_evento: horario_evento,
                horario_final_evento: horario_final_evento,
                fecha_montaje_simple: fecha_montaje_simple
            }
        }).done((res) => {
            $("#tabla_manteles").html("");
            res = JSON.parse(res);
            mostrar_inventario(inventario);
            mostrar_manteles(res);
            lugar_id_lugar_evento = id_lugar_evento;
            lugar_inventario = inventario;
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
        $("#mobiliario").show();
        var tr = "";
        var id_lugar = 0;
        for (var item in inventario) {
            id_lugar = inventario[item].lugar;
            tr += `<li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">done</i> <span class="title"><b>Artículo: </b> ${inventario[item].articulo}</span> <p> <b>Capacidad del lugar: </b> ${inventario[item].capacidad}<br><b>Disponible para el evento: </b>${inventario[item].disponible}</p><b>Cantidad para el evento: </b> <div class="input-field"><input placeholder="Ingrese cantidad deseada" class="cantidad_mobiliario" onblur="add_inventario('${inventario[item].id}', this, ${inventario[item].capacidad}, ${inventario[item].disponible})" id="cantidad_mobiliario_${inventario[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" type="tel"></div></div><div class="col s12 l6 text-center"> <a href="${inventario[item].ruta_img}" data-fancybox data-caption="${inventario[item].articulo}"> <br><img src="${inventario[item].ruta_img}" width="150"/> </a> </div><span class="col s12"><br></span></li>`;
        }
        $("#tabla_inventario").html(`<ul class="collection row">${tr}<div style="text-align: center" id="caja_btn_actualiza_inventario"> <button class="waves-effect waves-light btn col l4" id="btn_actualizar_inventario" onclick="actualizar_inventario()" type="button" style="background-color: #00C2EE;float: none">Reservar inventario <i class="material-icons right">save</i> </button></div><div style="text-align: center" hidden id="caja_btn_anular_inventario"> <button class="waves-effect waves-light btn col l4 red" id="btn_anular_inventario" onclick="anular_inventario()" type="button" style="float: none">Anular reserva inventario <i class="material-icons right">delete</i> </button></div></ul>`);
    }
    function mostrar_equipo_tecnico(equipo_tecnico) {
        $("#caja_equipo_tecnico").show();
        var tr = "";
        for (var item in equipo_tecnico) {
            tr += `<li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">done</i> <span class="title"><b>Artículo: </b> ${equipo_tecnico[item].articulo}</span> <p> <b>Capacidad del lugar: </b> ${equipo_tecnico[item].capacidad}<br><b>Disponible para el evento: </b>${equipo_tecnico[item].disponible}</p><b>Cantidad para el evento: </b> <div class="input-field"><input placeholder="Ingrese cantidad deseada" class="cantidad_mobiliario" onblur="add_equipo_tecnico('${equipo_tecnico[item].id}', this, ${equipo_tecnico[item].capacidad},${equipo_tecnico[item].disponible})" id="cantidad_equipo_tecnico_${equipo_tecnico[item].id}" autocomplete="off" onkeypress="return validar_solo_numeros(event, this.id, 2)" type="tel"></div></div><div class="col s12 l6 text-center"> <a href="${equipo_tecnico[item].ruta_img}" data-fancybox data-caption="${equipo_tecnico[item].articulo}"><br><img src="${equipo_tecnico[item].ruta_img}" width="150"/> </a> </div></li>`;
        }
        $("#tabla_equipo_tecnico").html(`<ul class="collection row">${tr}<div style="text-align: center" id="caja_btn_actualiza_equipo_tecnico"> <button class="waves-effect waves-light btn col l4" id="btn_actualizar_equipo_tecnico" onclick="actualizar_equipo_tecnico()" type="button" style="background-color: #00C2EE;float: none">Reservar equipo técnico <i class="material-icons right">save</i> </button></div><div style="text-align: center" hidden id="caja_btn_anular_equipo_tecnico"> <button class="waves-effect waves-light btn col l4 red" id="btn_anular_equipo_tecnico" onclick="anular_equipo_tecnico()" type="button" style="float: none">Anular reserva equipo técnico <i class="material-icons right">delete</i> </button></div></ul>`);
    }
    function mostrar_manteles(manteles) {
        coleccion_ids_manteles = [];
        var tr = "";
        var i = 0;
        if (manteles.length === 0) {
            $("#badge_mantel_no_asignacion").prop("hidden", false);
            $("#tabla_manteles").html("");
            return;
        }
        for (var item in manteles) {
            i++;
            coleccion_ids_manteles.push(manteles[item].id);
            tr += `<li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">done</i> <span class="title"> <b>Artículo:</b> ${manteles[item].articulo}</span> <p> <b>Capacidad del lugar: </b> ${manteles[item].capacidad}<br><b>Disponible para el evento: </b>${manteles[item].disponible}</p><b>Cantidad para el evento: </b> <div class="input-field"><input placeholder="Ingrese cantidad deseada" class="cantidad_mobiliario" id="cantidad_manteles_${manteles[item].id}" autocomplete="off" onblur="add_mantel('${manteles[item].id}', this, ${manteles[item].capacidad}, ${manteles[item].disponible})" onkeypress="return validar_solo_numeros(event, this.id, 2)" type="tel"> </div></div><div class="col s12 l6 text-center"> <a href="${manteles[item].ruta_img}" data-fancybox data-caption="${manteles[item].articulo}"> <br><img src="${manteles[item].ruta_img}" width="150"/> </a> </div></li>`;
        }
        $("#manteles").show();
        $("#tabla_manteles").html(`<ul class="collection row">${tr}<div style="text-align: center" id="caja_btn_actualiza_inventario_manteles"> <button class="waves-effect waves-light btn col l4" id="btn_actualizar_inventario_manteles" onclick="actualizar_inventario_manteles()" type="button" style="background-color: #00C2EE;float: none">Reservar manteles <i class="material-icons right">save</i> </button></div><div style="text-align: center" hidden id="caja_btn_anular_inventario_manteles"> <button class="waves-effect waves-light btn col l4 red" id="btn_anular_inventario_manteles" onclick="anular_inventario_manteles()" type="button" style="float: none">Anular reserva manteles <i class="material-icons right">delete</i> </button></div></ul>`);
    }
    function maxima_cantidad(id, cantidad) {
        if (!validar_maxima_cantidad(id, cantidad)) {
            $("#" + id).val("");
            $("#" + id).focus();
            M.toast({
                html: 'Máximo 2000 invitados!',
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
                'step': 60,
                'minTime': '06:00',
                'maxTime': '23:59',
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
                socket_id: pusher.connection.socket_id,
                ensayo: false
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
            select_personal_limpieza, select_personal_vigilancia, el) {
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
                $("#anular_reserva_personal").hide();
                $("#reserva_personal").show();
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
                socket_id: pusher.connection.socket_id,
                ensayo: true,
                n_ensayo: i
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
                timestamp_personal_montaje_ensayos.push({timestamp: res.timestamp, i: i + 1});
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function anular_reserva_personal_ensayo(select_personal_montaje, select_personal_cabina_auditorio,
            select_personal_limpieza, btn_anular, btn_asignar, i) {
        for (var item in timestamp_personal_montaje_ensayos) {
            if (timestamp_personal_montaje_ensayos[item].i === i + 1) {
                $.ajax({
                    url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_anula_personal_asignado.php',
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: () => {
                        $("#loading").fadeIn();
                    },
                    data: {timestamp: timestamp_personal_montaje_ensayos[item].timestamp}
                }).done((res) => {
                    if (res.response) {
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

                        for (var item in timestamp_personal_montaje_ensayos) {
                            if (timestamp_personal_montaje_ensayos[item].timestamp === res.timestamp) {
                                delete timestamp_personal_montaje_ensayos[item];
                            }
                        }
                        if ($.isEmptyObject(timestamp_personal_montaje_ensayos)) {
                            $("#requiero_ensayo").prop("disabled", false);
                            $("#select_ensayos").prop("disabled", false);
                            $('#select_ensayos option[value=0]').prop("selected", "selected").change();
                            $('select').formSelect();
                        }
                    }
                }).always(() => {
                    $("#loading").fadeOut();
                });
            }
        }
    }
    //Actualizacion de inventarios y notificaciones en tiempo real con pusher websockets
    function add_mantel(id, el, capacidad, disponible) {
        var faltante = disponible - el.value;
        if (parseInt(disponible) <= 0) {
            var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
            modal_recuerde_rentar.open();
        }
        if (capacidad < el.value) {
            $("#" + el.id).val("");
            $("#" + el.id).focus();
            M.toast({
                html: 'Debe asignar la cantidad de acuerdo con la capacidad del lugar',
                classes: 'deep-orange c-blanco'
            });
            return;
        }
        if (coleccion_manteles.length !== 0) {
            for (var item in coleccion_manteles) {
                if (coleccion_manteles[item].id === id) {
                    coleccion_manteles[item] = {id: id, cantidad: el.value, faltante: faltante < 0 ? faltante : 0};
                    return;
                }
            }
        }
        coleccion_manteles.push({id: id, cantidad: el.value, faltante: faltante < 0 ? faltante : 0});
    }
    function actualizar_inventario_manteles() {
        if (!validar_fecha_horario())
            return;
        var fecha_formateada = obtener_fecha();
        var horario_inicial_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        if (coleccion_manteles.length === 0) {
            M.toast({
                html: 'Debe asignar la cantidad del artículo',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_inventario_manteles.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            dataType: 'json',
            data: {
                fecha_montaje: fecha_formateada,
                hora_inicial: horario_inicial_evento,
                hora_final: horario_final_evento,
                coleccion_manteles: coleccion_manteles,
                token: token
            }
        }).done((res) => {
            if (res.respuesta) {
                timestamp_inventario_manteles = res.timestamp;
                for (var item in coleccion_manteles) {
                    $("#cantidad_manteles_" + coleccion_manteles[item].id).prop('disabled', true);
                }
                $("#caja_btn_actualiza_inventario_manteles").prop('hidden', true);
                $("#caja_btn_anular_inventario_manteles").prop('hidden', false);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function anular_inventario_manteles() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_anula_inventario_manteles.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            dataType: 'json',
            data: {
                coleccion_manteles: coleccion_manteles,
                timestamp: timestamp_inventario_manteles
            }
        }).done((res) => {
            if (res) {
                M.toast({
                    html: '¡Ha sido anulada la selección de manteles!',
                    classes: 'blue c-blanco',
                });
                for (var item in coleccion_manteles) {
                    $("#cantidad_manteles_" + coleccion_manteles[item].id).prop('disabled', false);
                }
                $("#caja_btn_actualiza_inventario_manteles").prop('hidden', false);
                $("#caja_btn_anular_inventario_manteles").prop('hidden', true);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });

    }
    function add_inventario(id, el, capacidad, disponible) {
        var faltante = disponible - el.value;
        if(faltante<0){            
            var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
            modal_recuerde_rentar.open();
        }
        if (parseInt(disponible) <= 0) {
            var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
            modal_recuerde_rentar.open();
        }
        if (capacidad < el.value) {
            $("#" + el.id).val("");
            $("#" + el.id).focus();
            M.toast({
                html: 'Debe asignar la cantidad de acuerdo con la capacidad del lugar',
                classes: 'deep-orange c-blanco',
            });
            return;
        }
        if (coleccion_inventario.length !== 0) {
            for (var item in coleccion_inventario) {
                if (coleccion_inventario[item].id === id) {
                    coleccion_inventario[item] = {id: id, cantidad: el.value, faltante: faltante < 0 ? faltante : 0};
                    return;
                }
            }
        }
        coleccion_inventario.push({id: id, cantidad: el.value, faltante: faltante < 0 ? faltante : 0});
    }
    function actualizar_inventario() {
        if (!validar_fecha_horario())
            return;
        var fecha_formateada = obtener_fecha();
        var horario_inicial_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        if (coleccion_inventario.length === 0) {
            M.toast({
                html: 'Debe asignar la cantidad del artículo',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_inventario.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            dataType: 'json',
            data: {
                fecha_montaje: fecha_formateada,
                hora_inicial: horario_inicial_evento,
                hora_final: horario_final_evento,
                coleccion_inventario: coleccion_inventario,
                token: token
            }
        }).done((res) => {
            if (res.respuesta) {
                timestamp_inventario = res.timestamp;
                for (var item in coleccion_inventario) {
                    $("#cantidad_mobiliario_" + coleccion_inventario[item].id).prop('disabled', true);
                }
                $("#caja_btn_actualiza_inventario").prop('hidden', true);
                $("#caja_btn_anular_inventario").prop('hidden', false);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function anular_inventario() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_anula_inventario_asignado.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            dataType: 'json',
            data: {
                coleccion_inventario: coleccion_inventario,
                timestamp: timestamp_inventario
            }
        }).done((res) => {
            if (res) {
                M.toast({
                    html: '¡Ha sido anulada la selección de mobiliario!',
                    classes: 'blue c-blanco',
                });
                for (var item in coleccion_inventario) {
                    $("#cantidad_mobiliario_" + coleccion_inventario[item].id).prop('disabled', false);
                }
                $("#caja_btn_actualiza_inventario").prop('hidden', false);
                $("#caja_btn_anular_inventario").prop('hidden', true);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });

    }
    function add_equipo_tecnico(id, el, capacidad, disponible) {
        var faltante = disponible - el.value;
        if (parseInt(disponible) <= 0) {
            var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
            modal_recuerde_rentar.open();
        }
        if (capacidad < el.value) {
            $("#" + el.id).val("");
            $("#" + el.id).focus();
            M.toast({
                html: 'Debe asignar la cantidad de acuerdo con la capacidad del lugar',
                classes: 'deep-orange c-blanco'
            });
            return;
        }
        if (coleccion_equipo_tecnico.length !== 0) {
            for (var item in coleccion_equipo_tecnico) {
                if (coleccion_equipo_tecnico[item].id === id) {
                    coleccion_equipo_tecnico[item] = {id: id, cantidad: el.value, faltante: faltante < 0 ? faltante : 0};
                    return;
                }
            }
        }
        coleccion_equipo_tecnico.push({id: id, cantidad: el.value, faltante: faltante < 0 ? faltante : 0});
    }
    function actualizar_equipo_tecnico() {
        if (!validar_fecha_horario())
            return;
        var fecha_formateada = obtener_fecha();
        var horario_inicial_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        if (coleccion_equipo_tecnico.length === 0) {
            M.toast({
                html: 'Debe asignar la cantidad del artículo',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_equipo_tecnico.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            dataType: 'json',
            data: {
                fecha_montaje: fecha_formateada,
                hora_inicial: horario_inicial_evento,
                hora_final: horario_final_evento,
                coleccion_equipo_tecnico: coleccion_equipo_tecnico,
                token: token
            }
        }).done((res) => {
            if (res.respuesta) {
                timestamp_equipo_tecnico = res.timestamp;
                for (var item in coleccion_equipo_tecnico) {
                    $("#cantidad_equipo_tecnico_" + coleccion_equipo_tecnico[item].id).prop('disabled', true);
                }
                $("#caja_btn_actualiza_equipo_tecnico").prop('hidden', true);
                $("#caja_btn_anular_equipo_tecnico").prop('hidden', false);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function anular_equipo_tecnico() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_anula_equipo_tecnico_asignado.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            dataType: 'json',
            data: {
                coleccion_equipo_tecnico: coleccion_equipo_tecnico,
                timestamp: timestamp_equipo_tecnico
            }
        }).done((res) => {
            if (res) {
                M.toast({
                    html: '¡Ha sido anulada la selección de equipo técnico!',
                    classes: 'blue c-blanco',
                });
                for (var item in coleccion_equipo_tecnico) {
                    $("#cantidad_equipo_tecnico_" + coleccion_equipo_tecnico[item].id).prop('disabled', false);
                }
                $("#caja_btn_actualiza_equipo_tecnico").prop('hidden', false);
                $("#caja_btn_anular_equipo_tecnico").prop('hidden', true);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });

    }
    function validar_fecha_horario() {
        var fecha_formateada = obtener_fecha();
        var horario_inicial_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        if (fecha_formateada === null) {
            M.toast({
                html: '¡Debe seleccionar una fecha válida!',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        if (horario_inicial_evento === "" || horario_final_evento === "") {
            M.toast({
                html: '¡Debe seleccionar un horario válido!',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        return true;
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
    function obtener_fecha_asignada() {
        var fecha = null;
        var fecha_permiso_cafe = $("#fecha_permiso_cafe").val();
        var fecha_evento_interno = $("#fecha_evento_interno").val();
        var fecha_evento_combinado_externo = $("#fecha_evento_combinado_externo").val();
        var fecha_servicio_especial = $("#fecha_servicio_especial").val();
        if (fecha_permiso_cafe !== "") {
            fecha = fecha_permiso_cafe;
        } else if (fecha_evento_interno !== "") {
            fecha = fecha_evento_interno;
        } else if (fecha_evento_combinado_externo !== "") {
            fecha = fecha_evento_combinado_externo;
        } else if (fecha_servicio_especial !== "") {
            fecha = fecha_servicio_especial;
        }
        return fecha;
    }
    //validaciones
    function validar_tipo_evento() {
        if ($("#tipo_evento").val() === "" || $("#tipo_evento").val() === "0" || $("#tipo_evento").val() === null) {
            M.toast({
                html: '¡Debe seleccionar un tipo de evento para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    function validar_horario_evento() {
        var horario_evento = $("#horario_evento");
        if (horario_evento.val() === "") {
            M.toast({
                html: 'Debe seleccionar un horario inicial válido para continuar!',
                classes: 'deep-orange c-blanco',
            }, 5000);
            return false;
        }
        return true;
    }
    function validar_horario_final() {
        var horario_final_evento = $("#horario_final_evento");
        if (horario_final_evento.val() === "") {
            M.toast({
                html: 'Debe seleccionar un horario final válido para continuar!',
                classes: 'deep-orange c-blanco',
            });
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
    function validar_responsable_evento() {
        var responsable_evento = $("#responsable_evento");
        if (responsable_evento.val() === "") {
            M.toast({
                html: '¡Debe ingresar un responsable del evento válido para continuar!',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        return true;
    }
    function validar_numero_invitados() {
        var cantidad_invitados = $("#cantidad_invitados");
        if (cantidad_invitados.val() === "") {
            M.toast({
                html: '¡Debe ingresar la cantidad de invitados al evento para continuar!',
                classes: 'deep-orange c-blanco',
            });
            return false;
        }
        return true;
    }
    function validar_lugar_evento() {
        switch (solo_cafe) {
            case true:
                if (lugar_evento_solo_cafe === "") {
                    M.toast({
                        html: '¡Debe seleccionar el lugar del evento para continuar!',
                        classes: 'deep-orange c-blanco'
                    });
                    return false;
                }
                break;

            case false:
                if ($("#lugar_evento").val() === "" || $("#lugar_evento").val() === "0" || $("#lugar_evento").val() === null) {
                    M.toast({
                        html: '¡Debe seleccionar el lugar del evento para continuar!',
                        classes: 'deep-orange c-blanco'
                    });
                    return false;
                }
                break;
        }
        return true;
    }
    function validar_tipo_montaje() {
        var tipo_montaje = $("#tipo_montaje").val();
        if (tipo_montaje === null || tipo_montaje === "" || tipo_montaje === "0") {
            M.toast({
                html: '¡Debe seleccionar el el tipo montaje para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    //salvar formulario
    function enviar_formulario() {
        //asignacion de esanyos
        ensayos = [];
        if (lista_ensayos > 0) {
            for (var i = 0, max = lista_ensayos; i < max; i++) {
                ensayos.push({
                    fecha_ensayo: $("#fecha_ensayo_" + i).val(),
                    hora_inicial: $("#horario_inicial_ensayo_" + i).val(),
                    hora_final: $("#horario_final_ensayo_" + i).val(),
                    requerimientos_especiales: $("#requerimientos_especiales_ensayo_" + i).val(),
                    index: i + 1
                });
            }
        }
        //validaciones
        if (!validar_tipo_evento())
            return;
        if (obtener_fecha() === null) {
            M.toast({
                html: '¡Debe seleccionar una fecha válida para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        if (!validar_tipo_montaje())
            return;
        if (!validar_horario_evento())
            return;
        if (!validar_horario_final())
            return;
        if (!validar_nombre_evento())
            return;
        if (!validar_responsable_evento())
            return;
        if (!validar_numero_invitados())
            return;
        if (!validar_lugar_evento())
            return;

        //data del formulario
        var fecha_solicitud = $("#fecha_solicitud").val();
        var solicitante = $("#solicitante").val();
        var tipo_evento = $("#tipo_evento").val();
        var fecha_montaje = obtener_fecha_asignada();
        var fecha_montaje_simple = obtener_fecha();
        var horario_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        var nombre_evento = $("#nombre_evento").val();
        var responsable_evento = $("#responsable_evento").val();
        var cantidad_invitados = $("#cantidad_invitados").val();
        var valet_parking = $("#valet_parking").val();
        if (tipo_evento === "1" || tipo_evento === "2") {
            valet_parking = 0;
        }
        var anexa_programa = $("#anexa_programa").val().length > 0 ? true : false;
        var lugar_evento = $("#lugar_evento").val();
        var select_tipo_repliegue = $("#select_tipo_repliegue").val();
        var requiero_ensayo = $("#requiero_ensayo").prop('checked');
        var select_ensayos = $("#select_ensayos").val();
        var requerimientos_especiales = $("#requerimientos_especiales").val();
        var tipo_montaje = $("#tipo_montaje").val();
        //var check_equipo_tecnico = $("#check_equipo_tecnico").prop('checked');

        var data = {
            fecha_solicitud: fecha_solicitud,
            solicitante: solicitante,
            tipo_evento: tipo_evento,
            fecha_montaje: fecha_montaje,
            fecha_montaje_simple: fecha_montaje_simple,
            horario_evento: horario_evento,
            horario_final_evento: horario_final_evento,
            nombre_evento: nombre_evento,
            responsable_evento: responsable_evento,
            cantidad_invitados: cantidad_invitados,
            valet_parking: valet_parking,
            anexa_programa: anexa_programa,
            tipo_repliegue: select_tipo_repliegue,
            lugar_evento: lugar_evento,
            requiero_ensayo: requiero_ensayo,
            select_ensayos: select_ensayos,
            requerimientos_especiales: requerimientos_especiales,
            timestamp_inventario: timestamp_inventario,
            timestamp_inventario_manteles: timestamp_inventario_manteles,
            timestamp_equipo_tecnico: timestamp_equipo_tecnico,
            timestamp_personal_montaje: timestamp_personal_montaje,
            timestamp_personal_montaje_ensayos: timestamp_personal_montaje_ensayos,
            ensayos: ensayos,
            solo_cafe: solo_cafe,
            lugar_evento_solo_cafe: lugar_evento_solo_cafe,
            evento_con_cafe: evento_con_cafe,
            tipo_montaje: tipo_montaje
        };
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_nuevo_montaje.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
                $("#btn_enviar_formulario").prop("disabled", true);
            },
            data: data
        }).done((res) => {
            if (parseInt(res) > 0) {
                M.toast({
                    html: 'Solicitud realizada con éxito',
                    classes: 'green accent-4 c-blanco'
                });
                if ($("#anexa_programa").val().length > 0) {
                    cargar_archivo_programa(archivo_cargado, res);
                } else {
                    setInterval(() => {
                        window.location.href = "https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/PMontajes.php?idseccion=";
                    }, 2000);
                }
            }
            ensayos = [];
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }
    function cargar_servicio_cafe() {
        var cantidad_invitados = $("#cantidad_invitados").val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_carga_servicio_cafe.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                cantidad_invitados: cantidad_invitados
            }
        }).done((res) => {
            $("#caja_cafe").fadeIn();
            if (evento_con_cafe) {
                $("#select_lugar_evento_solo_cafe").prop("hidden", true);
            } else {
                $("#select_lugar_evento_solo_cafe").prop("hidden", false);
            }
            var li = "";
            for (var item in res) {
                li += `<li class="collection-item avatar col s12" style="justify-content: space-around"> <div class="col s12 l6"> <br><i class="material-icons circle" style="background-color: #00C2EE">free_breakfast</i> <span class="title"> <b>Ingrediente:</b> ${res[item].ingrediente}</span> <p> <b>Cantidad para el evento: </b> ${res[item].cantidad_servicio}</div><div class="col s12 l6 text-center"> <a href="${res[item].ruta_img}" data-fancybox data-caption="${res[item].ingrediente}"> <br><img src="${res[item].ruta_img}" width="100"/> </a> </div></li>`;
            }
            $("#ul_servicio_cafe").html(li);
        }).always(() => {
            $("#loading").fadeOut();
        });

    }
    function cargar_evento_con_cafe(checked) {
        if (checked) {
            cargar_servicio_cafe();
        } else {
            $("#caja_cafe").fadeOut();
        }
    }
    function validar_fecha_no_posterior_ensayo(el) {
        var fecha_asignada = new Date(obtener_fecha().split("-")[0], obtener_fecha().split("-")[1] - 1, obtener_fecha().split("-")[2]);
        var fecha_ensayo = formatear_fecha_calendario_formato_a_m_d_guion(el.value);
        fecha_ensayo = new Date(fecha_ensayo.split("-")[0], fecha_ensayo.split("-")[1] - 1, fecha_ensayo.split("-")[2]);
        if (fecha_ensayo >= fecha_asignada) {
            M.toast({
                html: '¡Debe seleccionar una fecha de ensayo anterior a la fecha del evento!',
                classes: 'deep-orange c-blanco'
            });
            $("#" + el.id).val("");
            return;
        }
    }
    function consula_disponibilidad_lugar(id_lugar, id) {
        var fecha_montaje = obtener_fecha();
        var horario_evento = $("#horario_evento").val();
        var horario_final_evento = $("#horario_final_evento").val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_consulta_disponibilidad_lugar.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                id_lugar: id_lugar,
                fecha_montaje: fecha_montaje,
                horario_evento: horario_evento,
                horario_final_evento: horario_final_evento
            }
        }).done((res) => {
            if (parseInt(res) > 0) {
                M.toast({
                    html: '¡El lugar seleccionado ha sido ocupado con anterioridad!',
                    classes: 'deep-orange c-blanco'
                });
                $("#" + id + " option[value=0]").prop("selected", "selected");
                $("#" + id).focus();
                $('select').formSelect();
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
</script>

<?php include "$root_icloud/components/layout_bottom.php"; ?>
