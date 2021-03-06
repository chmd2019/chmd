<?php

require '../../Model/DBManager.php';
require '../../Helpers/DateHelper.php';
require '../../Transportes/common/ControlTransportes.php';

$db_manager = new DBManager();
$date_helper = new DateHelper();
//seteael uso horario para ciudad de mexico
$date_helper->set_timezone();
$control = new ControlTransportes();

$idusuario = $_POST['idusuario'];
$calle_numero = $_POST['calle_numero'];
$colonia = $_POST['colonia'];
$cp = $_POST['cp'];
$responsable = $_POST['responsable'];
$parentesco = $_POST['parentesco'];
$celular = $_POST['celular'];
$telefono = $_POST['telefono'];
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$turno = $_POST['turno'];
$comentarios = $_POST['comentarios'];
$nfamilia = $_POST['nfamilia'];
$tipo_permiso = $_POST['tipo_permiso'];
$fecha_creacion = $_POST['fecha_creacion'];
//coleccion de ids de los alumnos 
$coleccion_ids = $_POST['coleccion_ids'];
//campos para permiso permanente
$lunes = $_POST['lunes'];
$martes = $_POST['martes'];
$miercoles = $_POST['miercoles'];
$jueves = $_POST['jueves'];
$viernes = $_POST['viernes'];
$ruta = $_POST['ruta'];
$responsable = $_POST['responsable'];
$fecha_permiso = $_POST['fecha_permiso'];
//comprobar hora limite
$hora_limite = $date_helper->obtener_hora_limite();
if ($hora_limite && $date_helper->comprobar_igual_actual($fecha_inicial)) {
    echo 0;
    return;
}


if ($tipo_permiso == 1) {
    $connection = $db_manager->conectar1();

    if ($connection) {

        $verifica_duplicado_x_fecha = $control->verificar_permiso_duplicado_x_fecha_diario($fecha_permiso, $nfamilia);
        $id_permiso = mysqli_fetch_array($verifica_duplicado_x_fecha)[0];
        if ($id_permiso > 0) {
            foreach ($coleccion_ids as $value) {
                $verifica_duplicado_x_alumno = $control->verificar_permiso_duplicado_x_alumnos($id_permiso, $value);
                $id_alumno_duplicado = mysqli_fetch_array($verifica_duplicado_x_alumno)[0];
                if ($id_alumno_duplicado > 0) {
                    $nombre_alumno = mysqli_fetch_array($control->consultar_nombre_alumno($id_alumno_duplicado))[0];
                    echo json_encode("El alumno $nombre_alumno ya tiene una solicitud de transporte generada en la fecha asignada");
                    return;
                }
            }
        }
        $sql = "INSERT INTO Ventana_Permisos(
                idusuario,
                calle_numero,
                colonia,
                cp,
                id_ruta,
                comentarios,
                nfamilia,
                fecha_cambio,
                fecha_creacion,
                responsable,
                tipo_permiso)
                 VALUES ( 
                 '" . $idusuario . "',
                 '" . $calle_numero . "', 
                 '" . $colonia . "',
                 '" . $cp . "',
                 '" . $ruta . "',
                 '" . $comentarios . "',
                 '" . $nfamilia . "',
                 '" . $fecha_permiso . "',
                 '" . $fecha_creacion . "',
                 '" . $responsable . "',
                 '" . $tipo_permiso . "')
                ";
        mysqli_set_charset($connection, "utf8");
        $insertar = mysqli_query($connection, $sql);
        if (!$insertar) {
            die("error:" . mysqli_error($connection));
            echo json_encode("Registro fallido");
        }

        if ($insertar) {
            $ultimo_id_conexion = mysqli_insert_id($connection);
            $insert_alumnos = null;
            foreach ($coleccion_ids as $key => $id_alumno) {
                $sql = "INSERT INTO Ventana_permisos_alumnos(id_permiso,id_alumno)  VALUES ('"
                        . $ultimo_id_conexion . "','" . $id_alumno . "' )";
                $insert_alumnos = mysqli_query($connection, $sql);
            }
            $sql = "COMMIT";
            mysqli_query($connection, $sql);
            echo json_encode(true);
        } else {
            $sql = "ROLLBACK";
            mysqli_query($connection, $sql);
        }
        mysqli_close($connection);
    }
} else if ($tipo_permiso == 2) {
    $connection = $db_manager->conectar1();
    if ($connection) {
        $sql = "INSERT INTO Ventana_Permisos(
            idusuario,
            calle_numero, 
            colonia,
            cp,
            responsable,
            parentesco,
            celular,
            telefono, 
            fecha_inicial,
            fecha_final,
            turno,
            comentarios,
            nfamilia,
            tipo_permiso,
            fecha_creacion) 
                    VALUES (
             '" . $idusuario . "',
             '" . $calle_numero . "',
             '" . $colonia . "',
             '" . $cp . "',
             '" . $responsable . "',
             '" . $parentesco . "',
             '" . $celular . "', 
             '" . $telefono . "',
             '" . $fecha_inicial . "',
             '" . $fecha_final . "',
             '" . $turno . "',
             '" . $comentarios . "',
             '" . $nfamilia . "',
             '" . $tipo_permiso . "',
             '" . $fecha_creacion . "')";
        mysqli_set_charset($connection, "utf8");
        $insertar = mysqli_query($connection, $sql);
        if (!$insertar) {
            die("error:" . mysqli_error($connection));
            echo "Registro fallido";
        }

        if ($insertar) {
            $ultimo_id_conexion = mysqli_insert_id($connection);
            $insert_alumnos = null;
            foreach ($coleccion_ids as $key => $id_alumno) {
                $sql = "INSERT INTO Ventana_permisos_alumnos(id_permiso,id_alumno)  VALUES ('"
                        . $ultimo_id_conexion . "','" . $id_alumno . "' )";
                $insert_alumnos = mysqli_query($connection, $sql);
            }
            $sql = "COMMIT";
            mysqli_query($connection, $sql);
            echo 1;
        } else {
            $sql = "ROLLBACK";
            mysqli_query($connection, $sql);
        }
        mysqli_close($connection);
    }
} else if ($tipo_permiso == 3) {
    $connection = $db_manager->conectar1();
    if ($connection) {
        $sql = "INSERT INTO Ventana_Permisos(
            idusuario,
            calle_numero,
            colonia,
            cp,
            lunes,
            martes,
            miercoles,
            jueves,
            viernes,
            id_ruta,
            comentarios,
            nfamilia,
            fecha_creacion,
            responsable,
            tipo_permiso)
             VALUES ( 
             '" . $idusuario . "',
             '" . $calle_numero . "',
             '" . $colonia . "',
             '" . $cp . "',
             '" . $lunes . "',
             '" . $martes . "',
             '" . $miercoles . "', 
             '" . $jueves . "',
             '" . $viernes . "',
             '" . $ruta . "',
             '" . $comentarios . "',
             '" . $nfamilia . "',
             '" . $fecha_creacion . "',
             '" . $responsable . "',
             '" . 3 . "')";

        mysqli_set_charset($connection, "utf8");
        $insertar = mysqli_query($connection, $sql);
        if (!$insertar) {
            die("error:" . mysqli_error($connection));
            echo "Registro fallido";
        }

        if ($insertar) {
            $ultimo_id_conexion = mysqli_insert_id($connection);
            $insert_alumnos = null;
            foreach ($coleccion_ids as $key => $id_alumno) {
                $sql = "INSERT INTO Ventana_permisos_alumnos(id_permiso,id_alumno)  VALUES ('"
                        . $ultimo_id_conexion . "','" . $id_alumno . "' )";
                $insert_alumnos = mysqli_query($connection, $sql);
            }
            $sql = "COMMIT";
            mysqli_query($connection, $sql);
            echo 1;
        } else {
            $sql = "ROLLBACK";
            mysqli_query($connection, $sql);
        }
        mysqli_close($connection);
    }
}