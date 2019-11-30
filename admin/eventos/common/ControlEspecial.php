<?php

require_once "DBManager.php";
require_once "DateHelper.php";

class ControlEspecial {

    public $con;
    public $date_helper;

    public function __construct() {
        $this->con = new DBManager();
        $this->date_helper = new DateHelper();
    }

    public function obtener_responsables_padre($familia) {
        $conexion = $this->con->conectar1();
        if ($conexion) {
            $sql = "SELECT id, nombre, tipo FROM usuarios WHERE numero = '$familia'";
            mysqli_set_charset($conexion, 'utf8');
            return mysqli_query($conexion, $sql);
        }
    }

    public function obtener_responsables($familia) {
        $conexion = $this->con->conectar1();
        if ($conexion) {
            $sql = "SELECT id, nombre, parentesco FROM Responsables WHERE familia = '$familia'";
            mysqli_set_charset($conexion, 'utf8');
            return mysqli_query($conexion, $sql);
        }
    }

    public function nuevo_responsable($nombre, $parentesco, $familia) {
        $conexion = $this->con->conectar1();
        if ($conexion) {
            $sql = "INSERT INTO Responsables (nombre, familia, parentesco) VALUES ('$nombre', '$familia', '$parentesco')";
            mysqli_set_charset($conexion, "utf8");
            $respuesta = mysqli_query($conexion, $sql);
            if ($respuesta) {
                mysqli_close($conexion);
                return true;
            }
        }
        return false;
    }

    public function listado_permisos_especiales($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, nfamilia, fecha_cambio, tipo_permiso, idusuario, estatus "
                    . "FROM Ventana_Permisos WHERE tipo_permiso = '4' "
                    . "&& nfamilia = '$familia' ORDER BY id_permiso DESC";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function listado_eventos($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, nfamilia, fecha_cambio, tipo_permiso, idusuario, estatus "
                    . "FROM Ventana_Permisos WHERE tipo_permiso = '5' "
                    . "&& nfamilia = '$familia' ORDER BY id_permiso DESC";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function listado_eventos_inscritos($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT DISTINCT id_permiso, codigo_invitacion "
                    . "FROM Ventana_permisos_alumnos WHERE familia = '$familia' ORDER BY id_permiso DESC";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function aviso_tercer_permiso($id_alumno, $anio) {
        $this->date_helper->set_timezone();
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT COUNT(*) FROM Ventana_permisos_alumnos "
                    . "WHERE id_alumno = '$id_alumno' && anio_creacion = '$anio'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_nombre_alumno($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM Ventana_permisos_alumnos WHERE id_permiso = '$id_permiso'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_alumnos_permiso($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM Ventana_permisos_alumnos WHERE id_permiso = '$id_permiso'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_nombre_alumno($id_alumno) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM alumnoschmd WHERE id  = '$id_alumno'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_permiso($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT fecha_creacion, "
                    . "idusuario, "
                    . "fecha_cambio, "
                    . "responsable, "
                    . "parentesco, "
                    . "comentarios, "
                    . "estatus "
                    . "FROM Ventana_Permisos WHERE id_permiso = '$id_permiso'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_nombre_usuario($id_usuario) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT nombre FROM usuarios WHERE id = '$id_usuario'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function cancela_permiso($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {

            $sql = "SELECT * FROM Ventana_permisos_alumnos WHERE id_permiso = '$id_permiso'";
            $alumnos = mysqli_query($connection, $sql);
            while ($alumno = mysqli_fetch_array($alumnos)) {
                $id = $alumno[0];
                $sql_alumno = "UPDATE Ventana_permisos_alumnos SET estatus = 4 WHERE id ='$id'";
                mysqli_query($connection, $sql_alumno);
            }
            $sql = "UPDATE Ventana_Permisos SET estatus = 4 WHERE id_permiso ='$id_permiso'";
            mysqli_set_charset($connection, 'utf8');
            mysqli_query($connection, $sql);
            return true;
        }
        return false;
    }

    public function cancela_inscripcion_evento($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {

            $sql = "SELECT * FROM Ventana_permisos_alumnos WHERE id_permiso = '$id_permiso'";
            $alumnos = mysqli_query($connection, $sql);
            while ($alumno = mysqli_fetch_array($alumnos)) {
                $id = $alumno[0];
                $sql_alumno = "UPDATE Ventana_permisos_alumnos SET estatus = 4 WHERE id ='$id'";
                mysqli_query($connection, $sql_alumno);
            }
            return true;
        }
        return false;
    }

    public function cancela_inscripcion_evento_alumno($id_permiso, $id_alumno) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "DELETE FROM Ventana_permisos_alumnos WHERE id_permiso ='$id_permiso' && id_alumno = '$id_alumno'";
            return mysqli_query($connection, $sql);
        }
    }

    public function obtener_conteo_codigo_invitacion() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT COUNT(*) FROM Ventana_Permisos WHERE tipo_permiso = '5'";
            return mysqli_query($connection, $sql);
        }
    }

    public function conteo_bar_mitzva($codigo_invitacion) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT COUNT(*) FROM Ventana_permisos_alumnos WHERE codigo_invitacion ='$codigo_invitacion'  && estatus NOT LIKE '4%'";
            return mysqli_query($connection, $sql);
        }
    }

    public function verificar_existe_codigo_verificacion($codigo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT COUNT(*) FROM Ventana_Permisos WHERE tipo_permiso = '$codigo'";
            return mysqli_query($connection, $sql);
        }
    }

    public function generador_codigo_invitacion() {
        $codigo_invitacion = "";
        //genrador de codigo de invitacion
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $caracteres .= "1234567890";
        $final = array();
        $longitud = 5;
        $carac_desordenada = str_shuffle($caracteres);
        for ($i = 0; $i <= $longitud; $i++) {
            $final[$i] = $carac_desordenada[$i];
        }
        //recorremos la array e imprimimos
        foreach ($final as $datos) {
            $codigo_invitacion .= $datos;
        }
        return $codigo_invitacion;
    }

    public function buscar_codigo_invitacion($codigo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id_permiso, fecha_cambio, nfamilia,tipo_evento, codigo_invitacion FROM Ventana_Permisos WHERE codigo_invitacion = '$codigo'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_familia($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT familia FROM usuarios WHERE numero = '$familia'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_numero_familia($correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT numero FROM usuarios WHERE correo = '$correo'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function verificar_estado_evento($codigo_invitacion) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT estatus FROM Ventana_Permisos WHERE codigo_invitacion = '$codigo_invitacion'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function verificar_inscripcion($codigo_invitacion, $familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT COUNT(*) FROM Ventana_permisos_alumnos WHERE codigo_invitacion = '$codigo_invitacion' && familia = '$familia'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_inscripcion_evento($codigo_invitacion, $familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id, id_permiso, id_alumno, estatus, codigo_invitacion, familia "
                    . "FROM Ventana_permisos_alumnos WHERE codigo_invitacion = '$codigo_invitacion' && familia = '$familia'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_evento($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT "
                    . "idusuario, "
                    . "fecha_creacion, "
                    . "fecha_cambio, "
                    . "tipo_evento, "
                    . "responsable, "
                    . "parentesco, "
                    . "empresa_transporte, "
                    . "codigo_invitacion, "
                    . "comentarios "
                    . "FROM Ventana_Permisos WHERE id_permiso = '$id_permiso'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_evento_codigo($codigo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT "
                    . "idusuario, "
                    . "fecha_creacion, "
                    . "fecha_cambio, "
                    . "tipo_evento, "
                    . "responsable, "
                    . "parentesco, "
                    . "empresa_transporte, "
                    . "codigo_invitacion, "
                    . "comentarios, "
                    . "id_permiso, "
                    . "nfamilia, "
                    . "estatus "
                    . "FROM Ventana_Permisos WHERE codigo_invitacion = '$codigo'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function consultar_evento_listado($id_permiso) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT "
                    . "fecha_cambio, estatus "
                    . "FROM Ventana_Permisos WHERE id_permiso = '$id_permiso'";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

}
