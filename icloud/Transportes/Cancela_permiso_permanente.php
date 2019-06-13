
<?php
include_once './Control_permanente.php';
$id_permiso_permanente = htmlspecialchars($_POST['id_permiso_permanente']);
$objControlPermanente = new Control_permanente();
$respuesta = $objControlPermanente->cancela_permiso_permanente($id_permiso_permanente);
?>
