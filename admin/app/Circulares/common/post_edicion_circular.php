<?php
$titulo = htmlspecialchars(trim($_POST['titulo']));
$contenido = htmlspecialchars($_POST['contenido']);
$descripcion = htmlspecialchars($_POST['descripcion']);
$niveles = $_POST['nivel'];

echo json_encode(array($titulo,$contenido,$descripcion,$niveles));