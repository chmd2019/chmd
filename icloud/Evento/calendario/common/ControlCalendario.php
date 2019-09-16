<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Model/DBManager.php";

class ControlCalendario {

    public $con;

    public function __construct() {
        $this->con = new DBManager();
    }
    public function lista_ensayos() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT ee.fecha_ensayo_simple, em.nombre_evento, ee.horario_inicial, ee.horario_final FROM Evento_ensayos ee INNER JOIN  Evento_montaje em ON ee.id_montaje = em.id;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

    public function lista_montajes() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT fecha_montaje_simple, nombre_evento, horario_evento, horario_final_evento FROM Evento_montaje;";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }

      public function lista_montajes_dia($fecha ) {
            $connection = $this->con->conectar1();
            if ($connection) {
                $sql = "SELECT em.fecha_montaje_simple, em.nombre_evento, em.tipo_evento, em.horario_evento, em.horario_final_evento, le.descripcion, le.patio FROM Evento_montaje em INNER JOIN Lugares_eventos le  ON le.id = em.id_lugar_evento WHERE fecha_montaje_simple='$fecha';";
                mysqli_set_charset($connection, "utf8");
                return mysqli_query($connection, $sql);
            }
        }


    public function lista_ensayos_dia($fecha ) {
          $connection = $this->con->conectar1();
          if ($connection) {
            //  $sql = "SELECT ee.fecha_ensayo_simple, em.nombre_evento, ee.horario_inicio as horario_evento, ee.horario_final as horario_final_evento , le.descripcion, le.patio FROM Evento_ensayos ee INNER JOIN Evento_montaje em ON em.id=em.id_evento INNER JOIN Lugares_eventos le  ON le.id = em.id_lugar_evento WHERE ee.fecha_ensayo_simple='$fecha';";
              $sql = "SELECT ee.fecha_ensayo_simple, em.nombre_evento, em.tipo_evento, ee.horario_inicial as horario_evento, ee.horario_final as horario_final_evento , le.descripcion, le.patio FROM Evento_ensayos ee INNER JOIN Evento_montaje em ON em.id=ee.id_montaje INNER JOIN Lugares_eventos le  ON le.id = em.id_lugar_evento WHERE ee.fecha_ensayo_simple='$fecha';";
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
                    . " c.descripcion AS lugar_evento, a.solo_cafe, a.evento_con_cafe FROM Evento_montaje a LEFT OUTER JOIN Archivos_montaje b "
                    . "ON b.id_motaje = a.id INNER JOIN Lugares_eventos c ON c.id = a.id_lugar_evento "
                    . "WHERE a.id = $id_montaje";
            mysqli_set_charset($connection, "utf8");
            return mysqli_query($connection, $sql);
        }
    }




}
