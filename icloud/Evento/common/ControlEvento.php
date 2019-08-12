<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Model/DBManager.php";

class ControlEvento {

    public $con;

    public function __construct() {
        $this->con = new DBManager();
    }

    public function obtener_dias_habiles() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT tipo_tiempo, numero_dias FROM Tiempos_solicitud";
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_capacidad_montaje($lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id_articulo, a.lugar, b.articulo, a.capacidad, (b.inventario - b.asignado) AS disponible, b.ruta_img "
                    . "FROM Inventario_capacidad_mobiliario a "
                    . "INNER JOIN Inventario_mobiliario b ON a.id_articulo = b.id "
                    . "WHERE a.lugar = $lugar";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_capacidad_equipo_tecnico($lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id_articulo, b.articulo, a.capacidad, b.asignado, (b.inventario - b.asignado) AS disponible, b.ruta_img "
                    . "FROM Inventario_capacidad_equipo_tecnico a "
                    . "INNER JOIN Inventario_equipo_tecnico b ON a.id_articulo = b.id "
                    . "WHERE a.lugar = $lugar";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_capacidad_manteles($lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id_articulo, b.articulo, a.capacidad, b.asignado, (b.inventario - b.asignado) AS disponible, b.ruta_img "
                    . "FROM Inventario_capacidad_manteles a "
                    . "INNER JOIN Inventario_manteles b ON a.id_articulo = b.id "
                    . "WHERE a.lugar = $lugar";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function nuevo_evento_montaje($data) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `Evento_montaje` (
            `fecha_solicitud`, 
            `solicitante`, 
            `tipo_evento`, 
            `fecha_montaje`, 
            `nombre_evento`, 
            `cantidad_invitados`, 
            `horario_evento`, 
            `fecha_ensayo`, 
            `horario_ensayo`, 
            `responsable_evento`,  
            `id_lugar_evento`) VALUES ("
                    . "'$data[0]', "
                    . "'$data[1]', "
                    . "'$data[2]', "
                    . "'$data[3]', "
                    . "'$data[4]', "
                    . "'$data[5]', "
                    . "'$data[6]', "
                    . "'$data[7]', "
                    . "'$data[8]', "
                    . "'$data[9]', "
                    . "'$data[10]')";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql);
            return mysqli_insert_id($connection);
        }
    }

    //registra el inventario del que se va a disponer para eventos o montajes
    public function registro_evento_mobiliario($id_evento_montaje, $id_inventario_montaje, $id_lugar_evento, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `Evento_mobiliario` (
                    `id_evento_montaje`, 
                    `id_inventario_montaje`,
                    `id_lugar_evento`, 
                    `cantidad`) VALUES ("
                    . "'$id_evento_montaje', "
                    . "'$id_inventario_montaje', "
                    . "'$id_lugar_evento', "
                    . "'$cantidad')";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    //registra el inventario del equipo tecnico que se va a disponer para eventos o montajes
    public function registro_evento_equipo_tecnico($id_evento_montaje, $id_inventario_equipo_tecnico, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `Evento_equipo_tecnico` (
                    `id_evento_montaje`, 
                    `id_inventario_equipo_tecnico`,
                    `cantidad`) VALUES ("
                    . "'$id_evento_montaje', "
                    . "'$id_inventario_equipo_tecnico', "
                    . "'$cantidad')";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_inventario_disponible($id_lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, articulo, inventario, asignado, (inventario - asignado) AS disponible "
                    . "FROM Inventario_montajes WHERE lugar = $id_lugar";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_timestamp($id_lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT TIMESTAMP FROM Inventario_montajes WHERE lugar = $id_lugar ORDER BY id ASC LIMIT 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_personal_ocupado($fecha_montaje, $id_personal_montajes, $hora_inicial, $horario_final) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial';";
            $sql_2 = "SET @hora_final = '$horario_final';";
            $sql_3 = "SELECT COUNT(*) FROM Personal_ocupado_montaje "
                    . "WHERE id_tipo_personal = $id_personal_montajes AND fecha ='$fecha_montaje' "
                    . "AND (@hora_inicial >= hora_min AND @hora_inicial <= hora_max "
                    . "OR @hora_final >= hora_min AND @hora_final <= hora_max)";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            return mysqli_query($connection, $sql_3);
        }
    }

    public function obtener_personal_total($tipo_personal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT personal_total FROM Personal_montajes WHERE tipo_personal = '$tipo_personal'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_lugares_evento() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM Lugares_eventos ORDER BY patio";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_personal_tmp($id_tipo_personal, $fecha, $horario, $horario_final, $hora_min, $hora_max, $es_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `chmd_sistemas`.`Personal_ocupado_montaje` ("
                    . "`id_tipo_personal`, "
                    . "`fecha`, "
                    . "`horario`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`temporal`) VALUES ("
                    . "'$id_tipo_personal', "
                    . "'$fecha', "
                    . "'$horario', "
                    . "'$horario_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$es_temporal');";
            mysqli_set_charset($connection, "utf8");
            $insert = mysqli_query($connection, $sql);
            if (!$insert) return false;
            return true;
        }
    }

    public function obtener_conexion() {
        return $this->con->conectar1();
    }

}
