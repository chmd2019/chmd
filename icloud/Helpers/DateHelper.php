<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT']."/pruebascd/icloud";
include_once "$root_icloud/Model/DBManager.php";

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

    public function prueba() {
        return "OK";
    }

    public function get_time_day() {
        $hora_limite = date("11:30");
        $hora_limite_segundos = strtotime($hora_limite);
        $hora_actual_segundos = strtotime(date("H:i"));
        if ($hora_actual_segundos >= $hora_limite_segundos) {
            return true;
        }
        return false;
    }

    public function obtener_hora_limite() {
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

    //convierte las fechas de tipo string dd/mm/yyyy a m-d-Y, necesaria para convertir la fecha 
    //con detalle de dia de la semana mediante JavaScript
    public function fecha_formato_js($fecha) {
        return date("m-d-Y", strtotime(str_replace("/", "-", $fecha)));
    }

    //retorna en el DOM la fecha con formato - Dia de la semana, dia x del mes x del anio xxxx
    public function fecha_formato_datalle($fecha) {
        return "<script>var fecha = new Date('$fecha');"
                . "var options = {weekday: 'long', year: 'numeric', month:'long', day:'numeric'};"
                . "fecha = fecha.toLocaleDateString('es-MX', options);"
                . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
                . "document.write(fecha);</script>";
    }

    public function fecha_formato_mexico($fechax) {
        $fechax = str_replace("-", "/", $fechax);
        return "<script>"
                . "var options = {weekday: 'long', year: 'numeric', month:'long', day:'numeric'};"
                . "var fecha = new Date('$fechax');"
                . "fecha = fecha.toLocaleString('es-MX', options,{ timeZone: 'America/Mexico_city' });"
                . "document.write(`\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`);</script>";
    }

    public function comprobar_solicitud_vencida($fecha) {
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = explode("-", $fecha);
        $fecha_destino = strtotime("$fecha[1]-$fecha[0]-$fecha[2]");
        if ($fecha_actual <= $fecha_destino) {
            return true;
        }
        return false;
    }

    public function comprobar_solicitud_vencida2($fecha) {
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = explode("/", $fecha);
        $fecha_destino = strtotime("$fecha[1]-$fecha[0]-$fecha[2]");
        if ($fecha_actual <= $fecha_destino) {
            return true;
        }
        return false;
    }
    public function comprobar_solicitud_vencida_d_m_y_guion($fecha) {
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha_destino = strtotime("$fecha");
        if ($fecha_actual <= $fecha_destino) {
            return true;
        }
        return false;
    }

    public function comprobar_solicitud_no_vencida($fecha) {
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = explode("-", $fecha);
        $fecha_destino = strtotime("$fecha[1]-$fecha[0]-$fecha[2]");
        if ($fecha_actual < $fecha_destino) {
            return true;
        }
        return false;
    }
    public function comprobar_igual_actual($fecha){
        $this->set_timezone();
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = strtotime(date("$fecha"));
        if ($fecha_actual == $fecha) {
            return true;
        }
        return false;
    }
    public function comprobar_fecha_pasada($fecha){
        $this->set_timezone();
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = strtotime(date("$fecha"));
        if ($fecha_actual > $fecha) {
            return true;
        }
        return false;
    }
    public function comprobar_fecha_igual($fecha){
        $this->set_timezone();
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = strtotime(date("$fecha"));
        if ($fecha_actual === $fecha) {
            return true;
        }
        return false;
    }

    function formatear_fecha_calendario($fecha) {
        $fecha = explode(" ", $fecha);
        $dia = $fecha[1];
        $mes = $fecha[3];
        $anio = $fecha[5];
        if ($mes == "Enero")
            $mes = "01";
        if ($mes == "Febrero")
            $mes = "02";
        if ($mes == "Marzo")
            $mes = "03";
        if ($mes == "Abril")
            $mes = "04";
        if ($mes == "Mayo")
            $mes = "05";
        if ($mes == "Junio")
            $mes = "06";
        if ($mes == "Julio")
            $mes = "07";
        if ($mes == "Agosto")
            $mes = "08";
        if ($mes == "Septiembre")
            $mes = "09";
        if ($mes == "Octubre")
            $mes = "10";
        if ($mes == "Noviembre")
            $mes = "11";
        if ($mes== "Diciembre")
            $mes = "12";
        return "$dia-$mes-$anio";
    }
}
