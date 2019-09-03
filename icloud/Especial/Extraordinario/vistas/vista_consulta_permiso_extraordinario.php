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
                                $estatus = "Pendiente";
                                $badge = "amber accent-4 c-blanco";
                                $todos_autorizados = false;
                                break;

                            case "2":
                                $estatus = "Autorizado";
                                $badge = "green accent-4 c-blanco";
                                break;

                            case "3":
                                $estatus = "Declinado";
                                $badge = "red lighten-1 c-blanco";
                                $todos_autorizados = false;
                                break;

                            case "4":
                                $estatus = "Cancelado por el usuario";
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
                                <span class="new badge <?php echo $badge; ?>" data-badge-caption="<?php echo $estatus; ?>"></span>
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

<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul" href="<?php echo $redirect_uri ?>Especial/Extraordinario/PExtraordinario.php?idseccion=<?php echo $idseccion; ?>">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>


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