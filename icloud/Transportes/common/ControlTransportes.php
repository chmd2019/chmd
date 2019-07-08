<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/DBManager.php";

class ControlTransportes {

    public $con;

    public function __construct(){
        $this->con = new DBManager();
    }

    public function listado_permiso_diario($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, fecha_cambio, estatus, tipo_permiso, "
                    . "nfamilia FROM Ventana_Permisos WHERE tipo_permiso = 1 "
                    . "&& nfamilia = '$familia' ORDER BY id_permiso DESC";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function listado_permiso_temporal($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, fecha_inicial, fecha_final, estatus, 
                tipo_permiso, nfamilia FROM Ventana_Permisos WHERE 
                tipo_permiso = 2 && nfamilia = '$familia' ORDER BY id_permiso DESC";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function listado_permiso_permanente($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, lunes, martes, miercoles, jueves, viernes,
                nfamilia, estatus FROM Ventana_Permisos WHERE 
                tipo_permiso = 3 && nfamilia = '$familia' ORDER BY id_permiso DESC";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    function mostrar_domicilio($fam) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT calle,colonia,cp FROM usuarios WHERE numero='$fam'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function cancela_permiso($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Ventana_Permisos SET estatus = 4 WHERE id_permiso ='$id'";
            mysqli_set_charset($connection, 'utf8');
            mysqli_query($connection, $sql);
            return true;
        }
        return false;
    }
    public function consultar_permiso_diario($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT "
                    . "id_permiso, "
                    . "fecha_creacion, "
                    . "responsable, "
                    . "calle_numero, "
                    . "colonia, "
                    . "cp, "
                    . "ruta, "
                    . "comentarios, "
                    . "mensaje, "
                    . "fecha_cambio FROM Ventana_Permisos WHERE id_permiso  = '$id'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function consultar_permiso_temporal($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, "
                    . "idusuario, "
                    . "calle_numero, "
                    . "colonia, "
                    . "cp, "
                    . "comentarios, "
                    . "nfamilia, "
                    . "responsable, "
                    . "parentesco, "
                    . "celular, "
                    . "telefono, "
                    . "fecha_inicial, "
                    . "fecha_final, "
                    . "turno, "
                    . "tipo_permiso, "
                    . "estatus, "
                    . "fecha_creacion, "
                    . "mensaje FROM Ventana_Permisos WHERE id_permiso  = '$id'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function consultar_permiso_permanente($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT responsable,
                    fecha_creacion,
                    idusuario,
                    lunes,
                    martes,
                    miercoles,
                    jueves,
                    viernes,
                    calle_numero,
                    colonia,
                    comentarios, 
                    mensaje,
                    ruta,
                    cp 
                    FROM Ventana_Permisos WHERE id_permiso  = '$id'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function consultar_alumnos_permiso($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM Ventana_permisos_alumnos WHERE id_permiso  = '$id'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function consultar_nombre_alumno($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM alumnoschmd WHERE id  = '$id'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function consultar_nombre_usuario($id){
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM usuarios WHERE id = '$id'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

}
