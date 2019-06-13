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
                require('./Control_temporal.php');
                $objTemporal = new Control_temporal();
                $consulta2 = $objTemporal->mostrar_domicilio($fam);
                $cliente2 = mysqli_fetch_array($consulta2);

                $papa = $cliente2[0];
                $calle1 = $cliente2[1];
                $colonia1 = $cliente2[2];
                $cp1 = $cliente2[3];
                $idusuario = 1;
///////////////////////////////////////////////////////////////////////////////////

                $permiso = $objTemporal->mostrar_viajes($_GET['id']);
                if ($permiso) {
                    $permiso_temporal = mysqli_fetch_array($permiso); //datos
                    $permiso_id = $permiso_temporal[0];
                    $permiso_fecha2 = $permiso_temporal[1];
                    $permiso_correo = $permiso_temporal[2];
                    $permiso_alumno1 = $permiso_temporal[3];
                    $permiso_alumno2 = $permiso_temporal[4];
                    $permiso_alumno3 = $permiso_temporal[5];
                    $permiso_alumno4 = $permiso_temporal[6];
                    $permiso_alumno5 = $permiso_temporal[7];
                    $permiso_calle_numero = $permiso_temporal[8];
                    $permiso_colonia = $permiso_temporal[9];
                    $permiso_cp = $permiso_temporal[10];
                    $permiso_responsable = $permiso_temporal[11];
                    $permiso_parentesco = $permiso_temporal[12];
                    $permiso_celular = $permiso_temporal[13];
                    $permiso_telefono = $permiso_temporal[14];
                    $permiso_fecha_inicial = date("m-d-Y", strtotime(str_replace("/", "-", $permiso_temporal[15])));
                    $permiso_fecha_final = date("m-d-Y", strtotime(str_replace("/", "-", $permiso_temporal[16])));;
                    $permiso_turno = $permiso_temporal[17];
                    $permiso_comentarios = $permiso_temporal[18];
                    $permiso_calle = $permiso_temporal[19];
                    $permiso_colonia = $permiso_temporal[20];
                    $permiso_cp = $permiso_temporal[21];
                    $permiso_mensaje = $permiso_temporal[22];
                    //asigna fecha con formato legible en input 
                    function formato_permiso_fechas($fecha_formatear, $id_input){
                        echo "<script>"
                                . "var fecha = new Date('$fecha_formatear');"
                                . "var opciones = {weekday:'long', year:'numeric', month:'long',day:'numeric'};"
                                . "fecha = fecha.toLocaleDateString('es-MX', options);"
                                . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
                                . "$('#$id_input').val(fecha);"
                                . "</script>";
                    }
                    formato_permiso_fechas($permiso_fecha_inicial, "fecha_inicial");
                    formato_permiso_fechas($permiso_fecha_final, "fecha_final");
                }
                ?>

                <link href = "../bootstrap/css/bootstrap.min.css" rel = "stylesheet" media = "screen">
                <link href = "../css/bootstrap-datetimepicker.min.css" rel = "stylesheet" media = "screen">
                <link rel = "stylesheet" href = "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
                <script src = "//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>              

                <form id="RegisterUserForm" name="RegisterUserForm" action="Diario_Alta.php" method="post" onsubmit='Alta_Diario(); return false' >    
                    <center>
                        <p>
                            <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de solicitud:</font></label>
                            <input class="w3-input" name="fecha" type="text"  id="fecha_solicitud" value="<?php echo "$permiso_fecha2"; ?>" readonly="readonly" />        
                        </p> 
                        <p>
                            <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de inicial:</font></label>
                            <input class="w3-input" name="fecha" type="text"  id="fecha_inicial" value="" readonly="readonly" />        
                        </p> 
                        <p>
                            <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de final:</font></label>
                            <input class="w3-input" name="fecha" type="text"  id="fecha_final" value="" readonly="readonly" />        
                        </p> 
                        <p>
                            <label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Solicitante:</font></label>
                            <input class="w3-input" name="correo" type="text"  id="solicitante" value="<?php echo "$permiso_correo"; ?>"  readonly="readonly"/>             
                        </p>   
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

                        <p>
                            <label for="calle"><font face="Candara" size="3" COLOR="#2D35A9">Calle y Número:</font></label>
                            <input class="w3-input" name="calle" type="text"  id="calle" value="<?php echo "$permiso_calle"; ?>"  placeholder="Agrega calle y número"  minlength="5" maxlength="40" onkeyup="this.value = this.value.toUpperCase()"   required pattern="[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}" 
                                   title="Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales" readonly/>
                        </p>
                        <p>
                            <label for="colonia"><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label>
                            <input class="w3-input" name="colonia" type="text"  id="colonia"  value="<?php echo "$permiso_colonia"; ?>"  placeholder="Agrega colonia"  onkeyup="this.value = this.value.toUpperCase()"  minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}"
                                   title="Agrega colinia sin acentos ni signos especiales" required readonly/>
                        </p>
                        <!--
                        <p>
                        <label for="cp"><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label></td>
                        <input class="w3-input" name="cp" type="number"  value="<?php echo "ncp"; ?>"  id="cp" placeholder="Agrega CP"  readonly/>
                        </p>
                        -->       
                        <p>
                            <label for="ruta"><font face="Candara" size="3" COLOR="#2D35A9">Ruta:</font></label> 
                            <select type="select" name="ruta"  id="ruta"  disabled="disabled"> 
                                <option value="0"><?php echo "$permiso_turno"; ?> </option> 
                                <option value="General 2:50 PM">General 2:50 PM</option> 
                                <option value="Taller 4:30 PM">Taller 4:30 PM</option> 
                            </select>
                        </p>

                        <br>

                        <p>
                            <label for="Comentarios"><font face="Candara" size="3" COLOR="#2D35A9">Comentarios:</font></label>
                            <textarea class="w3-input"  id="Comentarios" name="comentarios" onkeyup="this.value = this.value.toUpperCase()" readonly><?php echo $permiso_comentarios; ?></textarea>
                        </p>

                        <p>
                            <label for="mensaje"><font face="Candara" size="3" COLOR="#2D35A9">Respuesta:</font></label>
                            <textarea class="w3-input"  id="mensaje" placeholder="Sin Respuesta" name="mensaje" readonly> <?php echo "$permiso_mensaje"; ?></textarea>
                        </p>
                        <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo "$permiso_id" ?>" />
                        <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo "$fam" ?>" />
                        <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo "$talumnos" ?>" />

                        <div id="custom-speed" class="btn">
                            <input type="submit"  name="submit" value="Regresar" onclick="Cancelar();return false;" />
                        </div>

                </form>
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
