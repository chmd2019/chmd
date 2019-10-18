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
    //inclusion de navbar
    include "{$root}/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul" style="float: none;margin: 0 auto;">
            <div class="row">
                <br>
                <div class="right" style="margin-right: 1rem;">
                    <a class="waves-effect waves-light"
                       href="../Eventos.php?idseccion=1">
                        <img src='../../../images/Atras.svg' style="width: 110px">
                    </a>
                </div>
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
                                                <input type="checkbox" 
                                                       class="filled-in" 
                                                       <?php if ($asistencia) echo "checked"; ?> />
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
                    <table class="display nowrap" id="tabla_temas" style="margin-top: 6px;">
                        <thead>
                            <tr>
                                <th style="width: 60%">Tema</th>
                                <th style="width: 20%">Acuerdos</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $temas = $controlMinutas->consultar_temas_minuta($id_minuta);
                            if (mysqli_num_rows($temas) > 0):
                                while ($row = mysqli_fetch_array($temas)):
                                    $id_tema = $row[0];
                                    $tema = $row[1];
                                    $acuerdos = $row[3];
                                    $estatus = $row[4];
                                    $color_estatus = $row[5];
                                    ?>
                                    <tr>
                                        <td><?php echo $tema; ?></td>
                                        <td><?php echo $acuerdos; ?></td>
                                        <td>
                                            <div class="text-center">
                                                <span class="chip c-blanco <?php echo $color_estatus; ?>"><?php echo $estatus; ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#tabla_invitados').DataTable({
                "language": {
                    "lengthMenu": "_MENU_",
                    "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
                    "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
                    "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
                    "infoFiltered": "(filtrado de _MAX_ total de registros)",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            $('#tabla_temas').DataTable({
                "language": {
                    "lengthMenu": "_MENU_",
                    "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
                    "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
                    "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
                    "infoFiltered": "(filtrado de _MAX_ total de registros)",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            $('select').formSelect();
        });
    </script>
<?php
endif;
include "{$root}/components/layout_bottom.php";
?>