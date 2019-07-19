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
    $nfamilia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);
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
    <?php
    $marca='';
    $modelo= '';
    $color= '';
    $placas= '';
    if (isset($_GET['idcarro'])){
      $id_carro= $_GET['idcarro'];
      $ctrol=new ControlChoferes();
      $consulta1=$ctrol->get_auto($id_carro);
      if($auto = mysqli_fetch_array($consulta1))
      {
        $marca= $auto['marca'];
        $modelo= $auto['modelo'];
        $color= $auto['color'];
        $placas= $auto['placas'];
      }
    }
     ?>
    <div class="row">
      <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
        <br>
        <h5 class="center-align c-azul">Editar Automovil</h5>
        <br>
        <div class="row" style="padding:0rem .5rem;">
          <div class="col s12 l6">
            <label for="marca" style="margin-left: 1rem">Marca</label>
            <div class="input-field">
              <i class="material-icons prefix c-azul">airport_shuttle</i>
              <input value="<?=$marca?>"
              id="marca"
              style="font-size: 1rem"
              type="text" placeholder="INGRESE MARCA" />
            </div>
            </div>
          <div class="col s12 l6">
            <label for="modelo" style="margin-left: 1rem">Modelo</label>
            <div class="input-field">
              <i class="material-icons prefix c-azul">directions_car</i>
              <input value="<?=$modelo?>"
              id="modelo"
              style="font-size: 1rem"
              type="text" placeholder="INGRESE MODELO" />
            </div>
          </div>
          <div class="col s12 l6">
            <label for="color" style="margin-left: 1rem">Color</label>
            <div class="input-field">
              <i class="material-icons prefix c-azul">color_lens</i>
              <input value="<?=$color?>"
              id="color"
              style="font-size: 1rem"
              type="text" placeholder="INGRESE COLOR"/>
            </div>
          </div>
          <div class="col s12 l6">
            <label for="placa" style="margin-left: 1rem">Placa</label>
            <div class="input-field">
              <i class="material-icons prefix c-azul">aspect_ratio</i>
              <input value="<?=$placas?>"
              id="placa"
              style="font-size: 1rem"
              type="text" placeholder="INGRESE PLACA" />
            </div>

          </div>
          <div class="col s12 l6" style="float: none;margin: 0 auto;">
              <button class="btn waves-effect waves-light b-azul white-text w-100"
                      id="btn_enviar_formulario"
                      type="button"
                      onclick="enviar_formulario('<?php echo $id_carro;?>')" >Editar
                  <i class="material-icons right">edit</i>
              </button>
          </div>
        </div>
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
<script type="text/javascript">
$(document).ready(function () {
  $("#loading").hide();
});
</script>
<script type="text/javascript" src="../js/edit_auto.js"></script>
<?php include "$root_icloud/components/layout_bottom.php"; ?>
