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
        <br>
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

            for($n=1; $n<=2; $n++){
              include('add_auto.php');
            }
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

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul" href="<?php echo $redirect_uri?>/Choferes/Choferes.php">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>

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
