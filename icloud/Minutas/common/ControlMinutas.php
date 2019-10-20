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
            $sql = "SELECT id_comite, nombre FROM `evento_comites` WHERE id_comite = {$id_comite};";
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
            $sql = "SELECT a.id, a.titulo, a.fecha, a.convocante, b.status, b.color_estatus "
                    . "FROM evento_principal a "
                    . "INNER JOIN Catalogo_status_acceso b ON b.id = a.estatus;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function guardar_minuta($titulo, $fecha, $hora, $fecha_formateada, $convocante, $director, $id_comite, $estatus, $id_session, $id_usuario) {
        $connection = $this->con->conectar1();
        if ($connection) {
            mysqli_autocommit($connection, false);
            mysqli_set_charset($connection, "utf8");
            try {
                $sql = "INSERT INTO `evento_principal` ("
                        . "`titulo`, "
                        . "`fecha`, "
                        . "`hora`, "
                        . "`fecha_simple`, "
                        . "`convocante`, "
                        . "`director`, "
                        . "`id_comite`, "
                        . "`estatus`) VALUES ("
                        . "'$titulo', "
                        . "'$fecha', "
                        . "'$hora', "
                        . "'$fecha_formateada', "
                        . "'$convocante', "
                        . "'$director', "
                        . "'$id_comite', "
                        . "'$estatus');";
                mysqli_query($connection, $sql);
                $id_minuta = mysqli_insert_id($connection);
                //insert de invitados
                $sql_invitados_tmp = "SELECT * FROM evento_invitados_tmp WHERE id_creador = $id_usuario AND id_session = '$id_session'";
                $invitados = mysqli_query($connection, $sql_invitados_tmp);
                while ($row = mysqli_fetch_array($invitados)) {
                    $sql_invitado = "INSERT INTO `evento_invitados` ("
                            . "`id_evento`, "
                            . "`id_invitado`, "
                            . "`invitado`, "
                            . "`correo`, "
                            . "`notificacion`) VALUES ("
                            . "'$id_minuta', "
                            . "'{$row[1]}', "
                            . "'{$row[2]}', "
                            . "'{$row[3]}', "
                            . "'0');";
                    mysqli_query($connection, $sql_invitado);
                    //query de eliminacion de los invitados en tmp
                    $sql_delete_invitado = "DELETE FROM evento_invitados_tmp WHERE id = '{$row[0]}'";
                    mysqli_query($connection, $sql_delete_invitado);
                }
                //insert de temas
                $sql_temas_tmp = "SELECT * FROM evento_temas_tmp WHERE id_usuario = $id_usuario AND id_session = '$id_session';";
                $temas = mysqli_query($connection, $sql_temas_tmp);
                $id_tema = null;
                while ($row = mysqli_fetch_array($temas)) {
                    $sql_tema = "INSERT INTO `evento_tema` ("
                            . "`tema`, "
                            . "`id_comite`, "
                            . "`id_minuta`, "
                            . "`acuerdos`, "
                            . "`estatus`) VALUES ("
                            . "'{$row[1]}', "
                            . "'{$id_comite}', "
                            . "'{$id_minuta}', "
                            . "'', "
                            . "'1');";
                    mysqli_query($connection, $sql_tema);
                    $id_tema = mysqli_insert_id($connection);
                    //query de eliminacion de los temas en tmp
                    $sql_delete_tema = "DELETE FROM evento_temas_tmp WHERE id ={$row[0]}";
                    mysqli_query($connection, $sql_delete_tema);
                    $sql_tema_pendiente = "INSERT INTO `evento_tema_pendiente` ("
                            . "`id_minuta`, "
                            . "`id_tema`, "
                            . "`id_comite`, "
                            . "`acuerdos`, "
                            . "`estatus`) VALUES ("
                            . "'{$id_minuta}', "
                            . "'{$id_tema}', "
                            . "'{$id_comite}', "
                            . "'', "
                            . "'1');";
                    mysqli_query($connection, $sql_tema_pendiente);
                }
                mysqli_commit($connection);
                return true;
            } catch (Exception $ex) {
                mysqli_rollback($connection);
                return $ex->getMessage();
            }
        }
    }

    public function consultar_minuta($id_minuta) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id, a.titulo, a.fecha, a.fecha_simple, a.hora, a.convocante, a.director, c.nombre,"
                    . " b.status FROM evento_principal a INNER JOIN Catalogo_status_acceso b ON b.id = a.estatus "
                    . "INNER JOIN evento_comites c ON c.id_comite = a.id_comite WHERE a.id = $id_minuta;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_invitados_minuta($id_minuta) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM evento_invitados a WHERE a.id_evento = $id_minuta;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_temas_minuta($id_minuta) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id_tema, a.tema, b.nombre, a.acuerdos, c.`status`, c.color_estatus, c.id "
                    . "FROM evento_tema a INNER JOIN evento_comites b ON b.id_comite = a.id_comite "
                    . "INNER JOIN Catalogo_status_acceso c ON c.id = a.estatus WHERE a.id_minuta = $id_minuta;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function guardar_acuerdo_tema($acuerdos, $id_minuta, $id_tema) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE `evento_tema_pendiente` SET `acuerdos`='$acuerdos' "
                    . "WHERE `id_minuta`=$id_minuta AND `id_tema` = $id_tema;";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql);
            $sql_select = "SELECT acuerdos FROM evento_tema_pendiente WHERE id_tema = $id_tema AND id_minuta = $id_minuta;";
            return mysqli_query($connection, $sql_select);
        }
    }

    public function consulta_acuerdo($id_tema) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT acuerdos FROM evento_tema_pendiente a WHERE a.id_tema = $id_tema";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_catalogo_estatus() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, status, color_estatus FROM Catalogo_status_acceso";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualiza_catalogo_estatus($estatus, $id_tema) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_tema_pendiente = "UPDATE `evento_tema_pendiente` SET `estatus`='$estatus' WHERE `id_tema`=$id_tema;";
            $sql_tema = "UPDATE `evento_tema` SET `estatus`='$estatus' WHERE `id_tema`=$id_tema;";
            $sql_color_estatus = "SELECT color_estatus FROM Catalogo_status_acceso WHERE id = $estatus";
            mysqli_set_charset($connection, "utf8");
            if (mysqli_query($connection, $sql_tema_pendiente) && mysqli_query($connection, $sql_tema)) {
                return mysqli_query($connection, $sql_color_estatus);
            }
        }
    }

    public function actualizar_asistencia($id_invitado,$id_minuta, $value) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE `evento_invitados` SET `asistencia`= $value "
                    . "WHERE `id_invitado`= $id_invitado AND id_evento = $id_minuta;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

}
