<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Especial/common/ControlEspecial.php";
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
		href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/menu.php?idseccion=<?php echo $idseccion; ?>">
                <i class="material-icons left">keyboard_backspace</i>Atrás
            </a>                
            <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
            </a>  
        </div>
    </span>

    <?php
    $control_especial = new ControlEspecial();
    $listado_permisos_especiales = $control_especial->listado_permisos_especiales($familia);
    $contador = mysqli_num_rows($listado_permisos_especiales);
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
                    <th scope="col">Fecha programada</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                while ($permiso = mysqli_fetch_array($listado_permisos_especiales)) {
                    $id_permiso = $permiso[0] ; 
                    $fecha_cambio = $permiso[2];
                    $tipo_permiso = $permiso[3];
                    $idusuario= $permiso[4];
                    $estatus = $permiso[5]; 
                    $autorizado = true;
                    $alumnos_permiso = $control_especial->obtener_alumnos_permiso($id_permiso);
                    
                    while ($alumno = mysqli_fetch_array($alumnos_permiso)){
                        if($alumno[6] !== "2"){
                            $autorizado = false;
                        }
                    }
                    if ($estatus == 1) {
                        $status_detalle = "Pendiente";
                        $badge = "badge blue c-blanco";
                    }
                    if ($estatus == 2 || $autorizado) {
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
                    $fecha_destino = $objDateHelper->formatear_fecha_calendario($fecha_cambio);
                    //oculta boton de cancelar de acuerdi a condiciones de hora limite, status
                    $ver_btn_cancelar = "";
                    if ($objDateHelper->comprobar_hora_limite("14:30") && $objDateHelper->comprobar_fecha_igual($fecha_destino) || $estatus != 1) {
                        $ver_btn_cancelar = "d-none";
                    }
                    $solicitud_vencida = $objDateHelper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino);
                    if ($solicitud_vencida) {
                        ?>
                        <tr style="cursor:pointer;">
                            <th scope="row"><?php echo $fecha_cambio; ?></th>
                            <td><span class="<?php echo $badge; ?>"><?php echo $status_detalle; ?></span></td>
                            <td>   
                                <div class="row">
                                    <div class="col s12 l3">  
                                        <a class="waves-effect waves-light btn green accent-3" 
                                           href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Extraordinario/vistas/vista_consulta_permiso_extraordinario.php?id=<?php echo $id_permiso; ?>&&tipo_permiso=<?php echo $tipo_permiso;?>&&idseccion=<?php echo $idseccion; ?>">
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
