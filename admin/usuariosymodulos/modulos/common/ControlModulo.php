<?php

$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlModulo
{
    var $conexion;

    public function __construct()
    {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function select_modulos()
    {
        $sql = "SELECT a.id_modulo, a.modulo FROM Modulos_admin a;";
        mysqli_set_charset($this->conexion, $sql);
        return mysqli_query($this->conexion, $sql);
    }

    public function nuevo_modulo($modulo)
    {
        $sql = "INSERT INTO `Modulos_admin` (`modulo`) VALUES ('{$modulo}');";
        mysqli_set_charset($this->conexion, "utf8");
        if (!mysqli_query($this->conexion, $sql)) {
            return mysqli_error($this->conexion);
        }
        return true;
    }

    public function delete_modulo($id_modulo)
    {
        $sql = "DELETE FROM `Modulos_admin` WHERE id_modulo = {$id_modulo}";
        if (!mysqli_query($this->conexion, $sql)) {
            return mysqli_error($this->conexion);
        }
        return true;
    }

    public function select_modulo_x_id($id_modulo)
    {
        $sql = "SELECT a.id_modulo, a.modulo FROM Modulos_admin a WHERE a.id_modulo = {$id_modulo}";
        mysqli_set_charset($this->conexion, $sql);
        return mysqli_fetch_assoc(mysqli_query($this->conexion, $sql));
    }

    public function editar_modulo($modulo, $id_modulo)
    {
        $sql = "UPDATE `Modulos_admin` SET `modulo`='{$modulo}' WHERE  `id_modulo`= {$id_modulo};";
        mysqli_set_charset($this->conexion, "utf8");
        if (!mysqli_query($this->conexion, $sql)) {
            return mysqli_error($this->conexion);
        }
        return true;
    }
}