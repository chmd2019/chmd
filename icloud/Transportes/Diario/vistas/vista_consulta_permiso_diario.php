<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";

$id_permiso = $_GET['id'];
$tipo_permiso = $_GET['tipo_permiso'];
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
    include_once "$root_icloud/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
            <div>
                <h5 class="c-azul center-align">Consulta de permiso</h5>
                <br>
                <div class="row"> 
                    <div class="col s12 l6">
                        <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly  id="fecha_solicitud" style="font-size: 1rem" type="text" >               
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <label for="fecha_permiso" style="margin-left: 1rem">Fecha programada</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly  id="fecha_permiso" type="text" style="font-size: 1rem"  >               
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <label for="responsable" style="margin-left: 1rem">Solicitante</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly  id="responsable" type="text"  style="font-size: 1rem"  >               
                        </div>
                    </div>
                    <br>
                    <h5 class="c-azul text-center col s12">Alumnos</h5>
                    <div class="col s12">
                        <label for="alumnos" style="margin-left: 1rem">Alumnos del permiso</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">school</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="alumnos" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                    </div>
                    <h5 class="c-azul text-center col s12">Dirección de cambio</h5>
                    <div class="col s12">                        
                        <label for="calle" style="margin-left: 1rem">Calle y número</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea readonly  
                                      id="calle" 
                                      class="materialize-textarea" 
                                      style="font-size: .9rem"></textarea>            
                        </div>
                    </div>
                    <br>
                    <div class="col s12">                        
                        <label for="colonia" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea readonly  
                                      id="colonia" 
                                      class="materialize-textarea" 
                                      style="font-size: .9rem"></textarea>            
                        </div>
                    </div>
                    <br>
                    <div class="col s12 l6">   
                        <label for="cp" style="margin-left: 1rem">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  id="cp" type="text" style="font-size: 1rem"  >               
                        </div>
                    </div>
                    <div class="col s12 l6">   
                        <label for="ruta" style="margin-left: 1rem">Ruta</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">departure_board</i>
                            <input readonly  id="ruta" type="text" >               
                        </div>
                    </div>
                    <div class="col s12">   
                        <label for="comentarios" style="margin-left: 1rem">Comentarios</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">comment</i>
                            <textarea readonly  
                                      id="comentarios" 
                                      class="materialize-textarea" 
                                      style="font-size: .9rem"></textarea>            
                        </div>
                    </div>
                    <div class="col s12">   
                        <label for="respuesta" style="margin-left: 1rem">Respuesta</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">question_answer</i>
                            <textarea readonly  
                                      id="respuesta" 
                                      class="materialize-textarea" 
                                      style="font-size: .9rem"></textarea>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul" href="<?php echo $redirect_uri?>Transportes/Diario/PDiario.php?idseccion=<?php echo $idseccion; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>

<div class="loading" hidden id="loading">
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
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });

        var fecha_solicitud = $("#fecha_solicitud");
        var fecha_cambio = $("#fecha_permiso");
        var responsable = $("#responsable");
        var alumnos = $("#alumnos");
        var calle = $("#calle");
        var colonia = $("#colonia");
        var cp = $("#cp");
        var ruta = $("#ruta");
        var comentarios = $("#comentarios");
        var respuesta = $("#respuesta");

        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Transportes/common/get_consulta_permiso.php',
            type: 'GET',
            data: {
                id: '<?php echo $id_permiso; ?>',
                tipo_permiso: '<?php echo $tipo_permiso; ?>'
            },
            beforeSend: function () {
                $("#loading").fadeIn("slow");
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                fecha_solicitud.val(res.fecha_solicitud);
                fecha_cambio.val(res.fecha_cambio);
                responsable.val(res.responsable);
                var alumnos_res = "";
                for (var item in res.alumnos) {
                    alumnos_res += `${parseInt(item) + 1} - ${res.alumnos[item].alumno}\n`;
                }
                alumnos.val(alumnos_res);
                M.textareaAutoResize($('#alumnos'));
                calle.val(res.calle);
                M.textareaAutoResize($('#calle'));
                colonia.val(res.colonia);
                M.textareaAutoResize($('#colonia'));
                cp.val(res.cp);
                ruta.val(res.ruta);
                comentarios.val(res.comentarios);
                M.textareaAutoResize($('#comentarios'));
                respuesta.val(res.mensaje);
                M.textareaAutoResize($('#respuesta'));
            }
        }).always(function () {
            setInterval(function () {
                $("#loading").fadeOut("slow");
            }, 1000);
        });

    });
</script>
<?php include "$root_icloud/components/layout_bottom.php"; ?>