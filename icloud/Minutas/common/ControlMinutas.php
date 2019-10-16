<?php

$root = dirname(dirname(__DIR__));
include_once "{$root}/Model/DBManager.php";

class ControlMinutas {

    public $con;

    public function __construct() {
        $this->con = new DBManager();
    }

    public function consultar_comite($id_comite) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM `evento_comites` WHERE id_comite = {$id_comite};";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_usuario_nombre_tipo($correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre, tipo, id FROM usuarios WHERE correo = '{$correo}';";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_director($id_comite) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM evento_usuarios WHERE id_comite = {$id_comite} AND director = TRUE;";
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_invitado($nombre) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM usuarios WHERE nombre COLLATE UTF8_GENERAL_CI LIKE '%{$nombre}%';";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_todos_invitados() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM usuarios;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_usuario($nombre) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, correo FROM usuarios WHERE nombre COLLATE UTF8_GENERAL_CI LIKE '%$nombre%';";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function guardar_minuta($titulo, $fecha, $hora, $convocado, $director, $id_comite, $fecha_alta) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `evento_principal` ("
                    . "`titulo`, "
                    . "`fecha`, "
                    . "`hora`, "
                    . "`convocado`, "
                    . "`director`, "
                    . "`id_comite`, "
                    . "`fecha_alta`) VALUES ("
                    . "'$titulo', "
                    . "'$fecha', "
                    . "'$hora', "
                    . "'$convocado', "
                    . "'$director', "
                    . "'$id_comite', "
                    . "'$fecha_alta';";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql);
            return mysqli_insert_id($connection);
        }
    }

    public function guardar_invitados($id_evento, $id_invitado, $invitado, $correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `evento_invitados` ("
                    . "`id_evento`, "
                    . "`id_invitado`, "
                    . "`invitado`, "
                    . "`correo`) VALUES ("
                    . "'$id_evento', "
                    . "'$id_invitado', "
                    . "'$invitado', "
                    . "'$correo');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function guardar_invitados_tmp($id_invitado, $invitado, $correo, $id_creador, $id_session) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `evento_invitados_tmp` ("
                    . "`id_invitado`, "
                    . "`invitado`, "
                    . "`correo`, "
                    . "`id_creador`, "
                    . "`id_session`) VALUES ("
                    . "$id_invitado, "
                    . "'$invitado', "
                    . "'$correo', "
                    . "'$id_creador', "
                    . "'$id_session');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function eliminar_invitados_tmp($correo, $id_creador, $id_session) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM evento_invitados_tmp WHERE id_creador = $id_creador AND correo = '$correo' AND id_session = '$id_session';";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function guardar_tema_tmp($tema, $id_session, $id_usuario) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `evento_temas_tmp` (`tema`, `id_session`, `id_usuario`) VALUES ("
                    . "'$tema', "
                    . "'$id_session', "
                    . "'$id_usuario');";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql);
            return mysqli_insert_id($connection);
        }
    }

    public function eliminar_tema_tmp($tema, $id_session, $id_usuario) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `evento_temas_tmp` WHERE "
                    . "`tema`='$tema' AND "
                    . "`id_session`='$id_session' AND "
                    . "`id_usuario`='$id_usuario';";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function guardar_archivo_tmp($nombre, $id_session, $id_usuario) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `evento_archivo_tmp` (`nombre`, `id_session`, `id_usuario`) VALUES ("
                    . "'$nombre', "
                    . "'$id_session', "
                    . "$id_usuario);";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_minutas() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_evento, titulo, fecha, hora, convocado, director, invitados, estatus, id_comite, id FROM evento_principal;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

}
