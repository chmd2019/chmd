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

    public function obtener_capacidad_montaje($id_lugar_evento, $horario_evento, $horario_final_evento, $fecha_evento) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$horario_evento';";
            $sql_2 = "SET @hora_final = '$horario_final_evento';";
            $sql_3 = "SELECT b.id_articulo, a.articulo, b.capacidad,(SELECT COUNT(c.id_articulo) "
                    . "FROM Inventario_ocupado_mobiliario c WHERE c.id_articulo = b.id_articulo "
                    . "AND c.fecha_montaje ='$fecha_evento' AND (@hora_inicial >= c.hora_min AND @hora_inicial "
                    . "<= c.hora_max OR @hora_final >= c.hora_min AND @hora_final <= c.hora_max)) AS asignado, "
                    . "a.inventario - (SELECT COUNT(c.id_articulo) FROM Inventario_ocupado_mobiliario c WHERE "
                    . "c.id_articulo = b.id_articulo AND c.fecha_montaje ='$fecha_evento' AND (@hora_inicial >= "
                    . "c.hora_min AND @hora_inicial <= c.hora_max OR @hora_final >= c.hora_min AND @hora_final "
                    . "<= c.hora_max)) AS disponible, a.ruta_img FROM Inventario_mobiliario a "
                    . "INNER JOIN Inventario_capacidad_mobiliario b ON b.id_articulo = a.id WHERE b.lugar = $id_lugar_evento";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            return mysqli_query($connection, $sql_3);
        }
    }

    public function obtener_capacidad_equipo_tecnico($id_lugar_evento, $horario_evento, $horario_final_evento, $fecha_evento) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$horario_evento';";
            $sql_2 = "SET @hora_final = '$horario_final_evento';";
            $sql_3 = "SELECT b.id_articulo, a.articulo, b.capacidad,"
                    . "(SELECT COUNT(c.id_articulo) FROM Inventario_ocupado_equipo_tecnico c "
                    . "WHERE c.id_articulo = b.id_articulo "
                    . "AND c.fecha_montaje ='$fecha_evento' "
                    . "AND (@hora_inicial >= c.hora_min AND @hora_inicial <= c.hora_max "
                    . "OR @hora_final >= c.hora_min AND @hora_final <= c.hora_max)) AS asignado,"
                    . " a.inventario - (SELECT COUNT(c.id_articulo) "
                    . "FROM Inventario_ocupado_equipo_tecnico c WHERE c.id_articulo = b.id_articulo "
                    . "AND c.fecha_montaje ='$fecha_evento' AND (@hora_inicial >= c.hora_min AND "
                    . "@hora_inicial <= c.hora_max OR @hora_final >= c.hora_min AND "
                    . "@hora_final <= c.hora_max)) AS disponible,a.ruta_img FROM Inventario_equipo_tecnico a "
                    . "INNER JOIN Inventario_capacidad_equipo_tecnico b ON b.id_articulo = a.id "
                    . "WHERE b.lugar = $id_lugar_evento";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            return mysqli_query($connection, $sql_3);
        }
    }

    public function obtener_capacidad_manteles($id_lugar_evento, $horario_evento, $horario_final_evento, $fecha_evento) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$horario_evento';";
            $sql_2 = "SET @hora_final = '$horario_final_evento';";
            $sql_3 = "SELECT b.id_articulo, a.articulo, b.capacidad,(SELECT COUNT(c.id_mantel) "
                    . "FROM Inventario_ocupado_manteles c WHERE c.id_mantel = b.id_articulo "
                    . "AND c.fecha_montaje ='$fecha_evento' "
                    . "AND (@hora_inicial >= c.hora_min AND @hora_inicial <= c.hora_max OR @hora_final >= "
                    . "c.hora_min AND @hora_final <= c.hora_max)) AS asignado, a.inventario - "
                    . "(SELECT COUNT(c.id_mantel) FROM Inventario_ocupado_manteles c "
                    . "WHERE c.id_mantel = b.id_articulo AND c.fecha_montaje ='$fecha_evento' "
                    . "AND (@hora_inicial >= c.hora_min AND @hora_inicial <= c.hora_max OR @hora_final >= "
                    . "c.hora_min AND @hora_final <= c.hora_max)) AS disponible, a.ruta_img FROM Inventario_manteles a "
                    . "INNER JOIN Inventario_capacidad_manteles b ON b.id_articulo = a.id WHERE b.lugar = $id_lugar_evento ";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            return mysqli_query($connection, $sql_3);
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
            $sql = "SELECT * FROM Lugares_eventos ORDER BY patio, descripcion ";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_personal_tmp($id_tipo_personal, $fecha, $horario, $horario_final, $hora_min, $hora_max, $es_temporal, $ensayo, $n_ensayo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Personal_ocupado_montaje` ("
                    . "`id_tipo_personal`, "
                    . "`fecha`, "
                    . "`horario`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`temporal`, "
                    . "`ensayo`, "
                    . "`n_ensayo`) VALUES ("
                    . "'$id_tipo_personal', "
                    . "'$fecha', "
                    . "'$horario', "
                    . "'$horario_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$es_temporal', "
                    . "$ensayo, "
                    . "$n_ensayo);";
            mysqli_set_charset($connection, "utf8");
            $insert = mysqli_query($connection, $sql);
            if (!$insert)
                return false;
            return mysqli_insert_id($connection);
        }
    }

    public function obtener_conexion() {
        return $this->con->conectar1();
    }

    public function obtener_ultimo_timestamp($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT TIMESTAMP FROM Personal_ocupado_montaje WHERE id = '$id'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_ultimo_timestamp_inventario_manteles($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT TIMESTAMP FROM Inventario_ocupado_manteles WHERE id = '$id'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_ultimo_timestamp_tecnico_asignado($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT TIMESTAMP FROM Inventario_ocupado_equipo_tecnico WHERE id = '$id'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_ultimo_timestamp_inventario($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT TIMESTAMP FROM Inventario_ocupado_mobiliario WHERE id = '$id'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function anular_personal_asignado($timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `icloud`.`Personal_ocupado_montaje` WHERE  TIMESTAMP = '$timestamp' AND temporal = 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function anular_inventario_manteles_asignado($timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `icloud`.`Inventario_ocupado_manteles` WHERE  TIMESTAMP = '$timestamp' AND temporal = 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function anular_inventario_asignado($timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `icloud`.`Inventario_ocupado_mobiliario` WHERE  TIMESTAMP = '$timestamp' AND temporal = 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function anular_inventario_asignado_tabla_evento_articulos_asignado($timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `Evento_articulos_asignados` WHERE  timestamp_temporal = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function anular_equipo_tecnico_asignado($timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `icloud`.`Inventario_ocupado_equipo_tecnico` WHERE  TIMESTAMP = '$timestamp' AND temporal = 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_mantel_asignado($id, $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, $es_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Inventario_ocupado_manteles` ("
                    . "`id_mantel`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`temporal`) VALUES ("
                    . "'$id', "
                    . "'$fecha_montaje', "
                    . "'$hora_inicial', "
                    . "'$hora_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$es_temporal');";
            mysqli_set_charset($connection, "utf8");
            $insert = mysqli_query($connection, $sql);
            if (!$insert)
                return false;
            return mysqli_insert_id($connection);
        }
    }

    public function actualizar_inventario_asignado($id, $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, $es_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Inventario_ocupado_mobiliario` ("
                    . "`id_articulo`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`temporal`) VALUES ("
                    . "'$id', "
                    . "'$fecha_montaje', "
                    . "'$hora_inicial', "
                    . "'$hora_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$es_temporal');";
            mysqli_set_charset($connection, "utf8");
            $insert = mysqli_query($connection, $sql);
            if (!$insert)
                return false;
            return mysqli_insert_id($connection);
        }
    }

    public function actualizar_inventario_asignado_edicion($id_evento_montaje,$id_articulo, $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, $es_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Inventario_ocupado_mobiliario` ("
                    . "`id_evento_montaje`, "
                    . "`id_articulo`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`temporal`) VALUES ("
                    . "'$id_evento_montaje', "
                    . "'$id_articulo', "
                    . "'$fecha_montaje', "
                    . "'$hora_inicial', "
                    . "'$hora_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$es_temporal');";
            mysqli_set_charset($connection, "utf8");
            $insert = mysqli_query($connection, $sql);
            if (!$insert)
                return false;
            return mysqli_insert_id($connection);
        }
    }

    public function actualizar_equipo_tecnico_asignado($id, $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, $es_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Inventario_ocupado_equipo_tecnico` ("
                    . "`id_articulo`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`temporal`) VALUES ("
                    . "'$id', "
                    . "'$fecha_montaje', "
                    . "'$hora_inicial', "
                    . "'$hora_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$es_temporal');";
            mysqli_set_charset($connection, "utf8");
            $insert = mysqli_query($connection, $sql);
            if (!$insert)
                return false;
            return mysqli_insert_id($connection);
        }
    }

    public function actualiza_mantel_asignado_suma($id, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_manteles SET asignado = asignado + $cantidad WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualiza_inventario_asignado_suma($id, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_mobiliario SET asignado = asignado + $cantidad WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualiza_equipo_tecnico_asignado_suma($id, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_equipo_tecnico SET asignado = asignado + $cantidad WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualiza_mantel_asignado_resta($id, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_manteles SET asignado = asignado - $cantidad WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualiza_inventario_asignado_resta($id, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_mobiliario SET asignado = asignado - $cantidad WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualiza_equipo_tecnico_asignado_resta($id, $cantidad) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_equipo_tecnico SET asignado = asignado - $cantidad WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function nuevo_montaje($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, $cantidad_invitados, $valet_parking, $anexa_programa, $tipo_repliegue, $requiere_ensayo, $cantidad_ensayos, $requerimientos_especiales, $check_equipo_tecnico, $id_lugar_evento, $evento_con_cafe, $tipo_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Evento_montaje` ("
                    . "`fecha_solicitud`, "
                    . "`solicitante`, "
                    . "`tipo_evento`, "
                    . "`fecha_montaje`, "
                    . "`fecha_montaje_simple`, "
                    . "`horario_evento`, "
                    . "`horario_final_evento`, "
                    . "`nombre_evento`, "
                    . "`responsable_evento`, "
                    . "`cantidad_invitados`, "
                    . "`valet_parking`, "
                    . "`anexa_programa`, "
                    . "`tipo_repliegue`, "
                    . "`requiere_ensayo`, "
                    . "`cantidad_ensayos`, "
                    . "`requerimientos_especiales`, "
                    . "`check_equipo_tecnico`, "
                    . "`id_lugar_evento`, "
                    . "`evento_con_cafe`, "
                    . "`tipo_montaje`) VALUES ("
                    . "'$fecha_solicitud', "
                    . "'$solicitante', "
                    . "'$tipo_evento', "
                    . "'$fecha_montaje', "
                    . "'$fecha_montaje_simple', "
                    . "'$horario_evento', "
                    . "'$horario_final_evento', "
                    . "'$nombre_evento', "
                    . "'$responsable_evento', "
                    . "'$cantidad_invitados', "
                    . "'$valet_parking', "
                    . "$anexa_programa, "
                    . "'$tipo_repliegue', "
                    . "$requiere_ensayo, "
                    . "'$cantidad_ensayos', "
                    . "'$requerimientos_especiales', "
                    . "$check_equipo_tecnico, "
                    . "$id_lugar_evento, "
                    . "$evento_con_cafe, "
                    . "'$tipo_montaje')";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql);
            return mysqli_insert_id($connection);
        }
    }

    public function nuevo_archivo_montaje($id_motaje, $name_file, $name_no_encripted, $path, $size, $timestamp_file, $url) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Archivos_montaje` ("
                    . "`id_motaje`, "
                    . "`name_file`, "
                    . "`name_no_encripted`, "
                    . "`path`, "
                    . "`size`, "
                    . "`timestamp_file`, "
                    . "`url`) VALUES ("
                    . "$id_motaje, "
                    . "'$name_file', "
                    . "'$name_no_encripted', "
                    . "'$path', "
                    . "'$size', "
                    . "'$timestamp_file', "
                    . "'$url');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function finalizar_mobiliario_asignado($id_montaje, $timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_ocupado_mobiliario "
                    . "SET id_evento_montaje = $id_montaje, "
                    . "temporal = false WHERE TIMESTAMP = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function finalizar_articulos_asignados($id_montaje, $timestamp_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Evento_articulos_asignados SET id_montaje = $id_montaje, temporal = false WHERE timestamp_temporal = '$timestamp_temporal'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function finalizar_manteles_asignados($id_montaje, $timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_ocupado_manteles "
                    . "SET id_evento_montaje = $id_montaje, "
                    . "temporal = false WHERE TIMESTAMP = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function finalizar_equipo_tecnico_asignado($id_montaje, $timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Inventario_ocupado_equipo_tecnico "
                    . "SET id_evento_montaje = $id_montaje, "
                    . "temporal = false WHERE TIMESTAMP = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function finalizar_personal_montaje_asignado($id_montaje, $timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Personal_ocupado_montaje "
                    . "SET id_evento_montaje = $id_montaje, "
                    . "temporal = false WHERE TIMESTAMP = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function listar_montajes() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id, a.fecha_montaje, a.solicitante, a.nombre_evento, b.status, b.color_estatus "
                    . "FROM Evento_montaje a INNER JOIN Catalogo_status_acceso b ON b.id = a.estatus ORDER BY id DESC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function listar_montaje_clientes($nombre_usuario) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id, a.fecha_montaje, a.solicitante, a.nombre_evento, b.status, b.color_estatus "
                    . "FROM Evento_montaje a INNER JOIN Catalogo_status_acceso b ON b.id = a.estatus "
                    . "WHERE solicitante = '$nombre_usuario' ORDER BY id DESC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id,a.fecha_solicitud,a.solicitante,a.tipo_evento,a.fecha_montaje, a.fecha_montaje_simple, "
                    . "a.horario_evento, a.horario_final_evento, a.nombre_evento, a.responsable_evento,"
                    . "a.cantidad_invitados, a.valet_parking, b.url,a.anexa_programa,a.tipo_repliegue,"
                    . "a.requiere_ensayo, a.cantidad_ensayos, a.requerimientos_especiales, b.name_no_encripted, "
                    . "c.descripcion AS lugar_evento, a.solo_cafe, a.evento_con_cafe, a.tipo_montaje, d.status, "
                    . "d.color_estatus, d.id, c.id AS id_lugar "
                    . "FROM Evento_montaje a LEFT OUTER JOIN Archivos_montaje b ON b.id_motaje = a.id "
                    . "INNER JOIN Lugares_eventos c ON c.id = a.id_lugar_evento "
                    . "INNER JOIN Catalogo_status_acceso d ON d.id = a.estatus WHERE a.id = $id_montaje";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_mobiliario_montaje($id_montaje, $id_lugar, $hora_inicial, $hora_final, $fecha_consulta) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial';";
            $sql_2 = "SET @hora_final = '$hora_final';";
            $sql_3 = "SET @fecha_consulta = '$fecha_consulta';";
            $sql_4 = "SELECT DISTINCT b.articulo,(SELECT COUNT(*) FROM Inventario_ocupado_mobiliario a "
                    . "WHERE a.id_articulo=b.id AND a.id_evento_montaje=$id_montaje) AS cantidad,b.ruta_img, b.id AS "
                    . "id_articulo, c.capacidad, b.inventario -(SELECT COUNT(*) FROM Inventario_ocupado_mobiliario a "
                    . "WHERE a.id_articulo=b.id AND a.fecha_montaje = @fecha_consulta AND "
                    . "( @hora_inicial >= a.hora_min AND @hora_inicial <= a.hora_max OR @hora_final >= a.hora_min AND "
                    . "@hora_final <= a.hora_max)) AS disponibilidad FROM Inventario_ocupado_mobiliario a "
                    . "INNER JOIN Inventario_mobiliario b ON b.id = a.id_articulo "
                    . "INNER JOIN Inventario_capacidad_mobiliario c ON c.id_articulo = a.id_articulo "
                    . "WHERE a.id_evento_montaje = $id_montaje AND c.lugar = $id_lugar ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            mysqli_query($connection, $sql_3);
            return mysqli_query($connection, $sql_4);
        }
    }

    public function consulta_manteles_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.articulo,(SELECT COUNT(*) FROM Inventario_ocupado_manteles a "
                    . "WHERE a.id_mantel=b.id AND a.id_evento_montaje=$id_montaje) AS cantidad, b.ruta_img, c.capacidad,"
                    . " b.inventario - (SELECT COUNT(*) FROM Inventario_ocupado_manteles a "
                    . "WHERE a.id_mantel=b.id AND a.id_evento_montaje=$id_montaje) AS disponibilidad, b.id "
                    . "FROM Inventario_ocupado_manteles a INNER JOIN Inventario_manteles b ON b.id = a.id_mantel "
                    . "INNER JOIN Inventario_capacidad_manteles c ON c.id_articulo = a.id_mantel "
                    . "WHERE a.id_evento_montaje = $id_montaje ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_equipo_tecnico_montaje($id_montaje, $id_lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.articulo,(SELECT COUNT(*) FROM Inventario_ocupado_equipo_tecnico a "
                    . "WHERE a.id_articulo=b.id AND a.id_evento_montaje=$id_montaje) AS cantidad, b.ruta_img, c.capacidad, "
                    . "b.inventario -(SELECT COUNT(*) FROM Inventario_ocupado_equipo_tecnico a "
                    . "WHERE a.id_articulo=b.id AND a.id_evento_montaje=$id_montaje) AS disponibilidad, b.id "
                    . "FROM Inventario_ocupado_equipo_tecnico a "
                    . "INNER JOIN Inventario_equipo_tecnico b ON b.id = a.id_articulo "
                    . "INNER JOIN Inventario_capacidad_equipo_tecnico c ON c.id_articulo = a.id_articulo "
                    . "WHERE a.id_evento_montaje = $id_montaje AND c.lugar = $id_lugar ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_personal_montaje($id_montaje, $fecha_montaje, $hora_inicial, $hora_final) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial';";
            $sql_2 = "SET @hora_final = '$hora_final';";
            $sql_3 = "SET @fecha_consulta = '$fecha_montaje';";
            $sql_4 = "SELECT DISTINCT a.id_tipo_personal, b.descripcion,(SELECT COUNT(*) "
                    . "FROM Personal_ocupado_montaje a WHERE a.id_tipo_personal=b.id AND a.id_evento_montaje=$id_montaje "
                    . "AND a.ensayo =false) AS cantidad, b.personal_total -(SELECT COUNT(*) "
                    . "FROM Personal_ocupado_montaje a WHERE a.id_tipo_personal=b.id AND a.fecha = @fecha_consulta "
                    . "AND ( @hora_inicial >= a.hora_min AND @hora_inicial <= a.hora_max OR @hora_final >= a.hora_min "
                    . "AND @hora_final <= a.hora_max)) AS disponibilidad, a.n_ensayo, b.personal_total FROM Personal_ocupado_montaje a "
                    . "INNER JOIN Personal_montajes b ON b.id = a.id_tipo_personal WHERE a.id_evento_montaje = $id_montaje "
                    . "AND a.ensayo=false ORDER BY b.tipo_personal";
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            mysqli_query($connection, $sql_3);
            return mysqli_query($connection, $sql_4);
        }
    }

    public function finalizar_ensayo($id_montaje, $fecha_ensayo, $horario_inicial, $horario_final, $requerimientos_especiales, $n_ensayo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Evento_ensayos` ("
                    . "`id_montaje`, "
                    . "`fecha_ensayo`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`requerimientos_especiales`, "
                    . "`n_ensayo`) VALUES ("
                    . "$id_montaje, "
                    . "'$fecha_ensayo', "
                    . "'$horario_inicial', "
                    . "'$horario_final', "
                    . "'$requerimientos_especiales', "
                    . "$n_ensayo);";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function finalizar_personal_ocupado($id_ensayo, $timestamp) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Personal_ocupado_montaje SET id_ensayo =$id_ensayo WHERE `timestamp` = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_ensayo($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT fecha_ensayo, horario_inicial, horario_final, requerimientos_especiales, n_ensayo, id "
                    . "FROM Evento_ensayos WHERE id_montaje = $id_montaje ORDER BY id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_personal_ensayo($id_montaje, $n_ensayo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.descripcion, (SELECT COUNT(*) FROM  Personal_ocupado_montaje a "
                    . "WHERE a.id_tipo_personal = b.tipo_personal "
                    . "AND a.id_evento_montaje= $id_montaje AND a.n_ensayo = $n_ensayo AND a.ensayo =1) AS cantidad, b.tipo_personal  "
                    . "FROM Personal_ocupado_montaje a "
                    . "INNER JOIN Personal_montajes b ON a.id_tipo_personal = b.tipo_personal "
                    . "WHERE a.id_evento_montaje = $id_montaje and a.id_tipo_personal = b.tipo_personal ORDER BY b.tipo_personal";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_servicio_cafe($catindad_invitados) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT b.ingrediente, (a.cantidad_x_invitado*$catindad_invitados.1) AS cantidad_servicio, b.ruta_img  "
                    . "FROM Inventario_capacidad_cafe a INNER JOIN Inventario_cafe b ON b.id = a.id_ingrediente "
                    . "WHERE $catindad_invitados >= a.n_invitados_min AND $catindad_invitados <= a.n_invitados_max;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function nuevo_montaje_cafe($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, $cantidad_invitados, $valet_parking, $id_lugar_evento, $evento_con_cafe, $anexa_programa, $solo_cafe, $tipo_repliegue, $requerimientos_especiales, $tipo_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Evento_montaje` ("
                    . "`fecha_solicitud`, "
                    . "`solicitante`, "
                    . "`tipo_evento`, "
                    . "`fecha_montaje`, "
                    . "`fecha_montaje_simple`, "
                    . "`horario_evento`, "
                    . "`horario_final_evento`, "
                    . "`nombre_evento`, "
                    . "`responsable_evento`, "
                    . "`cantidad_invitados`, "
                    . "`valet_parking`, "
                    . "`id_lugar_evento`, "
                    . "`evento_con_cafe`, "
                    . "`anexa_programa`, "
                    . "`solo_cafe`, "
                    . "`tipo_repliegue`, "
                    . "`requerimientos_especiales`, "
                    . "`tipo_montaje`) VALUES("
                    . "'$fecha_solicitud', "
                    . "'$solicitante', "
                    . "'$tipo_evento', "
                    . "'$fecha_montaje', "
                    . "'$fecha_montaje_simple', "
                    . "'$horario_evento', "
                    . "'$horario_final_evento',"
                    . "'$nombre_evento', "
                    . "'$responsable_evento', "
                    . "$cantidad_invitados, "
                    . "$valet_parking, "
                    . "$id_lugar_evento, "
                    . "$evento_con_cafe, "
                    . "$anexa_programa, "
                    . "$solo_cafe, "
                    . "'$tipo_repliegue', "
                    . "'$requerimientos_especiales', "
                    . "'$tipo_montaje')";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql);
            return mysqli_insert_id($connection);
        }
    }

    public function ocupar_lugar_evento($id_evento_montaje, $id_lugar, $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `Evento_ocupacion_lugar` ("
                    . "`id_evento_montaje`, "
                    . "`id_lugar`, "
                    . "`fecha_montaje`, "
                    . "`hora_inicial`, "
                    . "`hora_final`, "
                    . "`hora_min`, "
                    . "`hora_max`) VALUES ("
                    . "$id_evento_montaje, "
                    . "$id_lugar, "
                    . "'$fecha_montaje', "
                    . "'$hora_inicial', "
                    . "'$hora_final', "
                    . "'$hora_min', "
                    . "'$hora_max');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_disponibilidad_lugar($hora_inicial, $hora_final, $id_lugar, $fecha_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial';";
            $sql_2 = "SET @hora_final = '$hora_final';";
            $sql_3 = "SELECT COUNT(*) FROM Evento_ocupacion_lugar WHERE id_lugar = $id_lugar "
                    . "AND fecha_montaje ='$fecha_montaje' "
                    . "AND(@hora_inicial >= hora_min AND @hora_inicial <= hora_max OR @hora_final >= hora_min "
                    . "AND @hora_final <= hora_max);";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            return mysqli_query($connection, $sql_3);
        }
    }

    public function consulta_disponibilidad_lugar_edicion($hora_inicial, $hora_final, $id_lugar, $fecha_montaje, $id_evento) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial';";
            $sql_2 = "SET @hora_final = '$hora_final';";
            $sql_3 = "SELECT COUNT(*) FROM Evento_ocupacion_lugar WHERE id_lugar = $id_lugar "
                    . "AND fecha_montaje ='$fecha_montaje' "
                    . "AND(@hora_inicial >= hora_min AND @hora_inicial <= hora_max OR @hora_final >= hora_min "
                    . "AND @hora_final <= hora_max) AND id_evento_montaje != $id_evento;";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            return mysqli_query($connection, $sql_3);
        }
    }

    public function actualizar_estaus($id, $estatus) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Evento_montaje SET `estatus`= $estatus WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_montaje($tipo_montaje, $horario_evento, $hora_final_evento, $tipo_repliegue, $nombre_evento, 
            $responsable_evento, $cantidad_invitados, $estacionamiento, $requerimientos_especiales, $id,$lugar_evento) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Evento_montaje SET tipo_montaje = '$tipo_montaje', "
                    . "horario_evento = '$horario_evento', "
                    . "horario_final_evento = '$hora_final_evento', "
                    . "tipo_repliegue = '$tipo_repliegue', "
                    . "nombre_evento = '$nombre_evento', "
                    . "responsable_evento = '$responsable_evento', "
                    . "cantidad_invitados = $cantidad_invitados, "
                    . "valet_parking = $estacionamiento, "
                    . "requerimientos_especiales = '$requerimientos_especiales', "
                    . "edicion = true, "
                    . "notificacion5 = false, "
                    . "id_lugar_evento = '$lugar_evento' "
                    . "WHERE id = $id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_mobiliario_eliminar($id_evento, $id_articulo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM Inventario_ocupado_mobiliario WHERE id_evento_montaje = $id_evento "
                    . "AND id_articulo = $id_articulo";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_mobiliario_eliminar_tb_evento_articulos_asignados($id_evento, $id_articulo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM `Evento_articulos_asignados` WHERE `id_montaje`=$id_evento AND `id_mobiliario` = $id_articulo;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_manteles_eliminar($id_evento, $id_mantel) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM Inventario_ocupado_manteles WHERE id_evento_montaje = $id_evento AND id_mantel = $id_mantel";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_equipo_tecnico_eliminar($id_evento, $id_articulo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM Inventario_ocupado_equipo_tecnico WHERE id_evento_montaje = $id_evento AND id_articulo = $id_articulo";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_personal_eliminar($id_evento, $id_articulo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM Personal_ocupado_montaje WHERE id_evento_montaje = $id_evento AND id_tipo_personal = $id_articulo";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_mobiliario($id_articulo, $id_evento, $fecha_montaje, $horario_inicial, $horario_final, $hora_min, $hora_max) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `Inventario_ocupado_mobiliario` ("
                    . "`id_articulo`, "
                    . "`id_evento_montaje`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`) VALUES ("
                    . "'$id_articulo', "
                    . "'$id_evento', "
                    . "'$fecha_montaje', "
                    . "'$horario_inicial', "
                    . "'$horario_final', "
                    . "'$hora_min', "
                    . "'$hora_max');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_disponibilidad_mobiliario($hora_inicial, $hora_final, $fecha_consulta, $id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial'";
            $sql_2 = "SET @hora_final = '$hora_final'";
            $sql_3 = "SET @fecha_consulta = '$fecha_consulta'";
            $sql_4 = "SELECT DISTINCT b.id AS id_articulo, b.inventario -(SELECT COUNT(*) "
                    . "FROM Inventario_ocupado_mobiliario a WHERE a.id_articulo=b.id "
                    . "AND a.fecha_montaje = @fecha_consulta AND ( @hora_inicial >= a.hora_min "
                    . "AND @hora_inicial <= a.hora_max OR @hora_final >= a.hora_min "
                    . "AND @hora_final <= a.hora_max)) AS disponibilidad FROM Inventario_ocupado_mobiliario a "
                    . "INNER JOIN Inventario_mobiliario b ON b.id = a.id_articulo "
                    . "INNER JOIN Inventario_capacidad_mobiliario c ON c.id_articulo = a.id_articulo "
                    . "ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            mysqli_query($connection, $sql_3);
            return mysqli_query($connection, $sql_4);
        }
    }

    public function consulta_disponibilidad_manteles($hora_inicial, $hora_final, $fecha_consulta, $id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial'";
            $sql_2 = "SET @hora_final = '$hora_final'";
            $sql_3 = "SET @fecha_consulta = '$fecha_consulta'";
            $sql_4 = "SELECT DISTINCT b.id AS id_articulo, b.inventario -(SELECT COUNT(*) "
                    . "FROM Inventario_ocupado_manteles a WHERE a.id_mantel=b.id AND a.fecha_montaje = @fecha_consulta "
                    . "AND( @hora_inicial >= a.hora_min AND @hora_inicial <= a.hora_max OR @hora_final >= a.hora_min "
                    . "AND @hora_final <= a.hora_max)) AS disponibilidad "
                    . "FROM Inventario_ocupado_manteles a "
                    . "INNER JOIN Inventario_manteles b ON b.id = a.id_mantel "
                    . "INNER JOIN Inventario_capacidad_manteles c ON c.id_articulo = a.id_mantel "
                    . "ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            mysqli_query($connection, $sql_3);
            return mysqli_query($connection, $sql_4);
        }
    }

    public function consulta_disponibilidad_equipo_tecnico($hora_inicial, $hora_final, $fecha_consulta, $id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial'";
            $sql_2 = "SET @hora_final = '$hora_final'";
            $sql_3 = "SET @fecha_consulta = '$fecha_consulta'";
            $sql_4 = "SELECT DISTINCT b.id AS id_articulo, b.inventario -(SELECT COUNT(*) "
                    . "FROM Inventario_ocupado_equipo_tecnico a "
                    . "WHERE a.id_articulo=b.id AND a.fecha_montaje = @fecha_consulta "
                    . "AND( @hora_inicial >= a.hora_min AND @hora_inicial <= a.hora_max OR @hora_final >= a.hora_min "
                    . "AND @hora_final <= a.hora_max)) AS disponibilidad FROM Inventario_ocupado_equipo_tecnico a "
                    . "INNER JOIN Inventario_equipo_tecnico b ON b.id = a.id_articulo ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            mysqli_query($connection, $sql_3);
            return mysqli_query($connection, $sql_4);
        }
    }

    public function consulta_disponibilidad_personal($hora_inicial, $hora_final, $fecha_consulta) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql_1 = "SET @hora_inicial = '$hora_inicial'";
            $sql_2 = "SET @hora_final = '$hora_final'";
            $sql_3 = "SET @fecha_consulta = '$fecha_consulta'";
            $sql_4 = "SELECT DISTINCT a.id_tipo_personal, b.descripcion,(SELECT COUNT(*) "
                    . "FROM Personal_ocupado_montaje a WHERE a.id_tipo_personal=b.id AND a.fecha = @fecha_consulta "
                    . "AND ( @hora_inicial >= a.hora_min AND @hora_inicial <= a.hora_max OR @hora_final >= a.hora_min "
                    . "AND @hora_final <= a.hora_max)) AS cantidad, b.personal_total - "
                    . "(SELECT COUNT(*) FROM Personal_ocupado_montaje a WHERE a.id_tipo_personal=b.id "
                    . "AND a.fecha = @fecha_consulta AND ( @hora_inicial >= a.hora_min AND @hora_inicial <= a.hora_max "
                    . "OR @hora_final >= a.hora_min AND @hora_final <= a.hora_max)) AS disponibilidad "
                    . "FROM Personal_ocupado_montaje a INNER JOIN Personal_montajes b ON b.id = a.id_tipo_personal "
                    . "WHERE a.id_tipo_personal = b.id ORDER BY b.tipo_personal";
            mysqli_set_charset($connection, "utf8");
            mysqli_query($connection, $sql_1);
            mysqli_query($connection, $sql_2);
            mysqli_query($connection, $sql_3);
            return mysqli_query($connection, $sql_4);
        }
    }

    public function edicion_manteles($id_mantel, $id_evento, $fecha_montaje, $horario_inicial, $horario_final, $hora_min, $hora_max) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Inventario_ocupado_manteles` ("
                    . "`id_mantel`, "
                    . "`id_evento_montaje`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`) VALUES ("
                    . "'$id_mantel', "
                    . "'$id_evento', "
                    . "'$fecha_montaje', "
                    . "'$horario_inicial', "
                    . "'$horario_final', "
                    . "'$hora_min', "
                    . "'$hora_max');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_equipo_tecnico($id_articulo, $id_evento, $fecha_montaje, $horario_inicial, $horario_final, $hora_min, $hora_max) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Inventario_ocupado_equipo_tecnico` ("
                    . "`id_articulo`, "
                    . "`id_evento_montaje`, "
                    . "`fecha_montaje`, "
                    . "`horario_inicial`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`) VALUES ("
                    . "'$id_articulo', "
                    . "'$id_evento', "
                    . "'$fecha_montaje', "
                    . "'$horario_inicial', "
                    . "'$horario_final', "
                    . "'$hora_min', "
                    . "'$hora_max');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function edicion_personal($id_tipo_personal, $id_evento, $fecha_montaje, $horario_inicial, $horario_final, 
            $hora_min, $hora_max, $n_ensayo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `icloud`.`Personal_ocupado_montaje` ("
                    . "`id_evento_montaje`, "
                    . "`id_tipo_personal`, "
                    . "`fecha`, "
                    . "`horario`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`n_ensayo`, "
                    . "`temporal`) VALUES ("
                    . "'$id_evento', "
                    . "'$id_tipo_personal', "
                    . "'$fecha_montaje', "
                    . "'$horario_inicial', "
                    . "'$horario_final', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "$n_ensayo,0);";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_privilegio_usuario($correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id_privilegio FROM Usuarios_privilegios a "
                    . "INNER JOIN usuarios b ON b.id = a.id_usuario WHERE b.correo = '$correo' ";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_ensayo($id_ensayo,$fecha_ensayo,$hora_inicial_ensayo, $hora_final_ensayo, $requerimientos_ensayo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Evento_ensayos SET "
                    . "fecha_ensayo='$fecha_ensayo', "
                    . "horario_inicial='$hora_inicial_ensayo', "
                    . "horario_final='$hora_final_ensayo', "
                    . "requerimientos_especiales='$requerimientos_ensayo' WHERE id =$id_ensayo;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_personal_ensayo($id_montaje, $id_tipo_personal,$fecha_ensayo,$hora_inicial_ensayo, 
            $hora_final_ensayo, $hora_min, $hora_max,$n_ensayo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO Personal_ocupado_montaje( "
                    . "`id_evento_montaje`, "
                    . "`id_tipo_personal`, "
                    . "`fecha`, "
                    . "`horario`, "
                    . "`horario_final`, "
                    . "`hora_min`, "
                    . "`hora_max`, "
                    . "`n_ensayo`, "
                    . "`ensayo`) VALUES ( "
                    . "'$id_montaje', "
                    . "'$id_tipo_personal', "
                    . "'$fecha_ensayo', "
                    . "'$hora_inicial_ensayo', "
                    . "'$hora_final_ensayo', "
                    . "'$hora_min', "
                    . "'$hora_max', "
                    . "'$n_ensayo', "
                    . "'1');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function eliminar_personal_edicion_ensayo($id_montaje, $id_tipo_personal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM Personal_ocupado_montaje WHERE `id_evento_montaje`= $id_montaje "
                    . "AND `id_tipo_personal` = $id_tipo_personal AND `ensayo` = TRUE";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function asignar_ocupacion_articulos($id_montaje, $fecha_montaje, $id_mobiliario,
            $id_mantel, $id_equipo_tecnico, $cantidad_asignada, $cantidad_faltante, $temporal, $timestamp_temporal) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "INSERT INTO `Evento_articulos_asignados` ("
                    . "`id_montaje`, "
                    . "`fecha_montaje_simple`, "
                    . "`id_mobiliario`, "
                    . "`id_mantel`, "
                    . "`id_equipo_tecnico`, "
                    . "`cantidad_asignada`, "
                    . "`cantidad_faltante`, "
                    . "`temporal`, "
                    . "`timestamp_temporal`) VALUES ("
                    . "'$id_montaje', "
                    . "'$fecha_montaje', "
                    . "'$id_mobiliario', "
                    . "'$id_mantel', "
                    . "'$id_equipo_tecnico', "
                    . "'$cantidad_asignada', "
                    . "'$cantidad_faltante', "
                    . "$temporal, "
                    . "'$timestamp_temporal');";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function reporte_montaje_dia($fecha_dia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id_montaje, a.fecha_montaje_simple, b.articulo AS mobiliario, c.articulo AS mantel, "
                    . "d.articulo AS equipo_tecnico, a.cantidad_asignada, a.cantidad_faltante, e.nombre_evento, "
                    . "e.fecha_montaje FROM Evento_articulos_asignados a "
                    . "LEFT JOIN Inventario_mobiliario b ON b.id = a.id_mobiliario "
                    . "LEFT JOIN Inventario_manteles c ON c.id = a.id_mantel "
                    . "LEFT JOIN Inventario_equipo_tecnico d ON d.id = a.id_equipo_tecnico "
                    . "INNER JOIN Evento_montaje e ON e.id = a.id_montaje "
                    . "WHERE a.fecha_montaje_simple = '$fecha_dia' AND a.temporal = false ";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_fecha_montaje_dia($fecha_simple) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT fecha_montaje FROM Evento_montaje WHERE fecha_montaje_simple = '$fecha_simple' LIMIT 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_nombre_usuario($correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM usuarios WHERE correo = '$correo'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function actualiza_lugar_ocupacion_montaje($lugar_evento, $id){
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE `Evento_ocupacion_lugar` SET `id_lugar`='$lugar_evento' WHERE  `id_evento_montaje`=$id;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function consultar_articulo_en_lugar($id_articulo, $id_lugar){
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT COUNT(*) FROM Inventario_capacidad_mobiliario WHERE lugar = $id_lugar AND id_articulo = $id_articulo;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
}
