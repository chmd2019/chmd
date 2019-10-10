<?php
session_start();
$root = dirname(dirname(__DIR__));
require_once "{$root}/components/sesion.php";
require_once "{$root}/libraries/Google/autoload.php";
require_once "{$root}/Model/Login.php";
require_once "{$root}/Model/DBManager.php";
require_once "{$root}/Model/Config.php";
require_once "{$root}/Helpers/DateHelper.php";
include_once "{$root}/components/layout_top.php";

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
else :
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    include "{$root}/components/navbar.php";
    ?>
    <br>
    <div class="right" style="margin-right: 1rem;">
        <a class="waves-effect waves-light"
           href="https://www.chmd.edu.mx/pruebascd/icloud/Minutas/menu.php?idseccion=1">
            <img src='../../images/Atras.svg' style="width: 110px">
        </a>
        <a class="waves-effect waves-light"
           href="vistas/vista_nuevo_evento.php">
            <img src='../../images/Nuevo.svg' style="width: 110px">
        </a>
    </div>
    <br>
    <h4 class="col s12 c-azul text-center">Comité: Consejo Directivo</h4> 


<?php endif; ?>
<?php include "{$root}/components/layout_bottom.php"; ?>