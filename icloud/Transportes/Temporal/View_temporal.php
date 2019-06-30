<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once '../../Model/Login.php';
require_once "$root_icloud/Transportes/common/ControlTransportes.php";
$user = $service->userinfo->get(); //get user info 
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
//zona horaria para America/Mexico_city 
require_once '../../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m/d/Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
$consulta = mysqli_fetch_array($consulta);
$familia = str_pad($consulta[4], 4, 0, STR_PAD_LEFT);
?>

<br>
<div>
    <span>
        <h6 class=""><?php echo $fecha_actual_impresa_script; ?></h6>
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
                        $badge = "badge blue c-blanco";
                    }
                    if ($estatus == 2) {
                        $status_detalle = "Autorizado";
                        $badge = "badge green c-blanco";
                    }
                    if ($estatus == 3) {
                        $status_detalle = "Declinado";
                        $badge = "badge orange c-blanco";
                    }
                    if ($estatus == 4) {
                        $status_detalle = "Cancelado por usuario";
                        $badge = "badge red c-blanco";
                    }
                    //formatea fecha LUNES, dd De mmmm Del YYYY a dd-mm-yyyy
                    $fecha_destino = $objDateHelper->formatear_fecha_calendario($fecha_final);
                    //oculta boton de cancelar de acuerdi a condiciones de hora limite, status
                    $ver_btn_cancelar = "";
                    if ($objDateHelper->obtener_hora_limite() &&
                            $objDateHelper->comprobar_fecha_igual($fecha_destino) ||
                            $estatus != 1) {
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
                                        <a class="waves-effect waves-light btn green accent-3" 
                                           href="https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Temporal/vistas/vista_consulta_permiso_temporal.php?id=<?php echo $id_permiso;?>">
                                            <i class="material-icons">pageview</i>
                                        </a>
                                    </div>
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
