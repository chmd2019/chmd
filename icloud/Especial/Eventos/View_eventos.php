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
        <div style="text-align: right">   
        <div>
            <span class="c-azul" style="font-size: 1.5rem"><b>Alta</b></span>
            <a class="btn-floating btn-large waves-effect waves-light b-azul"
               href="vistas/vista_nuevo_permiso_eventos.php?idseccion=<?php echo $idseccion; ?>">
                <i class="large material-icons">add</i>
            </a>
        </div>
        <br>
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
    $control = new ControlEspecial();
    $listado_eventos = $control->listado_eventos($familia);
    $contador = mysqli_num_rows($listado_eventos);
    if ($contador == 0) {
        ?>
        <br>
        <span class="chip blue c-blanco col s12 text-center">Sin permisos para mostrar</span>
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
                while ($permiso = mysqli_fetch_array($listado_eventos)) {
                    $id_permiso = $permiso[0];
                    $fecha_cambio = $permiso[2];
                    $tipo_permiso = $permiso[3];
                    $idusuario = $permiso[4];
                    $estatus = $permiso[5];
                    $autorizado = true;
                    $alumnos_permiso = $control->obtener_alumnos_permiso($id_permiso);
                    $indica_autorizado = "";
                    $indica_no_autorizado = "";
                    $i = 0;
                    $total_en_evento = mysqli_num_rows($alumnos_permiso);
                    while ($alumno = mysqli_fetch_array($alumnos_permiso)) {
                        if ($alumno[6] !== "2") {
                            $autorizado = false;
                            $indica_no_autorizado = "$indica_no_autorizado <i class='material-icons red-text'>face</i>";
                        } else {
                            $indica_autorizado = "$indica_autorizado <i class='material-icons green-text accent-4'>face</i>";
                            $i = $i + 1;
                        }
                    }
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
                    $fecha_destino = $objDateHelper->formatear_fecha_calendario($fecha_cambio);
                    //oculta boton de cancelar de acuerdi a condiciones de hora limite, status
                    $ver_btn_cancelar = "";
                    if ($objDateHelper->comprobar_hora_limite("14:50") &&
                            $objDateHelper->comprobar_fecha_igual($fecha_destino) ||
                            $estatus != 1) {
                        $ver_btn_cancelar = "d-none";
                    }
                    $solicitud_vencida = $objDateHelper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino);
                    if ($solicitud_vencida) {
                        ?>
                        <tr style="cursor:pointer;">
                            <th scope="row"><?php echo $fecha_cambio; ?></th>
                            <td><span class="<?php echo $badge; ?> text-center"><?php echo $status_detalle; ?></span><?php echo " <div class='chip green accent-4 c-blanco' style='margin-top:.5rem'><span><i class='material-icons' style='margin-top:.2rem'>face</i> $i de $total_en_evento</span></div>"; ?></td>
                            <td>   
                                <div class="row">
                                    <div class="col s12 l3">  
                                        <a class="waves-effect waves-light btn blue accent-3" 
                                           href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Eventos/vistas/vista_consulta_evento.php?id_permiso=<?php echo $id_permiso; ?>&&tipo_permiso=<?php echo $tipo_permiso; ?>&&idseccion=<?php echo $idseccion; ?>">
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
