<?php
$user = $service->userinfo->get(); //get user info 
$correo = $user->email;
require('../Model/Login.php');
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
//zona horaria para America/Mexico_city 
require '../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();  
$fecha_actual = date('m-d-Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";

if ($consulta) { //if user already exist change greeting text to "Welcome Back"
    if ($cliente = mysqli_fetch_array($consulta)) {
        ?>
        <p align='center'>
            <span class='nuevo' id='nuevo'><a href='Temporal_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.png' width='80px' height='80px' alt='$modulo'></a>
        </p>
        <h3><?php echo $fecha_actual_impresa_script; ?></h3>
        <table id="gradient-style" summary="Meeting Results" style="width:100%;margin:auto;">
            <thead>
                <tr>
                    <th bgcolor="#CDCDCD">Fecha inicial</th>
                    <th bgcolor="#CDCDCD">Fecha final</th>
                    <th bgcolor="#CDCDCD">Estatus</th>
                    <th bgcolor="#CDCDCD">Acciones</th>
                </tr>
            </thead>
            <?php
            $id = $cliente[0];
            $correo = $cliente[1];
            $perfil = $cliente[2];
            $estatus = $cliente[3];
            $familia = $cliente[4];

/////////////////////////////////
            require('Control_temporal.php');
            $objPermanente = new Control_temporal();
            $consulta2 = $objPermanente->mostrar_viaje($familia);
            $contador = 0;
            $total = mysqli_num_rows($consulta2);
            if ($total == 0) {
                echo "<tr><td></td><td text-align: center;><b><p align='center'>Sin datos de permisos actualmente</p></b></td><td></td></tr>";
            }
            while ($cliente2 = mysqli_fetch_array($consulta2)) {
                $contador++;
                $Idpermiso = $cliente2[0];
                $fecha = $cliente2[25];
                $fecha_inicial = $objDateHelper->fecha_formato_js($cliente2[15]);
                $fecha_final = $objDateHelper->fecha_formato_js($cliente2[16]);
                $status1 = $cliente2[20];
                echo $fecha_inicial_detalle;
                if ($status1 == 1) {
                    $staus11 = "Pendiente";
                }
                if ($status1 == 2) {
                    $staus11 = "Autorizado";
                }
                if ($status1 == 3) {
                    $staus11 = "Declinado";
                }
                if ($status1 == 4) {
                    $staus11 = "Cancelado por usuario";
                }
                /*  echo "<tr>
                  <td><span class='modi' id='modi'><a href='Temporal_Ver.php?folio=$Idpermiso'>$fecha</span></td>
                  <td><span class='modi' id='modi'><a href='Temporal_Ver.php?folio=$Idpermiso'>$staus11</span></td>
                  </tr>  "; */
                include_once './Control_temporal.php';
                $objControlTemporal = new Control_temporal();
                $consulta_permiso_temporal = $objControlTemporal->comprueba_cancelacion_transporte_temporal($Idpermiso);
                $permiso_temporal = mysqli_fetch_array($consulta_permiso_temporal);
                $mostrar_boton_cancelar_permiso = null;
                $id_permiso_temporal = $permiso_temporal[0];
                if ($consulta_permiso_temporal && $status1 != 4) {
                    $mostrar_boton_cancelar_permiso = "<td><span class='modi' id='modi'><button type='button' class ='btn btn-danger' onclick ='modalCancelarPermisoTemporal($id_permiso_temporal)'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button><span></td>";
                } else {
                    $mostrar_boton_cancelar_permiso = "<td><span class='modi' id='modi'><button type='button' class ='btn btn-warning' disabled><span class='glyphicon glyphicon-alert' aria-hidden='true'></span></button><span></td>";
                }
                echo "<tr>          
                    <td><span class='modi' id='modi'>{$objDateHelper->fecha_formato_datalle($fecha_inicial)}</span></td>
                    <td><span class='modi' id='modi'>{$objDateHelper->fecha_formato_datalle($fecha_final)}</span></td>
                    <td><span class='modi' id='modi'>$staus11</span></td>   
                    $mostrar_boton_cancelar_permiso               
                    </tr>";
            }
            echo "</table>";
//fin 
        } else {
            echo 'Este usuario no tiene Acceso:' . $user->email . ',<br> !Favor de comunicarse para validar datos! <br> Salir del sitema [<a href="' . $redirect_uri . '?logout=1"> Log Out</a>]';
        }
    } else { //error en cosulta
        echo 'Error en cosulta';

        //echo 'Hi '.$user->email.',<br> Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
        //$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
        //$statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
        //$statement->execute();
        ///echo $mysqli->error;
    }
    ?>
            
    <script>
        function modalCancelarPermisoTemporal(id) {
            $('#modalCancelarPermisoTemporal').modal({show: true});
            $('#id_permiso_temporal').val(id);
        }
    </script>