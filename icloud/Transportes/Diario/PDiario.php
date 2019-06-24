<?php
include '../components/layout_top.php';
include '../components/sesion.php';
$user = $service->userinfo->get(); //get user info
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
//zona horaria para America/Mexico_city 
require '../../Helpers/DateHelper.php';
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
        <h2 class="alert alert-light text-primary text-center" role="alert">Mi Maguen</h2>
        <br><br>
        <?php echo '<a href="' . $authUrl . '"><img src="../../images/google.png" id="total"/></a>' ?>
    </div>
    <?php
} else {
    include '../components/navbar.php';
    ?>
    <div class="row"><br><br>
        <div class="col-sm-12 col-md-9 b-blanco border border-primary" style="margin:auto;">
            <br>
            <br>
            <h2 class="alert alert-light text-center c-azul" role="alert">Cambio del dia</h2>

            <div class="row">
                <div class="col-sm-12" style="margin:auto">
                    <center>  
                        <div class="container">
                            <?php include('View_Diario.php'); ?> 
                        </div>
                    </center> 
                </div>                
            </div>
            <br>
            <?php
        }
        ?>        
        <?php include('./modales/modal_form_diario_alta.php'); ?>        
    </div>
</div>
<?php include '../components/layout_bottom.php'; ?>