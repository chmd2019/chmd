<?php
$root = dirname(__DIR__);
require_once "{$root}/DBManager.php";

class Perfiles
{
    var $conexion;

    public function __construct()
    {
        $db_manager = new DBManager();
        $this->conexion = $db_manager->conectar1();
    }

    public function menu_perfil($id_seccion)
    {
        $sql = "SELECT a.id, a.modulo, a.link, a.imagen, a.idseccion, a.estatus, a.id_capacidad
                FROM Ventana_modulos_transporte a
                WHERE a.idseccion= {$id_seccion}
                ORDER BY a.modulo;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }
}