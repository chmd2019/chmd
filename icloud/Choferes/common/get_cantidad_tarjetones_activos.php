<?php
include_once './ControlChoferes.php';
$control = new ControlChoferes();
$id = htmlspecialchars($_GET['nfamilia']);
$query = $control->cant_tarjetones_activos($id);
if ($r = mysqli_fetch_array($query) ) {
  $reply  = array("n_tajetones"=> $r[0]);
}else{
  $reply  = array("n_tajetones"=> '0');
}
echo json_encode($reply);
?>
