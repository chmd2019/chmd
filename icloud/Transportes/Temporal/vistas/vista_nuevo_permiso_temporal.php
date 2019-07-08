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
                <br>
                <br>
                <h5 class="center-align c-azul">Nuevo permiso temporal</h5>
                <br>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <label for="fecha_solicitud_permiso_temporal" style="margin-left: 1rem">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" readonly  id="fecha_solicitud_permiso_temporal" style="font-size: 1rem" type="text" />               
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <label for="solicitante_permiso_temporal" style="margin-left: 1rem">Solicitante</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $nombre; ?>" readonly  id="solicitante_permiso_temporal" style="font-size: 1rem" type="text" />               
                        </div>
                    </div>    
                    <br>
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
                                    <i class="material-icons prefix c-azul">school</i>
                                    <textarea class="materialize-textarea"
                                              readonly  
                                              id="nombre_nuevo_permiso_temporal_<?php echo $counter; ?>"
                                              style="font-size: 1rem"></textarea>
                                </div>
                                <div class="switch col s12">
                                    <label class="checks-alumnos">
                                        <input type="checkbox" 
                                               id="alumno_permiso_temporal_<?php echo $counter; ?>" 
                                               value="<?php echo $cliente1['id']; ?>"/>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                                <br>
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
                    <br>
                    <h5 class="center-align c-azul">Dirección de Casa</h5>
                    <br>
                    <div class="col s12">
                        <label for="calle_guardada_nuevo" style="margin-left: 1rem">Calle y Número</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="calle_guardada_temporal" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                        <br>
                        <label for="colonia_guardada_nuevo" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="colonia_guardada_temporal"
                                      style="font-size: .9rem"></textarea>      
                        </div>
                        <br>
                        <label for="cp_guardada_temporal" style="margin-left: 1rem">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  
                                   id="cp_guardada_temporal"
                                   style="font-size: .9rem"
                                   value=""/>       
                        </div>
                    </div>                
                    <br>
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <select id="reside" class="input-field" onchange="cambiar_direccion('<?php echo $id; ?>')">
                        </select>
                        <label style="margin-left: 1rem">Dirección Guardada</label>
                    </div>
                    <div class="input-field col s12">
                        <label for="calle_nuevo_permiso_temporal" style="margin-left: 1rem">Calle y Número</label>
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <textarea id="calle_nuevo_permiso_temporal" 
                                  class="materialize-textarea"                                
                                  placeholder="INGRESE CALLE Y NUMERO"></textarea> 
                    </div>
                    <div class="input-field col s12">
                        <label for="colonia_nuevo_permiso_temporal " style="margin-left: 1rem">Colonia</label>
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <textarea class="materialize-textarea"  
                                  id="colonia_nuevo_permiso_temporal" 
                                  placeholder="INGRESE COLONIA"></textarea> 
                    </div>                    
                    <div class="input-field col s12">
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
                                   placeholder="Descripción de la dirección"
                                   autocomplete="off" />
                            <button type="button" class="btn waves-effect waves-light white-text b-azul w-100" onclick="enviar_direccion()">Guardar</button>
                        </div>
                    </div>  
                    <br>
                    <h5 class="center-align c-azul">Datos de responsable</h5>
                    <div class="input-field col s12">
                        <label for="nombre_nuevo_permiso_temporal " style="margin-left: 1rem">Nombre</label>
                        <i class="material-icons c-azul">person</i>
                        <textarea id="nombre_nuevo_permiso_temporal" 
                                  class="materialize-textarea"                                
                                  placeholder="Obligatorio"></textarea>    
                    </div>
                    <div>
                        <div class="input-field col s12 l6">
                            <label for="parentesco_nuevo_permiso_temporal " style="margin-left: 1rem">Parentesco</label>
                            <i class="material-icons c-azul">people</i>
                            <input 
                                placeholder="Obligatorio" 
                                id="parentesco_nuevo_permiso_temporal" 
                                type="text" 
                                autocomplete="off"/>
                        </div>
                        <div class="input-field col s12 l6">
                            <label for="celular_nuevo_permiso_temporal " style="margin-left: 1rem">Celular</label>
                            <i class="material-icons c-azul">smartphone</i>
                            <input placeholder="Agrega 10 dígitos" 
                                   autocomplete="off"
                                   id="celular_nuevo_permiso_temporal" 
                                   type="tel"
                                   onkeypress="return validar_solo_numeros_max(event)">
                        </div>
                        <div class="input-field col s12 l6">
                            <label for="telefono_nuevo_permiso_temporal " style="margin-left: 1rem">Teléfono</label>
                            <i class="material-icons c-azul">phone_in_talk</i>
                            <input placeholder="Agrega 8 dígitos" 
                                   autocomplete="off"
                                   id="telefono_nuevo_permiso_temporal" 
                                   type="tel"
                                   onkeypress="return validar_solo_numeros_max(event)">
                        </div>  
                    </div>
                    <br>
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
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">departure_board</i>
                        <select class="input-field" id="ruta_nuevo_permiso_temporal" >
                            <option value="">Selecciona opción</option>
                            <option value="Mañana">Mañana</option> 
                            <option value="Tarde">Tarde</option> 
                            <option value="Mañana-Tarde">Mañana-Tarde</option> 
                        </select>
                        <label>Ruta</label>
                    </div> 
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">comment</i>
                        <textarea id="comentarios_nuevo_permiso_temporal" 
                                  class="materialize-textarea"                                
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

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
        href="<?php echo $redirect_uri?>Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>">
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
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_temporal");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            swal("Error en colonia", "Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres", "error");
            return false;
        }
        //valida DESCRIPCION*
        var descripcion = $("#descripcion_recordar_direccion");
        if (descripcion.val().length === 0) {
            swal("Error en descripción", "Agrega descripción", "error");
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
                    swal("Información", `Registro exitoso!, puedes seleccionar tu nueva dirección en la lista desplegable con la descripción ${data.descripcion}`, "success");
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
        swal("Información", "Debe llenar todos los campos!", "error");
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
            swal("Información", "Debes seleccionar al menos un alumno para continuar", "error");
            return false;
        }
        //valida calle y colonia
        //valida calle
        var calle = $("#calle_nuevo_permiso_temporal");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_temporal");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            swal("Error en colonia", "Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres", "error");
            return false;
        }
        //valida nombre*
        var nombre_nuevo_permiso_temporal = $("#nombre_nuevo_permiso_temporal");
        var regex_nombre_nuevo_permiso_temporal = "[A-Za-z ]{1,256}";
        if (!validar_regex(regex_nombre_nuevo_permiso_temporal, nombre_nuevo_permiso_temporal.val())) {
            swal("Error en nombre", "Agregue nombre sin acentos ni signos especiales", "error");
            return false;
        }
        //valida parentesco*
        var parentesco_nuevo_permiso_temporal = $("#parentesco_nuevo_permiso_temporal");
        var regex_parentesco_nuevo_permiso_temporal = "[A-Za-z ]{1,256}";
        if (!validar_regex(regex_parentesco_nuevo_permiso_temporal, parentesco_nuevo_permiso_temporal.val())) {
            swal("Error en parentesco", "Agregue parentesco sin acentos ni signos especiales", "error");
            return false;
        }
        //valida celular*
        var celular_nuevo_permiso_temporal = $("#celular_nuevo_permiso_temporal");
        if (celular_nuevo_permiso_temporal.val().length == 8 ||
                celular_nuevo_permiso_temporal.val().length == 10)
        {

        } else {
            swal("Error en celular", "Agregue celular con 8 o 10 dígitos", "error");
            return false;
        }
        //valida telefono
        var telefono_nuevo_permiso_temporal = $("#telefono_nuevo_permiso_temporal");
        if (telefono_nuevo_permiso_temporal.val().length !== 8) {
            swal("Error en teléfono", "Agregue teléfono con 8 dígitos", "error");
            return false;
        }
        //valida fechas
        if ($("#fecha_inicial_nuevo_permiso_temporal").val().length === 0) {
            swal("Información", "Debes seleccionar una fecha inicial válida", "error");
            return false;
        }
        if ($("#fecha_final_nuevo_permiso_temporal").val().length === 0) {
            swal("Información", "Debes seleccionar una fecha final válida", "error");
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
            swal("Error en fecha final", "La fecha final debe ser posterior a la fecha inicial", "error");
            return false;
        }
        //valida seleccion de ruta 
        if ($("#ruta_nuevo_permiso_temporal").val() === "") {
            swal("Información", "Debes seleccionar una ruta", "error");
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
            var responsable = $("#nombre_nuevo_permiso_temporal").val();
            var parentesco = $("#parentesco_nuevo_permiso_temporal").val();
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
                        swal("Información", "Registro exitoso!", "success");
                        setInterval(() => {
                            window.location = "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>";
                        }, 1500);
                    } else {
                        swal("Información", res, "error");
                        setInterval(() => {
                            location.reload();
                        }, 10000);
                    }
                }
            })
                    .always(function () {
                        $("#btn_enviar_formulario").prop("disabled", false);
                        setInterval(function () {
                            $("#loading").fadeOut("slow");
                        }, 1000);
                    });
            coleccion_ids = [];
        }
    }
</script>
<?php include "$root_icloud/Transportes/Temporal/modales/modal_informacion_importante_hora_limite.php"; ?>
<?php include "$root_icloud/components/layout_bottom.php"; ?>

