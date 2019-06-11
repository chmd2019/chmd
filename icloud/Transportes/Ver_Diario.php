<?php
session_start(); //session start

include_once("../Model/DBManager.php");
require_once ('../libraries/Google/autoload.php');
require_once '../Model/Config.php';

//incase of logout request, just unset the session var
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
                require('Control_dia.php');
                $objDia = new Control_dia();
                $consulta2 = $objDia->mostrar_domicilio($fam);
                $cliente2 = mysqli_fetch_array($consulta2);

                $papa = $cliente2[0];
                $calle1 = $cliente2[1];
                $colonia1 = $cliente2[2];
                $cp1 = $cliente2[3];
                $idusuario = 1;
///////////////////////////////////////////////////////////////////////////////////

                $consulta4 = $objCliente->mostrar_permiso_diario($_GET['id']);
                $cliente4 = mysqli_fetch_array($consulta4);
                $folio = $cliente4[0];
                $fecha2 = $cliente4[1];
                $correo2 = $cliente4[2];
                $calle = $cliente4[3];
                $colonia = $cliente4[4];
                $cp = $cliente4[5];
                $ncalle = $cliente4[6];
                $ncolonia = $cliente4[7];
                $ncp = $cliente4[8];
                $rutan = $cliente4[9];
                $comentaios = $cliente4[10];
                $alumno1 = $cliente4[11];
                $alumno2 = $cliente4[12];
                $alumno3 = $cliente4[13];
                $alumno4 = $cliente4[14];
                $alumno5 = $cliente4[15];
                $mensaje = $cliente4[16];
                $fecha1 = date("m-d-Y", strtotime(str_replace('/', '-', $cliente4[17])));
                ///Ingreso codigo de alta//
                $fecha_detalle = "<script>"
                        . "var fecha = new Date('$fecha1');"
                        . "var opciones = { weekday :'long', year: 'numeric', month:'long', day:'numeric'};"
                        . "var fecha_detalle = fecha.toLocaleDateString('es-MX', opciones); "
                        . "$('#fecha-programada').val(fecha_detalle);"
                        . "</script>";
                echo $fecha_detalle;
                ?>
                <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
                <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>              
                
                <form id="RegisterUserForm" name="RegisterUserForm" action="Diario_Alta.php" method="post" onsubmit='Alta_Diario(); return false' >    
                    <center>
                        <p>
                            <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de solicitud:</font></label>
                            <input class="w3-input" name="fecha" type="text"  id="fecha" value="<?php echo $fecha2; ?>" readonly="readonly" />        
                        </p> 
                        <p>
                            <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha programada:</font></label>
                            <input class="w3-input" name="fecha" type="text" id="fecha-programada" value="" readonly="readonly" />    
                        </p> 
                        <p>
                            <label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Solicitante:</font></label>
                            <input class="w3-input" name="correo" type="text"  id="correo" value="<?php echo "$correo2"; ?>"  readonly="readonly"/>             
                        </p>   

                        <div id="formulariomayores1" style="display: none;">
                            <input type="button" value="Para otro día" onclick="mostrar()"> 
                        </div>
                        <!--Este formulario esta oculto-->
                        <div id="formulariomayores" style="display: none;">
                            <br>
                            <label for="papa"><font face="Candara" size="3" COLOR="#2D35A9">Para el día:</font></label>
                            <div class="form-group">

                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" id="fecha1" name="fecha1" value="" placeholder="dd/mm/aaaa"   readonly required >
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <input type="hidden" id="dtp_input2" value="" /><br/>
                            </div>
                        </div>
                        <!--------------------------------------------------------------------------->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
                        <script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
                        <script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>

                        <!--------------------------------------------------------------------------->

                        <br>
                        <h2><font color="#124A7B">Alumnos para el  Alumnos</font></h2>
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
                            $consulta1 = $objCliente->mostrar_alumnos_permiso($alumno1, $alumno2, $alumno3, $alumno4, $alumno5);
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
                            <input class="w3-input" name="calle" type="text"  id="calle" value="<?php echo $ncalle; ?>"  placeholder="Agrega calle y número"  minlength="5" maxlength="40" onkeyup="this.value = this.value.toUpperCase()"   required pattern="[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}" 
                                   title="Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales" readonly/>
                        </p>
                        <p>
                            <label for="colonia"><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label>
                            <input class="w3-input" name="colonia" type="text"  id="colonia"  value="<?php echo $ncolonia; ?>"  placeholder="Agrega colonia"  onkeyup="this.value = this.value.toUpperCase()"  minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}"
                                   title="Agrega colinia sin acentos ni signos especiales" required readonly/>
                        </p>
                        <!--
                        <p>
                        <label for="cp"><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label></td>
                        <input class="w3-input" name="cp" type="number"  value="<?php echo $ncp; ?>"  id="cp" placeholder="Agrega CP"  readonly/>
                        </p>
                        -->       
                        <p>
                            <label for="ruta"><font face="Candara" size="3" COLOR="#2D35A9">Ruta:</font></label> 
                            <select type="select" name="ruta"  id="ruta"  disabled="disabled"> 
                                <option value="0"><?php echo "$rutan"; ?> </option> 
                                <option value="General 2:50 PM">General 2:50 PM</option> 
                                <option value="Taller 4:30 PM">Taller 4:30 PM</option> 
                            </select>
                        </p>

                        <br>

                        <p>
                            <label for="Comentarios"><font face="Candara" size="3" COLOR="#2D35A9">Comentarios:</font></label>
                            <textarea class="w3-input"  id="Comentarios" name="comentarios" onkeyup="this.value = this.value.toUpperCase()" readonly><?php echo $comentaios; ?></textarea>
                        </p>

                        <p>
                            <label for="mensaje"><font face="Candara" size="3" COLOR="#2D35A9">Respuesta:</font></label>
                            <textarea class="w3-input"  id="mensaje" placeholder="Sin Respuesta" name="mensaje" readonly> <?php echo "$mensaje"; ?></textarea>
                        </p>
                        <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $id ?>" />
                        <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $fam ?>" />
                        <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />

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
    }//
}
?>