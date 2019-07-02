<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include "$root_icloud/Transportes/components/layout_top.php";
include "$root_icloud/Transportes/components/navbar.php";
session_start();
require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";
$idseccion = $_GET['idseccion'];
session_start();

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
    ?>
    <div class="caja-login" align="center">
        <h5 class="c-azul">Mi Maguen</h5>
        <?php echo '<a href="' . $authUrl . '"><img class = "logo-login" src="../../../images/google.png"/></a>' ?>
    </div>
    <?php
} else {
    $user = $service->userinfo->get(); //get user info
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->Acceso($correo);
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    $hora_limite = $date_helper->obtener_hora_limite();
    if ($hora_limite) {
        $fecha_disabled = date("m-d-Y");
        $msj_hora_limite = "- Seleccione desde la siguiente fecha disponible";
    }
    if ($consulta = mysqli_fetch_array($consulta)) {
        $id = $consulta[0];
        $correo = $consulta[1];
        $perfil = $consulta[2];
        $status = $consulta[3];
        $familia = str_pad($consulta[4], 4, 0, STR_PAD_LEFT);
        require_once '../../common/ControlTransportes.php';
        $control_temporal = new ControlTransportes();
        $domicilio = $control_temporal->mostrar_domicilio($familia);
        $domicilio = mysqli_fetch_array($domicilio);
        $papa = $domicilio[0];
        $calle = $domicilio[1];
        $colonia = $domicilio[2];
        $cp = $domicilio[3];
        $time = time();
        //manejo de fechas
        $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $arrayDias = array('Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado');
        ?>

        <div class="row">
            <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
                <br>
                <br>
                <h5 class="center-align c-azul">Nuevo permiso permanente</h5>
                <br>
                <div class="row" style="padding:0rem .5rem;">
                    <div class="col s12 l6">
                        <label for="fecha_solicitud_permiso_permanente" style="margin-left: 1rem">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input value="<?php echo $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" readonly  id="fecha_solicitud_permiso_permanente" style="font-size: 1rem" type="text" />               
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <label for="solicitante_permiso_permanente" style="margin-left: 1rem">Solicitante</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input value="<?php echo $correo; ?>" readonly  id="solicitante_permiso_permanente" style="font-size: 1rem" type="text" />               
                        </div>
                    </div>    
                    <br><div class="col s12">
                        <h5 class="c-azul text-center">Alumnos</h5>
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
                                              id="nombre_nuevo_permiso_permanente_<?php echo $counter; ?>"
                                              style="font-size: 1rem"></textarea>
                                </div>
                                <div class="switch col s12">
                                    <label class="checks-alumnos">
                                        <input type="checkbox" 
                                               id="alumno_permiso_permanente_<?php echo $counter; ?>" 
                                               value="<?php echo $cliente1['id']; ?>"/>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                                <br>
                                <input id="id_alumno_permiso_permanente_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                <br>
                                <br>
                                <script>
                                    $('#nombre_nuevo_permiso_permanente_<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                                    M.textareaAutoResize($('#nombre_nuevo_permiso_permanente_<?php echo $counter; ?>'));
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
                        <label for="calle_guardada_permanente" style="margin-left: 1rem">Calle y número</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="calle_guardada_permanente" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                        <br>
                        <label for="colonia_guardada_permanente" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="colonia_guardada_permanente"
                                      style="font-size: .9rem"></textarea>      
                        </div>
                        <br>
                        <label for="cp_guardada_permanente" style="margin-left: 1rem">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  
                                   id="cp_guardada_permanente"
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
                        <label style="margin-left: 1rem">Direcciones guardadas</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <textarea id="calle_nuevo_permiso_permanente" 
                                  class="materialize-textarea"                              
                                  placeholder="INGRESE CALLE Y NUMERO"></textarea>    
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <textarea class="materialize-textarea"  
                                  id="colonia_nuevo_permiso_permanente" 
                                  placeholder="INGRESE COLONIA"></textarea> 
                    </div>                 
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">person_pin_circle</i>
                        <input placeholder="INGRESE CP" 
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
                        <div class="input-field col s12">
                            <i class="material-icons prefix c-azul">store_mall_directory</i>
                            <input id="descripcion_recordar_direccion" 
                                   placeholder="Descripción de la dirección"
                                   autocomplete="off" />
                            <button type="button" class="btn waves-effect waves-light white-text b-azul w-100" onclick="enviar_direccion()">Guardar</button>
                        </div>
                    </div>  
                    <br>
                    <h5 class="center-align c-azul">Días de cambio</h5>
                    <br>
                    <div>
                        <div class="switch col s2" style="float:none;text-align: center;display: inline-block">
                            <label class="checks-alumnos-dias-cambio">
                                <input type="checkbox" 
                                       id="lunes" 
                                       value="lunes"/>
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
                    <br>
                    <div>
                        <div class="input-field col s12">
                            <i class="material-icons c-azul">departure_board</i>
                            <select class="input-field" id="ruta_nuevo_permiso_permanente" >
                                <option value="">Seleccione ruta</option>
                                <option value="General 2:50 PM">General 2:50 PM</option>
                                <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">comment</i>
                        <textarea id="comentarios_nuevo_permiso_permanente" 
                                  class="materialize-textarea"                                
                                  placeholder="Comentarios"></textarea>    
                    </div>
                    <br>
                    <div class="col s12 l6" style="float: none;margin: 0 auto;">
                        <button class="btn waves-effect waves-light b-azul white-text w-100" 
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

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul">
        <i class="large material-icons">edit</i>
    </a>
    <ul>
        <li>
            <a class="btn-floating blue" href="https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Permanente/PPermanente.php?idseccion=<?php echo $idseccion;?>">
                <i class="material-icons">keyboard_backspace</i>
            </a>
        </li>
        <?php
        echo '<li><a href="' . $redirect_uri . '?logout=1" class="btn-floating red" >'
        . "<i class='material-icons'>exit_to_app</i>Salir</a></li>";
        ?>
    </ul>
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
        $('#calle_guardada_permanente').val('<?php echo $calle; ?>');
        M.textareaAutoResize($('#calle_guardada_permanente'));
        $('#colonia_guardada_permanente').val('<?php echo $colonia; ?>');
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
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_permanente");
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
                "id_usuario":<?php echo $id; ?>
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
        var calle = $("#calle_nuevo_permiso_permanente");
        var regex_calle = "[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}";
        if (!validar_regex(regex_calle, calle.val())) {
            swal("Error en calle", "Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales", "error");
            return false;
        }
        //valida colonia*
        var colonia = $("#colonia_nuevo_permiso_permanente");
        var regex_colonia = "[A-Za-z ]{5,30}";
        if (!validar_regex(regex_colonia, colonia.val())) {
            swal("Error en colonia", "Agrega colonia sin acentos ni signos especiales, mínimo 5 y máximo 30 caracteres", "error");
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
            swal("Información", "Debes seleccionar al menos un día de cambio para continuar", "error");
            return false;
        }
        //valida seleccion de ruta 
        if ($("#ruta_nuevo_permiso_permanente").val() === "") {
            swal("Información", "Debes seleccionar una ruta", "error");
            return false;
        }
        return true;
    }
    function enviar_formulario(id, familia, tipo_permiso) {
        if (validar_formulario()) {
            //fecha solicitud, solicitante, fecha del permiso, nombre del alumno, alumnos, calle, colonia
            var calle_nuevo_permiso_permanente = $("#calle_nuevo_permiso_permanente").val();
            var colonia_nuevo_permiso_permanente = $("#colonia_nuevo_permiso_permanente").val();
            var cp = $("#cp").val();
            var responsable = $("#solicitante_permiso_permanente").val();
            var lunes = $("#lunes").prop("checked")? $("#lunes").val():"";
            var martes = $("#martes").prop("checked")? $("#martes").val():"";
            var miercoles = $("#miercoles").prop("checked")? $("#miercoles").val():"";
            var jueves = $("#jueves").prop("checked")? $("#jueves").val():"";
            var viernes = $("#viernes").prop("checked")? $("#viernes").val():"";
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
                idusuario:id,
                calle_numero:calle_nuevo_permiso_permanente,
                colonia:colonia_nuevo_permiso_permanente,
                cp:cp,
                lunes:lunes,
                martes:martes,
                miercoles:miercoles,
                jueves:jueves,
                viernes:viernes,
                ruta:ruta,
                comentarios:comentarios,
                nfamilia:familia,
                fecha_creacion:fecha_creacion,
                tipo_permiso:tipo_permiso,
                responsable:'<?php echo "$correo";?>',
                coleccion_ids: coleccion_ids,
            };
            $.ajax({
                url: "/pruebascd/icloud/Transportes/common/post_nuevo_permiso.php",
                type: "POST",
                data: model,
                beforeSend: function () {
                    $("#btn_enviar_formulario").prop("disabled",true);
                    $("#loading").fadeIn("slow");
                },
                success: function (res) {
                    if (res == 1) {
                        swal("Información", "Registro exitoso!", "success");
                        setInterval(() => {
                            window.location = "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Permanente/PPermanente.php?idseccion=<?php echo $idseccion;?>";
                        }, 1500);
                    } else {
                        swal("Información", res, "error");
                        setInterval(() => {
                            location.reload();
                        }, 10000);
                    }
                }
            }).always(function () {
                setInterval(function () {
                    $("#loading").fadeOut("slow");
                    $("#btn_enviar_formulario").prop("disabled",false);
                }, 1000);
            });;
            coleccion_ids = [];
        }}
</script>

<?php include "$root_icloud/Transportes/Permanente/modales/modal_informacion_importante_hora_limite.php"; ?>
<?php include_once "$root_icloud/Transportes/components/layout_bottom.php"; ?>