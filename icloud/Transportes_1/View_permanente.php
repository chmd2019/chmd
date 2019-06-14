<?php

$user = $service->userinfo->get(); //get user info 
$correo = $user->email;
require('../Model/Login.php');
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
//zona horaria para America/Mexico_city 
require_once '../Helpers/DateHelper.php';
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
            <span class='nuevo' id='nuevo'><a href='Permanente_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.png' width='80px' height='80px' alt='$modulo'></a>
        </p>
        <h3><?php echo $fecha_actual_impresa_script ?></h3>
        <table id="gradient-style" summary="Meeting Results">
            <thead>
                <tr>     
                    <th bgcolor="#CDCDCD">Dias de cambio permanente</th>
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
            require('Control_permanente.php');
            $objPermanente = new Control_permanente();
            $consulta2 = $objPermanente->mostrar_permanentes($familia);
            $contador = 0;
            $total = mysqli_num_rows($consulta2);
            if ($total == 0) {
                echo "<tr><td text-align: center;><b><p align='center'>Sin datos de permisos actualmente</p></b><td></tr>";
            }
            function comprobar_dia($dia){
                if (!empty($dia)) {
                    return ucfirst("$dia");
                }
            }
            while ($cliente2 = mysqli_fetch_array($consulta2)) {
                $contador++;
                $Idpermiso = $cliente2[0];
                $fecha = $cliente2[24];
                $dias = comprobar_dia($cliente2[11]). " ". 
                        comprobar_dia($cliente2[12]). " ". 
                        comprobar_dia($cliente2[13]). " ". 
                        comprobar_dia($cliente2[14]). " ". 
                        comprobar_dia($cliente2[15]);
                $status1 = $cliente2[19];
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

                /*
                  echo "<tr>
                  <td><span class='modi' id='modi'><a href='Permanente_Ver.php?folio=$Idpermiso'>$fecha</span></td>
                  <td><span class='modi' id='modi'><a href='Permanente_Ver.php?folio=$Idpermiso'>$staus11</span></td>
                  </tr>  "; */
                $objControlPermanente = new Control_permanente();
                $consulta_permiso_permanente = $objControlPermanente->comprueba_cancelacion_transporte_permanente($Idpermiso);
                $permiso_permanente = mysqli_fetch_array($consulta_permiso_permanente);
                $mostrar_boton_cancelar_permiso_ver = null;
                $id_permiso_permanente = $permiso_permanente[0];
                $boton_ver = "<span class='modi' id='modi'><a href='Ver_Permanente.php?id=$Idpermiso' class='btn btn-primary'><span class='glyphicon glyphicon-new-window' aria-hidden='true'></span> </a></span>";
                               
                if ($consulta_permiso_permanente && $status1 != 4) {
                    $mostrar_boton_cancelar_permiso_ver = "<td>$boton_ver | <span class='modi' id='modi'><button type='button' class ='btn btn-danger' onclick ='modalCancelarPermisoPermanente($Idpermiso)'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button><span></td>";
                } else {
                    $mostrar_boton_cancelar_permiso_ver = "<td>$boton_ver | <span class='modi' id='modi'><button type='button' class ='btn btn-warning' disabled><span class='glyphicon glyphicon-alert' aria-hidden='true'></span></button><span></td>";
                }
                echo "<tr>      
		  <td>$dias</td>
                  <td>$staus11</td>
                  $mostrar_boton_cancelar_permiso_ver
                   </tr>";
        }
            echo "     </table>";
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
        function modalCancelarPermisoPermanente(id) {
            $('#modalCancelarPermisoPermanente').modal({show: true});
            $('#id_permiso_permanente').val(id);
        }
    </script>




