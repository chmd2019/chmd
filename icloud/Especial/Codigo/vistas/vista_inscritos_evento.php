<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require "$root_icloud/Especial/common/ControlEspecial.php";
require_once "$root_icloud/Helpers/DateHelper.php";

$control = new ControlEspecial();

$date_helper = new DateHelper();
$date_helper->set_timezone();

$codigo_invitacion = $_GET['codigo_evento'];
$volver_listado = $_GET['volver_listado'];

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
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    include_once "$root_icloud/components/navbar.php";
    //consulta permiso
    $permiso = $control->consultar_evento_codigo($codigo_invitacion);
    $permiso = mysqli_fetch_array($permiso);
    $idusuario = $permiso[0];
    $fecha_creacion = $permiso[1];
    $fecha_cambio = $permiso[2];
    $tipo_evento = $permiso[3];
    $responsable = $permiso[4];
    $solicitante = $control->consultar_nombre_usuario($idusuario);
    $solicitante = mysqli_fetch_array($solicitante);
    $solicitante = $solicitante[0];
    $parentesco = $permiso[5];
    $empresa_transporte = $permiso[6];
    $codigo_invitacion = $permiso[7];
    $comentarios = $permiso[8];
    $id_permiso = $permiso[9];
    //consulta familia que invita tomando el codigo de familia del permiso    
    $familia = $control->consultar_familia($permiso[10]);
    $familia = mysqli_fetch_array($familia);
    $familia = $familia[0];
    $estatus = $permiso[11];
    $flag_estatus = $estatus == 1 ? true : false;
    $fecha_destino = $date_helper->formatear_fecha_calendario($fecha_cambio);
    //numero de familia del usuario que consulta
    $numero_familia = $control->consultar_numero_familia($correo);
    $numero_familia = mysqli_fetch_array($numero_familia);
    $nfamilia = $numero_familia[0];
    ?>
    <div class="row">        
        <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
            <div>
                <?php if (!$date_helper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino)): ?>
                    <span class="new badge amber darken-1 w-100" data-badge-caption="Evento vencido"></span>
                    <br>
                <?php endif; ?>

                <?php if (!$flag_estatus): ?>
                    <span class="new badge red w-100" data-badge-caption="No es posible realizar cambios para el evento"></span>
                    <br>
                <?php endif; ?>

                <h5 class="c-azul center-align">Consulta de invitación a evento</h5>
                <div class="row"> 
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_evento" style="margin-left: 1rem">Fecha del evento</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly  
                                   id="fecha_evento" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value="<?php echo $fecha_cambio; ?>"/>               
                        </div>
                    </div>   
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="codigo_evento" style="margin-left: 1rem">Código de invitación</label>
                            <i class="material-icons prefix c-azul">looks_6</i>
                            <input readonly  
                                   id="codigo_evento" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value="<?php echo $codigo_invitacion; ?>">               
                        </div>                        
                    </div>   
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="familia_invita" style="margin-left: 1rem">Familia que invita</label>
                            <i class="material-icons prefix c-azul">nature_people</i>
                            <input readonly  
                                   id="familia_invita" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value ="<?php echo $familia; ?>">               
                        </div>                        
                    </div>   
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="tipo_evento" style="margin-left: 1rem">Tipo de evento</label>
                            <i class="material-icons prefix c-azul">cake</i>
                            <input readonly  
                                   id="tipo_evento" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value="<?php echo $tipo_evento; ?>"/>               
                        </div>
                    </div> 
                    <span class="col s12"></span>
                    <?php
                    $id_inscritos = array();
                    $inscritos = $control->consultar_inscripcion_evento($codigo_invitacion, $nfamilia);
                    $hidden_inscritos = "";
                    if (mysqli_num_rows($inscritos) == 0)
                        $hidden_inscritos = "hidden";
                    ?>
                    <div <?php echo $hidden_inscritos; ?>>
                        <h5 class="c-azul center-align col s12">Estado de inscritos actuales al evento</h5>
                        <?php
                        while ($alumno = mysqli_fetch_array($inscritos)) :
                            $identificador = $alumno[0];
                            $id_alumno = $alumno[2];
                            $estatus = $alumno[3];
                            $nombre_alumno = $control->consultar_nombre_alumno($id_alumno);
                            $nombre = mysqli_fetch_array($nombre_alumno);
                            $nivel_escolaridad = $nombre[1];
                            $nombre = $nombre[0];
                            $hidden_btn_cancelar_inscripcion = "none";
                            if ($estatus != 4) {
                                array_push($id_inscritos, $id_alumno);
                            }
                            switch ($estatus) {
                                case "1":
                                    $estatus = "Pendiente";
                                    $badge = "amber accent-4 c-blanco";
                                    $todos_autorizados = false;
                                    break;

                                case "2":
                                    $estatus = "Autorizado";
                                    $badge = "green accent-4 c-blanco";
                                    break;

                                case "3":
                                    $estatus = "Declinado";
                                    $badge = "red lighten-1 c-blanco";
                                    $todos_autorizados = false;
                                    break;

                                case "4":
                                    $estatus = "Cancelado por el usuario";
                                    $badge = "red accent-4 c-blanco";
                                    $todos_autorizados = false;
                                    break;
                                default:
                                    break;
                            }
                            ?>    
                            <div class="col s12">                        
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">school</i>
                                    <?php if ($date_helper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino) && $flag_estatus):
                                        ?>
                                        <button 
                                            onclick="modal_anular_inscripcion('<?php echo $id_alumno; ?>', '<?php echo $nombre; ?>')"
                                            class="btn waves-effect waves-light red lighten-1"
                                            style="float:right;display: <?php echo $hidden_btn_cancelar_inscripcion; ?>">
                                            <i class="material-icons">cancel</i>
                                        </button>
                                    <?php endif; ?> 
                                    <br>
                                    <br>
                                    <span style="float:left;margin-left:3rem" class="new badge <?php echo $badge; ?>" data-badge-caption="<?php echo $estatus; ?>"></span>
                                    <br> 
                                    <textarea class="materialize-textarea"
                                              readonly  
                                              id="alumno_<?php echo $identificador; ?>"
                                              style="font-size: 1rem"></textarea>
                                    <script>
                                        var texto = '<?php echo $nombre; ?>\nNivel: <?php echo $nivel_escolaridad; ?>';
                                            $('#alumno_<?php echo $identificador; ?>').val(texto);
                                            M.textareaAutoResize($('#alumno_<?php echo $identificador; ?>'));
                                    </script>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if ($date_helper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino) && $flag_estatus):
                        ?>
                        <div class="col s12 l6" style="float: none;margin: 0 auto;">
                            <button class="btn waves-effect waves-light b-azul white-text w-100" 
                                    type="button"
                                    id="btn_mostrar_anadir_alumnos"
                                    onclick="mostrar_modificar_inscritos()">
                                <i class="material-icons right">person_add</i>Añadir más alumnos al evento
                            </button>
                        </div>
                        <div id="caja_modificar_inscritos" hidden>
                            <span class="col s12">
                                <br>
                            </span>
                            <h5 class="c-azul center-align col s12">Alumnos habilitados para inscribir al evento</h5>
                            <br>
                            <br>
                            <?php
                            $consulta1 = $objCliente->mostrar_alumnos($nfamilia);
                            if ($consulta1) {
                                $counter = 0;
                                $id_todos_alumnos = array();
                                while ($cliente1 = mysqli_fetch_array($consulta1)):
                                    $counter++;
                                    $hidden = "";
                                    foreach ($id_inscritos as $value) {
                                        if ($cliente1['id'] == $value) {
                                            $hidden = "hidden";
                                            break;
                                        } else {
                                            $hidden = "";
                                            continue;
                                        }
                                    }
                                    array_push($id_todos_alumnos, $cliente1['id']);
                                    ?> 
                                    <div <?php echo $hidden; ?>>

                                        <div class="switch col s1">
                                            <label class="checks-alumnos">
                                                <input type="checkbox" 
                                                       id="alumno_<?php echo $counter; ?>" 
                                                       value="<?php echo $cliente1['id']; ?>"/>
                                                <span class="lever" style="margin-top:1rem"></span>
                                            </label>
                                        </div>
                                        <div class="col s10 l11" style="float: right;">
                                            <textarea class="materialize-textarea"
                                                      readonly  
                                                      id="nombre_<?php echo $counter; ?>"
                                                      style="font-size: 1rem;"></textarea>
                                        </div>
                                        <br style="clear:both">
                                        <input id="id_alumno_permiso_temporal_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                        <script>
                                            $('#nombre_<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                                            M.textareaAutoResize($('#nombre_<?php echo $counter; ?>'));
                                        </script>
                                    </div>
                                    <?php
                                    $talumnos = $counter;
                                endwhile;
                            }
                            ?>
                            <span class="col s12">
                                <br>
                                <br>
                            </span>
                            <div class="col s12 l6" style="float: none;margin: 0 auto;">
                                <button class="btn waves-effect waves-light b-azul white-text w-100" 
                                        type="button"
                                        id="btn_inscribir_alumnos"
                                        onclick="inscribir_alumnos('<?php echo $id_permiso; ?>', '<?php echo $tipo_evento; ?>', '<?php echo $codigo_invitacion; ?>', '<?php echo $nfamilia; ?>')">
                                    <i class="material-icons right">send</i>Inscribir 
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>  
                    <br>
                    <h5 class="c-azul center-align col s12">Información adicional</h5>
                    <span class="col s12">
                        <br>
                    </span>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="solicitante" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly  
                                   id="solicitante" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value="<?php echo $solicitante; ?>"/>               
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label style="margin-left: 3rem">Nombre del responsable</label>
                            <i class="material-icons prefix c-azul prefix">person</i>
                            <input readonly 
                                   type="text" 
                                   id="responsable" 
                                   autocomplete="off"
                                   value="<?php echo $responsable; ?>"> 
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label style="margin-left: 3rem">Parentesco del responsable</label>
                            <i class="material-icons prefix c-azul prefix">person</i>
                            <input readonly 
                                   type="text" 
                                   id="parentesco_responsable" 
                                   autocomplete="off"
                                   value="<?php echo $parentesco; ?>"> 
                        </div>
                    </div>               
                    <div id="caja_transporte">    
                        <div class="col s12 l6">
                            <div class="input-field">
                                <label style="margin-left: 3rem">Empresa</label>
                                <i class="material-icons prefix c-azul">time_to_leave</i>
                                <input readonly
                                       type="text" 
                                       id="empresa" 
                                       autocomplete="off"
                                       value="<?php echo $empresa_transporte; ?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <label style="margin-left: 3rem">Comentarios</label>
                        <i class="material-icons c-azul prefix">chrome_reader_mode</i>
                        <textarea id="comentarios" 
                                  class="materialize-textarea" 
                                  readonly
                                  placeholder="Comentarios"></textarea>  
                        <script>
                            $("#comentarios").val('<?php echo $comentarios; ?>');
                            M.textareaAutoResize($("#comentarios"));
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
$diferencia_inscritos_alumnos_familia = count(array_diff($id_todos_alumnos, $id_inscritos));
$diferencia_inscritos_alumnos_familia = $diferencia_inscritos_alumnos_familia > 0 ?
        json_encode(true) : json_encode(false);
$url = "";
if ($volver_listado) {
    $url = "$redirect_uri/Especial/Codigo/vistas/PCodigo.php?idseccion=$idseccion";
} else {
    $url = "$redirect_uri/Especial/menu.php?idseccion=$idseccion";
}
?>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul" href="<?php echo $url; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>

<div class="loading" id="loading">
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


<div id="modal_anular_inscripcion" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿En verdad desea anular la inscripción del alumno 
            <b><span id="text_anular_inscripcion" class="c-azul"></span></b> al evento?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>    
        <button
            id="btn_anular_inscripcion"
            class="waves-effect btn-flat b-azul white-text" 
            onclick="anular_inscripcion('<?php echo $id_permiso; ?>', '<?php echo $id_alumno; ?>')">Aceptar</button>
    </div>        
    <br>    
</div>

<script>

    var coleccion_ids = [];
    var coleccion_checkbox_values = [];
    $(document).ready(function () {
        $(".modal").modal();
        $("#loading").hide();
        var flag_btn_mostrar_anadir_alumnos = <?php echo $diferencia_inscritos_alumnos_familia; ?>;
        if (!flag_btn_mostrar_anadir_alumnos)
            $("#btn_mostrar_anadir_alumnos").hide();
    });
    //validaciones 
    function validar_check_alumnos() {
        var selected = '';
        var id = '';
        $('.checks-alumnos input[type=checkbox]').each(function () {
            if (this.checked) {
                selected += $(this).val() + ',';
                id += $(this)[0].id + ',';
            }
        });
        var ids = id.split(",");
        for (var item in ids) {
            if (ids[item] !== "") {
                coleccion_ids.push(ids[item]);
            }
        }
        var values = selected.split(",");
        for (var item in values) {
            if (values[item] !== "") {
                coleccion_checkbox_values.push(values[item]);
            }
        }
        if (selected === '') {
            M.toast({
                html: 'Debes seleccionar al menos un alumno para continuar!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        console.log(coleccion_checkbox_values);
        return true;
    }
    var id_alumno_anular = "";

    function mostrar_modificar_inscritos() {
        if ($("#caja_modificar_inscritos").prop("hidden")) {
            $("#caja_modificar_inscritos").prop("hidden", false);
            return;
        }
        $("#caja_modificar_inscritos").prop("hidden", true);
    }

    function modal_anular_inscripcion(id_alumno, alumno) {
        id_alumno_anular = id_alumno;
        var modal_anular_inscripcion = M.Modal.getInstance($("#modal_anular_inscripcion"));
        $("#text_anular_inscripcion").text(alumno);
        modal_anular_inscripcion.open();
    }

    function anular_inscripcion(id_permiso) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_cancela_inscripcion_evento_alumno.php',
            type: 'POST',
            beforeSend: () => {
                $("#btn_anular_inscripcion").prop("disabled", true);
                $("#loading").fadeIn("slow");
            },
            data: {"id_permiso": id_permiso, "id_alumno": id_alumno_anular}
        }).done((res) => {
            M.toast({
                html: 'Solicitud exitosa',
                classes: 'green accent-4 c-blanco'
            });
            res = JSON.parse(res);
            if (res) {
                setInterval(() => {
                    window.location.reload();
                }, 1000);
            }
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }

    function inscribir_alumnos(id_permiso, tipo_evento, codigo_invitacion, familia) {
        var alumnos = coleccion_checkbox_values;
        if (!validar_check_alumnos())
            return;
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_inscripcion_evento.php',
            type: 'POST',
            beforeSend: () => {
                $("#btn_inscribir_alumnos").prop("disabled", true);
                $("#loading").fadeIn("slow");
            },
            data: {
                "alumnos": alumnos,
                "id_permiso": id_permiso,
                "tipo_evento": tipo_evento,
                "codigo_invitacion": codigo_invitacion,
                "familia": familia
            }
        }).done((res) => {
            res = JSON.parse(res);
            if (res === 4) {
                M.toast({
                    html: 'El evento ha alcanzado el límite estipulado de inscritos!',
                    classes: 'deep-orange c-blanco'
                });
                setInterval(() => {
                    window.location.reload();
                }, 4000);
                return;
            }
            M.toast({
                html: 'Inscripción exitosa!',
                classes: 'green accent-4 c-blanco'
            });
            setInterval(() => {
                window.location.reload();
            }, 1000);
            return;

            M.toast({
                html: 'No ha sido posible registrar con éxito su solicitud!',
                classes: 'deep-orange c-blanco'
            });
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
        coleccion_checkbox_values = [];
    }
</script>