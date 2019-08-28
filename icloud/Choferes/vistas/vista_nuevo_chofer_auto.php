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
        <h5 class="center-align c-azul">Nuevo Chofer</h5>
        <?php //contar cuantos choferes tiene esta familia
        $ctrol = new ControlChoferes();

        $consulta1=$ctrol->Cant_choferes($familia);
        $Nchoferes=0;
        if($chofer = mysqli_fetch_array($consulta1))
        {
                $NChoferes= $chofer['nchoferes'];
              //  echo 'N choferes: '.$NChoferes;
            if ($NChoferes==0){
                  for($n = 1; $n<=2 ;$n++ ){
                    include('add_chofer.php');
                  }
            }
            //si existe un chofer
            else if( $NChoferes==1 ){
              $n=1;
              include('add_chofer.php');
            }else{
              ?>
              <ul class="collapsible">
              <li>
              <div class="collapsible-header"><i class="material-icons">person</i>No más de dos Choferes.</div>
              <div class="collapsible-body"><span>  La familia solo puede tener dos choferes Asignados, si desea cambiar de chofer cancele uno de los Registrados, para hacer un nuevo registro.</span></div>
              </li>
              </ul>
              <?php
            }
        }
         ?>
        <h5 class="center-align c-azul">Nuevo Automóvil</h5>
        <?php
        $consulta2=$ctrol->cant_tarjetones_activos($familia);
        $Nautos=0;
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
//mostrar boton enviar
if ($NChoferes<2 || $Nautos<2)  {
?>


<div class="col s12 l6" style="float: none;margin: 0 auto;">
    <button class="btn waves-effect waves-light b-azul white-text w-100"
            id="btn_enviar_formulario"
            type="button"
            onclick="enviar_formulario(<?=$NChoferes?>,<?=$Nautos?>, <?=$familia?> )">ENVIAR
        <i class="material-icons right">send</i>
    </button>
</div>
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
<script type="text/javascript" src="../js/validar_auto_chofer.js"></script>
<?php include "$root_icloud/components/layout_bottom.php"; ?>
