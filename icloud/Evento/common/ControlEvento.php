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

    public function obtener_inventarios_montaje($lugar) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, lugar, articulo, inventario, (inventario - asignado) AS disponible "
                    . "FROM Inventario_montajes WHERE lugar ='$lugar'";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_equipo_tecnico() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, articulo, inventario, asignado, (inventario - asignado) AS disponible "
                    . "FROM Inventario_equipo_tecnico";
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

    public function obtener_inventario_disponible($id_lugar){        
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, articulo, inventario, asignado, (inventario - asignado) AS disponible "
                    . "FROM Inventario_montajes WHERE lugar = $id_lugar";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function obtener_timestamp($id_lugar){        
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT TIMESTAMP FROM Inventario_montajes WHERE lugar = $id_lugar ORDER BY id ASC LIMIT 1";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }
    
    public function obtener_conexion(){
        return $this->con->conectar1();
    }
}
