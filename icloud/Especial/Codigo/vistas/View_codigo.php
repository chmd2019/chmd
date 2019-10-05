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
            <a class="waves-effect waves-light"
               href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/menu.php?idseccion=<?php echo $idseccion; ?>">
                <!-- Boton de Atras-->
                <img src="../../../images/Atras.svg" style="width: 110px"/>
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
                    <th scope="col" width="30%">Fecha programada</th>
                    <th scope="col" width="35%">Estatus</th>
                    <th scope="col" width="35%">Acciones</th>
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
                        $status_detalle = "Por autorizar";
                        $color_badge = "#F6871F";
                    }
                    if ($estatus == 2) {
                        $status_detalle = "Autorizado";
                        $color_badge = "#77AF65";
                    }
                    if ($estatus == 3) {
                        $color_badge = "#EF4545";
                        $status_detalle = "Declinado";
                    }
                    if ($estatus == 4) {
                        $status_detalle = "Cancelado";
                        $color_badge = "#EF4545";
                    }

                    $fecha_destino = $objDateHelper->formatear_fecha_calendario($fecha_evento);
                    if ($objDateHelper->comprobar_hora_limite("11:30") && $objDateHelper->comprobar_fecha_igual($fecha_destino) || $estatus != 1) {
                        $ver_btn_cancelar = "d-none";
                    }
                    $solicitud_vencida = $objDateHelper->comprobar_solicitud_vencida_d_m_y_guion($fecha_destino);
                    if ($solicitud_vencida):
                        ?>
                        <tr style="cursor:pointer;" onclick='window.location.href = "https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php?familia=<?php echo $familia; ?>&&codigo_evento=<?php echo $codigo_invitacion; ?>&&volver_listado=true"'>
                            <th scope="row"><?php echo $fecha_evento; ?></th>
                            <td class="alinear-flex-center">
                                <span class="chip white-text" style="font-size: .9rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $status_detalle; ?></span>
                                <span class='chip green accent-4 c-blanco'><i class='material-icons' style='margin-top:.2rem'>face</i> <?= $i ?> de <?= $total_en_evento ?></span></td>
                            <td>
                                <a class="waves-effect waves-light"
                                   href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php?familia=<?php echo $familia; ?>&&codigo_evento=<?php echo $codigo_invitacion; ?>&&volver_listado=true">
                                    <img src="../../../images/Ver.svg" style="width: 40px"/>
                                </a>
                                <?php include '../modales/modal_cancelar_permiso.php'; ?>
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
