<?php

$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlAlumnos {

    public $conexion;

    public function __construct() {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function select_alumnos() {
        $sql = "SELECT * from alumnoschmd order by idcursar desc, nombre desc";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_grupos_especiales() {
        $sql = "SELECT id, grupo FROM App_grupos_especiales";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function insert_alumnos($alumnos, $grupos) {
        mysqli_autocommit($this->conexion, false);
        mysqli_set_charset($this->conexion, "utf8");
        try {
            foreach ($alumnos as $value_alumno) {
                foreach ($grupos as $value_grupo) {
                    $sql = "INSERT INTO `App_grupos_especiales_alumnos` ("
                            . "`alumno_id`, "
                            . "`grupo_id`, "
                            . "`clave_unica`) VALUES ("
                            . "{$value_alumno},"
                            . "{$value_grupo}, "
                            . "'{$value_alumno}-{$value_grupo}');";
                    mysqli_query($this->conexion, $sql);
                }
            }
            return mysqli_commit($this->conexion);
        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
    }

    public function select_grupos_especiales_segun_id_usuario($id_usuario) {
        $sql = "SELECT a.id, b.grupo FROM App_grupos_especiales_alumnos a "
                . "INNER JOIN App_grupos_especiales b ON b.id = a.grupo_id "
                . "WHERE a.alumno_id = $id_usuario";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function eliminar_grupo($id_alumno, $grupo) {
        mysqli_autocommit($this->conexion, false);
        try {
            $sql = "SELECT a.grupo_id FROM App_grupos_especiales_alumnos a "
                    . "INNER JOIN App_grupos_especiales b ON b.id = a.grupo_id "
                    . "WHERE a.alumno_id = {$id_alumno} AND b.grupo = '{$grupo}'";
            mysqli_set_charset($this->conexion, "utf8");
            $id_grupo = mysqli_fetch_array(mysqli_query($this->conexion, $sql))[0];
            $sql_delete = "DELETE FROM `App_grupos_especiales_alumnos` "
                    . "WHERE  `alumno_id`={$id_alumno} AND `grupo_id`= {$id_grupo};";
            mysqli_query($this->conexion, $sql_delete);
            return mysqli_commit($this->conexion);
        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
    }

}
