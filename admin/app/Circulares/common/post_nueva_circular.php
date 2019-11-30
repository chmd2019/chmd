<?php

require './ControlCirculares.php';

$control_circulares = new ControlCirculares();

$titulo = htmlspecialchars(trim(strtoupper($_POST['titulo'])));
$contenido = trim($_POST['contenido']);
$descripcion = htmlspecialchars(trim(strtoupper($_POST['descripcion'])));
$estatus = $_POST['estatus'];
$envia_todos = $_POST['envia_todos'];
$usuarios = $_POST['usuarios'];
$coleccion_nivel_grado_grupo = $_POST['coleccion_nivel_grado_grupo'];
$grupos_especiales = $_POST['grupos_especiales'];
$grupos_administrativos = $_POST['grupos_administrativos'];
$fecha_programada = $_POST['fecha_programada'];
$coleccion_padres_camiones = $_POST['coleccion_padres_camiones'];
$coleccion_padres_camiones_tarde = $_POST['coleccion_padres_camiones_tarde'];
$id_ciclo_escolar = $control_circulares->select_ciclo_escolar();
//ICS GOOGLE CALENDAR
$tema_ics = $_POST['tema_ics'];
$fecha_ics = $_POST['fecha_ics'];
$hora_inicial_ics = $_POST['hora_inicial_ics'];
$hora_final_ics = $_POST['hora_final_ics'];
$ubicacion_ics = $_POST['ubicacion_ics'];
$adjunto = FALSE;
if (strlen($tema_ics) > 0 && strlen($fecha_ics) > 0 && strlen($hora_inicial_ics) > 0 && 
        strlen($hora_final_ics) > 0 && strlen($ubicacion_ics) > 0) {
    $adjunto = TRUE;
}

$query = $control_circulares->nueva_circular($titulo, $contenido, $descripcion, 
        $envia_todos == 'true' ? true : false, $estatus, $usuarios, $grupos_especiales, 
        $grupos_administrativos, $coleccion_nivel_grado_grupo, $fecha_programada, 
        $coleccion_padres_camiones, $coleccion_padres_camiones_tarde, $id_ciclo_escolar, 
        var_export($adjunto, TRUE), var_export($tema_ics, TRUE), var_export($fecha_ics, true), 
        var_export($hora_inicial_ics, TRUE), var_export($hora_final_ics, TRUE), var_export($ubicacion_ics, TRUE));
echo json_encode($query);
