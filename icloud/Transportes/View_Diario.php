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
            <span class='nuevo' id='nuevo'><a href='Diario_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href='javascript:history.back(0)' title='Regresar'> <img src='../images/atras.png' width='80px' height='80px' alt='$modulo'></a>
        </p>
        <h3><?php echo $fecha_actual_impresa_script; ?></h3>
        <br>
        <table id="gradient-style" summary="Meeting Results" style="width:100%;margin:auto;">
            <thead>
                <tr>     
                    <th bgcolor="#CDCDCD">Fecha programada</th>
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
            require('./Control_dia.php');
            $objDia = new Control_dia();
            $consulta2 = $objDia->mostrar_diario($familia);
            $contador = 0;
            $total = mysqli_num_rows($consulta2);
            if ($total == 0) {
                echo "<tr><td text-align: center;><b><p align='center'>Sin datos de permisos actualmente</p></b><td><td></td><td></td></tr>";
            }
            while ($cliente2 = mysqli_fetch_array($consulta2)) {
                $contador++;
                $Idpermiso = $cliente2[0];
                $ruta = $cliente2[11]; //ruta
                $fecha_solicitud = $cliente2[20];
                $fecha_destino = $cliente2[21] != '0' ? date("m-d-Y", strtotime(str_replace("/", "-", $cliente2[21]))) : date("m-d-Y"); //fecha
                
                $status1 = $cliente2[14];
                
                if (is_null($fecha_destino)) {
                    $fechaFormateada = "Error al ingresar la fecha";
                } else {
                    $fechaFormateada = $objDateHelper->fecha_formato_datalle($fecha_destino);
                }
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

                  <td><span class='modi' id='modi'><a href='Diario_Ver.php?folio=$Idpermiso'>$fecha</span></td>
                  <td><span class='modi' id='modi'><a href='Diario_Ver.php?folio=$Idpermiso'>$staus11</span></td>

                  </tr>  "; */
                include_once './Control_dia.php';
                $objControlDia = new Control_dia();
                $consulta_permiso_diario = $objControlDia->comprueba_cancelacion_transporte($Idpermiso);
                $permiso_diario = mysqli_fetch_array($consulta_permiso_diario);
                $mostrar_boton_cancelar_permiso_ver = null;
                $boton_ver = "<span class='modi' id='modi'><a href='Ver_Diario.php?id=$Idpermiso' class='btn btn-primary'><span class='glyphicon glyphicon-new-window' aria-hidden='true'></span> </a></span>";
                $id_permiso_diario = $permiso_diario[0];
                if ($consulta_permiso_diario && $status1 != 4 || $objDateHelper->comprobar_solicitud_no_vencida($fecha_destino)) {
                    $mostrar_boton_cancelar_permiso_ver = "<td>$boton_ver | <span class='modi' id='modi'><button type='button' class ='btn btn-danger' onclick ='modalCancelarPermiso($Idpermiso)'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button><span></td>";
                }else{
                    $mostrar_boton_cancelar_permiso_ver = "<td>$boton_ver | <span class='modi' id='modi'><button type='button' class ='btn btn-warning' disabled><span class='glyphicon glyphicon-alert' aria-hidden='true'></span></button><span></td>";
                }                        
                if ($objDateHelper->comprobar_solicitud_vencida($fecha_destino)) {
                echo "<tr> 
		  <td><span class='modi' id='modi'>$fechaFormateada</span></td>
                  <td><span class='modi' id='modi'>$staus11</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  $mostrar_boton_cancelar_permiso_ver
                </tr>  ";
                }
            }
            echo "     </table>";
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
        function modalCancelarPermiso(id) {
            $('#modalCancelarPermiso').modal({show: true});
            $('#id_permiso_diario').val(id);
        }
    </script>