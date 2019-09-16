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
    $control = new ControlEvento();
    $date_helper = new DateHelper();
    $privilegio = mysqli_fetch_array($control->consultar_privilegio_usuario($correo));
    $id_privilegio = $privilegio[0];
    $fecha_dia = $_GET['fecha_reporte'];
    $fecha_montajes = $control->consulta_fecha_montaje_dia($fecha_dia);
    $fecha_montajes = mysqli_fetch_array($fecha_montajes)[0];
    ?>
    <div class="row">
        <div class="col s12 l7 b-blanco"               
             style="float: none;margin: 0 auto;padding:1rem">
                 <?php
                 $reporte = $control->reporte_montaje_dia("$fecha_dia");
                 if ($id_privilegio == 3):
                     if (mysqli_num_rows($reporte) > 0):
                         ?>
                    <div id="imprimir" style="padding: 1rem">   
                        <h5 class="c-azul center-align">Reportaje de montaje <?php echo $nombre_evento; ?></h5>
                        <br>
                        <span class="chip blue white-text"><?php echo $fecha_montajes; ?></span>
                        <br>
                        <br>
                        <table class="table highlight">
                            <thead class="b-azul c-blanco">
                                <tr>
                                    <th>Evento</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Faltante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_faltante = 0;
                                while ($row = mysqli_fetch_array($reporte)):
                                    $articulo = null;
                                    $mobiliario = $row[2];
                                    $mantel = $row[3];
                                    $equipo_tecnico = $row[4];
                                    if (strlen($mobiliario) > 0) {
                                        $articulo = $mobiliario;
                                    } elseif (strlen($mantel) > 0) {
                                        $articulo = $mantel;
                                    } else {
                                        $articulo = $equipo_tecnico;
                                    }
                                    $cantidad = $row[5];
                                    $faltante = $row[6];
                                    $evento = $row[7];
                                    $total_faltante += $faltante;
                                    ?>          
                                    <tr>
                                        <td><?php echo $evento; ?></td>
                                        <td><?php echo $articulo; ?></td>
                                        <td><?php echo $cantidad; ?></td>
                                        <td><?php echo $faltante; ?></td>
                                    </tr>                               
                                    <?php
                                endwhile;
                            else :
                                ?>
                            <div class="text-center">
                                <span class="chip red white-text">No existe reporte para la fecha seleccionada</span>
                            </div>                          
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <span class="chip red white-text">Usuario sin privilegios para esta sección</span>
                </div>  
            <?php endif; ?>
        </div>
    </div>

    <?php
}
?>
<style>
    nav{
        display: none;
    }
</style>

<script>
    $(document).ready(function () {
        descargarPDF('Reporte de montaje <?php echo $fecha_montajes; ?>');
        //setInterval(()=>{window.close();},4000);
    });

    function descargarPDF(nombre_pdf) {
        var elemento = document.getElementById("imprimir");
        html2canvas(elemento, {
            onrendered: function (canvas) {
                var img = canvas.toDataURL("image/png");
                var doc = new jsPDF();
                doc.addImage(img, 'JPEG', 0, 0);
                doc.save(nombre_pdf);
            }

        });
    }
</script>