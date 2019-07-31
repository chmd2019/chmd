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

$id_permiso = $_GET['id_permiso'];
$permiso = $control->consultar_permiso($id_permiso);
$permiso = mysqli_fetch_array($permiso);
$fecha_invitacion = $permiso[2];
$tipo_evento = $_GET['tipo_evento'];
$codigo_invitacion = $_GET['codigo_invitacion'];
$familia = $control->consultar_familia($_GET['familia']);
$familia = mysqli_fetch_array($familia);
$familia = $familia[0];

$estatus = $permiso[6];
$flag_estatus = $estatus == 1 ? true : false;

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
    $fecha_destino = $date_helper->formatear_fecha_calendario($fecha_invitacion);
    //numero de familia del usuario que consulta
    $numero_familia = $control->consultar_numero_familia($correo);
    $numero_familia = mysqli_fetch_array($numero_familia);
    $nfamilia = $numero_familia[0];
    include_once "$root_icloud/components/navbar.php";
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
                <h5 class="c-azul center-align">Inscripción a evento</h5>
                <br>
                <div class="row"> 
                    <div class="col s12 l6">
                        <label for="fecha_solicitud" style="margin-left: 1rem">Fecha del evento</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">insert_invitation</i>
                            <input readonly  
                                   id="fecha_solicitud" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value ="<?php echo $fecha_invitacion; ?>">               
                        </div>                        
                    </div>     
                    <div class="col s12 l6">
                        <label for="codigo" style="margin-left: 1rem">Código de invitación</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">looks_6</i>
                            <input readonly  
                                   id="codigo" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value ="<?php echo $codigo_invitacion; ?>">               
                        </div>                        
                    </div>   
                    <div class="col s12 l6">
                        <label for="familia_invita" style="margin-left: 1rem">Familia que invita</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">nature_people</i>
                            <input readonly  
                                   id="familia_invita" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value ="<?php echo $familia; ?>">               
                        </div>                        
                    </div>     
                    <div class="col s12 l6">
                        <label for="tipo_evento" style="margin-left: 1rem">Tipo de evento</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">cake</i>
                            <input readonly  
                                   id="tipo_evento" 
                                   style="font-size: 1rem" 
                                   type="text" 
                                   value ="<?php echo $tipo_evento; ?>">               
                        </div>                        
                    </div> 
                    <br>
                    <?php if ($date_helper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino) && $flag_estatus): ?>
                        <div>
                            <h5 class="c-azul text-center col s12">Inscripción de alumnos</h5>
                            <br>
                            <?php
                            $consulta1 = $objCliente->mostrar_alumnos($nfamilia);
                            if ($consulta1) {
                                $counter = 0;
                                // $numero = mysql_num_rows($consulta);
                                while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                    $counter++;
                                    ?>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix c-azul">school</i>
                                        <textarea class="materialize-textarea"
                                                  readonly  
                                                  id="nombre_<?php echo $counter; ?>"
                                                  style="font-size: 1rem"></textarea>
                                    </div>
                                    <div class="switch col s12">
                                        <label class="checks-alumnos">
                                            <input type="checkbox" 
                                                   id="alumno_<?php echo $counter; ?>" 
                                                   value="<?php echo $cliente1['id']; ?>"/>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                    <br>
                                    <input id="id_alumno_permiso_temporal_<?php echo $counter; ?>" hidden value="<?php echo $cliente1['id']; ?>"/>
                                    <script>
                                        $('#nombre_<?php echo $counter; ?>').val('<?php echo $cliente1['nombre']; ?>');
                                        M.textareaAutoResize($('#nombre_<?php echo $counter; ?>'));
                                    </script>
                                    <?php
                                    $talumnos = $counter;
                                }
                            }
                            ?>   
                            <span class="col s12"><br><br></span>
                            <div class="col s12 l6" style="float: none;margin: 0 auto;">
                                <button class="btn waves-effect waves-light b-azul white-text w-100" 
                                        id="btn_enviar_formulario"
                                        type="button" 
                                        onclick="enviar_formulario('<?php echo $id_permiso; ?>', '<?php echo $tipo_evento; ?>', '<?php echo $codigo_invitacion; ?>', '<?php echo $nfamilia; ?>')">Inscribir
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>  
                        </div>  
                    <?php endif; ?>                    
                </div>                     
            </div>                     
        </div>                     
    </div>

<?php }; ?>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul" href="<?php echo $redirect_uri ?>Especial/menu.php?idseccion=<?php echo $idseccion; ?>">
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

<script>
    $(document).ready(function () {
        $("#loading").hide();
    });
    var coleccion_ids = [];
    var coleccion_checkbox_values = [];
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

    function enviar_formulario(id_permiso, tipo_evento, codigo_invitacion, familia) {
        var alumnos = coleccion_checkbox_values;
        if (!validar_check_alumnos())
            return;
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_inscripcion_evento.php',
            type: 'POST',
            beforeSend: () => {
                $("#btn_enviar_formulario").prop("disabled", true);
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
            console.log(res);
            if (res === 4) {
                M.toast({
                    html: 'El evento ha alcanzado el límite estipulado de inscritos!',
                    classes: 'deep-orange c-blanco'
                });
                setInterval(() => {
                    window.location.href = `https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php?familia=${familia}&&codigo_evento=${codigo_invitacion}&&volver_listado=true`;
                }, 4000);
                return;
            }
            if (res) {
                M.toast({
                    html: 'Inscripción exitosa!',
                    classes: 'green accent-4 c-blanco'
                });
                setInterval(() => {
                    window.location.href = "https://www.chmd.edu.mx/pruebascd/icloud/Especial/menu.php?idseccion=1";
                }, 1500);
                return;
            }
            M.toast({
                html: 'No ha sido posible registrar con éxito su solicitud!',
                classes: 'deep-orange c-blanco'
            });
            $("#btn_enviar_formulario").prop("disabled", false);
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
        coleccion_checkbox_values = [];
    }

</script>



<?php include "$root_icloud/components/layout_bottom.php"; ?>