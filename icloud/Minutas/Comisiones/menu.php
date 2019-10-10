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

    <h4 class="b-azul c-blanco text-center" style="padding:1rem;margin-top:0px"> Mi Maguen <?php echo date("Y"); ?></h4>
    <div>
        <a class="waves-effect waves-light right" style="margin-right: 1rem;" href="<?php echo $redirect_uri; ?>">  
            <img src='https://www.chmd.edu.mx/pruebascd/icloud/images/Atras.svg' style="width: 110px">     
        </a>
        <span style="clear: both;"></span>
        <br>
        <h4 class="col s12 c-azul text-center">Comisiones</h4> 
        <div class="row">
            <div class="col s12 m8" style="float:none;margin:auto">       
                <div class="col s12 m10 l4">
                    <div class="card" style="box-shadow: none">
                        <div class="card-image waves-block efecto-btn">
                            <a href='Eventos/Eventos.php?idseccion=1'>
                                <img src="../../pics/activos/comites/7.png" style="padding:3rem;">
                            </a>
                        </div>
                        <div class="card-content text-center" style="padding:0px;margin-top: -30px">
                            <img class="activator waves-effect waves-light" src="../../../icloud/images/Info.svg" style="width: 30px;"/>
                        </div>
                        <div class="card-reveal b-azul white-text">
                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                            <p></p>
                        </div>
                    </div>
                </div>       
                <div class="col s12 m10 l4">
                    <div class="card" style="box-shadow: none">
                        <div class="card-image waves-block efecto-btn">
                            <a href='Eventos/Eventos.php?idseccion=1'>
                                <img src="../../pics/activos/comites/8.png" style="padding:3rem;">
                            </a>
                        </div>
                        <div class="card-content text-center" style="padding:0px;margin-top: -30px">
                            <img class="activator waves-effect waves-light" src="../../../icloud/images/Info.svg" style="width: 30px;"/>
                        </div>
                        <div class="card-reveal b-azul white-text">
                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                            <p></p>
                        </div>
                    </div>
                </div>        
                <div class="col s12 m10 l4">
                    <div class="card" style="box-shadow: none">
                        <div class="card-image waves-block efecto-btn">
                            <a href='Eventos/Eventos.php?idseccion=1'>
                                <img src="../../pics/activos/comites/14.png" style="padding:3rem;">
                            </a>
                        </div>
                        <div class="card-content text-center" style="padding:0px;margin-top: -30px">
                            <img class="activator waves-effect waves-light" src="../../../icloud/images/Info.svg" style="width: 30px;"/>
                        </div>
                        <div class="card-reveal b-azul white-text">
                            <span class="card-title white-text">Información adicional<i class="material-icons right">close</i></span>
                            <p></p>
                        </div>
                    </div>
                </div>       
            </div>   
        </div>     
    </div>     

<?php endif; ?>
<?php include "{$root}/components/layout_bottom.php"; ?>