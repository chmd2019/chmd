<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/Login.php";
require_once "$root_icloud/Transportes/common/ControlTransportes.php";
$idseccion = $_GET['idseccion'];
require_once "$root_icloud/Helpers/DateHelper.php";
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m/d/Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";

$consulta = mysqli_fetch_array($consulta);
$familia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);
?>
<br>
<div>

    <span>
        <h6><?php echo $fecha_actual_impresa_script; ?></h6>
        <br>
        <div style="text-align: right">   
            <a class="waves-effect waves-light btn b-azul c-blanco" 
		href="https://www.chmd.edu.mx/pruebascd/icloud/menu.php?idseccion=<?php echo $idseccion; ?>">
                <i class="material-icons left">keyboard_backspace</i>Atrás
            </a>                
            <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
            </a>  
        </div>
    </span>

    <?php
    $control_temporal = new ControlTransportes();
    $listado_permiso_temporal = $control_temporal->listado_permiso_temporal($familia);
    $contador = mysqli_num_rows($listado_permiso_temporal);
    if ($contador == 0) {
        ?>
        <br>
        <span class="badge blue c-blanco col s12">Sin permisos para mostrar</span>
        <?php
    } else {
        ?>
        <br>
        <!--Pinta solo el encabezado de la tabla-->
        <table class="highlight">
            <thead>
                <tr class="b-azul white-text">
                    <th scope="col">Fecha inicial</th>
                    <th scope="col">Fecha final</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                while ($permiso = mysqli_fetch_array($listado_permiso_temporal)) {
                    $id_permiso = $permiso[0];
                    $fecha_inicial = $permiso[1];
                    $fecha_final = $permiso[2];
                    $estatus = $permiso[3];
                    $tipo_permiso = $permiso[4];
                    $nfamilia = $permiso[4];
                    if ($estatus == 1) {
                        $status_detalle = "Pendiente";
                        $badge = "badge amber accent-4 c-blanco";
                    }
                    if ($estatus == 2) {
                        $status_detalle = "Autorizado";
                        $badge = "badge green accent-4 c-blanco";
                    }
                    if ($estatus == 3) {
                        $status_detalle = "Declinado";
                        $badge = "badge red lighten-1 c-blanco";
                    }
                    if ($estatus == 4) {
                        $status_detalle = "Cancelado por usuario";
                        $badge = "badge red accent-4 c-blanco";
                    }
                    //formatea fecha LUNES, dd De mmmm Del YYYY a dd-mm-yyyy
                    $fecha_destino = $objDateHelper->formatear_fecha_calendario($fecha_final);
                    //oculta boton de cancelar de acuerdo a condiciones de hora limite, status
                    $ver_btn_cancelar = "";
                    if ($objDateHelper->obtener_hora_limite() || $estatus != 1 && $estatus!=2 ) {
                        $ver_btn_cancelar = "d-none";
                    }
                    $solicitud_vencida = $objDateHelper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino);
                    if ($solicitud_vencida) {
                        ?>
                        <tr style="cursor:pointer;">
                            <th scope="row"><?php echo $fecha_inicial; ?></th>
                            <td><?php echo $fecha_final; ?></td>
                            <td><span class="<?php echo $badge; ?>"><?php echo $status_detalle; ?></span></td>
                            <td>   
                                <div class="row">
                                    <div class="col s12 l3">  
                                        <a class="waves-effect waves-light btn blue accent-3" 
                                           href="https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Temporal/vistas/vista_consulta_permiso_temporal.php?id=<?php echo $id_permiso; ?>&&tipo_permiso=2&&idseccion=<?php echo $idseccion; ?>">
                                            <i class="material-icons">pageview</i>
                                        </a>
                                    </div>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <div class="col s12 l3">
                                        <?php include './modales/modal_cancelar_permiso.php'; ?>
                                    </div>                                    
                                </div>
                            </td>
                        </tr> 
                        <?php
                    }
                }
            }
            ?>
        </tbody>
    </table>    
</div>
<br>
<br>