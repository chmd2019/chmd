<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require "$root_icloud/Especial/common/ControlEspecial.php";

$id_permiso = $_GET['id_permiso'];
$tipo_permiso = $_GET['tipo_permiso'];
$idseccion = $_GET['idseccion'];
$control = new ControlEspecial();
$alumnos_permiso = $control->obtener_alumnos_permiso($id_permiso);

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
                <h5 class="c-azul center-align">Consulta de evento</h5>
                <br>
                <br>
                <div class="row"> 
                    <div class="col s12">
                        <label for="codigo_evento" style="margin-left: 1rem">Código del evento</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">looks_6</i>
                            <input readonly  id="codigo_evento" style="font-size: 1rem" type="text" >               
                        </div>                        
                    </div>   
                    <div class="col s12 l6">
                        <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly  id="fecha_solicitud" style="font-size: 1rem" type="text" >               
                        </div>                        
                    </div>   
                    <div class="col s12 l6">
                        <label for="solicitante" style="margin-left: 1rem">Solicitante</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly  
                                   id="solicitante" 
                                   style="font-size: 1rem" 
                                   type="text" />               
                        </div>
                    </div>   
                    <div class="col s12 l6">
                        <label for="fecha_evento" style="margin-left: 1rem">Fecha del evento</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly  
                                   id="fecha_evento" 
                                   style="font-size: 1rem" 
                                   type="text" />               
                        </div>
                    </div>  
                    <div class="col s12 l6">
                        <label for="tipo_evento" style="margin-left: 1rem">Tipo de evento</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">cake</i>
                            <input readonly  
                                   id="tipo_evento" 
                                   style="font-size: 1rem" 
                                   type="text" />               
                        </div>
                    </div>  
                    <div class="col s12">
                        <h5 class="c-azul text-center">Alumnos inscritos</h5>
                        <?php
                        while ($alumno = mysqli_fetch_array($alumnos_permiso)) :
                            $id_alumno = $alumno[2];
                            $estatus = $alumno[6];
                            $nombre_alumno = $control->consultar_nombre_alumno($id_alumno);
                            $nombre = mysqli_fetch_array($nombre_alumno);
                            $nombre = $nombre[0];
                            switch ($estatus) {
                                case "1":
                                    $estatus = "Pendiente";
                                    $badge = "blue";
                                    $todos_autorizados = false;
                                    break;

                                case "2":
                                    $estatus = "Autorizado";
                                    $badge = "green";
                                    break;

                                case "3":
                                    $estatus = "Declinado";
                                    $badge = "orange";
                                    $todos_autorizados = false;
                                    break;

                                case "4":
                                    $estatus = "Cancelado por el usuario";
                                    $badge = "red";
                                    $todos_autorizados = false;
                                    break;

                                default:
                                    break;
                            }
                            ?>                        
                            <div class="col s12">                        
                                <div class="input-field">
                                    <i class="material-icons prefix c-azul">school</i>
                                    <span class="new badge <?php echo $badge; ?>" data-badge-caption="<?php echo $estatus; ?>"></span>
                                    <textarea class="materialize-textarea"
                                              readonly  
                                              id="alumno_<?php echo $id_alumno; ?>"
                                              style="font-size: 1rem"></textarea>
                                    <script>
                                        var texto = '<?php echo $nombre; ?>';
                                        $('#alumno_<?php echo $id_alumno; ?>').val(texto);
                                        M.textareaAutoResize($('#alumno_<?php echo $id_alumno; ?>'));
                                    </script>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="col s12 l6">
                        <label style="margin-left: 3rem">Nombre del responsable</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly 
                                   type="text" 
                                   id="responsable" 
                                   autocomplete="off"> 
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <label style="margin-left: 3rem">Parentesco del responsable</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly 
                                   type="text" 
                                   id="parentesco_responsable" 
                                   autocomplete="off"> 
                        </div>
                    </div>               
                    <div id="caja_transporte">    
                        <div class="col s12 l6">
                            <label style="margin-left: 3rem">Empresa</label>
                            <div class="input-field">
                                <i class="material-icons prefix c-azul">time_to_leave</i>
                                <input readonly
                                       type="text" 
                                       id="empresa" 
                                       autocomplete="off"> 
                            </div>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">chrome_reader_mode</i>
                        <textarea id="comentarios" 
                                  class="materialize-textarea"                                
                                  placeholder="Comentarios"></textarea>    
                    </div>  
                </div>                    
            </div>                    
        </div>                    
    </div>
<?php }; ?>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
       href="<?php echo $redirect_uri ?>Especial/Eventos/PEventos.php?idseccion=<?php echo $idseccion; ?>">
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
        var id_permiso = '<?php echo $id_permiso; ?>'
        $("#loading").hide();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_consultar_evento.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {"id_permiso": id_permiso}
        }).done((res) => {
            res = JSON.parse(res);
            $("#codigo_evento").val(res.codigo_invitacion);
            $("#fecha_solicitud").val(res.fecha_creacion);
            $("#solicitante").val(res.solicitante);
            $("#fecha_evento").val(res.fecha_cambio);
            $("#tipo_evento").val(res.tipo_evento);
            $("#responsable").val(res.responsable);
            $("#parentesco_responsable").val(res.parentesco);
            $("#empresa").val(res.empresa_transporte);
            $("#comentarios").val(res.comentarios);
            M.textareaAutoResize($("#comentarios"));
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    });

</script>