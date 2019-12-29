<?php
$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlPerfiles
{
    var $conexion;

    public function __construct()
    {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function select_perfiles()
    {
        $sql = "SELECT a.id_perfil, a.nombre, a.privilegios, a.activo FROM user_perfil a";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function nuevo_perfil($perfil)
    {
        $sql = "INSERT INTO `user_perfil` (`nombre`, `privilegios`, `activo`) VALUES 
                ('{$perfil}', '0', '1');";
        mysqli_set_charset($this->conexion, "utf8");
        if (!mysqli_query($this->conexion, $sql)) {
            return mysqli_error($this->conexion);
        }
        return true;
    }

    public function cambiar_activo($id_perfil, $activo)
    {
        $sql = "UPDATE `user_perfil` SET `activo`= {$activo} WHERE  `id_perfil`={$id_perfil};";
        mysqli_set_charset($this->conexion, "utf8");
        if (!mysqli_query($this->conexion, $sql)) {
            return mysqli_error($this->conexion);
        }
        return true;
    }
}