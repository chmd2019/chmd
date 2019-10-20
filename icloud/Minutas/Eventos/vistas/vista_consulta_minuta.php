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
                                                <input 
                                                <?php if ($asistencia) echo "checked"; ?> 
                                                    type="checkbox" 
                                                    class="filled-in" 
                                                    onchange="actualizar_asistencia(<?php echo $id_invitado; ?>,<?php echo $id_minuta; ?>, this);"/>
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
                                <th style="width: 25%">Tema</th>
                                <th style="width: 20%">Acuerdos</th>
                                <th style="width: 30%">Estatus</th>
                                <th style="width: 10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $temas = $controlMinutas->consultar_temas_minuta($id_minuta);
                            if (mysqli_num_rows($temas) > 0):
                                while ($row = mysqli_fetch_array($temas)):
                                    $id_tema = $row[0];
                                    $tema = $row[1];
                                    $acuerdos = mysqli_fetch_array($controlMinutas->consulta_acuerdo($id_tema))[0];
                                    $estatus = $row[4];
                                    $color_estatus = $row[5];
                                    $id_estatus = $row[6];
                                    ?>
                                    <tr style="font-size: .9rem;">
                                        <td><?php echo $tema; ?></td>
                                        <td><input id="input_acuerdos_<?php echo $id_tema; ?>" style="border-bottom: 0px;font-size: .9rem;" value="<?php echo $acuerdos; ?>"/></td>
                                        <td>
                                            <div style="display: flex;">
                                                <select style="font-size: .8rem;" 
                                                        onchange="actualizar_estado_tema('<?php echo $id_tema; ?>', this.value, 'id_chip_<?php echo $id_tema; ?>')">
                                                            <?php
                                                            $catalogo_estatus = $controlMinutas->consulta_catalogo_estatus();
                                                            while ($row = mysqli_fetch_array($catalogo_estatus)):
                                                                if ($row[0] != $id_estatus && $row[0] != 4):
                                                                    ?>
                                                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                                        <?php elseif ($row[0] == $id_estatus): ?>
                                                            <option value="<?php echo $row[0]; ?>" selected><?php echo $row[1]; ?></option>
                                                            <?php
                                                        endif;
                                                    endwhile;
                                                    ?>
                                                </select>
                                                <span id="id_chip_<?php echo $id_tema; ?>"
                                                      class="chip <?php echo $color_estatus; ?>" 
                                                      style="padding: .2rem;height: 10px;width: 10px;">&nbsp;
                                                </span>   
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a class="waves-effect waves-light modal-trigger"
                                               style="margin-top: 16px;"
                                               href="#modal_acuerdos"
                                               onclick="modal_acuerdos('<?php echo $id_tema; ?>', '<?php echo $tema; ?>', 'input_acuerdos_<?php echo $id_tema; ?>');get_consulta_acuerdo_temas('<?php echo $id_tema; ?>')">
                                                <i class="material-icons cyan-text accent-3">post_add</i>
                                            </a>
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

    <!-- Modal Structure -->
    <div id="modal_acuerdos" class="modal">
        <div class="modal-content">
            <h4 class="c-azul" id="id_titulo_tema"></h4>
            <div class="input-field">
                <i class="material-icons prefix c-azul-claro">mode_edit</i>
                <textarea id="id_acuerdos" 
                          class="materialize-textarea" 
                          data-length="4000" 
                          onkeyup="post_acuerdo_temas(this.value)"
                          placeholder="Acuerdos"
                          rows="10"
                          autofocus></textarea>
                <label>Acuerdos</label>
            </div>
            <input id="id_tema" hidden/>
            <input id="input_id_tema" hidden/>
        </div>
        <div class="modal-footer">
            <a href="#!" id="loading_keypress" hidden><img style="width: 6%;" src="../../../images/svg/loading_keypress.svg"/></a>
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
            $('.modal').modal();
            $('select').formSelect();
        });
        // es usada para limpiar las peticiones ajax del keypress de acuerdos 
        var limpia_post_acuerdo_temas = null;
        var id_minuta = '<?php echo $id_minuta; ?>';
        function modal_acuerdos(id_tema, tema, input) {
            $("#id_titulo_tema").text(tema);
            $("#id_tema").val(id_tema);
            $("#input_id_tema").val(input);
            M.textareaAutoResize($('#id_acuerdos'));
        }
        function post_acuerdo_temas(value) {
            clearTimeout(limpia_post_acuerdo_temas);
            limpia_post_acuerdo_temas = setTimeout(() => {
                //var titulo = $("#id_titulo_tema").text();
                var acuerdos = value;
                var id_tema = $("#id_tema").val();
                $.ajax({
                    url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_acuerdo_temas.php',
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: () => $("#loading_keypress").fadeIn(),
                    data: {acuerdos: acuerdos, id_tema: id_tema, id_minuta: id_minuta}
                }).done((res) => {
                    if (res.res) {
                        M.toast({
                            html: '<i class="material-icons prefix">done</i> &nbsp; Se han añadido los acuerdos correctamente.',
                            classes: 'green accent-4 c-blanco',
                        });
                        var id = $("#input_id_tema").val();
                        $("#" + id).val(res.acuerdos);
                    } else {
                        M.toast({
                            html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Ssolicitud no realizada.',
                            classes: 'red c-blanco',
                        });
                    }
                }).always(() => $("#loading_keypress").fadeOut());
            }, 1000);
        }
        function get_consulta_acuerdo_temas(id_tema) {
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/get_consulta_acuerdo_temas.php',
                type: 'GET',
                dataType: 'json',
                data: {id_tema: id_tema}
            }).done((res) => {
                $("#id_acuerdos").val(res);
                M.textareaAutoResize($('#id_acuerdos'));
            });
        }
        function actualizar_estado_tema(id_tema, estatus, chip) {
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_cambia_estatus_tema.php',
                type: 'POST',
                dataType: 'json',
                beforeSend: () => {
                },
                data: {id_tema: id_tema, estatus: estatus}
            }).done((res) => {
                $("#" + chip).removeClass().addClass(`chip ${res.color}`);
                if (res.res) {
                    M.toast({
                        html: '<i class="material-icons prefix">done</i> &nbsp; Solicitud exitosa.',
                        classes: 'green accent-4 c-blanco',
                    });
                    var id = $("#input_id_tema").val();
                    $("#" + id).val(res.acuerdos);
                } else {
                    M.toast({
                        html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Solicitud no realizada.',
                        classes: 'red c-blanco',
                    });
                }
            });
        }
        function actualizar_asistencia(invitado, id_minuta, el) {
            var checked = el.checked;
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_actualizar_asistencia.php',
                type: 'POST',
                dataType: 'json',
                data: {id_invitado: invitado, id_minuta: id_minuta, checked: checked}
            }).done((res) => {
                if (res) {
                    M.toast({
                        html: '<i class="material-icons prefix">done</i> &nbsp; Solicitud exitosa.',
                        classes: 'green accent-4 c-blanco',
                    });
                } else {
                    M.toast({
                        html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Solicitud no realizada.',
                        classes: 'red c-blanco',
                    });
                    el.checked = false;
                }
            });
        }
    </script>
<?php
endif;
include "{$root}/components/layout_bottom.php";
?>