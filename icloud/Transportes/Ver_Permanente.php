<?php
session_start(); //session start

include_once("../Model/DBManager.php");
require_once ('../libraries/Google/autoload.php');
require_once '../Model/Config.php';
//incase of logout request, just unset the session var
//zona horaria para America/Mexico_city 
require '../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}

$service = new Google_Service_Oauth2($client);

//echo "$service";

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
/* Agregar diseño */
if (isset($authUrl)) {
    header('Location: ../index.php');
} else {
    /* enviar datos a procesar */

    if (isset($_GET['id'])) {

        /* fin de guardar datos a procesar */
        $time = time();
        $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $arrayDias = array('Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado');

        $user = $service->userinfo->get(); //get user info 
        $correo = $user->email;
        require('../Model/Login.php');
        $objCliente = new Login();
        $consulta = $objCliente->Acceso($correo);
        if ($consulta) { //if user already exist change greeting text to "Welcome Back"
            if ($cliente = mysqli_fetch_array($consulta)) {

                $id = $cliente[0];
                $correo1 = $cliente[1];
                $perfil = $cliente[2];
                $estatus = $cliente[3];
                $fam = $cliente[4];
                $_SESSION['permiso'] = 1;
                $_SESSION['nickname'] = $fam;

/////////////////////datos de domicilio de familia//////////////////////////////////
                require('./Control_permanente.php');
                $objPermanente = new Control_permanente();
                $consulta2 = $objPermanente->mostrar_domicilio($fam);
                $cliente2 = mysqli_fetch_array($consulta2);

                $papa = $cliente2[0];
                $calle1 = $cliente2[1];
                $colonia1 = $cliente2[2];
                $cp1 = $cliente2[3];
                $idusuario = 1;
///////////////////////////////////////////////////////////////////////////////////

                $permiso = $objPermanente->mostrar_permanente($_GET['id']);
                if ($permiso) {
                    $permiso_permanente = mysqli_fetch_array($permiso); //datos
                    $permiso_id = $permiso_permanente[0];
                    $permiso_fecha2 = $permiso_permanente[1];
                    $permiso_correo = $permiso_permanente[2];
                    $permiso_calle = $permiso_permanente[3];
                    $permiso_colonia = $permiso_permanente[4];
                    $permiso_usu_cp = $permiso_permanente[5];
                    $permiso_calle_numero = $permiso_permanente[6];
                    $permiso_colonia = $permiso_permanente[7];
                    $permiso_vpp_cp = $permiso_permanente[8];
                    $permiso_ruta = $permiso_permanente[9];
                    $permiso_comentarios = $permiso_permanente[10];
                    $permiso_lunes = $permiso_permanente[11];
                    $permiso_martes = $permiso_permanente[12];
                    $permiso_miercoles = $permiso_permanente[13];
                    $permiso_jueves = $permiso_permanente[14];
                    $permiso_viernes = $permiso_permanente[15];
                    $permiso_alumno1 = $permiso_permanente[16];
                    $permiso_alumno2 = $permiso_permanente[17];
                    $permiso_alumno3 = $permiso_permanente[18];
                    $permiso_alumno4 = $permiso_permanente[19];
                    $permiso_alumno5 = $permiso_permanente[20];
                    $permiso_mensaje = $permiso_permanente[21];
                }
                function comprueba_dia($dia){
                    if (empty($dia) || is_null($dia) || strlen($dia) == 1) {
                        echo " ";
                        return;
                    }
                    echo "$dia ";
                }
                ?>

                <link href = "../bootstrap/css/bootstrap.min.css" rel = "stylesheet" media = "screen">
                <link href = "../css/bootstrap-datetimepicker.min.css" rel = "stylesheet" media = "screen">
                <link rel = "stylesheet" href = "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
                <script src = "//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>              

                <center>
                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Fecha de solicitud:</font></label></div>
                        <div class="panel-body">
                <?php echo "$permiso_fecha2"; ?>
                        </div>   
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Solicitante:</font></label></div>
                        <div class="panel-body">
                            <?php echo "$permiso_correo" ?>
                        </div>   
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Dias de permiso:</font></label></div>
                        <div class="panel-body">
                            <?php comprueba_dia($permiso_lunes);comprueba_dia($permiso_martes);comprueba_dia($permiso_miercoles);comprueba_dia($permiso_jueves);comprueba_dia($permiso_viernes); ?>
                        </div>   
                    </div>  
                    <!--------------------------------------------------------------------------->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
                    <script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
                    <script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>

                    <!--------------------------------------------------------------------------->

                    <br>
                    <h2><font color="#124A7B">Alumnos para el  permiso</font></h2>
                    <table id="gradient-style" summary="Meeting Results">
                        <thead>
                            <tr>
                            <!--<th bgcolor="#CDCDCD">Id</th>-->
                                <th bgcolor="#CDCDCD">Alumno</th>
                                <th bgcolor="#CDCDCD">Grupo</th>
                                 <!--<th bgcolor="#CDCDCD">Grado</th>-->
                            </tr>
                        </thead>
                        <?php
                        $consulta1 = $objCliente->mostrar_alumnos_permiso($permiso_alumno1, $permiso_alumno2, $permiso_alumno3, $permiso_alumno4, $permiso_alumno5);
                        if ($consulta1) {
                            $counter = 0;
                            // $numero = mysql_num_rows($consulta);
                            while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                $counter = $counter + 1;
                                $idalu = $row1[0];
                                $nombre = $cliente1[1];
                                $grado = $cliente1[2];
                                $grupo = $cliente1[3];
                                $contador++;
                                ?>
                                <tr>
                                    <td bgcolor="#ffffff"><?php echo $nombre; ?></td>
                                    <td bgcolor="#ffffff"><?php echo $grupo; ?></td>
                                </tr>
                                <?php
                            }
                            $talumnos = $counter;
                        }
                        ?>
                    </table>
                    <h2><font color="#124A7B">Dirección de cambio</font> </h2> 

                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Calle y Número:</font></label></div>
                        <div class="panel-body">
                <?php echo "$permiso_calle"; ?>
                        </div>   
                    </div>   
                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label></div>
                        <div class="panel-body">
                <?php echo "$permiso_colonia"; ?>
                        </div>   
                    </div>   
                    <!--
                    <p>
                    <label for="cp"><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label></td>
                    <input class="w3-input" name="cp" type="number"  value="<?php echo "ncp"; ?>"  id="cp" placeholder="Agrega CP"  readonly/>
                    </p>
                    -->  
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle">
                <?php echo "$permiso_ruta"; ?>
                            <span class="caret"></span>
                        </button>
                    </div>
                    <br>
                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Comentarios:</font></label></div>
                        <div class="panel-body">
                <?php echo $permiso_comentarios; ?>
                        </div>   
                    </div>  
                    <div class="panel panel-default">
                        <div class="panel-heading"><label><font face="Candara" size="3" COLOR="#2D35A9">Mensaje:</font></label></div>
                        <div class="panel-body">
                    <?php echo "$permiso_mensaje"; ?>
                        </div>   
                    </div> 
                    <a href="PPermanente.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
                    <?php
                } else {
                    echo 'Este usuario no tiene Acceso:' . $user->email . ',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="' . $redirect_uri . '?logout=1"> Log Out</a>]';
                }
            } else { //error en cosulta
                echo 'Error en cosulta';
            }
        }
    }
    ?>
