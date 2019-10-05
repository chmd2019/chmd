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
          <a class="waves-effect waves-light"
          href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/menu.php?idseccion=<?php echo $idseccion; ?>">
              <img src='../../images/Atras.svg' style="width: 110px"> 
        </a>
            <a class="waves-effect waves-light"
            href="vistas/vista_nuevo_permiso_extraordinario.php?idseccion=<?php echo $idseccion; ?>">
                <img src='../../images/Nuevo.svg' style="width: 110px"> 
          </a>
        <!--
          <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
                <i class="material-icons left">lock</i>Salir
            </a>
          -->
        </div>
    </span>

    <?php
    $control_especial = new ControlEspecial();
    $listado_permisos_especiales = $control_especial->listado_permisos_especiales($familia);
    $contador = mysqli_num_rows($listado_permisos_especiales);
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
                    <th scope="col" width="30%">Fecha programada</th>
                    <th scope="col" width="35%">Estatus</th>
                    <th scope="col" width="35%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($permiso = mysqli_fetch_array($listado_permisos_especiales)) {
                    $id_permiso = $permiso[0];
                    $fecha_cambio = $permiso[2];
                    $tipo_permiso = $permiso[3];
                    $idusuario = $permiso[4];
                    $estatus = $permiso[5];
                    $autorizado = true;
                    $alumnos_permiso = $control_especial->obtener_alumnos_permiso($id_permiso);
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
                            <td class="alinear-flex-center">
                              <span class="chip white-text" style="font-size: .9rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $status_detalle; ?></span>
                              <span class='chip green accent-4 c-blanco'><i class='material-icons' style='margin-top:.2rem'>face</i> <?=$i?> de <?=$total_en_evento?></span>
                            </td>
                            <td>
                              <a class="waves-effect waves-light"
                              href="https://www.chmd.edu.mx/pruebascd/icloud/Especial/Extraordinario/vistas/vista_consulta_permiso_extraordinario.php?id=<?php echo $id_permiso; ?>&&tipo_permiso=<?php echo $tipo_permiso; ?>&&idseccion=<?php echo $idseccion; ?>">
                              <svg width="38px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                              	 viewBox="0 0 600 600" style="enable-background:new 0 0 600 600;" xml:space="preserve">
                              <style type="text/css">
                              	.st0{fill:#4FA3D7;}
                              	.st1{fill:#0E497B;stroke:#0E497B;stroke-miterlimit:10;}
                              	.st2{fill:#FFFFFF;}
                              </style>
                              <circle class="st0" cx="300" cy="257.69" r="246.41"/>
                              <g>
                              	<path class="st1" d="M251,580.94l-17.27-40.61c-0.28-0.63-0.49-1.27-0.49-2.04c0-2.33,1.9-4.23,4.37-4.23
                              		c2.26,0,3.74,1.27,4.44,3.1l14.24,35.6l14.45-35.88c0.56-1.48,2.11-2.82,4.16-2.82c2.4,0,4.3,1.83,4.3,4.16
                              		c0,0.63-0.21,1.34-0.42,1.83l-17.34,40.89c-0.92,2.19-2.54,3.53-5,3.53h-0.49C253.54,584.46,251.92,583.12,251,580.94z"/>
                              	<path class="st1" d="M284.84,579.39v-40.61c0-2.47,1.9-4.37,4.37-4.37h28.69c2.12,0,3.88,1.76,3.88,3.88
                              		c0,2.19-1.76,3.88-3.88,3.88h-24.39V555h21.22c2.12,0,3.88,1.76,3.88,3.95c0,2.12-1.76,3.81-3.88,3.81h-21.22V576h24.74
                              		c2.11,0,3.88,1.76,3.88,3.88c0,2.19-1.76,3.88-3.88,3.88h-29.04C286.75,583.76,284.84,581.85,284.84,579.39z"/>
                              	<path class="st1" d="M328.55,538.78c0-2.47,1.9-4.37,4.37-4.37h17.62c6.2,0,11.07,1.83,14.24,4.93c2.61,2.68,4.09,6.34,4.09,10.64
                              		v0.14c0,7.9-4.58,12.69-11.21,14.73l9.45,11.91c0.85,1.06,1.41,1.97,1.41,3.31c0,2.4-2.04,4.02-4.16,4.02
                              		c-1.97,0-3.24-0.92-4.23-2.26l-11.98-15.3h-10.93v13.25c0,2.4-1.9,4.3-4.3,4.3c-2.47,0-4.37-1.9-4.37-4.3V538.78z M349.91,558.87
                              		c6.2,0,10.15-3.24,10.15-8.25v-0.14c0-5.29-3.81-8.18-10.22-8.18h-12.62v16.57H349.91z"/>
                              </g>
                              <g>
                              	<path class="st2" d="M346.35,83.58c-31.36,0-62.71,11.94-86.59,35.81c-45.68,45.68-47.65,118.76-5.92,166.81l-14.59,14.59
                              		l-14.86-14.86c-3.39-3.39-8.89-3.39-12.28,0l-69.63,69.63c-14.97,14.97-14.97,39.32,0,54.29c7.48,7.48,17.31,11.22,27.14,11.22
                              		c9.83,0,19.66-3.74,27.14-11.22l69.63-69.63c3.39-3.39,3.39-8.89,0-12.28l-14.86-14.86l14.59-14.59
                              		c22.94,19.92,51.58,29.89,80.23,29.89c31.36,0,62.71-11.94,86.59-35.81c47.74-47.74,47.74-125.43,0-173.17
                              		C409.06,95.52,377.71,83.58,346.35,83.58z M346.35,100.94c26.91,0,53.82,10.24,74.3,30.73c40.97,40.97,40.97,107.64,0,148.61
                              		c-40.97,40.97-107.64,40.97-148.61,0s-40.97-107.64,0-148.61C292.53,111.18,319.44,100.94,346.35,100.94z M346.35,121.16
                              		c-22.65,0-43.95,8.82-59.97,24.84s-24.84,37.32-24.84,59.97c0,22.65,8.82,43.95,24.84,59.97c16.02,16.02,37.32,24.84,59.97,24.84
                              		c22.65,0,43.95-8.82,59.97-24.84c16.02-16.02,24.84-37.32,24.84-59.97c0-22.65-8.82-43.95-24.84-59.97
                              		C390.3,129.99,369,121.16,346.35,121.16z M346.35,138.53c18.02,0,34.95,7.01,47.69,19.75c12.74,12.74,19.76,29.68,19.76,47.69
                              		c0,18.01-7.02,34.95-19.76,47.69c-12.74,12.74-29.68,19.76-47.69,19.76c-18.01,0-34.95-7.02-47.69-19.76
                              		c-12.74-12.74-19.76-29.68-19.76-47.69c0-18.02,7.02-34.95,19.76-47.69C311.4,145.55,328.33,138.53,346.35,138.53z M346.35,171.11
                              		c-4.8,0-8.68,3.89-8.68,8.68v17.5h-17.5c-4.8,0-8.68,3.89-8.68,8.68c0,4.8,3.89,8.68,8.68,8.68h17.5v17.5
                              		c0,4.8,3.89,8.68,8.68,8.68s8.68-3.89,8.68-8.68v-17.5h17.5c4.8,0,8.68-3.89,8.68-8.68s-3.89-8.68-8.68-8.68h-17.5v-17.5
                              		C355.03,175,351.14,171.11,346.35,171.11z M218.25,304.35l29.72,29.72l-12.35,12.35L205.9,316.7L218.25,304.35z M193.62,328.98
                              		l29.72,29.72l-38.85,38.85c-8.2,8.19-21.53,8.2-29.72,0c-8.2-8.19-8.2-21.53,0-29.72C154.76,367.84,193.62,328.98,193.62,328.98z"
                              		/>
                              </g>
                              </svg>

                              <!---
                              <i class="material-icons">pageview</i>
                              --->
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
