<?php
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array('Domingo', 'Lunes', 'Martes',
    'Miercoles', 'Jueves', 'Viernes', 'Sabado');
if ($consulta) { //if user already exist change greeting text to "Welcome Back"
    if ($cliente = mysqli_fetch_array($consulta)) {
        ?>
        <br>
        <div>
            <span>
                <h6 class=""><?php echo $objDateHelper->fecha_formato_datalle(date("m/d/Y")); ?></h6>
            </span>
        </div>
        <br>
        <br>

        <?php
        $id = $cliente[0];
        $correo = $cliente[1];
        $perfil = $cliente[2];
        $estatus = $cliente[3];
        $familia = $cliente[4];
        /////////////////////////////////
        require('./posts_gets/Control_dia.php');
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
                    while ($cliente2 = mysqli_fetch_array($consulta2)) {
                        $contador++;
                        //captura de registros 
                        $Idpermiso = $cliente2[0];
                        $ruta = $cliente2[11]; //ruta
                        $fecha_solicitud = $cliente2[20];
                        $fecha_destino = $cliente2[21]; //fecha
                        $status1 = $cliente2[14];
                        //deshabilita input de fecha si se ha pasado la hora
                        include_once './Control_dia.php';
                        $objControlDia = new Control_dia();
                        $consulta_permiso_diario = $objControlDia->comprueba_cancelacion_transporte($Idpermiso);
                        $permiso_diario = mysqli_fetch_array($consulta_permiso_diario);
                        $ver_btn_cancelar = "";
                        if ($objDateHelper->obtener_hora_limite() && $objDateHelper->comprobar_fecha_igual($fecha_destino) || $status1 != 1) {
                            $ver_btn_cancelar = "d-none";
                        }
                        if ($fecha_destino == "0") {
                            $fecha_destino = $fecha_solicitud;
                        } else {
                            $fecha_destino = str_replace("/", "-", $fecha_destino);
                            $fecha_destino = date("m-d-Y", strtotime($fecha_destino));
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
                            <tr style="cursor:pointer;">
                                <th scope="row"><?php echo $objDateHelper->fecha_formato_mexico($fecha_destino); ?></th>
                                <td><?php echo "$status_detalle"; ?></td>
                                <td>            
                                    <div class="row">
                                        <div class="col s12 l3">  
                                            <?php //include './modales/modal_consulta_diario.php'; ?>
                                            <a class="waves-effect waves-light btn green accent-3" 
                                               href="https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/vistas/vista_consulta_permiso_diario.php?id=<?php echo $Idpermiso;?>&&familia=<?php echo $familia;?>">
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
                    ?>
                </tbody>
            </table>        
            <?php
        }
    }
}
?>
<script>
    $(document).ready(function () {
        $('.modal').modal();
    });
</script>