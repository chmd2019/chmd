<?php
session_start(); //session start
include_once("../Model/DBManager.php");
require_once("../libraries/Google/autoload.php");
require_once("../Model/Config.php");
//zona horaria para America/Mexico_city 
require '../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
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

    if (isset($_POST['submit'])) {
        require('Control_dia.php');
        $idusuario = htmlspecialchars(trim($_POST['idusuario']));
        $alumno1 = htmlspecialchars(trim($_POST['alumno1']));
        $alumno2 = htmlspecialchars(trim($_POST['alumno2']));
        $alumno3 = htmlspecialchars(trim($_POST['alumno3']));
        $alumno4 = htmlspecialchars(trim($_POST['alumno4']));
        $alumno5 = htmlspecialchars(trim($_POST['alumno5']));
        $calle = htmlspecialchars(trim($_POST['calle']));
        $colonia = htmlspecialchars(trim($_POST['colonia']));
        $cp = htmlspecialchars(trim($_POST['cp']));
        $ruta = htmlspecialchars(trim($_POST['ruta']));
        $comentarios = htmlspecialchars(trim($_POST['comentarios']));
        $talumnos = htmlspecialchars(trim($_POST['suma']));
        $nfamilia = htmlspecialchars(trim($_POST['nfamilia']));
        $fecha = htmlspecialchars(trim($_POST['fecha']));
        $fecha1 = htmlspecialchars(trim($_POST['fecha1']));

        if (is_null($idusuario)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($nfamilia)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($alumno1)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($alumno2)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($alumno3)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($alumno4)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($alumno5)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($calle)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($colonia)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($cp)) {
            echo 'Error intentar de nuevo';
            return false;
        }
        if (is_null($ruta)) {
            echo 'Error intentar de nuevo';
            return false;
        }

        //validacion despues de las 11:30 el mismo dia

        $dia = date("d");
        $mes = date("m");
        $anio = date("Y");
        $validafecha = $dia . "/" . $mes . "/" . $anio;

        if ($validafecha == $fecha1) {
            echo "<font color='red'>fuera de horrario y fecha</font> ";
        } else {
            $objCliente = new Control_dia();
            if ($objCliente->Diario_Alta(array($idusuario,
                        $alumno1,
                        $alumno2,
                        $alumno3,
                        $alumno4,
                        $alumno5,
                        $calle,
                        $colonia,
                        $cp,
                        $ruta,
                        $comentarios,
                        $talumnos,
                        $nfamilia,
                        $fecha,
                        $fecha1)) == false) {
                echo 'Solicitud Guardada';
            } else {
                echo 'Se produjo un error. Intente nuevamente ';
            }
        }
        ////////////////////////VIN DE VALIDACION
    } else {
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
                ///Ingreso codigo de alta//
                ?><link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
                <script type="text/javascript">
                    alertify.alert("<h2><font color='#124A7B'>Cambio del día:</font> </h2><p align='justify'>Los cambios para el mismo día deberán solicitarse antes de las 11:30 horas, ya que el sistema no permitirá realizar solicitudes después del horario establecido, sin embargo podrá hacer solicitudes para fechas posteriores.<br> <b><font color='red'>NOTA:</b>Todas las solicitudes están sujetas a disponibilidad.</font></p>",
                            function () {});
                    $(document).ready(function () {
                        //alert("Si su permiso es para el día en que lo solicita, deberá hacerlo antes de las 11:30 A.M. El sistema no permitirá registrar permisos después de esta hora.");  

                        $("#reside").change(function () {
                            var dato = $('select[id=reside]').val();
                            if (dato == '1') {
                                $("#calle").val("Periferico Boulevard Manuel Avila Camacho 620");
                                $("#colonia").val("Lomas de Sotelo");
                                $("#cp").val("53538");
                            }
                            if (dato == '2') {

                                $("#calle").val('<?php echo $calle1; ?>');
                                $("#colonia").val('<?php echo $colonia1; ?>');
                                $("#cp").val('<?php echo $cp1; ?>');
                            }
                            if (dato == '0') {
                                $("#calle").val("");
                                $("#colonia").val("");
                                $("#cp").val("");
                            }
                        });
                    });

                    function mostrar() {
                        $("#formulariomayores").css("display", "block");
                    }
                </script>
                <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                <script type="text/javascript">
                    $(function () {
                        $("#calle").autocomplete({
                            source: "Complete_domicilios.php",
                            minLength: 2,
                            select: function (event, ui) {
                                event.preventDefault();
                                $('#calle').val(ui.item.calle_numero);
                                $('#colonia').val(ui.item.colonia);
                                $('#cp').val(ui.item.cp);
                                $('#id').val(ui.item.id);
                            }
                        });
                    });
                </script>
                <form id="RegisterUserForm" name="RegisterUserForm" action="Diario_Alta.php" method="post" onsubmit='Alta_Diario(); return false'>
                    <center>
                        <p>
                            <label for="fecha"><font face="Candara" size="3" COLOR="#2D35A9">Fecha de solicitud:</font></label>
                            <input class="w3-input" name="fecha" type="text" id="fecha" value="<?php echo $arrayDias[date('w')] . " , " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" readonly="readonly" />
                        </p>
                        <p>
                            <label for="idusuario"><font face="Candara" size="3" COLOR="#2D35A9">Solicitante:</font></label>
                            <input class="w3-input" name="correo" type="text" id="correo" value="<?php echo " $correo "; ?>" readonly="readonly" />
                        </p>
                        <label for="papa"><font face="Candara" size="3" COLOR="#2D35A9">Para el día:</font></label><br>
                        <?php
                        if ($objDateHelper->get_time_day()) {
                            echo "<b>Seleccione la fecha de su permiso.</b>";
                            echo "<script>$('#formulariomayores').css('display', 'block');"
                            . "document.getElementById('formulariomayores1').style.visibility = 'hidden';"
                            . "</script>";
                        } else {
                            echo "<b>Si su permiso es para otro día selección aquí.</b>";
                            echo "<script>$('#formulariomayores1').css('display', 'block');</script>";
                        }
                        ?>
                        <div id="formulariomayores1" style="display: none;">
                            <a href="#" onclick="mostrar()"><img src="../pics/calendario.fw.png" width="50" height="50"></a>
                                <!--<input type="image" src="../pics/calendario.fw.png" onclick="mostrar()">-->
                        </div>
                        <div id="formulariomayores" style="display: none;">
                            <br>
                            <div class="form-group">
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" id="fecha1" name="fecha1" value="" placeholder="dd/mm/aaaa" readonly required>
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
                        <?php
                        $i = 0;
                        $lista_fechas;
                        $fecha_calendario_escolar = $objDateHelper->get_calendario_escolar();
                        if ($fecha_calendario_escolar) {
                            while ($respuesta_calendario_escolar = mysqli_fetch_array($fecha_calendario_escolar)) {
                                $lista_fechas[$i] = $respuesta_calendario_escolar[1];
                                $i++;
                            }
                        }
                        ?>
                        <script type="text/javascript">
                                var calendario_escolar = <?php echo json_encode($lista_fechas) ?>;
                                $('.form_date').datetimepicker({
                                    language: 'es',
                                    weekStart: 1,
                                    todayBtn: 1,
                                    autoclose: 1,
                                    todayHighlight: 1,
                                    startView: 2,
                                    minView: 2,
                                    startDate: '+0d',
                                    daysOfWeekDisabled: [0, 6],
                                    datesDisabled: calendario_escolar,
                                    forceParse: 0, 
                                });
                        </script>
                        <script>
                            jQuery(document).ready(function ($) {
                                var requiredCheckboxes = $(':checkbox[required]');
                                requiredCheckboxes.on('change', function (e) {
                                    var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
                                    var isChecked = checkboxGroup.is(':checked');
                                    checkboxGroup.prop('required', !isChecked);
                                });
                            });
                        </script>
                        <!--------------------------------------------------------------------------->
                        <br>
                        <h2>
                            <font color="#124A7B">Selecciona Alumnos</font>
                        </h2>
                        <table id="gradient-style" summary="Meeting Results">
                            <thead>
                                <tr>
                                    <!--<th bgcolor="#CDCDCD">Id</th>-->
                                    <th bgcolor="#CDCDCD">Alumno</th>
                                    <th bgcolor="#CDCDCD">Grupo</th>
                                    <!--<th bgcolor="#CDCDCD">Grado</th>-->
                                    <th bgcolor="#CDCDCD">Activar</th>
                                </tr>
                            </thead>
                            <?php
                            $consulta1 = $objCliente->mostrar_alumnos($fam);
                            if ($consulta1) {
                                $counter = 0;
                                // $numero = mysql_num_rows($consulta);
                                while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                    $counter = $counter + 1;
                                    ?>
                                    <tr id="fila-<?php echo $cliente['id'] ?>">
                                        <!--<td bgcolor="#ffffff"><?php echo $cliente1['id'] ?></td>-->
                                        <td bgcolor="#ffffff">
                                            <?php echo $cliente1['nombre'] ?>
                                        </td>
                                        <td bgcolor="#ffffff">
                                            <?php echo $cliente1['grupo'] ?>
                                        </td>
                                        <!--<td bgcolor="#ffffff"><?php echo $cliente1['grado'] ?></td>-->
                                        <td>
                                            <label>
                                                <center><input type="checkbox" id="alumno<?php echo $counter ?>" name="alumno[]" value="<?php echo $cliente1[id]; ?> " required="required" title="Selecciona un alumno"></center>
                                                <label>
                                                    </td>
                                                    </tr>
                                                    <?php
                                                }
                                                $talumnos = $counter;
                                            }
                                            ?>
                                            </table>
                                            <h2><font color="#124A7B">Dirección de Casa</font> </h2>
                                            <p>
                                                <label for="calle1"><font face="Candara" size="3" COLOR="#2D35A9">Calle y Número:</font></label>
                                                <input name="calle1" class="w3-input" type="text" id="calle1" value="<?php echo " $calle1 "; ?>" readonly/>
                                            </p>
                                            <p>
                                                <label for="colonia1"><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label>
                                                <input name="colonia1" class="w3-input" type="text" id="colonia1" value="<?php echo " $colonia1 "; ?>" readonly/>
                                            </p>
                                            <p>
                                                <label for="cp1"><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label>
                                                <input name="cp1" class="w3-input" type="text" id="cp1" value="<?php echo " $cp1 "; ?>" readonly />
                                            </p>
                                            <h2>
                                                <font color="#124A7B">Dirección de cambio</font>
                                            </h2>
                                            <p>
                                                <label for="Guardada"><font face="Candara" size="3" COLOR="#2D35A9">Dirección Guardada:</font></label>
                                                <select type="select" name="reside" id="reside">
                                                    <option value="0">Selecciona</option>
                                                    <option value="1">Deportivo CDI</option>
                                                    <option value="2">Casa</option>
                                                </select>
                                            </p>
                                            <p>
                                                <label for="calle"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Calle y Número:</font></label>
                                                <input class="w3-input" name="calle" type="text" id="calle" value="" placeholder="Agrega calle y número" minlength="5" maxlength="40" onkeyup="this.value = this.value.toUpperCase()" required pattern="[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}" title="Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales"
                                                       />
                                            </p>
                                            <p>
                                                <label for="colonia"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Colonia:</font></label>
                                                <input class="w3-input" name="colonia" type="text" id="colonia" placeholder="Agrega colonia" onkeyup="this.value = this.value.toUpperCase()" minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}" title="Agrega colinia sin acentos ni signos especiales"
                                                       required />
                                            </p>
                                            <p>
                                                <!--<label for="cp"><font face="Candara" size="3" COLOR="#2D35A9">CP:</font></label></td>-->
                                                <input class="w3-input" name="cp" type="hidden" id="cp" value="00000" placeholder="Agrega CP" />
                                            </p>
                                            <table border=0>
                                                <tr>
                                                    <td align="left" colspan="5">
                                                        <br>
                                                        <table border="0">
                                                            <tr>
                                                                <td align="right">
                                                                    <label for="ruta"><font color="red">*</font><font face="Candara" size="3" COLOR="#2D35A9">Ruta:</font></label>
                                                                </td>
                                                                <?php
                                                                $dias = $arrayDias[date("w")];
                                                                if ($dias == 'Viernes') {
                                                                    ?>
                                                                    <td>
                                                                        <select type="select" name="ruta" id="ruta">
                                                                            <option value="0" >selecciona opción </option>
                                                                            <option value="General 2:50 PM" selected>General 2:00 PM</option>
                                                                            <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                                                                        </select>
                                                                    </td>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <td>
                                                                        <select type="select" name="ruta" id="ruta">
                                                                            <option value="0">selecciona opción </option>
                                                                            <option value="General 2:50 PM">General 2:50 PM</option>
                                                                            <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                                                                        </select>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                // echo "Buenos d&iacute;as, hoy es ".$dias;
                                                                ?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <p>
                                                <label for="Comentarios"><font face="Candara" size="3" COLOR="#2D35A9">Comentarios:</font></label>
                                                <textarea class="w3-input" id="Comentarios" name="comentarios" onkeyup="this.value = this.value.toUpperCase()"></textarea>
                                            </p>
                                            <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $id ?>" />
                                            <input type="hidden" name="nfamilia" id="nfamilia" value="<?php echo $fam ?>" />
                                            <input type="hidden" name="talumnos" id="talumnos" value="<?php echo $talumnos ?>" />
                                            <div id="custom-speed" class="btn">
                                                <input type="submit" name="submit" value="Enviar" />
                                                <input type="submit" name="submit" value="Regresar" onclick="Cancelar();
                                                        return false;" />
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