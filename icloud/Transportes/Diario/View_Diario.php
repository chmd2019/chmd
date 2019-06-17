<?php
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array('Domingo', 'Lunes', 'Martes',
    'Miercoles', 'Jueves', 'Viernes', 'Sabado');
if ($consulta) { //if user already exist change greeting text to "Welcome Back"
    if ($cliente = mysqli_fetch_array($consulta)) {
        ?>

        <div class="d-flex row">
            <span class="col-sm-12 col-md-6">
                <h4 class="float-left"><?php echo $fecha_actual_impresa_script; ?></h4>
            </span>
            <div class="col-sm-12 col-md-6">
                <div class="btn-group float-right" role="group">
                    <button type="button" class="btn btn-primary btn-squared"  data-toggle="modal" 
                            data-target="#modalNuevoPermiso"><i class='fas fa-file'></i>&nbsp;Nuevo</button>
                    <a href="javascript:history.back(0)" class="btn btn-primary btn-squared"><i class='fas fa-long-arrow-alt-left'></i>&nbsp;Atrás</a>
                    <?php
                    echo '<a href="' . $redirect_uri . '?logout=1" class="btn btn-primary btn-squared" >'
                    . "<i class='fas fa-sign-out-alt'></i>&nbsp;Salir</a>";
                    ?>
                </div>
            </div>
        </div>
        <br>

        <?php
        $id = $cliente[0];
        $correo = $cliente[1];
        $perfil = $cliente[2];
        $estatus = $cliente[3];
        $familia = $cliente[4];
        /////////////////////////////////
        require('./Control_dia.php');
        $objDia = new Control_dia();
        $consulta2 = $objDia->mostrar_diario($familia);
        $domicilio = $objDia->mostrar_domicilio($familia);
        $domicilio = mysqli_fetch_array($domicilio);
        $papa = $domicilio[0];
        $calle1 = $domicilio[1];
        $colonia1 = $domicilio[2];
        $cp1 = $domicilio[3];
        $idusuario = 1;
//inicio del while
        $contador = 0;
        $total = mysqli_num_rows($consulta2);
        if ($total == 0) {
            ?>
            <div class="alert alert-danger" role="alert">Sin registros para mostrar</div>
        <?php } else {
            ?>

            <!--Pinta solo el encabezado de la tabla-->
            <table class="table table-borderless table-light">
                <thead>
                    <tr>
                        <th scope="col">Fecha programada</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($cliente2 = mysqli_fetch_array($consulta2)) {
                        $contador++;
                        //captura de registros 
                        $Idpermiso = $cliente2[0];
                        $ruta = $cliente2[11]; //ruta
                        $fecha_solicitud = $cliente2[20];
                        $fecha_destino = $cliente2[21]; //fecha
                        $status1 = $cliente2[14];
                        //deshabilita input de fecha si se ha pasado la hora
                        $enabled = "enabled";
                        if ($objDateHelper->obtener_hora_limite()) {
                            $enabled = "disabled";
                        }
                        include_once './Control_dia.php';
                        $objControlDia = new Control_dia();
                        $consulta_permiso_diario = $objControlDia->comprueba_cancelacion_transporte($Idpermiso);
                        $permiso_diario = mysqli_fetch_array($consulta_permiso_diario);

                        if (!$objDateHelper->obtener_hora_limite() && !$objDateHelper->comprobar_solicitud_no_vencida($fecha_destino)) {
                            $mostrar_boton_cancelar_permiso_ver = '<button type="button" class="btn btn-danger btn-squared"><i class="fas fa-trash"></i></button>';
                        }
                        if ($fecha_destino == "0") {
                            $fecha_destino = $fecha_solicitud;
                        } else {
                            $fecha_destino = str_replace("/", "-", $fecha_destino);
                            $fecha_destino = date("m-d-Y", strtotime($fecha_destino));
                        }
                        //formato de fechas
                        if (is_null($fecha_destino)) {
                            $fechaFormateada = "Error al ingresar la fecha";
                        } else {
                            $fechaFormateada = $objDateHelper->fecha_formato_datalle($fecha_destino);
                        }
                        if ($status1 == 1) {
                            $status_detalle = "Pendiente";
                        }
                        if ($status1 == 2) {
                            $status_detalle = "Autorizado";
                        }
                        if ($status1 == 3) {
                            $status_detalle = "Declinado";
                        }
                        if ($status1 == 4) {
                            $status_detalle = "Cancelado por usuario";
                        }
                        if ($solicitud_vencida = $objDateHelper->comprobar_solicitud_vencida($fecha_destino)) {
                            ?> 
                            <!--Pinta en filas cada registro encontrado por el while y verifica si esta vencida con el if-->

                            <tr>
                                <th scope="row"><?php echo $objDateHelper->fecha_formato_datalle($fecha_destino); ?></th>
                                <td><?php echo "$status_detalle"; ?></td>
                                <td>            
                                    <div class="col-sm-12 col-md-6">
                                        <div class="btn-group float-right" role="group">
                                            <button type="button" class="btn btn-success btn-squared" onclick="consultar_registro('<?php echo "$Idpermiso" ?>', '<?php echo "$familia" ?>')"><i class='fas fa-binoculars'></i></button>
                                            <?php echo $mostrar_boton_cancelar_permiso_ver; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr> 
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <!-- Modal consultar permiso -->
            <?php include './View_consulta_diario.php'; ?> 
            <!-- Modal Nuevo registro -->            
            <?php
            include './View_diario_alta.php';
        }
    }
}
?>
