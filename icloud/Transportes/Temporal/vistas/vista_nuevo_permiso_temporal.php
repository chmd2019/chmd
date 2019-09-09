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
        $fecha_minima = date("Y-m-d");
        $fecha_minima = strtotime("+3 day", strtotime($fecha_minima));
        $fecha_minima = date("m/d/Y", $fecha_minima);
        //manejo de fechas
        $arrayMeses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

        $arrayDias = array('Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado');
        include "$root_icloud/components/navbar.php";
        ?>

        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
              <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
                <a class="waves-effect waves-light"
                href="<?php echo $redirect_uri ?>Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>">
                <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
                <style type="text/css">
                .sth0{fill:#6DC1EC;}
                .sth1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
                .sth2{fill-rule:evenodd;clip-rule:evenodd;fill:#0E497B;}
                </style>
                <path class="sth0" d="M559.25,192.49H45.33c-16.68,0-30.33-13.65-30.33-30.33V50.42c0-16.68,13.65-30.33,30.33-30.33h513.92
                c16.68,0,30.33,13.65,30.33,30.33v111.74C589.58,178.84,575.93,192.49,559.25,192.49z"/>
                <g>
                  <path class="sth1" d="M228.72,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
                  c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
                  c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C228,130.45,228.27,129.64,228.72,128.74z M270.07,110.86l-11.11-25.55
                  l-11.1,25.55H270.07z"/>
                  <path class="sth1" d="M313.14,83.05h-15.35c-2.89,0-5.15-2.35-5.15-5.15s2.26-5.15,5.15-5.15h41.98c2.8,0,5.06,2.35,5.06,5.15
                  s-2.26,5.15-5.06,5.15h-15.44v47.85c0,3.07-2.53,5.51-5.6,5.51c-3.07,0-5.6-2.44-5.6-5.51V83.05z"/>
                  <path class="sth1" d="M351.6,78.36c0-3.16,2.44-5.6,5.6-5.6h22.57c7.95,0,14.17,2.35,18.24,6.32c3.34,3.43,5.24,8.12,5.24,13.63
                  v0.18c0,10.11-5.87,16.25-14.36,18.87l12.1,15.26c1.08,1.35,1.81,2.53,1.81,4.24c0,3.07-2.62,5.15-5.33,5.15
                  c-2.53,0-4.15-1.17-5.42-2.89l-15.35-19.59h-13.99v16.97c0,3.07-2.44,5.51-5.51,5.51c-3.16,0-5.6-2.44-5.6-5.51V78.36z
                  M378.96,104.09c7.95,0,13-4.15,13-10.56v-0.18c0-6.77-4.88-10.47-13.09-10.47h-16.16v21.22H378.96z"/>
                  <path class="sth1" d="M408.75,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
                  c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
                  c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C408.03,130.45,408.3,129.64,408.75,128.74z M450.1,110.86L439,85.31
                  l-11.1,25.55H450.1z M436.02,65.18c0-0.63,0.36-1.44,0.72-1.99l5.15-7.95c0.99-1.62,2.44-2.62,4.33-2.62c2.89,0,6.5,1.81,6.5,3.52
                  c0,0.99-0.63,1.9-1.53,2.71l-6.05,5.78c-2.17,1.99-3.88,2.44-6.41,2.44C437.19,67.07,436.02,66.35,436.02,65.18z"/>
                  <path class="sth1" d="M476.01,128.92c-1.26-0.9-2.17-2.44-2.17-4.24c0-2.89,2.35-5.15,5.24-5.15c1.54,0,2.53,0.45,3.25,0.99
                  c5.24,4.15,10.83,6.5,17.7,6.5c6.86,0,11.2-3.25,11.2-7.95v-0.18c0-4.51-2.53-6.95-14.26-9.66c-13.45-3.25-21.04-7.22-21.04-18.87
                  v-0.18c0-10.83,9.03-18.33,21.58-18.33c7.95,0,14.36,2.08,20.04,5.87c1.26,0.72,2.44,2.26,2.44,4.42c0,2.89-2.35,5.15-5.24,5.15
                  c-1.08,0-1.99-0.27-2.89-0.81c-4.88-3.16-9.57-4.79-14.54-4.79c-6.5,0-10.29,3.34-10.29,7.49v0.18c0,4.88,2.89,7.04,15.08,9.93
                  c13.36,3.25,20.22,8.04,20.22,18.51v0.18c0,11.83-9.3,18.87-22.57,18.87C491.18,136.86,483.05,134.15,476.01,128.92z"/>
                </g>
                <g>
                  <path class="sth2" d="M81.84,94.54h97.68c14.9,0,14.9,23.73,0,23.73H81.84l26.49,27.04c11.04,11.04-5.52,27.59-16.56,16.56
                  l-47.46-46.91c-4.41-4.97-4.41-12.69,0-17.11l47.46-46.91c11.04-11.59,27.59,5.52,16.56,16.56L81.84,94.54z"/>
                </g>
              </svg>
              <!--
              <i class="material-icons left">keyboard_backspace</i>Atrás
            -->
          </a>
        </div>

                <h5 class="center-align c-azul">Nuevo permiso temporal</h5>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_solicitud_permiso_temporal" style="margin-left: 1rem">Fecha de solicitud</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" readonly  id="fecha_solicitud_permiso_temporal" style="font-size: 1rem" type="text" />
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="solicitante_permiso_temporal" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $nombre; ?>" readonly  id="solicitante_permiso_temporal" style="font-size: 1rem" type="text" />
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
                                                   id="alumno_permiso_temporal_<?php echo $counter; ?>"
                                                   value="<?php echo $cliente1['id']; ?>"/>
                                            <span class="lever" style="margin-top: 1rem;"></span>
                                        </label>
                                    </div>
                                    <textarea class="materialize-textarea col s10 l11"
                                              readonly
                                              id="nombre_nuevo_permiso_temporal_<?php echo $counter; ?>"
                                              style="font-size: 1rem;float: right;"></textarea>
                                    <br style="clear: both">
                                    <input id="id_alumno_permiso_temporal_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                    <script>
                                        $('#nombre_nuevo_permiso_temporal_<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                                        M.textareaAutoResize($('#nombre_nuevo_permiso_temporal_<?php echo $counter; ?>'));
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
                            <label for="calle_guardada_nuevo" style="margin-left: 1rem">Calle y Número</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="calle_guardada_temporal"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field">
                            <label for="colonia_guardada_nuevo" style="margin-left: 1rem">Colonia</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="colonia_guardada_temporal"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field" hidden>
                            <label for="cp_guardada_temporal" style="margin-left: 1rem">CP</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly
                                   id="cp_guardada_temporal"
                                   style="font-size: .9rem"
                                   value=""/>
                        </div>
                    </div>
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul prefix">person_pin_circle</i>
                        <select id="reside" class="input-field" onchange="cambiar_direccion('<?php echo $id; ?>')">
                        </select>
                        <label style="margin-left: 1rem">Dirección Guardada</label>
                    </div>
                    <div class="input-field col s12">
                        <label for="calle_nuevo_permiso_temporal" style="margin-left: 1rem">Calle y Número</label>
                        <i class="material-icons c-azul prefix">person_pin_circle</i>
                        <textarea id="calle_nuevo_permiso_temporal"
                                  class="materialize-textarea"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  placeholder="INGRESE CALLE Y NUMERO"></textarea>
                    </div>
                    <div class="input-field col s12" style="margin-top: -.3rem">
                        <label for="colonia_nuevo_permiso_temporal " style="margin-left: 1rem">Colonia</label>
                        <i class="material-icons c-azul prefix">person_pin_circle</i>
                        <textarea class="materialize-textarea"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  id="colonia_nuevo_permiso_temporal"
                                  placeholder="INGRESE COLONIA"></textarea>
                    </div>
                    <div class="input-field col s12" hidden>
                        <label for="cp " style="margin-left: 1rem">CP</label>
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <input placeholder="INGRESE CP"
                               autocomplete="off"
                               id="cp"
                               type="tel"
                               onkeypress="return validar_solo_numeros(event)">
                    </div>
                    <div class="switch col s12">
                        <label>
                            <input type="checkbox"
                                   class="filled-in"
                                   id="recordar_direccion"
                                   onchange="recordar_direccion()"/>
                            <span>Rercordar dirección </span>
                        </label>
                    </div>
                    <br>
                    <div id="container_descripcion_recordar_direccion" hidden>
                        <div class="input-field col s12" id="container_descripcion_recordar_direccion">
                            <i class="material-icons prefix c-azul prefix">store_mall_directory</i>
                            <input id="descripcion_recordar_direccion"
                                   placeholder="Descripción de la dirección"
                                   onkeyup ="capitaliza_primer_letra(this.id)"
                                   autocomplete="off" />
                            <button type="button" class="btn waves-effect waves-light white-text b-azul w-100" onclick="enviar_direccion()">Guardar</button>
                        </div>
                    </div>
                    <br>
                    <h5 class="center-align c-azul">Datos de responsable</h5>
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
                            <input id="responsable"
                                   type="text"
                                   onkeyup ="capitaliza_primer_letra(this.id)"
                                   autocomplete="off">
                            <label for="responsable">Nombre del responsable</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">person</i>
                            <input id="parentesco_responsable"
                                   type="text"
                                   onkeyup ="capitaliza_primer_letra(this.id)"
                                   autocomplete="off">
                            <label for="parentesco_responsable">Parentesco del responsable</label>
                        </div>
                        <a class="waves-effect waves-light btn col s12 b-azul c-blanco"
                           onclick="post_nuevo_responsable()"
                           id="btn_agregar_nuevo_responsable">
                            <i class="material-icons right">send</i>Guardar
                        </a>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12 l6">
                            <label for="celular_nuevo_permiso_temporal " style="margin-left: 1rem">Celular</label>
                            <i class="material-icons c-azul prefix">smartphone</i>
                            <input placeholder="Agrega 10 dígitos"
                                   autocomplete="off"
                                   id="celular_nuevo_permiso_temporal"
                                   type="tel"
                                   onkeypress="return validar_solo_numeros_max(event)">
                        </div>
                        <div class="input-field col s12 l6">
                            <label for="telefono_nuevo_permiso_temporal " style="margin-left: 1rem">Teléfono</label>
                            <i class="material-icons c-azul prefix">phone_in_talk</i>
                            <input placeholder="Agrega 8 dígitos"
                                   autocomplete="off"
                                   id="telefono_nuevo_permiso_temporal"
                                   type="tel"
                                   onkeypress="return validar_solo_numeros_max(event)">
                        </div>
                    </div>
                    <div class="col s12"></div>
                    <div>
                        <link rel='stylesheet' href='../../common/css/calendario.css'>
                        <div id="wrapper1" class="col s12 l6 input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input
                                type="date"
                                id="fecha_inicial_nuevo_permiso_temporal"
                                class="datepicker-start datepicker c-azul"
                                onchange="fecha_minusculas(this.value, 'fecha_inicial_nuevo_permiso_temporal')"/>
                            <label for="fecha_inicial_nuevo_permiso_temporal">Fecha inicial</label>
                        </div>
                        <div id="wrapper2" class="col s12 l6 input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input
                                type="date"
                                id="fecha_final_nuevo_permiso_temporal"
                                class="datepicker-end datepicker  c-azul"
                                onchange="fecha_minusculas(this.value, 'fecha_final_nuevo_permiso_temporal')"/>
                            <label for="fecha_final_nuevo_permiso_temporal">Fecha final</label>
                        </div>
                        <script src='../../common/js/calendario.js'></script>
                        <script src="../../common/js/common.js"></script>
                        <script>
                                    //obtiene el calendario escolar en db
                                    var calendario_escolar = obtener_calendario_escolar();
                                    //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
                                    var fecha_posterior = new Date();
                                    fecha_posterior.setDate(new Date().getDate() + 1);
                                    calendario_escolar.push(6);
                                    calendario_escolar.push(7);
                                    //fix de error al mostrar calendario (se oculta inmediatamente se abre)
                                    $(".datepicker").on('mousedown', function (event) {
                                        event.preventDefault();
                                    });
                                    $("input[class*='datepicker-']").pickadate({
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
                                        min: new Date("<?php echo $fecha_minima; ?>"),
                                        //establece rango de fecha final segun fecha inicial
                                        onSet: function (obj) {
                                            let thisPicker = $(this)[0].$node;
                                            let classes = thisPicker.attr("class");
                                            if (classes === undefined || classes.length === 0 || classes.indexOf("datepicker-start") < 0) {
                                                return;
                                            }
                                            let parent1 = thisPicker.closest("div.input-field");
                                            let parent2 = parent1.next("div.input-field");
                                            let picker2 = parent2.find(".datepicker-end");
                                            if (obj.select) {
                                                let dt = new Date(obj.select);
                                                picker2.pickadate('picker').set('min', new Date(dt.setDate(new Date(dt).getDate() + 1)));
                                            }

                                            if (obj.hasOwnProperty('clear')) {
                                                picker2.pickadate('picker').set('min', false);
                                            }
                                        }
                                    });
                        </script>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul prefix">departure_board</i>
                        <select class="input-field" id="ruta_nuevo_permiso_temporal" >
                            <option value="">Selecciona opción</option>
                            <option value="Mañana">Mañana</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Mañana-Tarde">Mañana-Tarde</option>
                        </select>
                        <label>Ruta</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul prefix">comment</i>
                        <textarea id="comentarios_nuevo_permiso_temporal"
                                  class="materialize-textarea"
                                  onkeyup ="capitaliza_primer_letra(this.id)"
                                  placeholder="Comentarios"></textarea>
                        <label>Comentarios</label>
                    </div>
                    <div class="col s12 l6" style="float: none;margin: 0 auto;">
                        <button class="btn waves-effect waves-light b-azul white-text w-100"
                                id="btn_enviar_formulario"
                                type="button"
                                onclick="enviar_formulario('<?php echo $id; ?>', '<?php echo $familia; ?>', 2)">Enviar
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
<!---
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
       href="<?php echo $redirect_uri ?>Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>
-->

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
<script src="/pruebascd/icloud/materialkit/js/common.js"></script>
<script>
                                    //arreglo global de ids de los alumnos seleccionados para el permiso
                                    var coleccion_ids = [];
                                    var responsables = [];
                                    $(document).ready(function () {
                                        $("#loading").hide();
                                        $('.fixed-action-btn').floatingActionButton({
                                            hoverEnabled: false
                                        });
                                        $('.modal').modal();
                                        var instance = M.Modal.getInstance($("#modal_alerta"));
                                        instance.open();
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
                                        consultar_direcciones("<?php echo $id; ?>");
                                        cargar_responsables();
                                    });
                                    function recordar_direccion() {
                                        if ($('#recordar_direccion').is(":checked")) {
                                            $('#container_descripcion_recordar_direccion').show();
                                            consultar_direcciones("<?php echo $id; ?>");
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
                                            $('#cp').val("");
                                        }
                                        if (dato == '1') {
                                            $("#calle_nuevo_permiso_temporal").val("Periferico Boulevard Manuel Avila Camacho 620");
                                            M.textareaAutoResize($('#calle_nuevo_permiso_temporal'));
                                            $("#colonia_nuevo_permiso_temporal").val("Lomas de Sotelo");
                                            M.textareaAutoResize($('#colonia_nuevo_permiso_temporal'));
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
                                                            $("#calle_nuevo_permiso_temporal").val(data[key].calle);
                                                            M.textareaAutoResize($('#calle_nuevo_permiso_temporal'));
                                                            $("#colonia_nuevo_permiso_temporal").val(data[key].colonia);
                                                            M.textareaAutoResize($('#colonia_nuevo_permiso_temporal'));
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
                                    function validar_recordar_direccion() {
                                        //valida calle
                                        var calle = $("#calle_nuevo_permiso_temporal");
                                        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
                                        if (!validar_regex(regex_calle, calle.val())) {
                                            M.toast({
                                                html: '¡Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida colonia*
                                        var colonia = $("#colonia_nuevo_permiso_temporal");
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
                                        var calle = $('#calle_nuevo_permiso_temporal').val();
                                        var colonia = $('#colonia_nuevo_permiso_temporal').val();
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
                                                        html: `¡Registro exitoso!, puedes seleccionar tu nueva dirección en la lista desplegable con la descripción ${data.descripcion}`,
                                                        classes: 'deep-orange c-blanco'
                                                    });
                                                    $('#calle_nuevo_permiso_temporal').val("");
                                                    $('#colonia_nuevo_permiso_temporal').val("");
                                                    $('#descripcion_recordar_direccion').val("");
                                                    consultar_direcciones(data.id_usuario);
                                                    cambiar_direccion(data.id_usuario);
                                                }
                                            })
                                                    .always(function () {
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
                                    function validar_regex(reg, val) {
                                        var regex = new RegExp(reg);
                                        if (regex.test(val)) {
                                            return true;
                                        }
                                        return false;
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
                                        var calle = $("#calle_nuevo_permiso_temporal");
                                        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
                                        if (!validar_regex(regex_calle, calle.val())) {
                                            M.toast({
                                                html: '¡Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida colonia*
                                        var colonia = $("#colonia_nuevo_permiso_temporal");
                                        var regex_colonia = "[A-Za-z ]{5,30}";
                                        if (!validar_regex(regex_colonia, colonia.val())) {
                                            M.toast({
                                                html: '¡Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida nombre*
                                        var nombre_nuevo_permiso_temporal = $("#responsable");
                                        var regex_nombre_nuevo_permiso_temporal = "[A-Za-z ]{1,256}";
                                        if (!validar_regex(regex_nombre_nuevo_permiso_temporal, nombre_nuevo_permiso_temporal.val())) {
                                            M.toast({
                                                html: '¡Agregue un responsable válido, sin acentos ni signos especiales!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida parentesco*
                                        var parentesco_nuevo_permiso_temporal = $("#parentesco_responsable");
                                        var regex_parentesco_nuevo_permiso_temporal = "[A-Za-z ]{1,256}";
                                        if (!validar_regex(regex_parentesco_nuevo_permiso_temporal, parentesco_nuevo_permiso_temporal.val())) {
                                            M.toast({
                                                html: '¡Agregue parentesco sin acentos ni signos especiales!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida celular*
                                        var celular_nuevo_permiso_temporal = $("#celular_nuevo_permiso_temporal");
                                        if (celular_nuevo_permiso_temporal.val().length == 8 ||
                                                celular_nuevo_permiso_temporal.val().length == 10)
                                        {

                                        } else {
                                            M.toast({
                                                html: '¡Agregue celular con 8 o 10 dígitos!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida telefono
                                        var telefono_nuevo_permiso_temporal = $("#telefono_nuevo_permiso_temporal");
                                        if (telefono_nuevo_permiso_temporal.val().length !== 8) {
                                            M.toast({
                                                html: '¡Agregue teléfono con 8 dígitos!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida fechas
                                        if ($("#fecha_inicial_nuevo_permiso_temporal").val().length === 0) {
                                            M.toast({
                                                html: '¡Debes seleccionar una fecha inicial válida!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        if ($("#fecha_final_nuevo_permiso_temporal").val().length === 0) {
                                            M.toast({
                                                html: '¡Debes seleccionar una fecha final válida!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //validar fecha final mayor que fecha inicial
                                        var fecha_inicial = $("#fecha_inicial_nuevo_permiso_temporal").val();
                                        fecha_inicial = formatear_fecha_calendario(fecha_inicial);
                                        var fecha_final = $("#fecha_final_nuevo_permiso_temporal").val();
                                        fecha_final = formatear_fecha_calendario(fecha_final);
                                        fecha_inicial = new Date(fecha_inicial);
                                        fecha_final = new Date(fecha_final);
                                        if (fecha_final <= fecha_inicial) {
                                            M.toast({
                                                html: '¡La fecha final debe ser posterior a la fecha inicial!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        //valida seleccion de ruta
                                        if ($("#ruta_nuevo_permiso_temporal").val() === "") {
                                            M.toast({
                                                html: '¡Debes seleccionar una ruta!',
                                                classes: 'deep-orange c-blanco'
                                            });
                                            return false;
                                        }
                                        return true;
                                    }
                                    function validar_solo_numeros_max(num) {
                                        var charCode = (num.which) ? num.which : num.keyCode;
                                        if (charCode != 46 && charCode > 31
                                                && (charCode < 48 || charCode > 57))
                                            return false;
                                        return true;
                                    }
                                    function enviar_formulario(id, familia, tipo_permiso) {
                                        if (validar_formulario()) {
                                            //fecha solicitud, solicitante, fecha del permiso, nombre del alumno, alumnos, calle, colonia
                                            var calle_nuevo_permiso_temporal = $("#calle_nuevo_permiso_temporal").val();
                                            var colonia_nuevo_permiso_temporal = $("#colonia_nuevo_permiso_temporal").val();
                                            var cp = $("#cp").val() !== "" ? $("#cp").val() : "00000";
                                            var responsable = $("#responsable").val();
                                            var parentesco = $("#parentesco_responsable").val();
                                            var celular = $("#celular_nuevo_permiso_temporal").val();
                                            var telefono = $("#telefono_nuevo_permiso_temporal").val();
                                            var fecha_inicial = $("#fecha_inicial_nuevo_permiso_temporal").val();
                                            var fecha_final = $("#fecha_final_nuevo_permiso_temporal").val();
                                            var turno = $("#ruta_nuevo_permiso_temporal").val();
                                            var comentarios = $("#comentarios_nuevo_permiso_temporal").val();
                                            var fecha_creacion = $("#fecha_solicitud_permiso_temporal").val();
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
                                                calle_numero: calle_nuevo_permiso_temporal,
                                                colonia: colonia_nuevo_permiso_temporal,
                                                cp: cp,
                                                responsable: responsable,
                                                nfamilia: familia,
                                                parentesco: parentesco,
                                                celular: celular,
                                                telefono: telefono,
                                                fecha_inicial: fecha_inicial,
                                                fecha_final: fecha_final,
                                                turno: turno,
                                                comentarios: comentarios,
                                                tipo_permiso: tipo_permiso,
                                                coleccion_ids: coleccion_ids,
                                                fecha_creacion: fecha_creacion
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
                                                            classes: 'green accent- c-blanco'
                                                        });
                                                        setInterval(() => {
                                                            window.location = "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>";
                                                        }, 1500);
                                                    } else {
                                                        M.toast({
                                                            html: res,
                                                            classes: 'deep-orange c-blanco'
                                                        });
                                                        setInterval(() => {
                                                            location.reload();
                                                        }, 10000);
                                                    }
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

                                    function post_nuevo_responsable() {
                                        var responsable = $("#responsable").val();
                                        var parentesco_responsable = $("#parentesco_responsable").val();
                                        if (validar_responsable()) {
                                            nuevo_responsable(responsable, parentesco_responsable, '<?php echo $familia; ?>');
                                            cargar_responsables();
                                        }
                                    }

                                    function cargar_responsables() {
                                        responsables = obtener_responsables('<?php echo $familia; ?>');
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
</script>
<?php include "$root_icloud/Transportes/Temporal/modales/modal_informacion_importante_hora_limite.php"; ?>
<?php include "$root_icloud/components/layout_bottom.php"; ?>
