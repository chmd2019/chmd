<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Transportes/components/sesion.php";
include_once "$root_icloud/components/layout_top.php";
$idseccion = $_GET['idseccion'];

//zona horaria para America/Mexico_city
require "$root_icloud/Helpers/DateHelper.php";
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m-d-Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
if (isset($authUrl)) {
    header("Location: $redirect_uri?logout=1");
} else {
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    include_once "$root_icloud/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 m12 l9 b-blanco border-azul" style="float: none;margin: 0 auto;">
            <div>
                <br>
                <h4 class="c-azul" style="text-align: center;">Eventos</h4>
                <div>
                    <?php include './View_eventos.php'; ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<script>

$("th").css("text-align", "center");
$("td").css("text-align", "center");
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        //set_table_desordenada('tabla'); 
        $(".modal").modal();
    });    
    setInterval(()=>{window.location.reload();},30000);
</script>


<?php include_once "$root_icloud/components/layout_bottom.php"; ?>
