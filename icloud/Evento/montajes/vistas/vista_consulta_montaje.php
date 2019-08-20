<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";
require_once "$root_icloud/Evento/common/ControlEvento.php";

$id_montaje = $_GET['id'];
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
if (isset($authUrl)) :
header("Location: $redirect_uri?logout=1");
else:
include_once "$root_icloud/components/navbar.php";
$control = new ControlEvento();
$montaje = $control->consulta_montaje($id_montaje);
$montaje = mysqli_fetch_array($montaje);
$fecha_solicitud = $montaje[1];
$solicitante = $montaje[2];
$tipo_montaje = $montaje[3];
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
?>
<div class="row">
    <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
        <div>
            <h5 class="c-azul center-align">Consulta de montaje</h5>
            <br>
            <div class="row"> 
                <div class="input-field col s12 l6">
                    <label>Fecha de solicitud</label>
                    <i class="material-icons prefix c-azul">calendar_today</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $fecha_solicitud; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Solicitante</label>
                    <i class="material-icons prefix c-azul">person</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $solicitante; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label >Tipo de evento</label>
                    <i class="material-icons prefix c-azul">room_service</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $tipo_montaje; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Fecha del montaje</label>
                    <i class="material-icons prefix c-azul">calendar_today</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $fecha_montaje; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Horario inicial del evento</label>
                    <i class="material-icons prefix c-azul">access_time</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $horario_evento; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Horario final del evento</label>
                    <i class="material-icons prefix c-azul">access_time</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $horario_final_evento; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Nombre del evento</label>
                    <i class="material-icons prefix c-azul">restaurant_menu</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $nombre_evento; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Responsable del evento del area solicitante</label>
                    <i class="material-icons prefix c-azul">person</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $responsable_evento; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Cantidad de invitados</label>
                    <i class="material-icons prefix c-azul">sentiment_very_satisfied</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $cantidad_invitados; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Valet Parking</label>
                    <i class="material-icons prefix c-azul">drive_eta</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $valet_parking; ?>">      
                </div>
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
                <?php endif;
                if($tipo_repliegue == "") $tipo_repliegue = "Sin repliegue";
                ?>
                <div class="input-field col s12 l6">
                    <label>Repliegue</label>
                    <i class="material-icons prefix c-azul">donut_small</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $tipo_repliegue; ?>">      
                </div>
                <div class="input-field col s12 l6">
                    <label>Lugar del evento</label>
                    <i class="material-icons prefix c-azul">place</i>
                    <input readonly  
                           style="font-size: 1rem" 
                           type="text" 
                           value="<?php echo $lugar_evento; ?>">      
                </div>
                <?php
                $mobiliario = $control->consulta_mobiliario_montaje($id_montaje);
                if (mysqli_num_rows($mobiliario) > 0):
                ?>
                <br><h5 class="col s12 c-azul text-center">Mobiliario del evento</h5>
                <ul class="collection row col s12">
                    <?php
                    while ($row = mysqli_fetch_array($mobiliario)):
                    $articulo = $row[0];
                    $cantidad = $row[1];
                    $url_img = $row[2];
                    ?>
                    <li class="collection-item avatar col s12" style="justify-content: space-around">
                        <div class="col s12 l6"> <br>
                            <i class="material-icons circle" style="background-color: #00C2EE">done</i>
                            <span class="title"><b>Artículo: </b> <?php echo $articulo; ?></span>
                            <br>
                            <b>Cantidad para el evento: </b>
                            <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i>
                                <input readonly
                                       value="<?php echo $cantidad; ?>"></div>
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
                <?php endif; ?>
                <?php
                $manteles = $control->consulta_manteles_montaje($id_montaje);
                if (mysqli_num_rows($manteles) > 0):
                ?>
                <br><h5 class="col s12 c-azul text-center">Manteles</h5>
                <ul class="collection row col s12">
                    <?php
                    while ($row = mysqli_fetch_array($manteles)):
                    $articulo = $row[0];
                    $cantidad = $row[1];
                    $url_img = $row[2];
                    ?>
                    <li class="collection-item avatar col s12" style="justify-content: space-around">
                        <div class="col s12 l6"> <br>
                            <i class="material-icons circle" style="background-color: #00C2EE">done</i>
                            <span class="title"><b>Artículo: </b> <?php echo $articulo; ?></span>
                            <br>
                            <b>Cantidad para el evento: </b>
                            <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i>
                                <input readonly
                                       value="<?php echo $cantidad; ?>"></div>
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
                <?php endif; ?>
                <?php
                $equipo_tecnico = $control->consulta_equipo_tecnico_montaje($id_montaje);
                if (mysqli_num_rows($equipo_tecnico) > 0):
                ?>
                <br><h5 class="col s12 c-azul text-center">Equipo Técnico</h5>
                <ul class="collection row col s12">
                    <?php
                    while ($row = mysqli_fetch_array($equipo_tecnico)):
                    $articulo = $row[0];
                    $cantidad = $row[1];
                    $url_img = $row[2];
                    ?>
                    <li class="collection-item avatar col s12" style="justify-content: space-around">
                        <div class="col s12 l6"> <br>
                            <i class="material-icons circle" style="background-color: #00C2EE">settings_input_composite</i>
                            <span class="title"><b>Artículo: </b> <?php echo $articulo; ?></span>
                            <br>
                            <b>Cantidad para el evento: </b>
                            <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i>
                                <input readonly
                                       value="<?php echo $cantidad; ?>"></div>
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
                <?php endif; ?>
                <?php
                $personal_requerido = $control->consulta_personal_montaje($id_montaje);
                if (mysqli_num_rows($personal_requerido) > 0):
                ?>
                <br><h5 class="col s12 c-azul text-center">Personal requerido</h5>
                <ul class="collection row col s12">
                    <?php
                    while ($row = mysqli_fetch_array($personal_requerido)):
                    $descripcion = $row[0];
                    $cantidad = $row[1];
                    ?>
                    <li class="collection-item avatar col s12" style="justify-content: space-around">
                        <div class="col s12 l6"> <br>
                            <i class="material-icons circle" style="background-color: #00C2EE">group_add</i>
                            <span class="title"><b>Tipo de personal: </b> <?php echo $descripcion; ?></span>
                            <br>
                            <b>Cantidad para el evento: </b>
                            <div class="input-field"><i class="material-icons prefix c-azul">plus_one</i>
                                <input readonly
                                       value="<?php echo $cantidad; ?>"></div>
                        </div><span class="col s12"><br></span>
                    </li>
                <?php endwhile; ?>
                </ul>
<?php endif; ?>
                <div class="input-field col s12">
                    <i class="material-icons prefix c-azul">list_alt</i>
                    <textarea class="materialize-textarea"
                              readonly
                              id="requerimientos_especiales"
                              placeholder="Requerimientos especiales"></textarea> 
                </div>
            </div>
        </div>

<?php endif; ?>
    </div>
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul" href="<?php echo $redirect_uri ?>Evento/montajes/PMontajes.php?idseccion=<?php echo $idseccion; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>

<script>

    $(document).ready(function () {
        $("#requerimientos_especiales").val('<?php echo $requerimientos_especiales; ?>');
        M.textareaAutoResize($('textarea'));
    });

</script>
<?php include "$root_icloud/components/layout_bottom.php"; ?>