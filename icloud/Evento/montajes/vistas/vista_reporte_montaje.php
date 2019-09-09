<?php
session_start();

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";

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
    echo "En proceso...";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
            <div>
                <h5 class="c-azul center-align">Reportaje de montaje <?php echo $nombre_evento; ?></h5>
                <?php
                $mobiliario = $control->consulta_mobiliario_montaje($id_montaje, $id_lugar, $horario_evento, $horario_final_evento, $fecha_montaje_simple);
                if (mysqli_num_rows($mobiliario) > 0):
                    ?>
                    <h5 class="col s12 c-azul">Mobiliario</h5>
                    <br>
                    <br>
                    <div>
                        <?php
                        if ($id_privilegio == 3):
                            while ($row = mysqli_fetch_array($mobiliario)):
                                $articulo = $row[0];
                                $cantidad = $row[1];
                                $url_img = $row[2];
                                $id_articulo = $row[3];
                                $capacidad_lugar = $row[4];
                                $disponibilidad = $row[5];
                                ?>
                                <div style="font-family: Consolas">
                                    <br>
                                    <span>Artículo: <?php echo str_pad($articulo, 40, ".", STR_PAD_LEFT); ?></span>
                                    <br>
                                    <span>Cantidad: <?php echo str_pad("# $cantidad", 40, ".", STR_PAD_LEFT); ?></span>
                                </div>
                                <?php
                            endwhile;
                        else :
                            ?>
                            <div class="text-center">
                                <span class="chip blue white-text">Usuario sin privilegios para esta sección</span>
                            </div>                            
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
}
?>