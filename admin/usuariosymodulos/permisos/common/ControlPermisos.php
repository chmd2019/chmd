<?php
$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlPermisos extends DBManager
{
    private $conexion;

    public function __construct()
    {
        parent::__construct();
        $this->conexion = parent::conectar1();
    }

    public function select_perfiles()
    {
        $sql = "SELECT a.id_perfil, a.nombre, a.activo FROM user_perfil a ORDER BY a.nombre;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_permisos($id_perfil)
    {
        $sql = "SELECT a.id_perfiles_modulos,a.id_perfil,c.nombre AS perfil, b.id_modulo, 
                UPPER(b.modulo) as modulo
                FROM Perfiles_modulos a
                INNER JOIN Modulos_admin b ON b.id_modulo = a.id_modulo
                INNER JOIN user_perfil c ON c.id_perfil = a.id_perfil
                WHERE a.id_perfil = {$id_perfil}
                ORDER BY b.modulo;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_modulos()
    {
        $sql = "SELECT a.id_modulo, UPPER(a.modulo) as modulo FROM Modulos_admin a";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function asociar_permisos($id_perfil, $modulos)
    {
        try {
            mysqli_autocommit($this->conexion, false);
            $sql_delete_permisos = "DELETE FROM Perfiles_modulos WHERE id_perfil = {$id_perfil};";
            if (!mysqli_query($this->conexion, $sql_delete_permisos)) {
                throw new Exception(mysqli_error($this->conexion));
            }

            /*$sql_insert_permiso = "INSERT INTO `Perfiles_modulos` (`id_perfil`, `id_modulo`)
                                    VALUES ({$id_perfil}, {$id_modulo});";*/
        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
    }
}