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
          <!-- Boton de Atras-->
        <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
           viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
        <style type="text/css">
          .stq0{fill:#6DC1EC;}
          .stq1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
          .stq2{fill-rule:evenodd;clip-rule:evenodd;fill:#0E497B;}
        </style>
        <path class="stq0" d="M559.25,192.49H45.33c-16.68,0-30.33-13.65-30.33-30.33V50.42c0-16.68,13.65-30.33,30.33-30.33h513.92
          c16.68,0,30.33,13.65,30.33,30.33v111.74C589.58,178.84,575.93,192.49,559.25,192.49z"/>
        <g>
          <path class="stq1" d="M228.72,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
            c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
            c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C228,130.45,228.27,129.64,228.72,128.74z M270.07,110.86l-11.11-25.55
            l-11.1,25.55H270.07z"/>
          <path class="stq1" d="M313.14,83.05h-15.35c-2.89,0-5.15-2.35-5.15-5.15s2.26-5.15,5.15-5.15h41.98c2.8,0,5.06,2.35,5.06,5.15
            s-2.26,5.15-5.06,5.15h-15.44v47.85c0,3.07-2.53,5.51-5.6,5.51c-3.07,0-5.6-2.44-5.6-5.51V83.05z"/>
          <path class="stq1" d="M351.6,78.36c0-3.16,2.44-5.6,5.6-5.6h22.57c7.95,0,14.17,2.35,18.24,6.32c3.34,3.43,5.24,8.12,5.24,13.63
            v0.18c0,10.11-5.87,16.25-14.36,18.87l12.1,15.26c1.08,1.35,1.81,2.53,1.81,4.24c0,3.07-2.62,5.15-5.33,5.15
            c-2.53,0-4.15-1.17-5.42-2.89l-15.35-19.59h-13.99v16.97c0,3.07-2.44,5.51-5.51,5.51c-3.16,0-5.6-2.44-5.6-5.51V78.36z
             M378.96,104.09c7.95,0,13-4.15,13-10.56v-0.18c0-6.77-4.88-10.47-13.09-10.47h-16.16v21.22H378.96z"/>
          <path class="stq1" d="M408.75,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
            c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
            c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C408.03,130.45,408.3,129.64,408.75,128.74z M450.1,110.86L439,85.31
            l-11.1,25.55H450.1z M436.02,65.18c0-0.63,0.36-1.44,0.72-1.99l5.15-7.95c0.99-1.62,2.44-2.62,4.33-2.62c2.89,0,6.5,1.81,6.5,3.52
            c0,0.99-0.63,1.9-1.53,2.71l-6.05,5.78c-2.17,1.99-3.88,2.44-6.41,2.44C437.19,67.07,436.02,66.35,436.02,65.18z"/>
          <path class="stq1" d="M476.01,128.92c-1.26-0.9-2.17-2.44-2.17-4.24c0-2.89,2.35-5.15,5.24-5.15c1.54,0,2.53,0.45,3.25,0.99
            c5.24,4.15,10.83,6.5,17.7,6.5c6.86,0,11.2-3.25,11.2-7.95v-0.18c0-4.51-2.53-6.95-14.26-9.66c-13.45-3.25-21.04-7.22-21.04-18.87
            v-0.18c0-10.83,9.03-18.33,21.58-18.33c7.95,0,14.36,2.08,20.04,5.87c1.26,0.72,2.44,2.26,2.44,4.42c0,2.89-2.35,5.15-5.24,5.15
            c-1.08,0-1.99-0.27-2.89-0.81c-4.88-3.16-9.57-4.79-14.54-4.79c-6.5,0-10.29,3.34-10.29,7.49v0.18c0,4.88,2.89,7.04,15.08,9.93
            c13.36,3.25,20.22,8.04,20.22,18.51v0.18c0,11.83-9.3,18.87-22.57,18.87C491.18,136.86,483.05,134.15,476.01,128.92z"/>
        </g>
        <g>
          <path class="stq2" d="M81.84,94.54h97.68c14.9,0,14.9,23.73,0,23.73H81.84l26.49,27.04c11.04,11.04-5.52,27.59-16.56,16.56
            l-47.46-46.91c-4.41-4.97-4.41-12.69,0-17.11l47.46-46.91c11.04-11.59,27.59,5.52,16.56,16.56L81.84,94.54z"/>
        </g>
        </svg>
        </a>
            <a class="waves-effect waves-light"
            href="vistas/vista_nuevo_permiso_extraordinario.php?idseccion=<?php echo $idseccion; ?>">
            <!-- Boton de Nuevo -->
            <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            	 viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
            <style type="text/css">
            	.sty0{fill:#6DC1EC;}
            	.sty1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
            	.sty2{fill:#0E497B;}
            </style>
            <g>
            	<path class="sty0" d="M556.96,190.97H43.04c-16.68,0-30.33-13.65-30.33-30.33V48.9c0-16.68,13.65-30.33,30.33-30.33h513.92
            		c16.68,0,30.33,13.65,30.33,30.33v111.74C587.29,177.33,573.64,190.97,556.96,190.97z"/>
            	<g>
            		<path class="sty1" d="M222.6,76.48c0-3.07,2.44-5.6,5.6-5.6h1.17c2.71,0,4.24,1.35,5.78,3.25l31.6,40.9V76.21
            			c0-2.98,2.44-5.42,5.42-5.42c3.07,0,5.51,2.44,5.51,5.42v53.09c0,3.07-2.35,5.51-5.42,5.51h-0.45c-2.62,0-4.24-1.35-5.78-3.34
            			l-32.5-42.07v40.09c0,2.98-2.44,5.42-5.42,5.42c-3.07,0-5.51-2.44-5.51-5.42V76.48z"/>
            		<path class="sty1" d="M288.41,107.63V76.3c0-3.07,2.44-5.51,5.6-5.51c3.07,0,5.51,2.44,5.51,5.51v30.88
            			c0,11.74,6.05,17.97,15.98,17.97c9.84,0,15.89-5.87,15.89-17.52V76.3c0-3.07,2.44-5.51,5.6-5.51c3.07,0,5.51,2.44,5.51,5.51v30.79
            			c0,18.87-10.65,28.35-27.18,28.35C298.89,135.43,288.41,125.95,288.41,107.63z"/>
            		<path class="sty1" d="M353.24,128.84v-52c0-3.16,2.44-5.6,5.6-5.6h36.75c2.71,0,4.97,2.26,4.97,4.97c0,2.8-2.26,4.97-4.97,4.97
            			h-31.24V97.6h27.18c2.71,0,4.97,2.26,4.97,5.06c0,2.71-2.26,4.88-4.97,4.88h-27.18v16.97h31.69c2.71,0,4.96,2.26,4.96,4.97
            			c0,2.8-2.26,4.97-4.96,4.97h-37.2C355.68,134.44,353.24,132,353.24,128.84z"/>
            		<path class="sty1" d="M427.54,130.83l-22.12-52c-0.36-0.81-0.63-1.62-0.63-2.62c0-2.98,2.44-5.42,5.6-5.42
            			c2.89,0,4.79,1.62,5.69,3.97l18.24,45.59l18.51-45.96c0.72-1.9,2.71-3.61,5.33-3.61c3.07,0,5.51,2.35,5.51,5.33
            			c0,0.81-0.27,1.72-0.54,2.35l-22.21,52.37c-1.17,2.8-3.25,4.51-6.41,4.51h-0.63C430.79,135.34,428.72,133.63,427.54,130.83z"/>
            		<path class="sty1" d="M468.08,103.02v-0.18c0-17.79,13.72-32.68,33.13-32.68s32.95,14.72,32.95,32.5v0.18
            			c0,17.79-13.72,32.68-33.13,32.68C481.62,135.52,468.08,120.81,468.08,103.02z M522.52,103.02v-0.18
            			c0-12.28-8.94-22.48-21.49-22.48s-21.31,10.02-21.31,22.3v0.18c0,12.28,8.94,22.39,21.49,22.39S522.52,115.3,522.52,103.02z"/>
            	</g>
            	<g>
            		<path class="sty2" d="M143.72,97.4h-21.55V75.85c0-4.03-3.34-7.37-7.37-7.37c-4.03,0-7.37,3.34-7.37,7.37V97.4H85.88
            			c-4.03,0-7.37,3.34-7.37,7.37c0,2.09,0.83,3.89,2.09,5.14c1.39,1.39,3.2,2.09,5.14,2.09h21.55v21.55c0,2.09,0.83,3.89,2.09,5.14
            			c1.39,1.39,3.2,2.09,5.14,2.09c4.03,0,7.37-3.34,7.37-7.37v-21.27h21.55c4.03,0,7.37-3.34,7.37-7.37
            			C150.95,100.74,147.75,97.4,143.72,97.4z"/>
            		<path class="sty2" d="M114.8,38.73c-36.43,0-66.04,29.62-66.04,66.04s29.62,66.04,66.04,66.04s66.04-29.62,66.04-66.04
            			S151.23,38.73,114.8,38.73z M114.8,156.08c-28.36,0-51.31-22.94-51.31-51.31s22.94-51.31,51.31-51.31s51.31,22.94,51.31,51.31
            			S143.16,156.08,114.8,156.08z"/>
            	</g>
            </g>
            </svg>
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
                      $status_detalle = "Pendiente";
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
                            <td>
                              <span class="chip white-text" style="font-size: .9rem;padding: 0px 3px;background-color: <?php echo $color_badge; ?>"><?php echo $status_detalle; ?></span>
                              <span class='chip green accent-4 c-blanco' style='margin-top:.5rem'><i class='material-icons' style='margin-top:.2rem'>face</i> <?=$i?> de <?=$total_en_evento?></span>
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
