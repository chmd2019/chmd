<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/Transportes/components/layout_top.php";
include_once "$root_icloud/Transportes/components/navbar.php";

session_start();
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
    ?>
    <div class="caja-login" align="center">
        <h5 class="c-azul">Mi Maguen</h5>
        <?php echo '<a href="' . $authUrl . '"><img class = "logo-login" src="../../../images/google.png"/></a>'; ?>
    </div>
    <?php
} else {
    ?>
    <div class="row">
        <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
            <br>
            <br>
            <h5 class="center-align c-azul">Consulta de permiso temporal</h5>
            <br>
            <div class="row" style="padding:0rem .5rem;">
                <div>
                    <div class="col s12 l6">
                        <label for="celular" style="margin-left: 2rem;">Fecha de solicitud</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input id="fecha_solicitud" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <label for="solicitante" style="margin-left: 2rem;">Solicitante</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person</i>
                            <input id="solicitante" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                    <br>
                    <div class="col s12">
                        <label for="dias_permiso" style="margin-left: 1rem">Días de permiso</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">today</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="dias_permiso" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                    </div>
                    <br>
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
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <br>
                    <div class="col s12 l6">
                        <label for="calle" style="margin-left: 1rem">Calle y numero</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="calle" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <label for="colonia" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="colonia" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <label for="cp" style="margin-left: 2rem;">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input id="cp" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                        <div class="col s12 l6">
                        <label for="ruta" style="margin-left: 2rem;">Ruta</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">departure_board</i>
                            <input id="ruta" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                    <br>
                    <div class="col s12">
                        <label for="comentarios" style="margin-left: 1rem">Comentarios</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">comment</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="comentarios" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                    </div>
                    <div class="col s12">
                        <label for="mensaje" style="margin-left: 1rem">Mensaje</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">mail</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="mensaje" 
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
    <a class="btn-floating btn-large b-azul" href="https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Permanente/PPermanente.php?idseccion=<?php echo $idseccion;?>">
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
    $(document).ready(function(){
        
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });

        var fecha_solicitud = $("#fecha_solicitud");
        var solicitante = $("#solicitante");
        var dias_permiso = $("#dias_permiso");
        var alumnos = $("#alumnos");
        var calle = $("#calle");
        var colonia = $("#colonia");
        var cp = $("#cp");
        var ruta = $("#ruta");
        var comentarios = $("#comentarios");
        var mensaje = $("#mensaje");

        $.ajax({
            url:'https://www.chmd.edu.mx/pruebascd/icloud/Transportes/common/get_consulta_permiso.php',
            type:'GET',
            data:{
                id:'<?php echo $id_permiso;?>',
                tipo_permiso:'<?php echo $tipo_permiso;?>'
            },
            beforeSend: function () {
                $("#loading").fadeIn("slow");
            },
            success:function(res){   
                res = JSON.parse(res);
                console.log(res);
                fecha_solicitud.val(res.fecha_creacion);
                solicitante.val(res.responsable);
                var dias_permiso_res = "";
                res.lunes = res.lunes !=="" && res.lunes !=="0" ? dias_permiso_res += `${res.lunes}\n`:"";
                res.martes = res.martes !=="" && res.martes !=="0" ? dias_permiso_res += `${res.martes}\n`:"";
                res.miercoles = res.miercoles !=="" && res.miercoles !=="0" ? dias_permiso_res += `${res.miercoles}\n`:"";
                res.jueves = res.jueves !=="" && res.jueves !=="0" ? dias_permiso_res += `${res.jueves}\n`:"";
                res.viernes = res.viernes !=="" && res.viernes !=="0" ? dias_permiso_res += `${res.viernes}\n`:"";
                dias_permiso.val(dias_permiso_res);
                M.textareaAutoResize($('#dias_permiso'));
                var alumnos_res = "";
                for (var item in res.alumnos) {
                    alumnos_res += `${parseInt(item) + 1} - ${res.alumnos[item].alumno}\n`;
                }
                alumnos.val(alumnos_res);
                M.textareaAutoResize($('#alumnos'));
                calle.val(res.calle_numero);
                colonia.val(res.colonia);
                cp.val(res.cp);
                ruta.val(res.ruta);
                comentarios.val(res.comentarios);
                mensaje.val(res.mensaje);
            }
        })
        .always(function () {
            setInterval(function () {
                $("#loading").fadeOut("slow");
            }, 1000);
        });
    });
</script>