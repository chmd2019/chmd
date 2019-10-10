<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Especial/common/ControlEspecial.php";
require_once "$root_icloud/Helpers/DateHelper.php";

$control = new ControlEspecial();

$date_helper = new DateHelper();
$date_helper->set_timezone();

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
    $url_actual = "Especial/Eventos/vistas/" . basename($_SERVER['REQUEST_URI']);
    setcookie("url_evento", $url_actual, time() + 300, "/", "", 0);
    header("Location: $redirect_uri");
} else {
    include_once "$root_icloud/components/navbar.php";
    setcookie("url_evento", "", time() + -300, "/", "", 0);
    $id_permiso = $_GET['id'];
    $cod_evento = $_GET['cod_evento'];
    $alumno = $_GET['alumno'];
    $familia = $_GET['familia'];
    $id_alumno = $_GET['id_alumno'];
    $evento = mysqli_fetch_array($control->buscar_codigo_invitacion_x_id($cod_evento, $id_alumno));
    $id_evento = $evento[0];
    $fecha_evento = $date_helper->formatear_fecha_calendario_formato_a_m_d_guion($evento[1]);
    $tipo_evento = $evento[3];
    $estatus = $evento[5];
    $color_estatus = $evento[6];
    $fecha_actual = date("Y-m-d");
    $flag_evento_vencido = null;
    if (strtotime($fecha_actual) > strtotime($fecha_evento)) {
        $flag_evento_vencido = false;
    } else {
        $flag_evento_vencido = true;
    }
}
?>

<div class="row">
    <div class="col s12 l8 border-azul" style="margin: auto;float:none;padding: 1rem;">
        <h5 class="c-azul text-center">Confirmación de invitación a evento</h5>
        <span class="col s12"><br></span>
        <div class="row">
            <?php if ($flag_evento_vencido) : ?>            <div class="col s12 l6">
                    <div class="card hoverable">
                        <div class="card-image">
                            <img src="../../../images/birthday.jpg">
                            <span class="card-title">Invitación a cumpleaños</span>
                            <a class="btn-floating btn-large halfway-fab waves-effect waves-light b-azul tooltipped"
                               target="_blank"  
                               data-position="bottom" data-tooltip="Puede verificar la información del evento aquí"
                               href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php?familia=<?php echo $familia; ?>&&codigo_evento=<?php echo $cod_evento; ?>">
                                <i class="material-icons">info</i>
                            </a>
                        </div>
                        <div class="card-content">
                            <p><b><?php echo $alumno; ?></b>, ha sido invitado(a) a un evento de cumpleaños.</p>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light red-text" 
                               onclick="confirmar_invitacion(false,<?php echo $id_permiso; ?>)">
                                <i class="material-icons left">delete</i>Declinar
                            </a>
                            <a class="waves-effect waves-light green-text" 
                               onclick="confirmar_invitacion(true,<?php echo $id_permiso; ?>)">
                                <i class="material-icons right">done</i>Aceptar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col s12 l6">
                    <span class="chip <?php echo $color_estatus; ?>"><?php echo $estatus; ?></span>
                </div>
            <?php else: ?>            
                <div class="text-center">
                    <span class="col s12 chip red white-text">Evento vencido</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
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
        $('.tooltipped').tooltip();
        $("#loading").fadeOut();
    });

    function confirmar_invitacion(aceptar_declinar, id_permiso_alumno) {
        aceptar_declinar = aceptar_declinar === true ? 2 : 3;
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_aceptar_declinar_invitacion_evento.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {estatus: aceptar_declinar, id_permiso_alumno: id_permiso_alumno}
        }).done((res) => {
            if (res) {
                M.toast({
                    html: 'Solicitud exitosa!',
                    classes: 'green accent-4 c-blanco'
                });
                setInterval(() => {
                    window.location.reload();
                }, 500);
            } else {
                M.toast({
                    html: 'Solicitud no realizada!',
                    classes: 'deep-orange c-blanco'
                });
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }
</script>

<?php include_once "$root_icloud/components/layout_bottom.php"; ?>