<?php
session_start();

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

include "$root_icloud/components/layout_top.php";

require_once "$root_icloud/libraries/Google/autoload.php";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Model/DBManager.php";
require_once "$root_icloud/Model/Config.php";
require_once "$root_icloud/Helpers/DateHelper.php";

$idseccion = $_GET['idseccion'];

if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}

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
    require_once "$root_icloud/Evento/common/ControlEvento.php";
    $id_montaje = $_GET['id'];
    $control = new ControlEvento();
//consulta de montaje
    $montaje = $control->consulta_montaje($id_montaje);
    $montaje = mysqli_fetch_array($montaje);
    $fecha_solicitud = $montaje[1];
    $solicitante = $montaje[2];
    $tipo_servicio = $montaje[3];
    $fecha_montaje = $montaje[4];
    $fecha_montaje_simple = $montaje[5];
    $horario_evento = $montaje[6];
    $horario_final_evento = $montaje[7];
    $nombre_evento = $montaje[8];
    $responsable_evento = $montaje[9];
    $cantidad_invitados = $montaje[10];
    $valet_parking = $montaje[11];
    $anexa_programa = $montaje[13];
    $url_pdf = $montaje[12];
    $tipo_repliegue = $montaje[14];
    $requiere_ensayo = $montaje[15];
    $cantidad_ensayos = $montaje[16];
    $requerimientos_especiales = $montaje[17];
    $nombre_pdf = $montaje[18];
    $lugar_evento = $montaje[19];
    $solo_cafe = $montaje[20];
    $cafe_con_evento = $montaje[21];
    if ($tipo_repliegue == "")
        $tipo_repliegue = "Sin repliegue";
    $tipo_montaje = $montaje[22];
    $estatus = $montaje[23];
    $color_estatus = $montaje[24];
    $id_estatus = $montaje[25];
    $id_lugar = $montaje[26];
}
?>
 <a class="btn-floating btn-large waves-effect waves-light green" 
    onclick="printDiv('pdf')"
    style="top:85%;right: 3%;position: fixed;">
     <i class="material-icons">print</i>
 </a>

<div class="row" id="pdf">
    <div class="col s12 l8" style="float: none;margin: 0 auto;padding: .5rem;">
        <br>
        <br>
        <div style="display: flex;justify-content: space-between">
            <img src="../../../images/LogoMaguenWT.png" style="width: 50%;"/>
            <span style="margin-top: 3rem;">Valor, tradición y conocimiento.</span>
        </div>
        <br>
        <h6 class="text-center"><b>Solicitud de requerimientos de montaje</b></h6>
        <br>
        <div class="border-azul" style="padding: 1rem;">
            <p class="text-center"><b>Para el llenado de la solicitud deberás colocarte en cada uno de los espacios y realizar la selección - 
                    Te pedimos analices con cuidado las necesidades del evento; para poder servirte mejor y no tengas 
                    contratiempos en el desarrollo del mismo tiempos para solicitud.</b></p>
            <br>
            <p>1. Servicios de café al menos 2 días hábiles de anticipación.</p>
            <p>2. Montaje de eventos internos al menos 7 días hábiles de anticipación.</p>
            <p>3. Montaje de eventos combinados o externos con al menos 15 días hábiles de anticipación.</p>
        </div>
        <br>
        <br>
        <div class="col s12 l6">
            <p>Fecha del evento : <span class="right"><?php echo $fecha_montaje; ?></span></p>
            <p>Nombre del evento :  <span class="right"><?php echo $nombre_evento; ?></span></p>
            <p>Lugar del evento :  <span class="right"><?php echo $lugar_evento; ?></span></p>
            <p>Horario del evento : <span class="right"><?php echo "{$horario_evento} - {$horario_final_evento}"; ?></span></p>
            <?php
            if ($requiere_ensayo):
                $ensayos = $control->consulta_ensayo($id_montaje);
                $counter = 0;
                while ($row = mysqli_fetch_array($ensayos)):
                    $counter++;
                    ?>
                    <p>Fecha ensayo <?php echo "#{$counter}"; ?>: <span class="right"><?php echo $row[0]; ?></span></p>
                    <p>Horario de ensayo <?php echo "#{$counter}"; ?>: <span class="right"><?php echo "{$row[1]} - {$row[2]}"; ?></span></p>
                    <?php
                endwhile;
            endif;
            ?>
            <p>Responsable del eveto por parte del área solicitante:  <br><span><?php echo $responsable_evento; ?></span></p>
            <p>Anexa programa : 
                <?php if ($anexa_programa): ?>
                    <span class="right">Sí</span>
                <?php else : ?>
                    <span class="right">No</span>
                <?php endif; ?>
            </p>
        </div>
        <div class="col s12">
            <br>   
            <div style="display: flex;">
                <?php
                $mobiliario = $control->consulta_mobiliario_montaje($id_montaje, $id_lugar, $horario_evento, $horario_final_evento, $fecha_montaje_simple);
                if (mysqli_num_rows($mobiliario) > 0):
                    ?>      
                    <div style="width: 45%;margin: auto;">
                        <h6>Mobiliario</h6>
                        <table class="table border-azul">
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($mobiliario)): ?>
                                    <tr><td><?php echo $row[0]; ?></td><td><?php echo $row[1]; ?></td></tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                endif;
                $equipo_tecnico = $control->consulta_equipo_tecnico_montaje($id_montaje, $id_lugar);
                if (mysqli_num_rows($equipo_tecnico) > 0):
                    ?>      
                    <div style="width: 45%;margin-left: .5rem;">
                        <h6>Equipo técnico</h6>
                        <table class="table border-azul">
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($equipo_tecnico)): ?>
                                    <tr><td><?php echo $row[0]; ?></td><td><?php echo $row[1]; ?></td></tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>   
            </div>
        </div>
        <span class="col s12" id="posicion_salto"><br></span>
        <div class="col s12 border-azul">
            <span class="col s12"><br></span>        
            <h6>Personal requerido</h6>
            <div class="col s12 l6" id="personal_requerido" style="padding: 2rem;">
                <?php
                $personal_requerido = $control->consulta_personal_montaje($id_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento);
                while ($row = mysqli_fetch_array($personal_requerido)):
                    ?>
                    <p><?php echo $row[1]; ?> :  <span class="right"><?php echo $row[2]; ?></span></p>
                <?php endwhile; ?>
                <p>Servicio de café : <span class="right"><?php
                        if ($solo_cafe || $cafe_con_evento)
                            echo "Sí";
                        else
                            echo "No";
                        ?></span></p>
                <p>N° de personas :  <span class="right"><?php echo $cantidad_invitados; ?></span></p>
            </div>
            <div class="col s12 l6" style="padding: 1rem;">
                <p>Valet Parking :  <span class="right"><?php echo $valet_parking; ?></span></p>
                <p>¿Requieres repliegue? <span class="right"><?php
                        if ($tipo_repliegue != "Sin repliegue")
                            echo "Sí";
                        else
                            echo "No";
                        ?></span></p>
                <p>Tipo de repliegue :  <ins><br><span><?php echo $tipo_repliegue; ?></span></ins></p> 
            </div>   
            <span class="col s12"><br></span>           
        </div>
        <span class="col s12"><br></span>  
        <div class="col s12 border-azul" id="requerimientos_especiales" style="padding: 1rem;">
            <span class="col s12"><br></span> 
            <p>Requerimientos especiales : <br><?php echo $requerimientos_especiales; ?></p>
            <span class="col s12"><br></span> 
        </div>
    </div>
    <br> 
</div>

<script>
    $(document).ready(function () {
        var personal_requerido = $("#personal_requerido").offset().top;
        var posicion_salto = $("#posicion_salto").offset().top;
        //alert(posicion_salto);
    });

    function printDiv(nombreDiv) {
        var contenido = document.getElementById(nombreDiv).innerHTML;
        var contenidoOriginal = document.body.innerHTML;
        document.body.innerHTML = contenido;
        window.print();
        document.body.innerHTML = contenidoOriginal;
    }
</script>