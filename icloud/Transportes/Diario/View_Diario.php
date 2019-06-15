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
                        //
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
            <button type="btn" id="botonModalInformacionPermiso" class="btn btn-primary" data-toggle="modal" 
                    data-target="#modalInformacionPermiso" hidden></button>
            <div class="modal fade" id="modalInformacionPermiso" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Información de permiso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Fecha de solicitud</span>
                                    </div>
                                    <input type="text" class="form-control" id="fecha_solicitud" readonly>
                                </div>                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Solicitante</span>
                                    </div>
                                    <input type="text" class="form-control" id="solicitante" readonly>
                                </div>                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Fecha programada</span>
                                    </div>
                                    <input type="text" class="form-control" id="fecha_permiso" readonly>
                                </div>                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Alumnos para el permiso</span>
                                    </div>
                                    <input type="text" class="form-control" id="" readonly>
                                </div>   
                                <div class="card w-100">
                                    <div class="card-header">
                                        Dirección de cambio
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >Calle y Número</span>
                                                </div>
                                                <input type="text" class="form-control" id="calle" readonly>
                                            </div>  
                                        </li>
                                        <li class="list-group-item">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >Colonia</span>
                                                </div>
                                                <input type="text" class="form-control" id="colonia" readonly>
                                            </div>  
                                        </li>
                                    </ul>
                                </div>
                                <br>    
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Ruta</span>
                                    </div>
                                    <input type="text" class="form-control" id="ruta" readonly>
                                </div>                               
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Comentarios</span>
                                    </div>                                    
                                    <textarea class="form-control" id="comentarios" readonly></textarea>
                                </div>                             
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Respuesta</span>
                                    </div>
                                    <textarea class="form-control" id="respuesta" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-squared" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Nuevo registro -->
            <div class="modal fade" id="modalNuevoPermiso" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nuevo permiso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Fecha de solicitud</span>
                                    </div>
                                    <input type="text" class="form-control" name="fecha" readonly value ="<?php echo $arrayDias[date('w')] . " , " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" >
                                </div>                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Solicitante</span>
                                    </div>
                                    <input type="text" class="form-control" name="correo" value="<?php echo " $correo "; ?>" readonly >
                                </div>                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Fecha del permiso</span>
                                    </div>
                                    <input type="text" class="form-control" id="fecha1" name="fecha1" autocomplete="off">
                                </div>   
                                <!--<div class="input-group mb-3">
                                    <div class="card w-100">
                                        <div class="card-header">
                                            Alumnos para el permiso
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="input-group mb-3">

                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                        <label class="custom-control-label" for="customCheck2">Alumno x</label>
                                                    </div>
                                                </div>  
                                            </li>
                                        </ul>
                                    </div> 
                                </div> -->
                                <div class="input-group mb-3">
                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <!--<th bgcolor="#CDCDCD">Id</th>-->
                                                <th bgcolor="#CDCDCD">Alumno</th>
                                                <th bgcolor="#CDCDCD">Grupo</th>
                                                <!--<th bgcolor="#CDCDCD">Grado</th>-->
                                                <th bgcolor="#CDCDCD">Activar</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $consulta1 = $objCliente->mostrar_alumnos($familia);
                                        if ($consulta1) {
                                            $counter = 0;
                                            // $numero = mysql_num_rows($consulta);
                                            while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                                $counter = $counter + 1;
                                                ?>
                                                <tr id="fila-<?php echo $cliente['id'] ?>">
                                                    <!--<td bgcolor="#ffffff"><?php echo $cliente1['id'] ?></td>-->
                                                    <td bgcolor="#ffffff">
                                                        <?php echo $cliente1['nombre'] ?>
                                                    </td>
                                                    <td bgcolor="#ffffff">
                                                        <?php echo $cliente1['grupo'] ?>
                                                    </td>
                                                    <!--<td bgcolor="#ffffff"><?php echo $cliente1['grado'] ?></td>-->
                                                    <td>
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input type="checkbox" class="custom-control-input" id="alumno<?php echo $cliente1[id]; ?>" name="alumno[]" value="<?php echo $cliente1[id]; ?>"> 
                                                            <label class="custom-control-label" for="alumno<?php echo $cliente1[id]; ?>"></label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input type="checkbox" class="custom-control-input"id="alumno<?php echo $counter ?>" >
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            $talumnos = $counter;
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="card w-100">
                                        <div class="card-header">
                                            Dirección de cambio
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" >Calle y Número</span>
                                                    </div>
                                                    <input type="text" class="form-control" >
                                                </div>  
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" >Colonia</span>
                                                    </div>
                                                    <input type="text" class="form-control" >
                                                </div>  
                                            </li>
                                        </ul>
                                    </div>  
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Ruta</span>
                                    </div>
                                    <input type="text" class="form-control">
                                </div>                               
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Comentarios</span>
                                    </div>                                    
                                    <textarea class="form-control" ></textarea>
                                </div>                             
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Respuesta</span>
                                    </div>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-squared" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>
