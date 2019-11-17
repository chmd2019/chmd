<?php
session_start();
$root = dirname(dirname(dirname(__DIR__)));
require_once "{$root}/components/sesion.php";
require_once "{$root}/libraries/Google/autoload.php";
require_once "{$root}/Model/Login.php";
require_once "{$root}/Model/DBManager.php";
require_once "{$root}/Model/Config.php";
require_once "{$root}/Helpers/DateHelper.php";
include_once "{$root}/components/layout_top.php";

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
if (isset($authUrl)) :
    header("Location: $redirect_uri?logout=1");
else :
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    $id_minuta = $_GET['id_minuta'];
    //consultas en db
    require_once "../../common/ControlMinutas.php";
    $controlMinutas = new ControlMinutas();
    $minuta = mysqli_fetch_array($controlMinutas->consultar_minuta($id_minuta));
    //$id_minuta = $minuta[0];
    $titulo = $minuta[1];
    $fecha = $minuta[2];
    $fecha_simple = $minuta[3];
    $hora = $minuta[4];
    $convocante = $minuta[5];
    $director = $minuta[6];
    $comite = $minuta[7];
    $estatus = $minuta[8];
    $cerrado = $minuta[9];
    $id_comite = $minuta[10];
    $temas_pendientes = $controlMinutas->consultar_temas_pendientes($id_minuta);
    //coleccion de temas que seran eventualmente cerrados
    $temas_json = array();
    //inclusion de navbar
    include "{$root}/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul" style="float: none;margin: 0 auto;">            
            <div class="row">
                <br>
                <?php if ($cerrado): ?>
                    <div class="text-center">
                        <span class="chip red c-blanco">Este evento ha sido cerrado, no es posible realizar cambios</span>
                    </div>
                <?php endif; ?>
                <div class="right" style="margin-right: 1rem;">
                    <a class="waves-effect waves-light"
                       href="../Eventos.php?idseccion=1">
                        <img src='../../../images/Atras.svg' style="width: 110px">
                    </a>
                </div>
                <div id="pdf">
                    <h5 class="col s12 c-azul text-center">Consulta de evento</h5> 
                    <div>
                        <div class="input-field col s12 l6">
                            <i class="material-icons prefix c-azul">person</i>
                            <input 
                                id="id_convocado_por"
                                type="text" 
                                class="validate" 
                                value="<?php echo $convocante; ?>"
                                readonly>
                            <label>Convocado por</label>
                        </div>  
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">meeting_room</i>
                        <input 
                            id="id_comite"
                            type="text" 
                            class="validate" 
                            value="<?php echo $comite; ?>"
                            readonly>
                        <label>Para el comité</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">record_voice_over</i>
                        <input 
                            id="id_director"
                            type="text" 
                            class="validate" 
                            value="<?php echo $director; ?>"
                            readonly>
                        <label>Director</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">work</i>
                        <input 
                            id="id_titulo_evento"
                            type="text" 
                            class="validate"
                            value="<?php echo $titulo; ?>"
                            readonly>
                        <label>Título del evento</label>
                    </div>
                    <div class="col s12 s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                id="id_fecha_evento" 
                                value="<?php echo $fecha; ?>"
                                readonly>     
                            <label>Fecha del evento</label>       
                        </div>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">access_time</i>
                        <input id="id_horario_minuta"
                               type="text"
                               placeholder="Horario del evento"
                               value="<?php echo $hora; ?>"
                               readonly>
                        <label>Hora del evento</label>
                    </div>  
                    <h5 class="col s12 c-azul text-center">Invitados para el evento</h5> 
                    <div class="input-field col s12">
                        <table class="display nowrap" id="tabla_invitados" style="margin-top: 6px;">
                            <thead>
                                <tr>
                                    <th>Invitado</th>
                                    <th>Correo</th>
                                    <th>Notificado</th>
                                    <th>Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $invitados = $controlMinutas->consultar_invitados_minuta($id_minuta);
                                if (mysqli_num_rows($invitados) > 0):
                                    while ($row = mysqli_fetch_array($invitados)):
                                        $id_invitacion = $row[0];
                                        $id_invitado = $row[2];
                                        $invitado = $row[3];
                                        $correo = $row[4];
                                        $notificacion = $row[5];
                                        $asistencia = $row[6];
                                        ?>
                                        <tr>
                                            <td><?php echo $invitado; ?></td>
                                            <td><?php echo $correo; ?></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" 
                                                           class="filled-in" 
                                                           disabled
                                                           <?php if ($notificacion) echo "checked"; ?> />
                                                    <span style="left: 35%;"></span>
                                                </label>
                                            </td>              
                                            <td>
                                                <label>
                                                    <input 
                                                    <?php if ($asistencia) echo "checked"; ?> 
                                                        type="checkbox" 
                                                        class="filled-in" 
                                                        disabled/>
                                                    <span style="left: 35%;"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <?php
                                    endwhile;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="col s12 c-azul text-center">Temas del evento</h5> 
                    <div class="input-field col s12">
                        <ul class="collection">
                            <?php
                            $temas_evento = $controlMinutas->consultar_temas_minuta_descarga($id_minuta);
                            while ($row = mysqli_fetch_array($temas_evento)):
                                ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle b-azul-claro">done</i>
                                    <span class="title"><b><?php echo $row[1]; ?></b></span>
                                    <p><b>Estatus: </b><?php echo $row[4]; ?></p>
                                    <p><b>Acuerdos: </b><?php echo $row[3]; ?></p>
                                </li>
                            <?php endwhile; ?><?php ?>
                        </ul>
                    </div>     
                    <?php if (mysqli_num_rows($temas_pendientes) > 0): ?>
                        <h5 class="col s12 c-azul text-center">Temas pendientes</h5>
                        <div class="input-field col s12">
                            <ul class="collection">
                                <?php
                                while ($row = mysqli_fetch_array($temas_pendientes)):
                                    $id_tema_pendiente = $row[0];
                                    $tema_pendiente = $row[1];
                                    $acuerdos_pendiente = $row[2];
                                    $estatus_pendiente = $row[3];
                                    $color_estatus_pendiente = $row[4];
                                    $id_estatus_pendiente = $row[5];
                                    $cerrado_pendiente = $row[6];
                                    array_push($temas_json, $id_tema_pendiente);
                                    ?>
                                    <li class="collection-item avatar">
                                        <i class="material-icons circle b-azul-claro">done</i>
                                        <span class="title"><b><?php echo $tema_pendiente; ?></b></span>
                                        <p><b>Estatus: </b><?php echo $estatus; ?></p>
                                        <p><b>Acuerdos: </b><?php echo $acuerdos_pendiente; ?></p>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php
                        endif;
                        $temas_json = json_encode($temas_json);

                        $archivos = $controlMinutas->consulta_archivos($id_minuta);
                        if (mysqli_num_rows($archivos) > 0):
                            ?>
                            <div class="col s12">
                                <div class="card-panel grey lighten-5 z-depth-1">
                                    <div class="row valign-wrapper">
                                        <div class="col s2">
                                            <img src="../../../images/svg/clip.svg" class="responsive-img" style="width: 35px;"> <!-- notice the "circle" class -->
                                        </div>
                                        <div class="col s10">
                                            <span class="black-text">
                                                <h6 class="c-azul">Archivos adjuntos</h6>
                                                <p>Puedes ver los archivos adjuntos para este evento.</p>
                                                <?php
                                                while ($row = mysqli_fetch_array($archivos)):
                                                    $nombre_archivo = $row[0];
                                                    $nombre_compuesto = $row[1];
                                                    $ruta = "https://docs.google.com/gview?url=https://www.chmd.edu.mx/pruebascd/icloud/Minutas/archivos/{$nombre_compuesto}";
                                                    ?>
                                                    <a href="<?= $ruta ?>" target="_blank" class="c-azul" style="text-decoration: underline;"><?= $nombre_archivo ?></a><br>
                                                <?php endwhile; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <span class="col s12"><br><br></span>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <a class="btn-floating btn-large waves-effect waves-light green" 
       onclick="printDiv('pdf')"
       style="top:85%;right: 3%;position: fixed;">
        <i class="material-icons">print</i>
    </a>
    <script>
        $(document).ready(function () {
            $('.modal').modal();
            $('select').formSelect();
            M.textareaAutoResize($('textarea'));
        });

        function printDiv(nombreDiv) {
            var contenido = document.getElementById(nombreDiv).innerHTML;
            var contenidoOriginal = document.body.innerHTML;
            document.body.innerHTML = contenido;
            window.print();
            document.body.innerHTML = contenidoOriginal;
        }
    </script>
<?php
endif;
include "{$root}/components/layout_bottom.php";
?>