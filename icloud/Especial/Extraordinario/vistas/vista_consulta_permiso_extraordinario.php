<?php
session_start();
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include_once "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require "$root_icloud/Especial/common/ControlEspecial.php";

$id_permiso = $_GET['id'];
$tipo_permiso = $_GET['tipo_permiso'];
$idseccion = $_GET['idseccion'];
$control = new ControlEspecial();
$alumnos_permiso = $control->obtener_alumnos_permiso($id_permiso);
$todos_autorizados = true;

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
                href="<?php echo $redirect_uri ?>Especial/Extraordinario/PExtraordinario.php?idseccion=<?php echo $idseccion; ?>">
                <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
                <style type="text/css">
                .sth0{fill:#6DC1EC;}
                .sth1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
                .sth2{fill-rule:evenodd;clip-rule:evenodd;fill:#0E497B;}
                </style>
                <path class="sth0" d="M559.25,192.49H45.33c-16.68,0-30.33-13.65-30.33-30.33V50.42c0-16.68,13.65-30.33,30.33-30.33h513.92
                c16.68,0,30.33,13.65,30.33,30.33v111.74C589.58,178.84,575.93,192.49,559.25,192.49z"/>
                <g>
                  <path class="sth1" d="M228.72,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
                  c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
                  c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C228,130.45,228.27,129.64,228.72,128.74z M270.07,110.86l-11.11-25.55
                  l-11.1,25.55H270.07z"/>
                  <path class="sth1" d="M313.14,83.05h-15.35c-2.89,0-5.15-2.35-5.15-5.15s2.26-5.15,5.15-5.15h41.98c2.8,0,5.06,2.35,5.06,5.15
                  s-2.26,5.15-5.06,5.15h-15.44v47.85c0,3.07-2.53,5.51-5.6,5.51c-3.07,0-5.6-2.44-5.6-5.51V83.05z"/>
                  <path class="sth1" d="M351.6,78.36c0-3.16,2.44-5.6,5.6-5.6h22.57c7.95,0,14.17,2.35,18.24,6.32c3.34,3.43,5.24,8.12,5.24,13.63
                  v0.18c0,10.11-5.87,16.25-14.36,18.87l12.1,15.26c1.08,1.35,1.81,2.53,1.81,4.24c0,3.07-2.62,5.15-5.33,5.15
                  c-2.53,0-4.15-1.17-5.42-2.89l-15.35-19.59h-13.99v16.97c0,3.07-2.44,5.51-5.51,5.51c-3.16,0-5.6-2.44-5.6-5.51V78.36z
                  M378.96,104.09c7.95,0,13-4.15,13-10.56v-0.18c0-6.77-4.88-10.47-13.09-10.47h-16.16v21.22H378.96z"/>
                  <path class="sth1" d="M408.75,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
                  c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
                  c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C408.03,130.45,408.3,129.64,408.75,128.74z M450.1,110.86L439,85.31
                  l-11.1,25.55H450.1z M436.02,65.18c0-0.63,0.36-1.44,0.72-1.99l5.15-7.95c0.99-1.62,2.44-2.62,4.33-2.62c2.89,0,6.5,1.81,6.5,3.52
                  c0,0.99-0.63,1.9-1.53,2.71l-6.05,5.78c-2.17,1.99-3.88,2.44-6.41,2.44C437.19,67.07,436.02,66.35,436.02,65.18z"/>
                  <path class="sth1" d="M476.01,128.92c-1.26-0.9-2.17-2.44-2.17-4.24c0-2.89,2.35-5.15,5.24-5.15c1.54,0,2.53,0.45,3.25,0.99
                  c5.24,4.15,10.83,6.5,17.7,6.5c6.86,0,11.2-3.25,11.2-7.95v-0.18c0-4.51-2.53-6.95-14.26-9.66c-13.45-3.25-21.04-7.22-21.04-18.87
                  v-0.18c0-10.83,9.03-18.33,21.58-18.33c7.95,0,14.36,2.08,20.04,5.87c1.26,0.72,2.44,2.26,2.44,4.42c0,2.89-2.35,5.15-5.24,5.15
                  c-1.08,0-1.99-0.27-2.89-0.81c-4.88-3.16-9.57-4.79-14.54-4.79c-6.5,0-10.29,3.34-10.29,7.49v0.18c0,4.88,2.89,7.04,15.08,9.93
                  c13.36,3.25,20.22,8.04,20.22,18.51v0.18c0,11.83-9.3,18.87-22.57,18.87C491.18,136.86,483.05,134.15,476.01,128.92z"/>
                </g>
                <g>
                  <path class="sth2" d="M81.84,94.54h97.68c14.9,0,14.9,23.73,0,23.73H81.84l26.49,27.04c11.04,11.04-5.52,27.59-16.56,16.56
                  l-47.46-46.91c-4.41-4.97-4.41-12.69,0-17.11l47.46-46.91c11.04-11.59,27.59,5.52,16.56,16.56L81.84,94.54z"/>
                </g>
              </svg>
              <!--
              <i class="material-icons left">keyboard_backspace</i>Atrás
            -->
          </a>
        </div>
                <h5 class="c-azul center-align">Consulta de permiso extraordinario</h5>
                <span id="todos_autorizados" class="new badge green col s12" data-badge-caption="Permiso autorizado" hidden></span>
                <div class="row">
                    <div class="col s12 l6">
                        <div class="input-field">
                        <label for="fecha_solicitud" style="margin-left: 1rem">Fecha de solicitud</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly placeholder="Fecha de solicitud" id="fecha_solicitud" style="font-size: 1rem" type="text" >
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                        <label for="solicitante" style="margin-left: 1rem">Solicitante</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly placeholder="Solicitante" id="solicitante" style="font-size: 1rem" type="text" >
                        </div>
                    </div>
                    <h5 class="c-azul text-center">Fecha de salida</h5>
                    <div class="col s12 l6">
                        <div class="input-field">
                        <label for="fecha_permiso" style="margin-left: 1rem">Fecha del permiso</label>
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input readonly placeholder="Fecha del permiso" id="fecha_permiso" style="font-size: 1rem" type="text" >
                        </div>
                    </div>
                    <h5 class="c-azul text-center col s12">Alumnos</h5>
                    <?php
                    while ($alumno = mysqli_fetch_array($alumnos_permiso)) :
                        $id_alumno = $alumno[2];
                        $hora_salida = $alumno[3];
                        $hora_regreso = $alumno[4];
                        $regresa = $alumno[5] == "1" ? "SI" : "NO";
                        $estatus = $alumno[6];
                        $nombre_alumno = $control->consultar_nombre_alumno($id_alumno);
                        $nombre = mysqli_fetch_array($nombre_alumno);
                        $nivel_escolaridad = $nombre[1];
                        $nombre = $nombre[0];
                        switch ($estatus) {
                            case "1":
                                $status_detalle = "Pendiente";
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

                        <script>
                            var todos_autorizados = '<?php echo $todos_autorizados; ?>';
                            if (todos_autorizados === "1") {
                                $("#todos_autorizados").prop("hidden", false);
                            } else {
                                $("#todos_autorizados").prop("hidden", true);
                            }
                        </script>
                        <div class="col s12">
                            <div class="input-field">
                                <i class="material-icons prefix c-azul">school</i>
                                <span class="chip  white-text new" data-badge-caption="<?php echo $status_detalle; ?>" style="float: right;font-size: .9rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $status_detalle; ?></span>
                                <!--
                                <span class="new badge <?php echo $badge; ?>" data-badge-caption="<?php //echo $estatus; ?>"></span>
                                --->
                                <textarea class="materialize-textarea"
                                          readonly
                                          id="alumno_<?php echo $id_alumno; ?>"
                                          style="font-size: 1rem"></textarea>
                                <script>
                                    var texto = '<?php echo $nombre; ?>\nNivel: <?php echo $nivel_escolaridad; ?>\nRegresa: <?php echo $regresa; ?>\nHora de salida: <?php echo $hora_salida; ?>\n<?php echo $regresa == "SI" ? "Hora de regreso: $hora_regreso" : ""; ?>'
                                        $('#alumno_<?php echo $id_alumno; ?>').val(texto);
                                        M.textareaAutoResize($('#alumno_<?php echo $id_alumno; ?>'));
                                </script>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <h5 class="c-azul text-center col s12">Información adicional</h5>
                    <div class="col s12 l6">
                        <div class="input-field">
                        <label for="responsable" style="margin-left: 1rem">Responsable</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly placeholder="Responsable" id="responsable" style="font-size: 1rem" type="text" >
                        </div>
                    </div>
                    <div class="col s12 l6">
                        <div class="input-field">
                        <label for="parentesco" style="margin-left: 1rem">Parentesco</label>
                            <i class="material-icons prefix c-azul">person</i>
                            <input readonly placeholder="Parentesco" id="parentesco" style="font-size: 1rem" type="text" >
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field">
                        <label for="motivos" style="margin-left: 1rem">Motivos</label>
                            <i class="material-icons prefix c-azul">chrome_reader_mode</i>
                            <textarea class="materialize-textarea"
                                      placeholder="Motivos"
                                      readonly
                                      id="motivos"
                                      style="font-size: .9rem"></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!---
<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul"
    href="<?php echo $redirect_uri ?>Especial/Extraordinario/PExtraordinario.php?idseccion=<?php echo $idseccion; ?>">
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

<?php include "$root_icloud/components/layout_bottom.php"; ?>

<script>
    $(document).ready(function () {
        consultar_permiso();
    });

    function consultar_permiso() {
        $.ajax({
            async:false,
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_consultar_permiso.php',
            type: 'GET',
            data: {"id_permiso":<?php echo $id_permiso; ?>},
            beforeSend: function () {
                $("#loading").fadeIn("slow");
            },
            success: function (res) {
                res = JSON.parse(res);
                $("#fecha_solicitud").val(res.fecha_creacion);
                $("#solicitante").val(res.solicitante);
                $("#fecha_permiso").val(res.fecha_cambio);
                $("#responsable").val(res.responsable);
                $("#parentesco").val(res.parentesco);
                $("#motivos").val(res.comentarios);
                M.textareaAutoResize($('#motivos'));
            }
        }).always(function () {
            $("#loading").fadeOut("slow");
        });
    }
</script>
