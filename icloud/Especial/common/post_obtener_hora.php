<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Helpers/DateHelper.php";

$date_helper = new DateHelper();

$hora = $_GET['hora'];
echo json_encode($date_helper->gana_tiempo_extraordinario($hora));
