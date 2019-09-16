<?php
include_once './ControlCalendario.php';
$control = new ControlCalendario();
$fecha = htmlspecialchars($_GET['fecha_actual']);
$query = $control->lista_montajes_dia($fecha);
$eventos  = array();
while ($res = mysqli_fetch_array($query)){
  $title = $res['nombre_evento'];
  $hora_inicio = $res ['horario_evento'];
  $hora_fin = $res ['horario_final_evento'];
  $lugar = $res['descripcion'];
  $patio_lugar = $res['patio'];
  $tipo_evento= $res['tipo_evento'];

  array_push($eventos, array("title" => $title, "start_hour" => $hora_inicio, "end_hour"=> $hora_fin, "place"=> $lugar, "type_event" =>$tipo_evento));
}

/**Agregar ensayos
**/
$query = $control->lista_ensayos_dia($fecha);
while ($res = mysqli_fetch_array($query)){
  $title = 'Ensayo - '.$res['nombre_evento'];
  $hora_inicio = $res ['horario_evento'];
  $hora_fin = $res ['horario_final_evento'];
  $lugar = $res['descripcion'];
  $patio_lugar = $res['patio'];
  $tipo_evento= $res['tipo_evento'];

  array_push($eventos, array("title" => $title, "start_hour" => $hora_inicio, "end_hour"=> $hora_fin, "place"=> $lugar, "type_event" =>$tipo_evento ));
}


echo json_encode($eventos);
?>
