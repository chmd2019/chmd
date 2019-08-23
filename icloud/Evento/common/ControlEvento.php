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

    public function obtener_capacidad_montaje($id_lugar_evento,$horario_evento,$horario_final_evento,$fecha_evento) {
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

    public function obtener_capacidad_equipo_tecnico($id_lugar_evento,$horario_evento,$horario_final_evento,$fecha_evento) {
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

    public function obtener_capacidad_manteles($id_lugar_evento,$horario_evento,$horario_final_evento,$fecha_evento) {
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
            $sql = "SELECT * FROM Lugares_eventos ORDER BY patio";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function actualizar_personal_tmp($id_tipo_personal, $fecha, $horario, 
            $horario_final, $hora_min, $hora_max, $es_temporal, $ensayo,$n_ensayo) {
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

    public function nuevo_montaje($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, $cantidad_invitados, $valet_parking, $anexa_programa, $tipo_repliegue, $requiere_ensayo, $cantidad_ensayos, $requerimientos_especiales, $check_equipo_tecnico, $id_lugar_evento) {
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
                    . "`check_equipo_tecnico`, `id_lugar_evento`) VALUES ("
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
                    . "$id_lugar_evento)";
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
            $sql = "SELECT id, fecha_montaje, solicitante, nombre_evento FROM Evento_montaje ORDER BY id DESC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT a.id,a.fecha_solicitud,a.solicitante,a.tipo_evento,a.fecha_montaje,"
                    . "a.fecha_montaje_simple, a.horario_evento, a.horario_final_evento, "
                    . "a.nombre_evento, a.responsable_evento,a.cantidad_invitados, "
                    . "a.valet_parking, b.url,a.anexa_programa,a.tipo_repliegue,a.requiere_ensayo,"
                    . "a.cantidad_ensayos, a.requerimientos_especiales, b.name_no_encripted,"
                    . " c.descripcion AS lugar_evento FROM Evento_montaje a LEFT OUTER JOIN Archivos_montaje b "
                    . "ON b.id_motaje = a.id INNER JOIN Lugares_eventos c ON c.id = a.id_lugar_evento "
                    . "WHERE a.id = $id_montaje";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_mobiliario_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.articulo,(SELECT COUNT(*) FROM Inventario_ocupado_mobiliario a "
                    . "WHERE a.id_articulo=b.id AND a.id_evento_montaje=$id_montaje) AS cantidad,b.ruta_img "
                    . "FROM Inventario_ocupado_mobiliario a "
                    . "INNER JOIN Inventario_mobiliario b ON b.id = a.id_articulo "
                    . "WHERE a.id_evento_montaje = $id_montaje ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_manteles_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.articulo,(SELECT COUNT(*) FROM Inventario_ocupado_manteles a "
                    . "WHERE a.id_mantel=b.id AND a.id_evento_montaje=$id_montaje) AS cantidad, b.ruta_img "
                    . "FROM Inventario_ocupado_manteles a INNER JOIN Inventario_manteles b "
                    . "ON b.id = a.id_mantel WHERE a.id_evento_montaje = $id_montaje ORDER BY a.id ASC";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_equipo_tecnico_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.articulo,(SELECT COUNT(*) FROM Inventario_ocupado_equipo_tecnico a "
                    . "WHERE a.id_articulo=b.id AND a.id_evento_montaje=$id_montaje) AS cantidad, b.ruta_img "
                    . "FROM Inventario_ocupado_equipo_tecnico a INNER JOIN Inventario_equipo_tecnico b "
                    . "ON b.id = a.id_articulo WHERE a.id_evento_montaje = $id_montaje";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function consulta_personal_montaje($id_montaje) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.descripcion,(SELECT COUNT(*) FROM Personal_ocupado_montaje a "
                    . "WHERE a.id_tipo_personal=b.id AND a.id_evento_montaje=$id_montaje AND a.ensayo =0) AS cantidad "
                    . "FROM Personal_ocupado_montaje a INNER JOIN Personal_montajes b "
                    . "ON b.id = a.id_tipo_personal WHERE a.id_evento_montaje = $id_montaje AND a.ensayo=false ORDER BY b.tipo_personal";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function finalizar_ensayo($id_montaje,$fecha_ensayo,$horario_inicial,
            $horario_final, $requerimientos_especiales, $n_ensayo){
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
    
    public function finalizar_personal_ocupado($id_ensayo, $timestamp){
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Personal_ocupado_montaje SET id_ensayo =$id_ensayo WHERE `timestamp` = '$timestamp'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function consulta_ensayo($id_montaje){
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT fecha_ensayo, horario_inicial, horario_final, requerimientos_especiales, n_ensayo "
                    . "FROM Evento_ensayos WHERE id_montaje = $id_montaje ORDER BY id";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function consulta_personal_ensayo($id_montaje, $n_ensayo){
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT b.descripcion, (SELECT COUNT(*) FROM  Personal_ocupado_montaje a "
                    . "WHERE a.id_tipo_personal = b.tipo_personal "
                    . "AND a.id_evento_montaje= $id_montaje AND a.n_ensayo = $n_ensayo AND a.ensayo =1) AS cantidad "
                    . "FROM Personal_ocupado_montaje a "
                    . "INNER JOIN Personal_montajes b ON a.id_tipo_personal = b.tipo_personal "
                    . "WHERE a.id_evento_montaje = $id_montaje and a.id_tipo_personal = b.tipo_personal ORDER BY b.tipo_personal";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

}
