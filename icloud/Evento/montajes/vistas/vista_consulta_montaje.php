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
    include_once "$root_icloud/components/navbar.php";
    require_once "$root_icloud/Evento/common/ControlEvento.php";

    $service = new Google_Service_Oauth2($client);
    $id_montaje = $_GET['id'];
    $idseccion = $_GET['idseccion'];
    $control = new ControlEvento();
    $date_helper = new DateHelper();
    $montaje = $control->consulta_montaje($id_montaje);
    $montaje = mysqli_fetch_array($montaje);
    $fecha_solicitud = $montaje[1];
    $solicitante = $montaje[2];
    $tipo_servicio = $montaje[3];
    $fecha_montaje = $montaje[4];
    $fecha_montaje_simple = $montaje[5];
    $horario_evento = $montaje[6];
    $horario_final_evento = $montaje[7];
    $nombre_evento = $montaje[8];
    $responsable_evento = $montaje[9];
    $cantidad_invitados = $montaje[10];
    $valet_parking = $montaje[11];
    $anexa_programa = $montaje[13];
    $url_pdf = $montaje[12];
    $tipo_repliegue = $montaje[14];
    $requiere_ensayo = $montaje[15];
    $cantidad_ensayos = $montaje[16];
    $requerimientos_especiales = $montaje[17];
    $nombre_pdf = $montaje[18];
    $lugar_evento = $montaje[19];
    $solo_cafe = $montaje[20];
    $cafe_con_evento = $montaje[21];
    if ($tipo_repliegue == "")
        $tipo_repliegue = "Sin repliegue";
    $tipo_montaje = $montaje[22];
    $estatus = $montaje[23];
    $color_estatus = $montaje[24];
    $id_estatus = $montaje[25];
    $id_lugar = $montaje[26];
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
        <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
            <div>
                <h5 class="c-azul center-align">Consulta de montaje</h5>
                <br>
                <div class="right">
                    <?php if ($id_privilegio == 3): ?>                    
                        <a class="waves-effect waves-light" href="#!"
                           onclick="habilitar_edicion()">
                            <img src='../../../images/Editar.svg' style="width: 55px;">
                        </a>
                        <a class="waves-effect waves-light btn  cyan accent-4 tooltipped" 
                           data-position="top" 
                           data-tooltip="Reporte de montaje"
                           target="_blank"
                           href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_reporte_montaje.php?id=<?php echo $id_montaje;?>"><i class="material-icons">receipt</i>
                        </a>
                    <?php endif; ?>
                    <a class='dropdown-trigger btn <?php echo $color_estatus; ?>' href='#' data-target='dropdown1'>
                        <i class="material-icons right">arrow_drop_down</i>Estatus - <?php echo $estatus; ?>
                    </a>
                    <ul id='dropdown1' class='dropdown-content'>
                        <?php if ($id_estatus != 1 && $id_privilegio == 3) : ?>   
                            <li style="background-color: #F6871F">
                                <a href="#!" class="c-blanco" 
                                   onclick="mostrar_modal_estatus('<?php echo $id_montaje; ?>', 1)">
                                    <i class="material-icons c-blanco">done</i>Pendiente</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($id_estatus != 2 && ($id_privilegio == 2 || $id_privilegio == 3)) : ?>   
                            <li  style="background-color: #77AF65">
                                <a href="#!" class="c-blanco" 
                                   onclick="mostrar_modal_estatus('<?php echo $id_montaje; ?>', 2)">
                                    <i class="material-icons c-blanco">done</i>Autorizar</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($id_estatus != 3 && ($id_privilegio == 1 || $id_privilegio == 2 || $id_privilegio == 3)) : ?> 
                            <li style="background-color: #EF4545">
                                <a href="#!" class="c-blanco" 
                                   onclick="mostrar_modal_estatus('<?php echo $id_montaje; ?>', 3)">
                                    <i class="material-icons c-blanco">delete</i>Declinar</a>
                            </li>
                        <?php endif; ?>
                    </ul>   
                </div>
                <div class="row"> 
                    <link rel='stylesheet' href='/pruebascd/icloud/materialkit/css/calendario.css'> 
                    <script src='/pruebascd/icloud/materialkit/js/calendario.js'></script>
                    <script src="/pruebascd/icloud/materialkit/js/common.js"></script>
                    <br> 
                    <br> 
                    <br> 
                    <br> 
                    <br> 
                    <div class="input-field col s12 l6">
                        <label>Fecha de solicitud</label>
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input readonly  
                               style="font-size: 1rem" 
                               type="text" 
                               autocomplete="off"
                               value="<?php echo $fecha_solicitud; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Solicitante</label>
                        <i class="material-icons prefix c-azul">person</i>
                        <input readonly  
                               id="solicitud"
                               style="font-size: 1rem" 
                               type="text" 
                               autocomplete="off"
                               value="<?php echo $solicitante; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">room_service</i>
                        <select id="tipo_evento" readonly>
                            <option selected><?php echo $tipo_servicio; ?></option>
                        </select>
                        <label>Tipo de evento</label>  
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">filter_tilt_shift</i>
                        <select readonly id="tipo_montaje">
                            <option value="<?php echo $tipo_montaje; ?>" selected><?php echo $tipo_montaje; ?></option>
                        </select>  
                        <label>Tipo de montaje</label>  
                    </div>                    
                    <div class="input-field col s12 l6">
                        <label>Fecha del montaje</label>
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input readonly  
                               id="fecha_montaje"
                               style="font-size: 1rem" 
                               type="text" 
                               autocomplete="off"
                               value="<?php echo $fecha_montaje; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Horario inicial del evento</label>
                        <i class="material-icons prefix c-azul">access_time</i>
                        <input readonly  
                               class="timepicker"
                               onkeypress="return validar_solo_numeros(event, this.id, 1)"
                               onchange="consulta_disponibilidad_lugar('<?php echo $id_lugar; ?>', 'hora_final', '<?php echo $id_montaje; ?>')"
                               autocomplete="off"
                               onfocus="blur();"
                               id="hora_inicial"
                               style="font-size: 1rem" 
                               type="text" 
                               placeholder="Horario inicial"
                               value="<?php echo $horario_evento; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Horario final del evento</label>
                        <i class="material-icons prefix c-azul">access_time</i>
                        <input readonly  
                               class="timepicker"
                               onkeypress="return validar_solo_numeros(event, this.id, 1)"
                               onchange="validar_horario_final_ensayo(this, 'hora_inicial');consulta_disponibilidad_lugar('<?php echo $id_lugar; ?>', 'hora_final', '<?php echo $id_montaje; ?>')"
                               autocomplete="off"
                               onfocus="blur();"
                               id="hora_final"
                               style="font-size: 1rem" 
                               type="text" 
                               placeholder="Horario final"
                               value="<?php echo $horario_final_evento; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Lugar del evento</label>
                        <i class="material-icons prefix c-azul">place</i>
                        <input readonly 
                               id="lugar_evento"
                               style="font-size: 1rem" 
                               type="text" 
                               autocomplete="off"
                               value="<?php echo $lugar_evento; ?>">      
                    </div>                    
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">donut_small</i>
                        <select id="tipo_repliegue" readonly>
                            <option value="<?php echo $tipo_repliegue; ?>" selected><?php echo $tipo_repliegue; ?></option>
                        </select>
                        <label>Repliegue</label>     
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Nombre del evento</label>
                        <i class="material-icons prefix c-azul">restaurant_menu</i>
                        <input readonly  
                               id="nombre"
                               onkeyup="capitaliza_primer_letra('nombre')"
                               style="font-size: 1rem" 
                               type="text" 
                               placeholder="Nombre del evento"
                               autocomplete="off"
                               value="<?php echo $nombre_evento; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Responsable del evento del area solicitante</label>
                        <i class="material-icons prefix c-azul">person</i>
                        <input readonly  
                               id="responsable"
                               style="font-size: 1rem" 
                               type="text" 
                               placeholder="Responsable del evento del area solicitante"
                               autocomplete="off"
                               onkeyup="capitaliza_primer_letra('responsable')"
                               value="<?php echo $responsable_evento; ?>">      
                    </div>
                    <div class="input-field col s12 l6">
                        <label>Cantidad de invitados</label>
                        <i class="material-icons prefix c-azul">sentiment_very_satisfied</i>
                        <input readonly  
                               id="cantidad_invitados"
                               style="font-size: 1rem" 
                               type="text" 
                               placeholder="Cantidad de invitados"
                               autocomplete="off"
                               onkeyup="calcular_parking(this)"
                               onkeypress="return validar_solo_numeros(event, this.id, 3)"
                               value="<?php echo $cantidad_invitados; ?>">      
                    </div>
                    <?php if ($valet_parking != 0): ?>                      
                        <div class="input-field col s12 l6">
                            <label>Estacionamiento</label>
                            <i class="material-icons prefix c-azul">drive_eta</i>
                            <input readonly  
                                   id="estacionamiento"
                                   style="font-size: 1rem" 
                                   type="text" 
                                   placeholder="Estacionamiento"
                                   autocomplete="off"
                                   value="<?php echo $valet_parking; ?>">      
                        </div>  
                    <?php endif; ?>
                    <?php if ($solo_cafe || $cafe_con_evento): ?>        
                        <div class="input-field col s12">
                            <h5 class="col s12 c-azul text-center">Servicio de café</h5>
                            <br>  
                            <ul class="collection row">
                                <?php
                                $servicio_cafe = $control->consulta_servicio_cafe($cantidad_invitados);
                                while ($row_cafe = mysqli_fetch_array($servicio_cafe)):
                                    ?>
                                    <li class="collection-item avatar col s12" style="justify-content: space-around">
                                        <div class="col s12 l6">
                                            <br><i class="material-icons circle" style="background-color: #00C2EE">free_breakfast</i> <span class="title">
                                                <b>Ingrediente:</b> <?php echo $row_cafe[0]; ?></span>
                                            <p> <b>Cantidad para el evento: </b> <?php echo bcdiv($row_cafe[1], 1, 2) < 1 ? bcdiv($row_cafe[1], 1, 2) : intval($row_cafe[1]); ?>
                                        </div>
                                        <div class="col s12 l6 text-center">
                                            <a href="<?php echo $row_cafe[2]; ?>" data-fancybox data-caption="<?php echo $row_cafe[0]; ?>">
                                                <br><img src="<?php echo $row_cafe[2]; ?>" width="100" /> </a>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>  
                    <?php endif; ?>
                    <?php if ($anexa_programa) : ?>
                        <div class="input-field col s12 l6" style="text-align: center;margin-top: -1rem">
                            <label style="font-size: .9rem">Programación</label>
                            <br>
                            <br>
                            <a class="waves-effect waves-light btn" 
                               href="<?php echo $url_pdf; ?>" 
                               target="_blank"
                               style="background-color: #00C2EE">
                                <i class="material-icons left">attach_file</i>
                                <?php echo $nombre_pdf; ?>
                            </a>
                        </div>  
                        <?php
                    endif;
                    $mobiliario = $control->consulta_mobiliario_montaje($id_montaje, $id_lugar, $horario_evento, $horario_final_evento, $fecha_montaje_simple);
                    if (mysqli_num_rows($mobiliario) > 0):
                        ?>
                        <br><h5 class="col s12 c-azul text-center">Mobiliario actual del evento</h5>
                        <div>
                            <ul class="collection row col s12">
                                <?php
                                $mobiliario_index = 0;
                                $id_montaje_coleccion = array();
                                while ($row = mysqli_fetch_array($mobiliario)):
                                    $mobiliario_index++;
                                    $articulo = $row[0];
                                    $cantidad = $row[1];
                                    $url_img = $row[2];
                                    $id_articulo = $row[3];
                                    array_push($id_montaje_coleccion, $id_articulo);
                                    $capacidad_lugar = $row[4];
                                    $disponibilidad = $row[5];
                                    ?>
                                    <li class="collection-item avatar col s12" style="justify-content: space-around">
                                        <div class="col s12 l6"> <br>
                                            <i class="material-icons circle" style="background-color: #00C2EE">done</i>
                                            <span class="title"><b>Artículo: </b> <?php echo $articulo; ?></span>
                                            <br>
                                            <span class="title"><b>Capacidad del lugar: </b> <?php echo $capacidad_lugar; ?></span>
                                            <br>
                                            <span class="title" style="display: flex;"><b>Disponible: </b> 
                                                <input id="disponibilidad_articulo_<?php echo $id_articulo; ?>"
                                                       readonly
                                                       style="margin-top: -.8rem;margin-bottom: 0px;color: black;border: none"
                                                       disabled
                                                       value="<?php echo $disponibilidad < 0 ? 0 : $disponibilidad; ?>"> 
                                            </span>
                                            <span class="title">
                                                <b>Cantidad para el evento: </b>
                                                <input readonly
                                                       autocomplete="off"
                                                       placeholder="Cantidad"
                                                       onkeypress="return validar_solo_numeros(event, this.id, 2)"
                                                       id="articulo_mobiliario_cantidad_<?php echo $mobiliario_index; ?>"
                                                       value="<?php echo $cantidad; ?>">
                                            </span>
                                            <div id="caja_btn_actualizar_mobiliario_<?php echo $mobiliario_index; ?>" hidden>
                                                <button class="waves-effect waves-light btn b-azul white-text col s6" 
                                                        id="btn_actualizar_mobiliario_<?php echo $mobiliario_index; ?>"
                                                        type="button" 
                                                        onclick="actualizar_mobiliario(<?php echo $row[3]; ?>,<?php echo $id_montaje; ?>, <?php echo $cantidad; ?>, 'articulo_mobiliario_cantidad_<?php echo $mobiliario_index; ?>', <?php echo $capacidad_lugar; ?>, 'disponibilidad_articulo_<?php echo $id_articulo; ?>');"
                                                        style="background-color: #00C2EE;float: none">Asignar
                                                    <i class="material-icons right">save</i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col s12 l6 text-center"> 
                                            <a href="<?php echo $url_img; ?>" data-fancybox
                                               data-caption="<?php echo $articulo; ?>"> <br>
                                                <img src="<?php echo $url_img; ?>" width="150" />
                                            </a>
                                        </div><span class="col s12"><br></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php if ($id_privilegio == 3): ?>
                                <div class="input-field col s12">
                                    <div style="text-align: center">
                                        <button class="waves-effect waves-light btn green accent-4 white-text col s12 l4" 
                                                id="btn_disminuir_mobiliario"
                                                type="button" 
                                                onclick='consultar_disponibilidad_mobiliario(<?php echo $id_montaje; ?>);habilitar_mobiliario(<?php echo json_encode($id_montaje_coleccion) ?>, <?php echo $mobiliario_index; ?>)' 
                                                style="background-color: #00C2EE;float: none">Alterar mobiliario
                                            <i class="material-icons right">edit</i>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; 
                    $manteles = $control->consulta_manteles_montaje($id_montaje);
                    if (mysqli_num_rows($manteles) > 0):
                        ?>
                        <br><h5 class="col s12 c-azul text-center">Manteles</h5>
                        <ul class="collection row col s12">
                            <?php
                            $manteles_index = 0;
                            $id_manteles_coleccion = array();
                            while ($row = mysqli_fetch_array($manteles)):
                                $manteles_index++;
                                $articulo = $row[0];
                                $cantidad = $row[1];
                                $url_img = $row[2];
                                $capacidad_lugar = $row[3];
                                $disponibilidad = $row[4];
                                $id_mantel = $row[5];
                                array_push($id_manteles_coleccion, $id_mantel);
                                ?>
                                <li class="collection-item avatar col s12" style="justify-content: space-around">
                                    <div class="col s12 l6"> <br>
                                        <i class="material-icons circle" style="background-color: #00C2EE">done</i>
                                        <span class="title"><b>Artículo: </b> <?php echo $articulo; ?></span>
                                        <br>
                                        <span class="title"><b>Capacidad del lugar: </b> <?php echo $capacidad_lugar; ?></span>
                                        <br>                                    
                                        <span class="title" style="display: flex;"><b>Disponible: </b> 
                                            <input id="disponibilidad_articulo_mantel_<?php echo $id_mantel; ?>"
                                                   readonly
                                                   style="margin-top: -.8rem;margin-bottom: 0px;color: black;border: none"
                                                   disabled
                                                   value="<?php echo $disponibilidad < 0 ? 0 : $disponibilidad; ?>"> 
                                        </span>                                        
                                        <span class="title">
                                            <b>Cantidad para el evento: </b>
                                            <input readonly
                                                   autocomplete="off"
                                                   placeholder="Cantidad"
                                                   onkeypress="return validar_solo_numeros(event, this.id, 2)"
                                                   id="articulo_mantel_cantidad_<?php echo $manteles_index; ?>"
                                                   value="<?php echo $cantidad; ?>">
                                        </span>                                        
                                        <div id="caja_btn_actualizar_manteles_<?php echo $manteles_index; ?>" hidden>
                                            <button class="waves-effect waves-light btn b-azul white-text col s6" 
                                                    id="btn_actualizar_mantel_<?php echo $manteles_index; ?>"
                                                    onclick="actualizar_mantel(<?php echo $id_montaje; ?>,<?php echo $id_mantel; ?>,<?php echo $cantidad; ?>, 'articulo_mantel_cantidad_<?php echo $manteles_index; ?>', <?php echo $capacidad_lugar; ?>, 'disponibilidad_articulo_mantel_<?php echo $id_mantel; ?>');"
                                                    type="button" style="background-color: #00C2EE;float: none">Asignar
                                                <i class="material-icons right">save</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col s12 l6 text-center"> 
                                        <a href="<?php echo $url_img; ?>" data-fancybox
                                           data-caption="<?php echo $articulo; ?>"> <br>
                                            <img src="<?php echo $url_img; ?>" width="150" />
                                        </a>
                                    </div><span class="col s12"><br></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php if ($id_privilegio == 3): ?>
                            <div class="input-field col s12">
                                <div style="text-align: center">
                                    <button class="waves-effect waves-light btn green accent-4 white-text col s12 l4" 
                                            id="btn_edicion_manteles"
                                            onclick='consultar_disponibilidad_manteles(<?php echo $id_montaje; ?>);habilitar_manteles(<?php echo json_encode($id_manteles_coleccion) ?>, <?php echo $manteles_index; ?>);' 
                                            type="button" style="background-color: #00C2EE;float: none">Alterar manteles
                                        <i class="material-icons right">edit</i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php
                    $equipo_tecnico = $control->consulta_equipo_tecnico_montaje($id_montaje, $id_lugar);
                    if (mysqli_num_rows($equipo_tecnico) > 0):
                        ?>
                        <br><h5 class="col s12 c-azul text-center">Equipo Técnico</h5>
                        <ul class="collection row col s12">
                            <?php
                            $equipo_tecnico_index = 0;
                            $id_equipo_tecnico_coleccion = array();
                            while ($row = mysqli_fetch_array($equipo_tecnico)):
                                $equipo_tecnico_index++;
                                $articulo = $row[0];
                                $cantidad = $row[1];
                                $url_img = $row[2];
                                $capacidad_lugar = $row[3];
                                $disponibilidad = $row[4];
                                $id_articulo = $row[5];
                                array_push($id_equipo_tecnico_coleccion, $id_articulo);
                                ?>
                                <li class="collection-item avatar col s12" style="justify-content: space-around">
                                    <div class="col s12 l6"> <br>
                                        <i class="material-icons circle" style="background-color: #00C2EE">settings_input_composite</i>
                                        <span class="title"><b>Artículo: </b> <?php echo $articulo; ?></span>
                                        <br>
                                        <span class="title"><b>Capacidad del lugar: </b> <?php echo $capacidad_lugar; ?></span>
                                        <br>                               
                                        <span class="title" style="display: flex;"><b>Disponible: </b> 
                                            <input id="disponibilidad_articulo_equipo_tecnico_<?php echo $id_articulo; ?>"
                                                   readonly
                                                   style="margin-top: -.8rem;margin-bottom: 0px;color: black;border: none"
                                                   disabled
                                                   value="<?php echo $disponibilidad < 0 ? 0 : $disponibilidad; ?>"> 
                                        </span>                                       
                                        <span class="title">
                                            <b>Cantidad para el evento: </b>
                                            <input readonly
                                                   autocomplete="off"
                                                   placeholder="Cantidad"
                                                   onkeypress="return validar_solo_numeros(event, this.id, 2)"
                                                   id="articulo_equipo_tecnico_cantidad_<?php echo $equipo_tecnico_index; ?>"
                                                   value="<?php echo $cantidad; ?>">
                                        </span>                                         
                                        <div id="caja_btn_actualizar_equipo_tecnico_<?php echo $equipo_tecnico_index; ?>" hidden>
                                            <button class="waves-effect waves-light btn b-azul white-text col s6" 
                                                    id="btn_actualizar_equipo_tecnico_<?php echo $equipo_tecnico_index; ?>"
                                                    onclick="actualizar_equipo_tecnico(<?php echo $id_montaje; ?>,<?php echo $id_articulo; ?>,<?php echo $cantidad; ?>, 'articulo_equipo_tecnico_cantidad_<?php echo $equipo_tecnico_index; ?>', <?php echo $capacidad_lugar; ?>, 'disponibilidad_articulo_equipo_tecnico_<?php echo $id_articulo; ?>');"
                                                    type="button" style="background-color: #00C2EE;float: none">Asignar
                                                <i class="material-icons right">save</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col s12 l6 text-center"> 
                                        <a href="<?php echo $url_img; ?>" data-fancybox
                                           data-caption="<?php echo $articulo; ?>"> <br>
                                            <img src="<?php echo $url_img; ?>" width="150" />
                                        </a>
                                    </div><span class="col s12"><br></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php if ($id_privilegio == 3): ?>
                            <div class="input-field col s12">
                                <div style="text-align: center">
                                    <button class="waves-effect waves-light btn green accent-4 white-text col s12 l4" 
                                            id="btn_edicion_equipo_tecnico"
                                            onclick='consultar_disponibilidad_equipo_tecnico(<?php echo $id_montaje; ?>);habilitar_equipo_tecnico(<?php echo json_encode($id_equipo_tecnico_coleccion) ?>, <?php echo $equipo_tecnico_index; ?>);' 
                                            type="button" style="background-color: #00C2EE;float: none">Alterar equipo técnico
                                        <i class="material-icons right">edit</i>
                                    </button>
                                </div>
                            </div>
                            <?php
                        endif;
                    endif;
                    $personal_requerido = $control->consulta_personal_montaje($id_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento);
                    if (mysqli_num_rows($personal_requerido) > 0):
                        ?>
                        <br><h5 class="col s12 c-azul text-center">Personal requerido</h5>
                        <ul class="collection row col s12">
                            <?php
                            $personal_index = 0;
                            $id_personal_coleccion = array();
                            while ($row = mysqli_fetch_array($personal_requerido)):
                                $personal_index++;
                                $id_personal = $row[0];
                                $descripcion = $row[1];
                                $cantidad = $row[2];
                                $disponibilidad = $row[3];
                                $n_ensayo = $row[4];
                                $max_personal_permitido = $row[5];
                                array_push($id_personal_coleccion, $id_personal);
                                ?>
                                <li class="collection-item avatar col s12" style="justify-content: space-around">
                                    <div class="col s12 l6"> <br>
                                        <i class="material-icons circle" style="background-color: #00C2EE">group_add</i>
                                        <span class="title"><b>Tipo de personal: </b> <?php echo $descripcion; ?></span>
                                        <br>  <span class="title"><b>Personal contratado: </b> <?php echo $max_personal_permitido; ?></span>
                                        <br>                                  
                                        <span class="title" style="display: flex;"><b>Disponible: </b> 
                                            <input id="disponibilidad_personal_<?php echo $id_personal; ?>"
                                                   readonly
                                                   style="margin-top: -.8rem;margin-bottom: 0px;color: black;border: none"
                                                   disabled
                                                   value="<?php echo $disponibilidad < 0 ? 0 : $disponibilidad; ?>"> 
                                        </span>                                         
                                        <span class="title">
                                            <b>Cantidad para el evento: </b>
                                            <input readonly
                                                   autocomplete="off"
                                                   placeholder="Cantidad"
                                                   onkeypress="return validar_solo_numeros(event, this.id, 2)"
                                                   id="tipo_personal_cantidad_<?php echo $personal_index; ?>"
                                                   value="<?php echo $cantidad; ?>">
                                        </span>  
                                    </div>                                                                     
                                    <div id="caja_btn_actualizar_personal_<?php echo $personal_index; ?>" hidden>
                                        <button class="waves-effect waves-light btn b-azul white-text col s6" 
                                                id="btn_actualizar_personal_<?php echo $personal_index; ?>"
                                                onclick="actualizar_personal(<?php echo $id_montaje; ?>,<?php echo $id_personal; ?>, 'tipo_personal_cantidad_<?php echo $personal_index; ?>', 'disponibilidad_personal_<?php echo $id_personal; ?>',<?php echo $n_ensayo; ?>,<?php echo $max_personal_permitido; ?>);"
                                                type="button" style="background-color: #00C2EE;float: none">Asignar
                                            <i class="material-icons right">save</i>
                                        </button>
                                    </div>
                                    <span class="col s12"><br></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php if ($id_privilegio == 3): ?>
                            <div class="input-field col s12">
                                <div style="text-align: center">
                                    <button class="waves-effect waves-light btn green accent-4 white-text col s12 l4" 
                                            onclick='consultar_disponibilidad_personal(<?php echo $id_montaje; ?>);habilitar_personal(<?php echo json_encode($id_personal_coleccion) ?>, <?php echo $personal_index; ?>);'  
                                            id="btn_edicion_equipo_tecnico"type="button" style="background-color: #00C2EE;float: none">Alterar personal                   
                                        <i class="material-icons right">edit</i>
                                    </button>
                                </div>
                            </div>
                            <?php
                        endif;
                    endif;
                    $counter = 0;
                    $id_ensayo_coleccion = array();
                    $ensayos = $control->consulta_ensayo($id_montaje);
                    while ($row = mysqli_fetch_array($ensayos)):
                        $counter++;
                        $requerimientos_especiales_ensayo = $row[3];
                        $n_ensayo = $row[4];
                        $id_ensayo = $row[5];
                        array_push($id_ensayo_coleccion, $id_ensayo);
                        ?>
                        <div class="col s12 card">
                            <div class="card-content" style="color:#00C2EE;">
                                <h5>Ensayo N° <?php echo $counter; ?></h5>
                            </div>
                            <div class="card-tabs">
                                <ul class="tabs tabs-fixed-width">
                                    <li class="tab blue white-text active"><a href="#tab_1_<?php echo $counter; ?>">Información de ensayo</a></li>
                                    <li class="tab blue white-text" ><a href="#tab_2_<?php echo $counter; ?>">Personal</a> </li>
                                </ul>
                            </div>
                            <div class="card-content">
                                <div id="tab_1_<?php echo $counter; ?>">
                                    <div class="col s12 l6">
                                        <label style="margin-left: 1rem;color:#00C2EE">Fecha del ensayo</label>
                                        <div class="input-field"> 
                                            <i class="material-icons prefix c-azul">calendar_today</i>
                                            <input type="text" 
                                                   class="datepicker"
                                                   id="calendario_ensayo_<?php echo $id_ensayo; ?>"
                                                   style="font-size: 1rem" 
                                                   value="<?php echo $row[0]; ?>" 
                                                   onchange="fecha_minusculas(this.value, 'calendario_ensayo_<?php echo $id_ensayo; ?>');
                                                           consulta_disponibilidad_lugar_ensayo('hora_inicial_ensayo_<?php echo $id_ensayo; ?>', 'hora_final_ensayo_<?php echo $id_ensayo; ?>', <?php echo $id_lugar; ?>, this.id, <?php echo $id_montaje; ?>, this);"
                                                   readonly> 
                                        </div>
                                    </div>
                                    <div class="col s12 l6">
                                        <label style="margin-left: 1rem;color:#00C2EE">Horario inicial</label>
                                        <div class="input-field">
                                            <i class="material-icons prefix c-azul">access_time</i>
                                            <input class="timepicker" 
                                                   type="text" 
                                                   id="hora_inicial_ensayo_<?php echo $id_ensayo; ?>"
                                                   style="font-size: 1rem" 
                                                   value="<?php echo $row[1]; ?>" 
                                                   onchange="consulta_disponibilidad_lugar_ensayo(this.id, 'hora_final_ensayo_<?php echo $id_ensayo; ?>', <?php echo $id_lugar; ?>, 'calendario_ensayo_<?php echo $id_ensayo; ?>', <?php echo $id_montaje; ?>, this);"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col s12 l6">
                                        <label style="margin-left: 1rem;color:#00C2EE">Horario final</label>
                                        <div class="input-field">
                                            <i class="material-icons prefix c-azul">access_time</i>
                                            <input class="timepicker" 
                                                   type="text" 
                                                   id="hora_final_ensayo_<?php echo $id_ensayo; ?>"
                                                   style="font-size: 1rem" 
                                                   value="<?php echo $row[2]; ?>" 
                                                   onchange="consulta_disponibilidad_lugar_ensayo('hora_inicial_ensayo_<?php echo $id_ensayo; ?>', this.id, <?php echo $id_lugar; ?>, 'calendario_ensayo_<?php echo $id_ensayo; ?>', <?php echo $id_montaje; ?>, this);"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="input-field col s12"> 
                                        <i class="material-icons prefix c-azul">list_alt</i>
                                        <textarea class="materialize-textarea" 
                                                  readonly
                                                  id="requerimientos_especiales_ensayo_<?php echo $id_ensayo; ?>"></textarea>
                                    </div>
                                </div>
                                <div id="tab_2_<?php echo $counter; ?>">
                                    <?php
                                    $personal = $control->consulta_personal_ensayo($id_montaje, $n_ensayo);
                                    $personal_ensayo_index = 0;
                                    $id_personal_coleccion_ensayo = array();
                                    while ($row_personal = mysqli_fetch_array($personal)) :
                                        $personal_ensayo_index++;
                                        $id_personal_ensayo = $row_personal[2];
                                        array_push($id_personal_coleccion_ensayo, $id_personal_ensayo);
                                        ?>                                 
                                        <div class="input-field col s12 l6">
                                            <i class="material-icons prefix c-azul">build</i>
                                            <select class="personal_ensayo_<?php echo $id_personal_ensayo; ?>" id="personal_ensayo_<?php echo $personal_ensayo_index; ?>" readonly>
                                                <option value="<?php echo $row_personal[1]; ?>" selected><?php echo $row_personal[1]; ?></option>
                                            </select>
                                            <label style="margin-left: 1rem;color:#00C2EE"><?php echo $row_personal[0]; ?></label> 
                                        </div>                    
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <script>
                                $("#requerimientos_especiales_ensayo_<?php echo $id_ensayo; ?>").val("<?php echo $requerimientos_especiales_ensayo; ?>");
                                M.textareaAutoResize($('textarea'));
                                $('.tabs').tabs();
                            </script>
                            <?php if ($id_privilegio == 3): ?>
                                <div class="input-field col s12">
                                    <div style="text-align: center">
                                        <a class="waves-effect waves-light col s12 l4" 
                                           href="#!"
                                           onclick="habilitar_ensayo(<?php echo $id_ensayo; ?>, <?php echo $personal_ensayo_index; ?>);
                                                   consultar_disponibilidad_personal_ensayo('hora_inicial_ensayo_<?php echo $id_ensayo; ?>', 'hora_final_ensayo_<?php echo $id_ensayo; ?>', 'calendario_ensayo_<?php echo $id_ensayo; ?>');"  
                                           id="btn_actualizar_ensayo_<?php echo $id_ensayo; ?>"
                                           style="float: none">
                                            <img src='../../../images/Editar.svg' style="width: 80px;">
                                        </a>
                                        &nbsp;&nbsp; 
                                        <span id="caja_btn_enviar_ensayo_<?php echo $id_ensayo; ?>" hidden>                                                                                            
                                            <button class="waves-effect waves-light btn green accent-4 white-text col s12 l4" 
                                                    id="btn_enviar_ensayo_<?php echo $id_ensayo; ?>"
                                                    type="button" 
                                                    onclick='actualizar_ensayo(<?php echo $id_ensayo; ?>, "calendario_ensayo_<?php echo $id_ensayo; ?>", "hora_inicial_ensayo_<?php echo $id_ensayo; ?>", "hora_final_ensayo_<?php echo $id_ensayo; ?>", "requerimientos_especiales_ensayo_<?php echo $id_ensayo; ?>", <?php echo json_encode($id_personal_coleccion_ensayo); ?>, <?php echo $n_ensayo; ?>, <?php echo $id_montaje; ?>)' 
                                                    style="background-color: #00C2EE;float: none">Actualizar
                                                <i class="material-icons right">save</i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>

                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">list_alt</i>
                        <textarea class="materialize-textarea"
                                  readonly
                                  id="requerimientos_especiales"
                                  onkeyup="capitaliza_primer_letra('requerimientos_especiales')"
                                  placeholder="Requerimientos especiales"></textarea> 
                        <label style="margin-left: 1rem">Requerimientos especiales</label>
                    </div>
                    <?php if ($id_privilegio == 3): ?>
                        <div class="input-field col s12">
                            <div style="text-align: center">
                                <button class="waves-effect waves-light btn b-azul white-text col s12 l4" 
                                        id="btn_enviar_formulario"
                                        type="button" 
                                        onclick="actualizar_montaje('<?php echo $id_montaje; ?>')"
                                        style="background-color: #00C2EE;float: none">Actualizar
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

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

<div id="modal_recuerde_rentar" class="modal bottom-sheet">
    <div class="modal-content">
        <h4 class="c-azul">Recuerde</h4>
        <p>El inventario disponible actual ha sido sobrepasado, recuerde rentar el número de artículos faltantes.</p>
    </div>
    <div class="modal-footer">
        <a href="#!"
           class="modal-close waves-effect waves-light btn-flat green accent-4 c-blanco">Aceptar</a>
    </div>
</div>


<div id="modal_estatus" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma que desea realizar esta acción?</p>
        <input hidden id="input_id" value="">
        <input hidden id="input_estatus" value="">
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat white-text" style="background-color: #EF4545">Cancelar</a>    
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="actualizar_estatus()">Aceptar</a>
    </div>        
    <br>    
</div>

<script>
    //campos    
    var tipo_montaje = $("#tipo_montaje");
    var hora_inicial = $("#hora_inicial");
    var hora_final = $("#hora_final");
    var fecha_montaje = $("#fecha_montaje");
    var tipo_repliegue = $("#tipo_repliegue");
    var nombre = $("#nombre");
    var responsable = $("#responsable");
    var cantidad_invitados = $("#cantidad_invitados");
    var estacionamiento = $("#estacionamiento");
    var requerimientos_especiales = $("#requerimientos_especiales");
    //selects
    var select_tipo_montaje = ['Auditorio', 'Escuela &quot;mesa con silla&quot;', 'Herradura &quot;una mesa varias sillas&quot;', 'Otros'];
    var select_tipo_montaje_option_selected = '<?php echo $tipo_montaje; ?>';
    //valida opcion de repliegue escogida
    var select_repliegue = ['Estacionamiento maestros', 'Patio de camiones 1/2', 'Patio de completo'];
    var select_repliege_option_selected = '<?php echo $tipo_repliegue; ?>';
    //coleccion de montajes
    var id_montaje_coleccion = null;
    var id_manteles_coleccion = null;
    var id_equipo_tecnico_coleccion = null;
    var id_personal_coleccion = null;
    var id_personal_ensayo_coleccion = [];
    var mobiliario_index = null;
    var manteles_index = null;
    var equipo_tecnico_index = null;
    var personal_index = null;
    $(document).ready(function () {
        $('.modal').modal();
        $("#requerimientos_especiales").val('<?php echo $requerimientos_especiales; ?>');
        M.textareaAutoResize($('textarea'));
        $('.dropdown-trigger').dropdown();
        $("#loading").fadeOut("slow");
        $("select").formSelect();
        //horario        
        $('.timepicker').timepicker({
            'step': 60,
            'minTime': '00:00',
            'maxTime': '23:59',
            'timeFormat': 'H:i:s'
        });
        //$("#disponible_mobiliario_1").text("aaaaaa");
        $('.tooltipped').tooltip();
    });

    function mostrar_modal_estatus(id, estatus) {
        var instance = M.Modal.getInstance($("#modal_estatus"));
        instance.open();
        $("#input_id").val(id);
        $("#input_estatus").val(estatus);
    }
    function actualizar_estatus() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_estatus.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {id: $("#input_id").val(), estatus: $("#input_estatus").val()}
        }).done((res) => {
            if (res) {
                window.location.reload();
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function habilitar_edicion() {
        tipo_montaje.prop("readonly", false);
        var option_tipo_montaje = '';
        for (var item in select_tipo_montaje) {
            if (select_tipo_montaje_option_selected !== select_tipo_montaje[item]) {
                option_tipo_montaje += `<option value ='${select_tipo_montaje[item]}'>${select_tipo_montaje[item]}</option>`;
            }
        }
        tipo_montaje.append(option_tipo_montaje);
        $("select").formSelect();
        hora_inicial.prop("readonly", false);
        hora_final.prop("readonly", false);
        //select del repliegue
        tipo_repliegue.prop("readonly", false);
        var option_tipo_repliegue = '';
        for (var item in select_repliegue) {
            if (select_repliege_option_selected !== select_repliegue[item]) {
                option_tipo_repliegue += `<option value ='${select_repliegue[item]}'>${select_repliegue[item]}</option>`;
            }
        }
        tipo_repliegue.append(option_tipo_repliegue);
        $("select").formSelect();
        nombre.prop("readonly", false);
        responsable.prop("readonly", false);
        cantidad_invitados.prop("readonly", false);
        estacionamiento.prop("readonly", false);
        requerimientos_especiales.prop("readonly", false);
        tipo_montaje.focus();
        M.toast({
            html: 'Ahora es posible editar el formulario',
            classes: 'green accent-4 c-blanco'
        });
    }
    function actualizar_montaje(id_montaje) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_actualiza_montaje.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
                $("#btn_enviar_formulario").prop("disabled", true);
            },
            data: {
                id: id_montaje,
                tipo_montaje: tipo_montaje.val(),
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val(),
                tipo_repliegue: tipo_repliegue.val(),
                nombre: nombre.val(),
                responsable: responsable.val(),
                cantidad_invitados: cantidad_invitados.val(),
                estacionamiento: estacionamiento.val(),
                requerimientos_especiales: requerimientos_especiales.val()
            }
        }).done((res) => {
            if (res) {
                M.toast({
                    html: '¡Solicitud exitosa!',
                    classes: 'green accent-4 c-blanco'
                });
                setInterval(() => {
                    window.location.reload();
                }, 2000);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function calcular_parking(el) {
        var value = el.value;
        $("#estacionamiento").val(parseInt(value * .6));
    }
    function obtener_fecha() {
        return formatear_fecha_calendario_formato_a_m_d_guion(fecha_montaje.val());
    }
    function consulta_disponibilidad_lugar(id_lugar, id, id_evento) {
        var fecha_montaje = obtener_fecha();
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
                horario_evento: hora_inicial.val(),
                horario_final_evento: hora_final.val(),
                edicion_montaje: true,
                id_evento: id_evento
            }
        }).done((res) => {
            if (parseInt(res) > 0) {
                M.toast({
                    html: '¡El lugar seleccionado ha sido ocupado con anterioridad!',
                    classes: 'deep-orange c-blanco'
                });
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function habilitar_mobiliario(_id_montaje_coleccion, _mobiliario_index) {
        id_montaje_coleccion = _id_montaje_coleccion;
        mobiliario_index = _mobiliario_index;
        for (var i = 1; i <= mobiliario_index; i++) {
            if ($(`#articulo_mobiliario_cantidad_${i}`).prop("readonly")) {
                $(`#articulo_mobiliario_cantidad_${i}`).prop("readonly", false);
                $(`#caja_btn_actualizar_mobiliario_${i}`).fadeIn();
                $(`#articulo_mobiliario_cantidad_1`).select();
            } else {
                $(`#articulo_mobiliario_cantidad_${i}`).prop("readonly", true);
                $(`#caja_btn_actualizar_mobiliario_${i}`).fadeOut();
            }
        }
    }
    function actualizar_mobiliario(id_articulo, id_montaje, max_cantidad, id_inputcantidad,
            capacidad_lugar, id_disponibilidad_mobiliario) {
        var cantidad = $("#" + id_inputcantidad).val();

        if (!validaciones_edicion(max_cantidad, cantidad, capacidad_lugar, id_inputcantidad))
            return;

        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_edicion_mobiliario.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                id_montaje: id_montaje,
                id_articulo: id_articulo,
                cantidad: cantidad,
                fecha_montaje_simple: obtener_fecha(),
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val()
            }
        }).done((res) => {
            if (res) {
                consultar_disponibilidad_mobiliario(id_montaje);
                M.toast({
                    html: '¡Artículo asignado correctamente!',
                    classes: 'green accent-4 c-blanco'
                });
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function consultar_disponibilidad_mobiliario(id_montaje) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_consulta_mobiliario.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                mobiliario: true,
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val(),
                fecha_consulta: obtener_fecha(),
                id_montaje: id_montaje
            }
        }).done((res) => {
            if (res) {
                var flag_debe_rentar = false;
                for (var item in res) {
                    if ($(`#disponibilidad_articulo_${res[item].id_articulo}`).length > 0) {
                        $(`#disponibilidad_articulo_${res[item].id_articulo}`).val(res[item].disponibilidad);
                        if (res[item].disponibilidad < 0) {
                            flag_debe_rentar = true;
                        }
                    }
                }
                if (flag_debe_rentar) {
                    var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
                    modal_recuerde_rentar.open();
                }
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function habilitar_manteles(_id_manteles_coleccion, _manteles_index) {
        id_manteles_coleccion = _id_manteles_coleccion;
        manteles_index = _manteles_index;
        for (var i = 1; i <= _manteles_index; i++) {
            if ($(`#articulo_mantel_cantidad_${i}`).prop("readonly")) {
                $(`#articulo_mantel_cantidad_${i}`).prop("readonly", false);
                $(`#caja_btn_actualizar_manteles_${i}`).fadeIn();
                $(`#articulo_mantel_cantidad_1`).select();
            } else {
                $(`#articulo_mantel_cantidad_${i}`).prop("readonly", true);
                $(`#caja_btn_actualizar_manteles_${i}`).fadeOut();
            }
        }
    }
    function consultar_disponibilidad_manteles(id_montaje) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_consulta_mobiliario.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                manteles: true,
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val(),
                fecha_consulta: obtener_fecha(),
                id_montaje: id_montaje
            }
        }).done((res) => {
            if (res) {
                for (var item in res) {
                    var flag_debe_rentar = false;
                    if ($(`#disponibilidad_articulo_mantel_${res[item].id_articulo}`).length > 0) {
                        $(`#disponibilidad_articulo_mantel_${res[item].id_articulo}`).val(res[item].disponibilidad);
                        if (res[item].disponibilidad < 0)
                            flag_debe_rentar = true;
                    }
                }
                if (flag_debe_rentar) {
                    var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
                    modal_recuerde_rentar.open();
                }

            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function validaciones_edicion(max_cantidad, cantidad, capacidad_lugar, id_inputcantidad) {
        if (cantidad > capacidad_lugar) {
            M.toast({
                html: '¡La cantidad asignada no debe ser mayor a la capacidad del lugar!',
                classes: 'deep-orange c-blanco'
            });
            $("#" + id_inputcantidad).val(max_cantidad).select();
            return false;
        }
        return true;
    }
    function actualizar_mantel(id_montaje, id_mantel, cantidad_asignada, id_inputcantidad, capacidad_lugar, id_disponibilidad) {
        if (!validar(cantidad_asignada, id_inputcantidad, capacidad_lugar, id_disponibilidad))
            return;
        var cantidad = $("#" + id_inputcantidad).val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_edicion_manteles.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                id_montaje: id_montaje,
                id_mantel: id_mantel,
                cantidad: cantidad,
                fecha_montaje_simple: obtener_fecha(),
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val()
            }
        }).done((res) => {
            if (res) {
                consultar_disponibilidad_manteles(id_montaje);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
        //cantidad, id, capacidad del lugar
    }
    function habilitar_equipo_tecnico(_id_equipo_tecnico_coleccion, _equipo_tecnico_index) {
        id_equipo_tecnico_coleccion = _id_equipo_tecnico_coleccion;
        equipo_tecnico_index = _equipo_tecnico_index;
        for (var i = 1; i <= _equipo_tecnico_index; i++) {
            if ($(`#articulo_equipo_tecnico_cantidad_${i}`).prop("readonly")) {
                $(`#articulo_equipo_tecnico_cantidad_${i}`).prop("readonly", false);
                $(`#caja_btn_actualizar_equipo_tecnico_${i}`).fadeIn();
                $(`#articulo_equipo_tecnico_cantidad_1`).select();
            } else {
                $(`#articulo_equipo_tecnico_cantidad_${i}`).prop("readonly", true);
                $(`#caja_btn_actualizar_equipo_tecnico_${i}`).fadeOut();
            }
        }
    }
    function consultar_disponibilidad_equipo_tecnico(id_montaje) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_consulta_mobiliario.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                equipo_tecnico: true,
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val(),
                fecha_consulta: obtener_fecha(),
                id_montaje: id_montaje
            }
        }).done((res) => {
            if (res) {
                var flag_debe_rentar = false;
                for (var item in res) {
                    if ($(`#disponibilidad_articulo_equipo_tecnico_${res[item].id_articulo}`).length > 0) {
                        $(`#disponibilidad_articulo_equipo_tecnico_${res[item].id_articulo}`).val(res[item].disponibilidad);
                        if (res[item].disponibilidad < 0)
                            flag_debe_rentar = true;
                    }
                }
                if (flag_debe_rentar) {
                    var modal_recuerde_rentar = M.Modal.getInstance($("#modal_recuerde_rentar"));
                    modal_recuerde_rentar.open();
                }
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function validar(cantidad_asignada, id_inputcantidad, capacidad_lugar, id_disponibilidad) {
        var cantidad = $("#" + id_inputcantidad).val();
        if (capacidad_lugar < cantidad) {
            M.toast({
                html: '¡La cantidad asignada no debe ser mayor a la capacidad del lugar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }
    function actualizar_equipo_tecnico(id_montaje, id_articulo, cantidad_asignada, id_inputcantidad,
            capacidad_lugar, id_disponibilidad) {
        if (!validar(cantidad_asignada, id_inputcantidad, capacidad_lugar, id_disponibilidad))
            return;
        var cantidad = $("#" + id_inputcantidad).val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_edicion_equipo_tecnico.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                id_montaje: id_montaje,
                id_articulo: id_articulo,
                cantidad: cantidad,
                fecha_montaje_simple: obtener_fecha(),
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val()
            }
        }).done((res) => {
            if (res) {
                consultar_disponibilidad_equipo_tecnico(id_montaje);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function habilitar_personal(_id_personal_coleccion, _personal_index) {
        id_personal_coleccion = _id_personal_coleccion;
        personal_index = _personal_index;
        for (var i = 1; i <= _personal_index; i++) {
            if ($(`#tipo_personal_cantidad_${i}`).prop("readonly")) {
                $(`#tipo_personal_cantidad_${i}`).prop("readonly", false);
                $(`#caja_btn_actualizar_personal_${i}`).fadeIn();
                $(`#tipo_personal_cantidad_1`).select();
            } else {
                $(`#tipo_personal_cantidad_${i}`).prop("readonly", true);
                $(`#caja_btn_actualizar_personal_${i}`).fadeOut();
            }
        }
    }
    function consultar_disponibilidad_personal() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_consulta_mobiliario.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                personal: true,
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val(),
                fecha_consulta: obtener_fecha()
            }
        }).done((res) => {
            if (res) {
                for (var item in res) {
                    if ($(`#disponibilidad_personal_${res[item].id_personal}`).length > 0) {
                        $(`#disponibilidad_personal_${res[item].id_personal}`).val(res[item].disponibilidad);
                    }
                }
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function actualizar_personal(id_montaje, id_personal, id_inputcantidad, id_disponibilidad, n_ensayo, max_personal_permitido) {
        var disponibilidad = $("#" + id_disponibilidad).val();
        var cantidad = $("#" + id_inputcantidad).val();
        if ((cantidad + disponibilidad) > (max_personal_permitido + disponibilidad)) {
            M.toast({
                html: '¡El personal asignado supera el personal contratado!',
                classes: 'deep-orange c-blanco'
            });
            return;
        }
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_edicion_personal.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                id_montaje: id_montaje,
                id_personal: id_personal,
                cantidad: cantidad,
                n_ensayo: n_ensayo,
                fecha_montaje_simple: obtener_fecha(),
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val()
            }
        }).done((res) => {
            if (res) {
                consultar_disponibilidad_personal();
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function habilitar_ensayo(id_ensayo, personal_ensayo_index) {
        $('.timepicker').timepicker({
            'step': 60,
            'minTime': '00:00',
            'maxTime': '23:59',
            'timeFormat': 'H:i:s'
        });
        $("#calendario_ensayo_" + id_ensayo).prop("readonly", false).focus();
        $("#hora_inicial_ensayo_" + id_ensayo).prop("readonly", false);
        $("#hora_final_ensayo_" + id_ensayo).prop("readonly", false);
        $("#requerimientos_especiales_ensayo_" + id_ensayo).prop("readonly", false);
        for (var i = 1; i <= personal_ensayo_index; i++) {
            $("#personal_ensayo_" + i).prop("readonly", false);
        }
        if ($("#caja_btn_enviar_ensayo_" + id_ensayo).prop("hidden")) {
            $("#calendario_ensayo_" + id_ensayo).prop("disabled", false);
            $("#caja_btn_enviar_ensayo_" + id_ensayo).prop("hidden", false);
            M.toast({
                html: 'Ahora es posible editar el ensayo',
                classes: 'green accent-4 c-blanco'
            });
            //obtiene el calendario escolar en db
            var calendario_escolar = obtener_calendario_escolar();
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
                min: new Date()
            });
        } else {
            $("#caja_btn_enviar_ensayo_" + id_ensayo).prop("hidden", true);
            $("#calendario_ensayo_" + id_ensayo).prop("readonly", true);
            $("#hora_inicial_ensayo_" + id_ensayo).prop("readonly", true);
            $("#hora_final_ensayo_" + id_ensayo).prop("readonly", true);
            $("#requerimientos_especiales_ensayo_" + id_ensayo).prop("readonly", true);
            $("#calendario_ensayo_" + id_ensayo).prop("disabled", true);
        }
    }
    function consulta_disponibilidad_lugar_ensayo(id_hora_inicial, id_hora_final, id_lugar, id_fecha_montaje,
            id_evento, el) {
        var fecha_montaje = formatear_fecha_calendario_formato_a_m_d_guion($("#" + id_fecha_montaje).val());
        var horario_evento = $("#" + id_hora_inicial).val();
        var horario_final_evento = $("#" + id_hora_final).val();

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
                horario_final_evento: horario_final_evento,
                edicion_montaje: true,
                id_evento: id_evento
            }
        }).done((res) => {
            if (parseInt(res) > 0) {
                M.toast({
                    html: '¡El lugar seleccionado ha sido ocupado con anterioridad!',
                    classes: 'deep-orange c-blanco'
                });
                el.value = el.defaultValue;
                el.focus();
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function consultar_disponibilidad_personal_ensayo(id_hora_inicial, id_hora_final, id_fecha_consulta) {
        var hora_inicial = $("#" + id_hora_inicial);
        var hora_final = $("#" + id_hora_final);
        var fecha_consulta = formatear_fecha_calendario_formato_m_d_a($("#" + id_fecha_consulta).val());
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/get_consulta_mobiliario.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                personal: true,
                hora_inicial: hora_inicial.val(),
                hora_final: hora_final.val(),
                fecha_consulta: fecha_consulta
            }
        }).done((res) => {
            if (res) {
                for (var item in res) {
                    if ($(`.personal_ensayo_${res[item].id_personal}`).length > 0) {
                        var options = "";
                        $(`.personal_ensayo_${res[item].id_personal}`).html('');
                        for (var i = 1; i <= res[item].disponibilidad; i++) {
                            options += `<option value="${i}">${i}</option>`;
                        }
                        $(`.personal_ensayo_${res[item].id_personal}`).html(options);
                        $("select").formSelect();
                    }
                }
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
    function actualizar_ensayo(id_ensayo, id_fecha_ensayo, id_hora_inicial_ensayo, id_hora_final_ensayo,
            id_requerimientos_ensayo, id_tipo_personal_conleccion, n_ensayo, id_montaje) {
        var fecha_ensayo = $("#" + id_fecha_ensayo);
        var hora_inicial_ensayo = $("#" + id_hora_inicial_ensayo);
        var hora_final_ensayo = $("#" + id_hora_final_ensayo);
        var requerimientos_ensayo = $("#" + id_requerimientos_ensayo);
        var id_tipo_personal_conleccion_ensayo = id_tipo_personal_conleccion;
        var cantidad_personal = [];

        for (var item in id_tipo_personal_conleccion_ensayo) {
            var id = id_tipo_personal_conleccion_ensayo[item];
            if ($(".personal_ensayo_" + id).length > 0) {
                cantidad_personal.push({id: id, cantidad: $(".personal_ensayo_" + id).val()});
            }
        }

        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_edicion_ensayo.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {
                fecha_ensayo_formateada: formatear_fecha_calendario_formato_a_m_d_guion(fecha_ensayo.val()),
                fecha_ensayo: fecha_ensayo.val(),
                hora_inicial_ensayo: hora_inicial_ensayo.val(),
                hora_final_ensayo: hora_final_ensayo.val(),
                id_ensayo: id_ensayo,
                requerimientos_ensayo: requerimientos_ensayo.val(),
                cantidad_personal: cantidad_personal,
                n_ensayo: n_ensayo,
                id_montaje: id_montaje
            }
        }).done((res) => {
            if (res) {
                M.toast({
                    html: '¡Solicitud exitosa!',
                    classes: 'green accent-4 c-blanco'
                });
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
</script>
<?php include "$root_icloud/components/layout_bottom.php"; ?>