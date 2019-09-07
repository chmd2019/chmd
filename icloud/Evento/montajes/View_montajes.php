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
                <a class="waves-effect waves-light" href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/menu.php?idseccion=<?php echo $idseccion; ?>&&correo=<?php echo $correo; ?>">
                    <img src='../../images/Atras.svg' style="width: 110px">                
                </a>
                <a class="waves-effect waves-light" href="vistas/vista_nueva_solicitud_montaje.php?idseccion=<?php echo $idseccion; ?>">
                    <img src='../../images/Nuevo.svg' style="width: 110px">       
                </a>  
            </div>              
            <!--<a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
            </a>  -->
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
        <table>
            <thead>
                <tr class="b-azul white-text">
                    <td scope="row">Fecha</td>
                    <td class="hide-on-med-and-down">Solicitante</td>
                    <td>Evento</td>
                    <td>Estatus</td>
                    <td>Acciones</td>
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
                    switch ($estatus) {
                        case "Pendiente":
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
                    <tr style="cursor:pointer;">
                        <th><?php echo $fecha_montaje; ?></th>
                        <th class="hide-on-med-and-down"><?php echo $solicitante; ?></th>
                        <th><?php echo $nombre_evento; ?></th>
                        <th><span class="chip white-text" style="font-size: .9rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $estatus; ?></span></th>
                        <td>   
                            <div class="row">
                                <div class="col s12 l3" style="padding: 0px">  
                                    <a class="waves-effect waves-light" 
                                       href="https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_consulta_montaje.php?id=<?php echo $id_montaje; ?>&&idseccion=<?php echo $idseccion; ?>">
                                        <img src='../../images/Ver.svg' style="width: 60px;">
                                    </a>
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