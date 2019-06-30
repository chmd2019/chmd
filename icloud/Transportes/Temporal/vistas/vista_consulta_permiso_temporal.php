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
    ?>
    <div class="row">
        <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
            <br>
            <br>
            <h5 class="center-align c-azul">Consulta de permiso temporal</h5>
            <br>
            <div class="row" style="padding:0rem .5rem;">
                <div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input id="fecha_solicitud" type="text" class="validate" readonly>
                        <label for="fecha_solicitud">Fecha de solicitud</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">person</i>
                        <input id="solicitante" type="text" class="validate" readonly>
                        <label for="solicitante">Solicitante</label>
                    </div>
                    <!--TODO ALUMNOS--> <h1>Alumnos pendiente</h1><br>
                    <h5 class="center-align c-azul">Dirección de Casa</h5>
                    <br>
                    <div class="col s12">
                        <label for="calle_guardada" style="margin-left: 1rem">Calle y número</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="calle_guardada" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                        <br>
                        <label for="colonia_guardada" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="colonia_guardada"
                                      style="font-size: .9rem"></textarea>      
                        </div>
                        <br>
                        <label for="cp_guardada" style="margin-left: 1rem">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  
                                   id="cp_guardada"
                                   style="font-size: .9rem"
                                   value=""/>       
                        </div>
                    </div>                
                    <br>
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <br>
                    <div class="col s12">
                        <label for="calle_cambio" style="margin-left: 1rem">Calle y número</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="calle_cambio" 
                                      style="font-size: .9rem"></textarea> 
                        </div>
                        <br>
                        <label for="colonia_cambio" style="margin-left: 1rem">Colonia</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly  
                                      id="colonia_cambio"
                                      style="font-size: .9rem"></textarea>      
                        </div>
                        <br>
                        <label for="cp_cambio" style="margin-left: 1rem">CP</label>
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  
                                   id="cp_cambio"
                                   style="font-size: .9rem"
                                   value=""/>       
                        </div>
                    </div>
                    <br>
                    <div>   
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">people</i>
                            <input id="parentesco" type="text" class="validate" readonly>
                            <label for="parentesco">Parentesco</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">smartphone</i>
                            <input id="celular" type="text" class="validate" readonly>
                            <label for="celular">Celular</label>
                        </div>
                        <br>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">phone_in_talk</i>
                            <input id="celular" type="text" class="validate" readonly>
                            <label for="celular">Teléfono</label>
                        </div>
                    </div>
                    <br>
                    <h5 class="center-align c-azul col s12">Fechas de cambio</h5>
                    <br>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input id="fecha_inicial" type="text" class="validate" readonly>
                        <label for="fecha_inicial">Fecha inicial</label>
                    </div>
                    <br>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input id="fecha_final" type="text" class="validate" readonly>
                        <label for="fecha_final">Fecha inicial</label>
                    </div>
                    <br>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">departure_board</i>
                        <input id="turno" type="text" class="validate" readonly>
                        <label for="turno">Turno</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">comment</i>
                        <textarea class="materialize-textarea"
                                  readonly  
                                  id="comentarios"
                                  style="font-size: .9rem"></textarea>  
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons c-azul">question_answer</i>
                        <textarea class="materialize-textarea"
                                  readonly  
                                  id="respuesta"
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
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Transportes/common/get_consulta_permiso.php',
            type: 'GET',
            data: {id: '<?php echo $id_permiso; ?>'},
            beforeSend: function () {
                $("#loading").fadeIn("slow");
            },
            success: function (res) {
                console.log(JSON.parse(res));
            }
        }).then(function () {
            setInterval(function () {
                $("#loading").fadeOut("slow");
            }, 1000);
        });
    });
</script>