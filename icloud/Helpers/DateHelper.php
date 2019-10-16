<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Model/DBManager.php";

class DateHelper {

    public $con;

    public function __construct() {
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

    public function comprobar_hora_limite($hora) {
        $hora_limite = date("$hora");
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

    public function comprobar_igual_actual($fecha) {
        $this->set_timezone();
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = strtotime(date("$fecha"));
        if ($fecha_actual == $fecha) {
            return true;
        }
        return false;
    }

    public function comprobar_fecha_pasada($fecha) {
        $this->set_timezone();
        $fecha_actual = strtotime(date("d-m-Y"));
        $fecha = strtotime(date("$fecha"));
        if ($fecha_actual > $fecha) {
            return true;
        }
        return false;
    }

    public function comprobar_fecha_igual($fecha) {
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
        if ($mes == "Enero" || $mes == "enero")
            $mes = "01";
        if ($mes == "Febrero" || $mes == "febrero")
            $mes = "02";
        if ($mes == "Marzo" || $mes == "marzo")
            $mes = "03";
        if ($mes == "Abril" || $mes == "abril")
            $mes = "04";
        if ($mes == "Mayo" || $mes == "mayo")
            $mes = "05";
        if ($mes == "Junio" || $mes == "junio")
            $mes = "06";
        if ($mes == "Julio" || $mes == "julio")
            $mes = "07";
        if ($mes == "Agosto" || $mes == "agosto")
            $mes = "08";
        if ($mes == "Septiembre" || $mes == "septiembre")
            $mes = "09";
        if ($mes == "Octubre" || $mes == "octubre")
            $mes = "10";
        if ($mes == "Noviembre" || $mes == "noviembre")
            $mes = "11";
        if ($mes == "Diciembre" || $mes == "diciembre")
            $mes = "12";
        return "$dia-$mes-$anio";
    }

    public function obtener_meses() {
        return array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    }

    public function obtener_dias() {
        return array('Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado');
    }

    function suma_dia_habil($fecha, $dias) {
        $datestart = strtotime($fecha);
        $datesuma = 15 * 86400;
        $diasemana = date('N', $datestart);
        $totaldias = $diasemana + $dias;
        $findesemana = intval($totaldias / 5) * 2;
        $diasabado = $totaldias % 5;
        if ($diasabado == 6)
            $findesemana++;
        if ($diasabado == 0)
            $findesemana = $findesemana - 2;

        $total = (($dias + $findesemana) * 86400) + $datestart;
        return $fechafinal = date('Y-m-d', $total);
    }

    public function formato_fecha_diagonal_m_d_y($fecha) {
        $fecha = explode("-", $fecha);
        return "$fecha[2]/$fecha[1]/$fecha[0]";
    }

    public function formatear_fecha_calendario_formato_a_m_d_guion($fecha) {
        $dia = explode(" ", $fecha)[1];
        $mes = explode(" ", $fecha)[3];
        $anio = explode(" ", $fecha)[5];
        if ($mes === "Enero" || $mes === "enero")
            $mes = "01";
        if ($mes === "Febrero" || $mes === "febrero")
            $mes = "02";
        if ($mes === "Marzo" || $mes === "marzo")
            $mes = "03";
        if ($mes === "Abril" || $mes === "abril")
            $mes = "04";
        if ($mes === "Mayo" || $mes === "mayo")
            $mes = "05";
        if ($mes === "Junio" || $mes === "junio")
            $mes = "06";
        if ($mes === "Julio" || $mes === "julio")
            $mes = "07";
        if ($mes === "Agosto" || $mes === "agosto")
            $mes = "08";
        if ($mes === "Septiembre" || $mes === "septiembre")
            $mes = "09";
        if ($mes === "Octubre" || $mes === "octubre")
            $mes = "10";
        if ($mes === "Noviembre" || $mes === "noviembre")
            $mes = "11";
        if ($mes === "Diciembre" || $mes === "diciembre")
            $mes = "12";
        return "{$anio}-{$mes}-{$dia}";
    }
    
    function fecha_listados(){
        $fecha_actual = date('m/d/Y');
        $fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
        return $fecha_actual_impresa_script;
    }
}
