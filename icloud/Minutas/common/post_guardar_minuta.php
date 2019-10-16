<?php

require_once "./ControlMinutas.php";
require_once "../../Helpers/DateHelper.php";

$controlMontajes = new ControlMinutas();
$dateHelper = new DateHelper();

$dateHelper->set_timezone();
$key = $_GET['key'];