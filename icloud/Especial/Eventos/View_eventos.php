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
$url_home = dirname(dirname(dirname($_SERVER['REQUEST_URI']))) . "/index.php";
?>
<br>
<div>
    <span>
        <h6><?php echo $fecha_actual_impresa_script; ?></h6>
        <div style="text-align: right">
            <a class="waves-effect waves-light"
               href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/menu.php?idseccion=<?php echo $idseccion; ?>">
                <!-- Boton de Atras-->
                <img src='../../images/Atras.svg' style="width: 120px">   
            </a>

            <a class="waves-effect waves-light"
               href="vistas/vista_nuevo_permiso_eventos.php?idseccion=<?php echo $idseccion; ?>">
                <!-- Boton de Nuevo -->
                <img src='../../images/Nuevo.svg' style="width: 120px">   
            </a>
            <a class="waves-effect waves-light b-azul-claro" 
               href="<?= $url_home; ?>"
               style="border-radius: 5px;padding: .09rem 1.5rem;margin-top: -.35rem;">
                <img src='../../images/svg/home_page.svg' style="width: 25px">
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
        <table id="tabla">
            <thead>
                <tr class="b-azul white-text">
                    <th scope="col" width="30%" style="padding: 3px;">Fecha programada</th>
                    <th scope="col" width="40%" style="padding: 3px;">Estatus</th>
                    <th scope="col" width="30%" style="padding: 3px;">Acciones</th>
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
                    $resta_cancelados = 0;
                    $total_en_evento = mysqli_num_rows($alumnos_permiso);
                    while ($alumno = mysqli_fetch_array($alumnos_permiso)) {
                        if ($alumno[6] == "4") {
                            $resta_cancelados++;
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
                        $resta_cancelados++;
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
                        <tr style="cursor:pointer;" onclick='window.location.href = "https://www.chmd.edu.mx/pruebascd/icloud/Especial/Eventos/vistas/vista_consulta_evento.php?id_permiso=<?php echo $id_permiso; ?>&&tipo_permiso=<?php echo $tipo_permiso; ?>&&idseccion=<?php echo $idseccion; ?>"'>
                            <td scope="row"><?php echo $fecha_cambio; ?></td>
                            <td class="alinear-flex-center">
                                <span class="chip white-text" 
                                      style="font-size: .7rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $status_detalle; ?></span>
                                <span class='chip green accent-4 c-blanco' style="font-size: .8rem;">
                                    <i class='material-icons' style='margin-top:.2rem;font-size: .8rem;'>face</i> <?= $i; ?> de <?= $total_en_evento - $resta_cancelados; ?></span>
                            </td>
                            <td>
                                <a class="waves-effect waves-light"
                                   href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Eventos/vistas/vista_consulta_evento.php?id_permiso=<?php echo $id_permiso; ?>&&tipo_permiso=<?php echo $tipo_permiso; ?>&&idseccion=<?php echo $idseccion; ?>">
                                    <img src="../../images/Ver.svg" style="width: 40px"/>                              
                                </a>
                                <?php include './modales/modal_cancelar_permiso.php'; ?>
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