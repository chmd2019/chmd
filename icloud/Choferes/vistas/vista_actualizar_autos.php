<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

session_start();

include "$root_icloud/components/layout_top.php";
require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";
include ("$root_icloud/Choferes/common/ControlChoferes.php");

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
  //usaurio
  $user = $service->userinfo->get();
  $correo = $user->email;
  $objCliente = new Login();
  $consulta = $objCliente->acceso_login($correo);
  //manejo de fechas y tiempo
  $date_helper = new DateHelper();
  $date_helper->set_timezone();
  $meses = $date_helper->obtener_meses();
  $dias = $date_helper->obtener_dias();
  if ($consulta = mysqli_fetch_array($consulta)) {
    //ca  mpos necesarios en tabla Ventana_permisos
    $idusuario = $consulta[0];
    $nombre = $consulta[1];
    $familia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);
    //COnseguir id_chofer
    $id_chofer=$_GET['idchofer'];
    //se estableció 4 para permisos extraordinarios
    $tipo_permiso = 4;
    $fecha_creacion = $dias[date("w")]
    . ", " . date("d")
    . " de " . $meses[date("m") - 1]
    . " de "
    . date("Y")
    . ", "
    . date("h:i a");

    $fecha_minima = date("Y-m-d");
    $fecha_hoy = $dias[date('w')] . ", " . date('d') .
    " de " . $meses[date('m') - 1] . " de " . date('Y');
    //se establece hora limite a 2:30 PM

    $btn_fecha = true;
    if ($date_helper->comprobar_hora_limite("14:30")) {
      $fecha_minima = strtotime("+1 day", strtotime($fecha_minima));
      $fecha_minima = date("m/d/Y", $fecha_minima);
      $fecha_hoy = "";
      $btn_fecha = false;
    } else {
      $fecha_minima = date("m/d/Y");
      $btn_fecha = true;
    }
    include "$root_icloud/components/navbar.php";
    ?>
    <div class="row">
      <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
        <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
          <a class="waves-effect waves-light"
          href="<?php echo $redirect_uri?>/Choferes/Choferes.php">
          <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
          <style type="text/css">
          .sth0{fill:#6DC1EC;}
          .sth1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
          .sth2{fill-rule:evenodd;clip-rule:evenodd;fill:#0E497B;}
          </style>
          <path class="sth0" d="M559.25,192.49H45.33c-16.68,0-30.33-13.65-30.33-30.33V50.42c0-16.68,13.65-30.33,30.33-30.33h513.92
          c16.68,0,30.33,13.65,30.33,30.33v111.74C589.58,178.84,575.93,192.49,559.25,192.49z"/>
          <g>
            <path class="sth1" d="M228.72,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
            c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
            c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C228,130.45,228.27,129.64,228.72,128.74z M270.07,110.86l-11.11-25.55
            l-11.1,25.55H270.07z"/>
            <path class="sth1" d="M313.14,83.05h-15.35c-2.89,0-5.15-2.35-5.15-5.15s2.26-5.15,5.15-5.15h41.98c2.8,0,5.06,2.35,5.06,5.15
            s-2.26,5.15-5.06,5.15h-15.44v47.85c0,3.07-2.53,5.51-5.6,5.51c-3.07,0-5.6-2.44-5.6-5.51V83.05z"/>
            <path class="sth1" d="M351.6,78.36c0-3.16,2.44-5.6,5.6-5.6h22.57c7.95,0,14.17,2.35,18.24,6.32c3.34,3.43,5.24,8.12,5.24,13.63
            v0.18c0,10.11-5.87,16.25-14.36,18.87l12.1,15.26c1.08,1.35,1.81,2.53,1.81,4.24c0,3.07-2.62,5.15-5.33,5.15
            c-2.53,0-4.15-1.17-5.42-2.89l-15.35-19.59h-13.99v16.97c0,3.07-2.44,5.51-5.51,5.51c-3.16,0-5.6-2.44-5.6-5.51V78.36z
            M378.96,104.09c7.95,0,13-4.15,13-10.56v-0.18c0-6.77-4.88-10.47-13.09-10.47h-16.16v21.22H378.96z"/>
            <path class="sth1" d="M408.75,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
            c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
            c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C408.03,130.45,408.3,129.64,408.75,128.74z M450.1,110.86L439,85.31
            l-11.1,25.55H450.1z M436.02,65.18c0-0.63,0.36-1.44,0.72-1.99l5.15-7.95c0.99-1.62,2.44-2.62,4.33-2.62c2.89,0,6.5,1.81,6.5,3.52
            c0,0.99-0.63,1.9-1.53,2.71l-6.05,5.78c-2.17,1.99-3.88,2.44-6.41,2.44C437.19,67.07,436.02,66.35,436.02,65.18z"/>
            <path class="sth1" d="M476.01,128.92c-1.26-0.9-2.17-2.44-2.17-4.24c0-2.89,2.35-5.15,5.24-5.15c1.54,0,2.53,0.45,3.25,0.99
            c5.24,4.15,10.83,6.5,17.7,6.5c6.86,0,11.2-3.25,11.2-7.95v-0.18c0-4.51-2.53-6.95-14.26-9.66c-13.45-3.25-21.04-7.22-21.04-18.87
            v-0.18c0-10.83,9.03-18.33,21.58-18.33c7.95,0,14.36,2.08,20.04,5.87c1.26,0.72,2.44,2.26,2.44,4.42c0,2.89-2.35,5.15-5.24,5.15
            c-1.08,0-1.99-0.27-2.89-0.81c-4.88-3.16-9.57-4.79-14.54-4.79c-6.5,0-10.29,3.34-10.29,7.49v0.18c0,4.88,2.89,7.04,15.08,9.93
            c13.36,3.25,20.22,8.04,20.22,18.51v0.18c0,11.83-9.3,18.87-22.57,18.87C491.18,136.86,483.05,134.15,476.01,128.92z"/>
          </g>
          <g>
            <path class="sth2" d="M81.84,94.54h97.68c14.9,0,14.9,23.73,0,23.73H81.84l26.49,27.04c11.04,11.04-5.52,27.59-16.56,16.56
            l-47.46-46.91c-4.41-4.97-4.41-12.69,0-17.11l47.46-46.91c11.04-11.59,27.59,5.52,16.56,16.56L81.84,94.54z"/>
          </g>
        </svg>
        <!--
        <i class="material-icons left">keyboard_backspace</i>Atrás
      -->
    </a>
  </div>

        <h5 class="center-align c-azul">Actualiza los datos del Automóvil(es)</h5>
        <br>
        <?php
        $ctrol = new ControlChoferes();
        $consulta2=$ctrol->cant_tarjetones_activos($familia);
        $Nautos=0;
        $existe_auto=false;
        if($auto = mysqli_fetch_array($consulta2))
        {
          $Nautos= $auto['ntarjetones'];
        //echo 'N autos:'.$Nautos;
          if($Nautos==0){
            $n=1;
            $existe_auto=true;
            include('add_auto.php');
            /*
            for($n=1; $n<=2; $n++){
              include('add_auto.php');
            }*/
          }else if($Nautos==1){
            $n=1;
            $existe_auto=true;
            include('add_auto.php');
          }else{
            ?>
            <ul class="collapsible">
            <li>
            <div class="collapsible-header"><i class="material-icons">directions_car</i>No más de dos Carros</div>
            <div class="collapsible-body"><span>La familia solo puede tener dos Automóviles asignados, si desea cambiarlos debe eliminar los existentes y crear un nuevo registro, o editar los ya existentes.</span></div>
            </li>
            </ul>
          <?php
              }
        }
           ?>
           <br>
<?php
//mostrar boton enviar
if ($Nautos<2)  {
?>


<div class="col s12 l6" style="float: none;margin: 0 auto;">
    <button class="btn waves-effect waves-light b-azul white-text w-100"
            id="btn_enviar_formulario"
            type="button"
            onclick="enviar_formulario( <?=$id_chofer?>, <?=$Nautos?>, <?=$familia?> , <?=$existe_auto?>)">RENOVAR
        <i class="material-icons right">send</i>
    </button>
</div>
<br>
<br>
<?php
}
?>
</div>
</div>
<?php
}
}
?>
<!---
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
    href="<?php echo $redirect_uri?>/Choferes/Choferes.php">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>
--->

<div class="loading" id="loading" >
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
  $("#loading").hide();
});
</script>
<script type="text/javascript" src="../js/renovar_autos.js"></script>

<?php include "$root_icloud/components/layout_bottom.php"; ?>
