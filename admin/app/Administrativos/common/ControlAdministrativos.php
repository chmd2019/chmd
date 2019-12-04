<?php

$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlAdministrativos {

    public $conexion;

    public function __construct() {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function select_usuarios_administrativos() {
        $sql = "SELECT id, nombre FROM usuarios ORDER BY nombre;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_grupos_administrativos() {
        $sql = "SELECT id, grupo FROM App_grupos_administrativos;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_administrativos() {
        $sql = "SELECT b.id, a.id, b.nombre, b.correo, c.grupo "
                . "FROM App_usuarios_administrativos a "
                . "INNER JOIN usuarios b ON b.id = a.id_usuario "
                . "INNER JOIN App_grupos_administrativos c ON c.id = a.id_grupo;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_id_grupo_administrativo($grupo) {
        $sql = "SELECT id FROM App_grupos_administrativos WHERE grupo = '$grupo';";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_fetch_array(mysqli_query($this->conexion, $sql))[0];
    }

    public function cancelar_grupo_adm($id_usuario, $id_grupo) {
        $sql = "DELETE FROM App_usuarios_administrativos WHERE id_usuario = $id_usuario AND id_grupo = $id_grupo;";
        return mysqli_query($this->conexion, $sql);
    }

    public function insert_administrativos($usuarios, $grupos) {
        mysqli_autocommit($this->conexion, false);
        mysqli_set_charset($this->conexion, "utf8");
        try {
            foreach ($usuarios as $value_usuario) {
                foreach ($grupos as $value_grupo) {
                    $sql = "INSERT INTO `App_usuarios_administrativos` (`id_usuario`, `id_grupo`, `clave_unica`) "
                            . "VALUES ({$value_usuario}, {$value_grupo}, '{$value_usuario}-{$value_grupo}');";
                    mysqli_query($this->conexion, $sql);
                }
            }
            return mysqli_commit($this->conexion);
        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
    }

    public function insert_grupo_administrativo($grupo) {
        $sql = "INSERT INTO `icloud`.`App_grupos_administrativos` (`grupo`) VALUES ('$grupo');";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

}
