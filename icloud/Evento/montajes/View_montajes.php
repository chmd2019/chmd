<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Evento/common/ControlEvento.php";
//zona horaria para America/Mexico_city
require_once "$root_icloud/Helpers/DateHelper.php";
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m/d/Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
$control = new ControlEvento();
$privilegio = mysqli_fetch_array($control->consultar_privilegio_usuario($correo));
$id_privilegio = $privilegio[0];
$declinados_cancelados = $control->consultar_declinados_cancelados();
while ($row = mysqli_fetch_array($declinados_cancelados)) {
    $control->desocupar_lugar($row[0]);
}
$url_home = dirname(dirname(dirname($_SERVER['REQUEST_URI']))) . "/index.php";
?>

<br>
<div>
    <span>
        <h6><?php echo $fecha_actual_impresa_script; ?></h6>
        <br>
        <?php if ($id_privilegio == 3): ?>
            <div class="col s12 l5">
                <div class="input-field"style="display: flex">
                    <i class="material-icons prefix c-azul">calendar_today</i>
                    <input id="fecha_reporte"
                           type="text" 
                           class="datepicker" 
                           autocomplete="off"
                           placeholder="Para el día">     
                    <label  style="margin-left: 1rem">Consulta reporte</label> 
                    <a class="waves-effect waves-light btn cyan accent-4" 
                       onclick="consultar_reporte();"
                       href="#!" style="margin-top: .6rem">
                        <i class="material-icons">search</i>
                    </a>
                </div> 
            </div>
        <?php endif; ?>
        <div style="text-align: right">   
            <div>
                <a class="waves-effect waves-light" href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/menu.php?idseccion=<?php echo $idseccion; ?>&&correo=<?php echo $correo; ?>">
                    <img src='../../images/Atras.svg' style="width: 110px">                
                </a>
                <a class="waves-effect waves-light" href="vistas/vista_nueva_solicitud_montaje.php?idseccion=<?php echo $idseccion; ?>">
                    <img src='../../images/Nuevo.svg' style="width: 110px">       
                </a>    
                <?php if ($id_privilegio == 3): ?>      
                <a class="waves-effect waves-light b-azul-claro" 
                   href="vistas/vista_montaje_permanente.php"
                   style="border-radius: 5px;padding: 0rem 1.5rem;margin-top: -.38rem;">
                    <i class="material-icons c-azul" style="margin-top: .2rem;">date_range</i>
                </a> 
                <?php endif; ?>    
                <a class="waves-effect waves-light b-azul-claro" 
                   href="<?= $url_home; ?>"
                   style="border-radius: 5px;padding: .05rem 1.5rem;margin-top: -.35rem;">
                    <img src='../../images/svg/home_page.svg' style="width: 25px">
                </a>   
            </div>     
        </div>
    </span>

    <?php
    $nombre_usuario = $control->consulta_nombre_usuario($correo);
    $nombre_usuario = mysqli_fetch_array($nombre_usuario)[0];
    if ($id_privilegio == 1) {
        $listado_montajes = $control->listar_montaje_clientes($nombre_usuario);
    } else {
        $listado_montajes = $control->listar_montajes();
    }
    $counter = mysqli_num_rows($listado_montajes);
    if ($counter == 0):
        ?>
        <br>
        <br>
        <div style="text-align: center">
            <div class="chip blue c-blanco">No existen montajes para listar</div>        
        </div>
        <br>
        <br>    
    <?php else: ?>
        <br>
        <!--Pinta solo el encabezado de la tabla-->
        <table class="display" data-page-length='10' id="tabla_no_archivados">
            <thead>
                <tr class="b-azul white-text">
                    <th style="width: 30%;">Fecha</th>
                    <th class="hide-on-med-and-down" style="width: 20%;">Solicitante</th>
                    <th style="width: 20%;">Evento</th>
                    <th style="text-align: center;">Estatus</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                while ($row = mysqli_fetch_array($listado_montajes)):
                    $id_montaje = $row[0];
                    $fecha_montaje = $row[1];
                    $solicitante = $row[2];
                    $nombre_evento = $row[3];
                    $estatus = $row[4];
                    $esta_archivado = $row[6];
                    switch ($estatus) {
                        case "Por autorizar":
                            $color_badge = "#F6871F";
                            break;
                        case "Autorizado":
                            $color_badge = "#77AF65";
                            break;
                        case "Declinado":
                            $color_badge = "#EF4545";
                            break;
                    }
                    ?>
                    <?php if (!$esta_archivado && $id_privilegio != 1): ?>
                        <tr style="cursor: pointer;font-size: 1rem;">
                            <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $fecha_montaje; ?></td>
                            <td style="padding: 0px;" class="hide-on-med-and-down" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $solicitante; ?></td>
                            <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $nombre_evento; ?></td>
                            <td style="padding: 0px;text-align: center" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'">
                                <span class="chip white-text" style="font-size: .8rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $estatus; ?></span>
                            </td>
                            <td style="padding: 0px;text-align: center">   
                                <a class="waves-effect waves-light"
                                   href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                    <img src='../../images/Ver.svg' style="width: 40px;margin-top: .4rem;">
                                </a> 
                                <?php if ($id_privilegio == 3): ?>
                                    <a class="waves-effect waves-light"
                                       target="_blank"
                                       href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_descarga_pdf.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                        <img src='../../images/Descargar.svg' style="width: 40px;margin-top: .4rem;">
                                    </a>
                                    <a class="waves-effect waves-light light-green-text accent-3" 
                                       onclick="modal_archivo(true);flag_archivar = true;id_montaje = <?php echo $id_montaje; ?>">
                                        <i class="material-icons" style="font-size: 2.5rem;">archive</i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr> 
                    <?php elseif ($esta_archivado && $id_privilegio != 3): ?>                    
                        <tr style="cursor: pointer;font-size: 1rem;">
                            <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $fecha_montaje; ?></td>
                            <td style="padding: 0px;" class="hide-on-med-and-down" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $solicitante; ?></td>
                            <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $nombre_evento; ?></td>
                            <td style="padding: 0px;text-align: center" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'">
                                <span class="chip white-text" style="margin-top: 3px;font-size: .8rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>">
                                    <?php echo $estatus; ?></span>
                                <br>
                                <i class="material-icons teal-text accent-1 tooltipped" data-position="top" data-tooltip="Montaje archivado" style="vertical-align: middle;">tab</i>   
                            </td>
                            <td style="padding: 0px;text-align: center">   
                                <a class="waves-effect waves-light"
                                   href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                    <img src='../../images/Ver.svg' style="width: 40px;margin-top: .4rem;">
                                </a> 
                                <?php if ($id_privilegio == 3): ?>
                                    <a class="waves-effect waves-light"
                                       target="_blank"
                                       href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_descarga_pdf.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                        <img src='../../images/Descargar.svg' style="width: 40px;margin-top: .4rem;">
                                    </a>
                                    <a class="waves-effect waves-light light-green-text accent-3" 
                                       onclick="modal_archivo(true);flag_archivar = true;id_montaje = <?php echo $id_montaje; ?>">
                                        <i class="material-icons" style="font-size: 2.5rem;">archive</i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr> 
                    <?php elseif (!$esta_archivado && $id_privilegio != 3): ?>                    
                        <tr style="cursor: pointer;font-size: 1rem;">
                            <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $fecha_montaje; ?></td>
                            <td style="padding: 0px;" class="hide-on-med-and-down" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $solicitante; ?></td>
                            <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $nombre_evento; ?></td>
                            <td style="padding: 0px;text-align: center" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'">
                                <span class="chip white-text" style="margin-top: 3px;font-size: .8rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>">
                                    <?php echo $estatus; ?></span>
                                <br>
                            </td>
                            <td style="padding: 0px;text-align: center">   
                                <a class="waves-effect waves-light"
                                   href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                    <img src='../../images/Ver.svg' style="width: 40px;margin-top: .4rem;">
                                </a> 
                            </td>
                        </tr> 
                    <?php endif; ?>                        
                <?php endwhile; ?>
            </tbody>
        </table>  
        <?php
        if ($id_privilegio == 3):
            $existe_archivados = mysqli_fetch_array($control->consultar_existe_archivado())[0];
            if ($existe_archivados):
                if ($id_privilegio == 1) {
                    $listado_montajes_archivado = $control->listar_montaje_clientes_archivado($nombre_usuario);
                } else {
                    $listado_montajes_archivado = $control->listar_montajes_archivado();
                }
                ?>
                <br>
                <h5 class="col s12 c-azul">Archviados</h5>
                <table class="display" data-page-length='10' id="tabla_archivados">
                    <thead>
                        <tr class="b-azul white-text">
                            <th style="width: 30%;">Fecha</th>
                            <th class="hide-on-med-and-down" style="width: 20%;">Solicitante</th>
                            <th style="width: 20%;">Evento</th>
                            <th style="text-align: center;">Estatus</th>
                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($listado_montajes_archivado)):
                            $id_montaje = $row[0];
                            $fecha_montaje = $row[1];
                            $solicitante = $row[2];
                            $nombre_evento = $row[3];
                            $estatus = $row[4];
                            switch ($estatus) {
                                case "Por autorizar":
                                    $color_badge = "#F6871F";
                                    break;
                                case "Autorizado":
                                    $color_badge = "#77AF65";
                                    break;
                                case "Declinado":
                                    $color_badge = "#EF4545";
                                    break;
                            }
                            ?>
                            <tr style="cursor: pointer;font-size: 1rem;">
                                <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $fecha_montaje; ?></td>
                                <td style="padding: 0px;" class="hide-on-med-and-down" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $solicitante; ?></td>
                                <td style="padding: 0px;" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><?php echo $nombre_evento; ?></td>
                                <td style="padding: 0px;text-align: center" onclick="window.location.href = 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>'"><span class="chip white-text" style="font-size: .8rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $estatus; ?></span></th>
                                <td style="padding: 0px;text-align: center">   
                                    <a class="waves-effect waves-light"
                                       href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                        <img src='../../images/Ver.svg' style="width: 40px;margin-top: .4rem;">
                                    </a> 
                                    <?php if ($id_privilegio == 3 || $id_privilegio == 1): ?>
                                        <a class="waves-effect waves-light"
                                           target="_blank"
                                           href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_descarga_pdf.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                            <img src='../../images/Descargar.svg' style="width: 40px;margin-top: .4rem;">
                                        </a>

                                        <a class="waves-effect waves-light light-green-text accent-3" 
                                           onclick="modal_archivo(false);flag_archivar = false;id_montaje = <?php echo $id_montaje; ?>">
                                            <i class="material-icons" style="font-size: 2.5rem;">unarchive</i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>                         
                        <?php endwhile; ?>
                    </tbody>
                </table>  
            <?php else: ?>
                <br>
                <div class="col s12 text-center"><span class="chip red white-text">No existen montajes archivados</span></div>
            <?php endif; ?>
        </div>
        <br>
        <br>
        <?php
    endif;
endif;
?>

<div class="loading" id="loading" >
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

<div id="confirmar_archivo" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma archivar este montaje?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text" onclick="id_montaje = null;flag_archivar = null;">Cancelar</a>
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="archivar()">Aceptar</a>
    </div>
    <br>
</div>
<div id="confirmar_desarchivo" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma desarchivar este montaje?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text" onclick="id_montaje = null;flag_archivar = null;">Cancelar</a>
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="archivar()">Aceptar</a>
    </div>
    <br>
</div>