<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";

$id_permiso = $_GET['id'];
$tipo_permiso = $_GET['tipo_permiso'];
$idseccion = $_GET['idseccion'];
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
        <div class="col s12 l8 b-blanco border-azul" style="float: none;margin: 0 auto;">
          <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
              <a class="waves-effect waves-light"
                href="<?php echo $redirect_uri ?>Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>">
                    <img src='../../../images/Atras.svg' style="width: 110px">
              </a>
            </div>
            <h5 class="center-align c-azul">Consulta de permiso temporal</h5>
            <div class="row" style="padding:0rem .5rem;">
                <div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_solicitud" style="margin-left: 2rem;">Fecha de solicitud</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input id="fecha_solicitud" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                    <div class="input-field col s12 l6">
                        <label for="solicitante" style="margin-left: 2rem;">Solicitante</label>
                        <i class="material-icons prefix c-azul">person</i>
                        <input id="solicitante" type="text" readonly style="font-size: .9rem">
                    </div>
                    <h5 class="center-align c-azul">Alumnos con permiso</h5>
                    <div class="col s12">
                        <div class="input-field">
                            <label for="alumnos" style="margin-left: 1rem">Alumnos</label>
                            <i class="material-icons prefix c-azul">school</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="alumnos"
                                      style="font-size: .9rem"></textarea>
                        </div>
                    </div>
                    <h5 class="center-align c-azul">Dirección de Casa</h5>
                    <div class="col s12">
                        <div class="input-field">
                            <label for="calle_guardada" style="margin-left: 1rem">Calle y número</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="calle_guardada"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field">
                            <label for="colonia_guardada" style="margin-left: 1rem">Colonia</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="colonia_guardada"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field" hidden>
                            <label for="cp_guardada" style="margin-left: 1rem">CP</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly
                                   id="cp_guardada"
                                   style="font-size: .9rem"
                                   value=""/>
                        </div>
                    </div>
                    <h5 class="center-align c-azul">Dirección de cambio</h5>
                    <div class="col s12">
                        <div class="input-field">
                            <label for="calle_cambio" style="margin-left: 1rem">Calle y número</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="calle_cambio"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field">
                            <label for="colonia_cambio" style="margin-left: 1rem">Colonia</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <textarea class="materialize-textarea"
                                      readonly
                                      id="colonia_cambio"
                                      style="font-size: .9rem"></textarea>
                        </div>
                        <div class="input-field" hidden>
                            <label for="cp_cambio" style="margin-left: 1rem">CP</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly
                                   id="cp_cambio"
                                   style="font-size: .9rem"
                                   value=""/>
                        </div>
                    </div>
                    <h5 class="center-align c-azul">Datos de responsable</h5>
                    <div class="col s12">
                        <div class="input-field">
                            <label for="responsable" style="margin-left: 1rem">Responsable</label>
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly
                                   type="text"
                                   id="responsable"
                                   style="font-size: .9rem"/>
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="parentesco" style="margin-left: 2rem;">Parentesco</label>
                            <i class="material-icons prefix c-azul">people</i>
                            <input id="parentesco" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="celular" style="margin-left: 2rem;">Celular</label>
                            <i class="material-icons prefix c-azul">smartphone</i>
                            <input id="celular" type="text" readonly style="font-size: .9rem">
                        </div>

                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="telefono" style="margin-left: 2rem;">Teléfono</label>
                            <i class="material-icons prefix c-azul">phone_in_talk</i>
                            <input id="telefono" type="text" readonly style="font-size: .9rem">
                        </div>

                    </div>
                    <h5 class="center-align c-azul col s12">Fechas de cambio</h5>
                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_inicial" style="margin-left: 2rem;">Fecha inicial</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input id="fecha_inicial" type="text" readonly style="font-size: .9rem">
                        </div>

                    </div>

                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="fecha_final" style="margin-left: 2rem;">Fecha final</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input id="fecha_final" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>

                    <div class="col s12 l6">
                        <div class="input-field">
                            <label for="turno" style="margin-left: 2rem;">Turno</label>
                            <i class="material-icons prefix c-azul">departure_board</i>
                            <input id="turno" type="text" readonly style="font-size: .9rem">
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <label for="comentarios" style="margin-left: 2rem;">Comentarios</label>
                        <i class="material-icons c-azul prefix">comment</i>
                        <textarea class="materialize-textarea"
                                  placeholder="Comentarios"
                                  readonly
                                  id="comentarios"
                                  style="font-size: .9rem"></textarea>
                    </div>
                    <div class="input-field col s12">
                        <label for="respuesta" style="margin-left: 2rem;">Respuesta</label>
                        <i class="material-icons c-azul prefix">question_answer</i>
                        <textarea class="materialize-textarea"
                                  readonly
                                  id="respuesta"
                                  placeholder="Respuesta"
                                  style="font-size: .9rem"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!--
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light b-azul"
       href="<?php echo $redirect_uri ?>Transportes/Temporal/PTemporal.php?idseccion=<?php echo $idseccion; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>
-->

<div class="loading" hidden id="loading">
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
<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        var nfamilia = "";
        var calle_guardada = $("#calle_guardada");
        var colonia_guardada = $("#colonia_guardada");
        var cp_guardada = $("#cp_guardada");
        var fecha_solicitud = $("#fecha_solicitud");
        var solicitante = $("#solicitante");
        ////calle guardada
        var calle_cambio = $("#calle_cambio");
        var colonia_cambio = $("#colonia_cambio");
        var cp_cambio = $("#cp_cambio");
        var responsable = $("#responsable");
        var parentesco = $("#parentesco");
        var celular = $("#celular");
        var telefono = $("#telefono");
        var fecha_inicial = $("#fecha_inicial");
        var fecha_final = $("#fecha_final");
        var turno = $("#turno");
        var comentarios = $("#comentarios");
        var respuesta_permiso = $("#respuesta");
        var alumnos_permiso = $("#alumnos");
        $.ajax({
            async: false,
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Transportes/common/get_consulta_permiso.php',
            type: 'GET',
            data: {
                id: '<?php echo $id_permiso; ?>',
                tipo_permiso: '<?php echo $tipo_permiso; ?>'
            },
            beforeSend: function () {
                $("#loading").fadeIn("slow");
            },
        }).done(function (res) {
            var respuesta = JSON.parse(res);
            nfamilia = respuesta.nfamilia;
            fecha_solicitud.val(respuesta.fecha_creacion);
            solicitante.val(respuesta.usuario);
            ////calle guardada
            calle_cambio.val(respuesta.calle_numero);
            colonia_cambio.val(respuesta.colonia);
            cp_cambio.val(respuesta.cp);
            responsable.val(respuesta.responsable);
            parentesco.val(respuesta.parentesco);
            celular.val(respuesta.celular);
            telefono.val(respuesta.telefono);
            fecha_inicial.val(respuesta.fecha_inicial);
            fecha_final.val(respuesta.fecha_final);
            turno.val(respuesta.turno);
            comentarios.val(respuesta.comentarios);
            respuesta_permiso.val(respuesta.mensaje);
            //reajusta tamaño del textarea al contenido
            M.textareaAutoResize($('#calle_guardada'));
            M.textareaAutoResize($('#colonia_guardada'));
            M.textareaAutoResize($('#calle_cambio'));
            M.textareaAutoResize($('#colonia_cambio'));
            M.textareaAutoResize($('#comentarios'));
            M.textareaAutoResize($('#respuesta'));
            var alumnos = "";
            for (var item in respuesta.alumnos) {
                alumnos += `${parseInt(item) + 1} - ${respuesta.alumnos[item].alumno}\n`;
            }
            alumnos_permiso.val(alumnos);
            M.textareaAutoResize($('#alumnos'));
            $.ajax({
                async: false,
                url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/common/get_consultar_direccion_guardada.php",
                type: "GET",
                data: {nfamilia: nfamilia},
                success: function (res) {
                    respuesta = JSON.parse(res);
                    calle_guardada.val(respuesta.calle);
                    colonia_guardada.val(respuesta.colonia);
                    cp_guardada.val(respuesta.cp);
                    M.textareaAutoResize($('#calle_guardada'));
                    M.textareaAutoResize($('#colonia_guardada'));
                    M.textareaAutoResize($('#cp_guardada'));
                    $("#fecha_solicitud").focus();
                    $("#solicitante").focus();
                    $("#alumnos").focus();
                    $("#calle_guardada").focus();
                    $("#colonia_guardada").focus();
                    $("#cp_guardada").focus();
                    $("#calle_cambio").focus();
                    $("#colonia_cambio").focus();
                    $("#cp_cambio").focus();
                    $("#responsable").focus();
                    $("#parentesco").focus();
                    $("#celular").focus();
                    $("#telefono").focus();
                    $("#fecha_inicial").focus();
                    $("#fecha_final").focus();
                    $("#turno").focus();
                    $("#comentarios").focus();
                    $("#respuesta").focus();
                }
            });
        }).always(function () {
            setInterval(function () {
                $("#loading").fadeOut("slow");
            }, 1000);
        });
    });
</script>
<?php include "$root_icloud/components/layout_bottom.php"; ?>
