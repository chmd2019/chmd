<?php
require '../../conexion.php';

// Ventana_permisos
$id_permiso =$_POST['id_permiso'];
$codigo_invitacion = $_POST['codigo_evento'];
$nfamilia = $_POST['nfamilia'];
// Ventana_permisos_alumnos
$alumnos = $_POST['alumnos'];

/*******Generacion de codigo de evento****/

if ($conexion) {
        $ultimo_id_conexion = mysqli_insert_id($conexion);
        $insert_alumnos = null;
        foreach ($alumnos as $key => $alumno) {

          $sql = "INSERT INTO Ventana_permisos_alumnos("
                            . "id_permiso,"
                            . "id_alumno, "
                            . "estatus, "
                            . "familia, "
                            . "codigo_invitacion) "
                            . "VALUES ('"
                            . $id_permiso . "','"
                            . $alumno . "','"
                            . 1 . "','"
                            . $nfamilia . "','"
                            . $codigo_invitacion . "')";

                    $insert_alumnos = mysqli_query($conexion, $sql);
        }
        $sql = "COMMIT";
        mysqli_query($conexion, $sql);
        //if ($insert_alumnos)
        echo json_encode(array ("codigo_invitacion" => $codigo_invitacion, "estatus"=> $insert_alumnos) );
        mysqli_close($conexion);
}
