<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Transportes/components/layout_top.php";
include_once "$root_icloud/Transportes/components/navbar.php";
include_once "$root_icloud/Transportes/components/sesion.php";
$idseccion = $_GET['idseccion'];

$user = $service->userinfo->get(); //get user info
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->acceso_login($correo);
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
    //show login url
    ?>
    <div class="caja-login" align="center">
        <h2>Mi Maguen</h2>
        <br><br>
        <?php echo '<a href="' . $authUrl . '"><img src="../../images/google.png" id="total"/></a>' ?>
    </div>
    <?php
} else {
    ?>
    <div class="row">    
        <div class="col s12 m12 l9 b-blanco border-azul" style="float: none;margin: 0 auto;"> 
            <div>
                <br>
                <h4 class="c-azul" style="text-align: center;">Cambio del dia</h4>
                <div>
                    <?php include('View_Diario.php');  ?> 
                </div>
                <?php
            }
            ?>               
        </div>
    </div>
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul">
        <i class="large material-icons">edit</i>
    </a>
    <ul>
        <li><a class="btn-floating green accent-3" href="vistas/vista_nuevo_permiso_diario.php?idseccion=<?php echo $idseccion; ?>"><i class="material-icons">add</i></a></li>
        <li><a class="btn-floating blue" href="https://www.chmd.edu.mx/pruebascd/icloud/menu.php?idseccion=<?php echo $idseccion; ?>"><i class="material-icons">keyboard_backspace</i></a></li>
            <?php
            echo '<li><a href="' . $redirect_uri . '?logout=1" class="btn-floating red" >'
            . "<i class='material-icons'>exit_to_app</i>Salir</a></li>";
            ?>
    </ul>
</div>

<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
    });
</script>


<?php include "$root_icloud/Transportes/components/layout_bottom.php"; ?>