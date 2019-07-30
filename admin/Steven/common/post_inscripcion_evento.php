<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Model/DBManager.php";
require "$root_icloud/Especial/common/ControlEspecial.php";

$db_manager = new DBManager();
$control = new ControlEspecial();

// Ventana_permisos
$id_permiso = $_POST['id_permiso'];
$codigo_invitacion = $_POST['codigo_invitacion'];
$familia = $_POST['familia'];
$alumnos = $_POST['alumnos'];
$tipo_evento = htmlspecialchars($_POST['tipo_evento']);
$query = null;
$connection = $db_manager->conectar1();
if ($connection) {
    foreach ($alumnos as $key => $alumno) {

        $conteo_bar_mitzva = $control->conteo_bar_mitzva($codigo_invitacion);
        $conteo_bar_mitzva = mysqli_fetch_array($conteo_bar_mitzva);
        $conteo_bar_mitzva = $conteo_bar_mitzva[0];

        if ($conteo_bar_mitzva >= 4 && trim($tipo_evento) == "Bar Mitzvá") {
            // se envia 4 si ha superado el limite
            echo json_encode(4);
            return;
        }

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
                . $familia . "','"
                . $codigo_invitacion . "')";
        $query = mysqli_query($connection, $sql);
    }
}
if ($query) {
    echo json_encode(true);
    return;
}
echo json_encode(false);

