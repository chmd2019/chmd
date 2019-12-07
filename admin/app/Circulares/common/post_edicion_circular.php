<?php
require './ControlCirculares.php';

$controlCirculares = new ControlCirculares();
$id_circular = $_POST['id_circular'];
$titulo = htmlspecialchars(trim($_POST['titulo']));
$contenido = htmlspecialchars($_POST['contenido']);
$descripcion = htmlspecialchars($_POST['descripcion']);
$niveles = $_POST['nivel'];

$controlCirculares->update_circular($id_circular, $id_nivel, $id_grado, $id_grupo);