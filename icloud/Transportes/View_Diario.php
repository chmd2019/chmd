<?php

$user = $service->userinfo->get(); //get user info
$correo = $user->email;
require('../Model/Login.php');
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);

if ($consulta) { //if user already exist change greeting text to "Welcome Back"
    if ($cliente = mysqli_fetch_array($consulta)) {
        ?>

        <p align='center'>
            <span class='nuevo' id='nuevo'><a href='Diario_Alta.php' title='Nuevo'> <img src='../images/nuevo.png' width='80px' height='80px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href='javascript:history.back(1)' title='Regresar'> <img src='../images/atras.png' width='80px' height='80px' alt='$modulo'></a>
        </p>
        <table id="gradient-style" summary="Meeting Results" style="width:90%;">
            <thead>
                <tr>     
                    <th bgcolor="#CDCDCD">Fecha solicitud</th>
                    <th bgcolor="#CDCDCD">Permiso para</th>
                    <th bgcolor="#CDCDCD">Ruta</th>
                    <th bgcolor="#CDCDCD">Estatus</th>
                </tr>
            </thead>     
            <?php

            $id = $cliente[0];
            $correo = $cliente[1];
            $perfil = $cliente[2];
            $estatus = $cliente[3];
            $familia = $cliente[4];
            /////////////////////////////////
            require('Control_dia.php');
            $objDia = new Control_dia();
            $consulta2 = $objDia->mostrar_diario($familia);
            $contador = 0;
            $total = mysqli_num_rows($consulta2);

            if ($total == 0) {
                echo "<tr><td text-align: center;><b><p align='center'>Sin datos de permisos actualmente</p></b><td></tr>";
            }
            while ($cliente2 = mysqli_fetch_array($consulta2)) {
                $contador++;
                $Idpermiso = $cliente2[0];
                $ruta = $cliente2[11]; //ruta
                $fecha_solicitud = $cliente2[20];
                $fecha_destino = $cliente2[21]; //fecha
                echo $fecha_destino;
                $status1 = $cliente2[14];
                if (is_null($fecha_destino)) {
                    $fechaFormateada = "Error al ingresar la fecha";
                }elseif (empty($fecha_destino)) {
                    $fechaFormateada = $fecha_solicitud;
                } 
                else {
                    $fechaFormateada = "<script>"
                            . "var fechaSolicitud = '$fecha_destino'.split('/');"
                            . "var nuevaFechaSolicitud = fechaSolicitud[1] + '/' +fechaSolicitud[0] +'/' +fechaSolicitud[2];"
                            . "fechaSolicitud = new Date(nuevaFechaSolicitud);"
                            . "var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
                            . "document.write(`\${fechaSolicitud.toLocaleDateString('es-MX', options)}`)"
                            . "</script>";
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
                /*  echo "<tr>

                  <td><span class='modi' id='modi'><a href='Diario_Ver.php?folio=$Idpermiso'>$fecha</span></td>
                  <td><span class='modi' id='modi'><a href='Diario_Ver.php?folio=$Idpermiso'>$staus11</span></td>

                  </tr>  "; */

                echo "<tr>                 
		   
		  <td><span class='modi' id='modi'>$fecha_solicitud</span></td>
		  <td><span class='modi' id='modi'>$fechaFormateada</span></td>
		  <td><span class='modi' id='modi'>$ruta</span></td>
                  <td><span class='modi' id='modi'>$staus11</span> <span class='modi' id='modi'><a href='Ver_Diario.php?id=$Idpermiso' title='Nuevo'> <img src='../images/link.png' width='15px' height='15px' alt='Nueva'></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  
                   </tr>  ";
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