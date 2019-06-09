<?php

include_once '../Model/DBManager.php';

class DateHelper {

    public $con;

    public function DateHelper() {
        $this->con = new DBManager();
    }

    public function set_timezone() {
        date_default_timezone_set('America/Mexico_city');
    }

    /* establece hora limite para operar en 11.30, se convienrte a segundos 
     * para luego comprar con la hora actual, retorna falso si aún no ha 
     * alcanzado el tiempo, y verdadero si ya lo ha alcanzado
     */

    public function get_time_day() {
        $hora_limite = date("11:30");
        $hora_limite_segundos = strtotime($hora_limite);
        $hora_actual_segundos = strtotime(date("H:i"));
        if ($hora_actual_segundos >= $hora_limite_segundos) {
            return true;
        }
        return false;
    }

    public function get_calendario_escolar() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM Calendario_escolar";
            return mysqli_query($connection, $sql);
        }
    }

}
