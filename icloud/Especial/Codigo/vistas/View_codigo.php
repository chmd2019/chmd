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
    $control = new ControlEspecial();
    $listado_eventos_inscritos = $control->listado_eventos_inscritos($familia);
    $contador = mysqli_num_rows($listado_eventos_inscritos);
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
                while ($permiso = mysqli_fetch_array($listado_eventos_inscritos)):
                    $id_permiso = $permiso[0];
                    $codigo_invitacion = $permiso[1];
                    $listado_eventos = $control->consultar_evento_listado($id_permiso);
                    $listado_eventos = mysqli_fetch_array($listado_eventos);
                    $fecha_evento = $listado_eventos[0];
                    $estatus = $listado_eventos[1];
                    $autorizado = true;

                    $alumnos_permiso = $control->obtener_alumnos_permiso($id_permiso);
                    $todos_cancelados = true;
                    $todos_declinados = true;
                    $indica_autorizado = "";
                    $indica_no_autorizado = "";
                    $i = 0;
                    $total_en_evento = mysqli_num_rows($alumnos_permiso);
                    while ($alumno = mysqli_fetch_array($alumnos_permiso)) {
                        if ($alumno[6] !== "2") {
                            $autorizado = false;
                        }
                        if ($alumno[6] !== "4") {
                            $todos_cancelados = false;
                        }
                        if ($alumno[6] !== "3") {
                            $todos_declinados = false;
                        }
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
                    if ($estatus == 2 || $autorizado) {
                        $status_detalle = "Autorizado";
                        $badge = "badge green accent-4 c-blanco";
                    }
                    if ($estatus == 3 || $todos_declinados) {
                        $status_detalle = "Declinado";
                        $badge = "badge red lighten-1 c-blanco";
                    }
                    if ($estatus == 4 || $todos_cancelados) {
                        $status_detalle = "Cancelado por usuario";
                        $badge = "badge red accent-4 c-blanco";
                    }

                    $fecha_destino = $objDateHelper->formatear_fecha_calendario($fecha_evento);
                    if ($objDateHelper->comprobar_hora_limite("11:30") && $objDateHelper->comprobar_fecha_igual($fecha_destino) || $estatus != 1) {
                        $ver_btn_cancelar = "d-none";
                    }
                    $solicitud_vencida = $objDateHelper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino);
                    if ($solicitud_vencida):
                        ?>
                        <tr style="cursor:pointer;">
                            <th scope="row"><?php echo $fecha_evento; ?></th>
                            <td><span class="<?php echo $badge; ?>"><?php echo $status_detalle; ?></span><?php echo " <div class='chip green accent-4 c-blanco' style='margin-top:.5rem'><span><i class='material-icons' style='margin-top:.2rem'>face</i> $i de $total_en_evento</span></div>"; ?></td>
                            <td>   
                                <div class="row">
                                    <div class="col s12 l3">  
                                        <a class="waves-effect waves-light btn blue accent-3" 
                                           href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php?familia=<?php echo $familia; ?>&&codigo_evento=<?php echo $codigo_invitacion; ?>&&volver_listado=true">
                                            <i class="material-icons">pageview</i>
                                        </a>
                                    </div>  
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <div class="col s12 l3">
                                        <?php include '../modales/modal_cancelar_permiso.php'; ?>
                                    </div>                                     
                                </div>
                            </td>
                        </tr>
                        <?php
                    endif;
                endwhile;
            }
            ?>
        </tbody>
    </table>    
</div>
<br>
<br>
