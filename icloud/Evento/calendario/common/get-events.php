<?php

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timeZone" GET parameter will force all ISO8601 date stings to a given timeZone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Evento/calendario/common/ControlCalendario.php";

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
  die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timeZone, like "2013-12-29".
// Since no timeZone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timeZone parameter if it is present.
$time_zone = null;
if (isset($_GET['timeZone'])) {
  $time_zone = new DateTimeZone($_GET['timeZone']);
}
/*** Control de calendario **/
$control = new ControlCalendario();

$eventos_montaje = $control->lista_montajes();
$eventos_array = array();

while ($row = mysqli_fetch_array($eventos_montaje)) {
  $titulo =  $row['nombre_evento'];
  $titulo = (strlen($titulo) > 6 ) ?  substr( $titulo, 0, 6).'...' : $titulo;
  array_push($eventos_array, [
    "title" => $titulo,
    "start" => $row['fecha_montaje_simple']. 'T'. $row['horario_evento'],
    "end" => $row['fecha_montaje_simple']. 'T'. $row['horario_final_evento']
  ]);
}


// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($eventos_array as $array) {

  // Convert the input array into a useful Event object
  $event = new Event($array, $time_zone);

  // If the event is in-bounds, add it to the output
  if ($event->isWithinDayRange($range_start, $range_end)) {
    $output_arrays[] = $event->toArray();
  }
}

// Send JSON to the client.
echo json_encode($output_arrays);
