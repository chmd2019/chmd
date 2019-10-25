<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require "$root_icloud/Especial/common/ControlEspecial.php";

$id_permiso = $_GET['id_permiso'];
$tipo_permiso = $_GET['tipo_permiso'];
$idseccion = $_GET['idseccion'];
$control = new ControlEspecial();
$alumnos_permiso = $control->obtener_alumnos_permiso($id_permiso);

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
if (isset($authUrl)) {
    header("Location: $redirect_uri?logout=1");
} else {
    include_once "$root_icloud/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
            <div>
                <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
                    <a class="waves-effect waves-light"
                       href="<?php echo $redirect_uri ?>Especial/Eventos/PEventos.php?idseccion=<?php echo $idseccion; ?>">
                        <img src='../../../images/Atras.svg' style="width: 110px">
                    </a>
                </div>
                <h5 class="c-azul center-align">Consulta de evento</h5>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            <label for="codigo_evento" style="margin-left: 1rem">Código del evento</label>
                            <i class="material-icons prefix c-azul">looks_6</i>
                            <input readonly
                                   placeholder="Código del evento"
                                   id="codigo_evento"
                                   style="font-size: 1rem"
                                   type="text" >
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly
                                   placeholder="Fecha de solicitud"
                                   id="fecha_solicitud"
                                   style="font-size: 1rem"
                                   type="text" >
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="solicitante" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly
                                   placeholder="Solicitante"
                                   id="solicitante"
                                   style="font-size: 1rem"
                                   type="text" />
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_evento" style="margin-left: 1rem">Fecha del evento</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly
                                   placeholder="Fecha del evento"
                                   id="fecha_evento"
                                   style="font-size: 1rem"
                                   type="text" />
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="tipo_evento" style="margin-left: 1rem">Tipo de evento</label>
                            <i class="material-icons prefix c-azul">cake</i>
                            <input readonly
                                   placeholder="Tipo de evento"
                                   id="tipo_evento"
                                   style="font-size: 1rem"
                                   type="text" />
                        </div>
                    </div>
                    <h5 class="c-azul text-center">Alumnos inscritos</h5>
                    <?php
                    while ($alumno = mysqli_fetch_array($alumnos_permiso)) :
                        $id_alumno = $alumno[2];
                        $estatus = $alumno[6];
                        $nombre_alumno = $control->consultar_nombre_alumno($id_alumno);
                        $nombre_consulta = mysqli_fetch_array($nombre_alumno);
                        $nivel_escolaridad = $nombre_consulta[1];
                        $nombre = $nombre_consulta[0];
                        $grupo = $nombre_consulta[2];
                        $grado = $nombre_consulta[3];

                        switch ($estatus) {
                            case "1":
                                $status_detalle = "Por autorizar";
                                $color_badge = "#F6871F";
                                //    $estatus = "Pendiente";
                                $badge = "amber accent-4 c-blanco";
                                $todos_autorizados = false;
                                break;

                            case "2":
                                $status_detalle = "Autorizado";
                                $color_badge = "#77AF65";
                                //      $estatus = "Autorizado";
                                $badge = "green accent-4 c-blanco";
                                break;

                            case "3":
                                $color_badge = "#EF4545";
                                $status_detalle = "Declinado";
                                //  $estatus = "Declinado";
                                $badge = "red lighten-1 c-blanco";
                                $todos_autorizados = false;
                                break;

                            case "4":
                                $status_detalle = "Cancelado";
                                $color_badge = "#EF4545";
                                //    $estatus = "Cancelado por el usuario";
                                $badge = "red accent-4 c-blanco";
                                $todos_autorizados = false;
                                break;

                            default:
                                break;
                        }
                        ?>
                        <div class="col s12 input-field">
                            <div class="text-center">
                                <span class="chip white-text new col s2 l1" data-badge-caption="<?php echo $status_detalle; ?>" style="font-size: .7rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $status_detalle; ?></span>
                            </div>
                            <textarea class="materialize-textarea col s7 l9"
                                      readonly
                                      id="alumno_<?php echo $id_alumno; ?>"
                                      style="font-size: 1rem"></textarea>
                            <script>
                                var texto = '<?php echo $nombre; ?>\nNivel: <?php echo $nivel_escolaridad; ?>\nGrado: <?php echo $grado; ?>\nGrupo: <?php echo $grupo; ?>';
                                    $('#alumno_<?php echo $id_alumno; ?>').val(texto);
                                    M.textareaAutoResize($('#alumno_<?php echo $id_alumno; ?>'));
                            </script>
                            <a class="col s2 l1 waves-effect waves-light text-center modal-trigger" 
                               href="#modal_cancelar_x_alumno"
                               onclick="id_alumno =<?php echo $id_alumno; ?>;">
                                <img src="../../../images/Eliminar.svg" style="width: 38px"/>
                            </a>
                        </div>
                    <?php endwhile; ?>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label style="margin-left: 3rem">Nombre del responsable</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly
                                   placeholder="Nombre del responsable"
                                   type="text"
                                   id="responsable"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label style="margin-left: 3rem">Parentesco del responsable</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly
                                   placeholder="Parentesco del responsable"
                                   type="text"
                                   id="parentesco_responsable"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div id="caja_transporte">
                        <div class="col s12 l6">
                            <div class="input-field">
                                <label style="margin-left: 3rem">Empresa</label>
                                <i class="material-icons prefix c-azul">time_to_leave</i>
                                <input readonly
                                       placeholder="Empresa"
                                       type="text"
                                       id="empresa"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <label style="margin-left: 3rem">Comentarios</label>
                        <i class="material-icons c-azul prefix">chrome_reader_mode</i>
                        <textarea id="comentarios"
                                  class="materialize-textarea"
                                  placeholder="Comentarios"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }; ?>

<div class="loading" id="loading">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

<div id="modal_cancelar_x_alumno" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma cancelar el evento para este alumno?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>
        <a href="#!" class="waves-effect btn-flat b-azul white-text" 
           onclick="cancelar_x_alumno(<?php echo $id_permiso; ?>)">Aceptar</a>
    </div>
    <br>
</div>

<script>

    var id_alumno = 0;

    $(document).ready(function () {
        var id_permiso = '<?php echo $id_permiso; ?>'
        $("#loading").hide();
        $(".modal").modal();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_consultar_evento.php',
            type: 'GET',
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            },
            data: {"id_permiso": id_permiso}
        }).done((res) => {
            res = JSON.parse(res);
            $("#codigo_evento").val(res.codigo_invitacion);
            $("#fecha_solicitud").val(res.fecha_creacion);
            $("#solicitante").val(res.solicitante);
            $("#fecha_evento").val(res.fecha_cambio);
            $("#tipo_evento").val(res.tipo_evento);
            $("#responsable").val(res.responsable);
            $("#parentesco_responsable").val(res.parentesco);
            $("#empresa").val(res.empresa_transporte);
            $("#comentarios").val(res.comentarios);
            M.textareaAutoResize($("#comentarios"));
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    });

    function cancelar_x_alumno(id_permiso) {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_cancelar_x_alumno.php',
            type: 'POST',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            datatype: 'json',
            data: {id_alumno: id_alumno, id_permiso: id_permiso}
        }).done((res) => {
            if (res) {
                M.toast({
                    html: 'Solicitud exitosa!',
                    classes: 'green accent-4 c-blanco'
                });
                var instance = M.Modal.getInstance($(".modal"));
                instance.close();
                setInterval(()=>{window.location.reload()}, 1500);
            }
        }).always(() => {
            $("#loading").fadeOut();
        });
    }

</script>
