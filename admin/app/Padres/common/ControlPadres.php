<?php

$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlPadres {

    public $conexion;

    public function __construct() {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function consulta_padres() {
        $sql = "SELECT id, nombre, numero, familia, responsable, correo FROM usuarios WHERE  responsable='PADRE' or responsable='MADRE' order by familia desc, numero";
        mysqli_set_charset($this->conexion, "utf8");
        $datos = mysqli_query($this->conexion, $sql);
        return $datos;
    }

    public function insert_padres($nombre, $apellidos, $responsable, $correo, $familia, $tipo) {
        $sql_consulta_numero = "SELECT numero FROM usuarios WHERE familia ='{$familia}' LIMIT 1";
        mysqli_set_charset($this->conexion, "utf8");
        $numero = mysqli_fetch_array(mysqli_query($this->conexion, $sql_consulta_numero))[0];
        $nombre_completo = "{$nombre} {$apellidos}";
        $sql_insert = "INSERT INTO `usuarios` ("
                . "`nombre`, "
                . "`numero`, "
                . "`correo`, "
                . "`familia`, "
                . "`tipo`, "
                . "`responsable`) VALUES ("
                . "'$nombre_completo', "
                . "'$numero', "
                . "'$correo', "
                . "'$familia', "
                . "$tipo, "
                . "'$responsable');";
        return mysqli_query($this->conexion, $sql_insert);
    }

}
