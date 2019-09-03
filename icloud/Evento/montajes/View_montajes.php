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
?>

<br>
<div>
    <span>
        <h6><?php echo $fecha_actual_impresa_script; ?></h6>
        <br>
        <div style="text-align: right">   
            <div>
                <span class="c-azul" style="font-size: 1.5rem"><b>Alta</b></span>
                <a class="btn-floating btn-medium waves-effect waves-light b-azul"
                   href="vistas/vista_nueva_solicitud_montaje.php?idseccion=<?php echo $idseccion; ?>">
                    <i class="large material-icons">add</i>
                </a>
            </div>
            <br>
            <a class="waves-effect waves-light btn b-azul c-blanco" 
               href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/menu.php?idseccion=<?php echo $idseccion; ?>">
                <i class="material-icons left">keyboard_backspace</i>Atrás
            </a>                
            <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
            </a>  
        </div>
    </span>

    <?php
    $control = new ControlEvento();
    $listado_montajes = $control->listar_montajes();
    $counter = mysqli_num_rows($listado_montajes);

    if ($counter == 0):
        ?>
        <br><br>
        <div style="text-align: center">
            <div class="chip blue c-blanco">No existen montajes para listar</div>        
        </div>
        <br><br>    
    <?php else: ?>
        <br>
        <!--Pinta solo el encabezado de la tabla-->
        <table class="highlight">
            <thead>
                <tr class="b-azul white-text">
                    <th scope="col">Fecha</th>
                    <th scope="col">Solicitante</th>
                    <th scope="col">Evento</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Acciones</th>
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
                    $color_badge = $row[5];
                    ?>
                    <tr style="cursor:pointer;">
                        <th><?php echo $fecha_montaje; ?></th>
                        <th><?php echo $solicitante; ?></th>
                        <th><?php echo $nombre_evento; ?></th>
                        <th><span class="chip <?php echo $color_badge;?>"><?php echo $estatus; ?></span></th>
                        <td>   
                            <div class="row">
                                <div class="col s12 l3">  
                                    <a class="waves-effect waves-light btn blue accent-3" 
                                       href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                        <i class="material-icons">pageview</i>
                                    </a>
                                </div>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                <div class="col s12 l3">
                                    <?php include './modales/modal_cancelar_permiso.php'; ?>
                                </div>                                    
                            </div>
                        </td>
                    </tr>                         
                <?php endwhile; ?>
            </tbody>
        </table>    
    </div>
    <br>
    <br>
<?php endif; ?>