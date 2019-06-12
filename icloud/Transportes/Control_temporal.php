
<?php

//require_once("Class_login.php");
include_once("../Model/DBManager.php");
include_once '../Helpers/DateHelper.php';

class Control_temporal {

    //constructor	
    var $con;
    public $objDateHelper;

    function Control_temporal() {
        $this->con = new DBManager;
        $this->objDateHelper = new DateHelper();
    }

    function mostrar_viaje($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select * from Ventana_Permiso_viaje where nfamilia='$familia' and year(fecha)=YEAR(NOW()) and MONTH(fecha)=MONTH(NOW())";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    function mostrar_domicilio($fam) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select papa,calle,colonia,cp from usuarios where password='$fam'";
            mysqli_set_charset($connection,'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    function mostrar_viajes($folio) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select 
                    vpv.id,
                    vpv.fecha2,
                    vs.correo,
                    vpv.alumno1,
                    vpv.alumno2,
                    vpv.alumno3,
                    vpv.alumno4,
                    vpv.alumno5,
                    vpv.calle_numero,
                    vpv.colonia,
                    vpv.cp,
                    vpv.responsable,
                    vpv.parentesco,
                    vpv.celular,
                    vpv.telefono,
                    vpv.fecha_inicial,
                    vpv.ficha_final,
                    vpv.turno,
                    vpv.comentarios,
                    usu.calle,usu.colonia,usu.cp,vpv.mensaje
                    from 
                    Ventana_Permiso_viaje vpv
                    LEFT JOIN Ventana_user vs on vpv.idusuario=vs.id
                    LEFT JOIN usuarios usu on vpv.nfamilia=usu.`password` 
                    where vpv.id=$folio";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

    ///formato Permanente
    function Temporal_Alta($campos) {
        $this->objDateHelper->set_timezone();
        $hoy = date("Y-m-d");
        $connection = $this->con->conectar1();
        if ($connection) {
            mysqli_query($connection, "SET NAMES 'utf8'");
            mysqli_query($connection, "SET AUTOCOMMIT=0");
            mysqli_query($connection, "START TRANSACTION");
            $sql = "INSERT INTO Ventana_Permiso_viaje( idusuario, alumno1, alumno2, alumno3, alumno4,"
                    . " alumno5, calle_numero, colonia, cp, responsable,"
                    . " parentesco, celular, telefono, fecha_inicial,"
                    . " ficha_final, turno, comentarios, talumnos,"
                    . " nfamilia,fecha2) 
                            VALUES ( 
                     '" . $campos[0] . "',
                     '" . $campos[1] . "',
                     '" . $campos[2] . "',
                     '" . $campos[3] . "',
                     '" . $campos[4] . "',
                     '" . $campos[5] . "',
                     '" . $campos[6] . "', 
                     '" . $campos[7] . "',
                     '" . $campos[8] . "',
                     '" . $campos[9] . "',
                     '" . $campos[10] . "',
                     '" . $campos[11] . "',
                     '" . $campos[12] . "',
                     '" . $campos[13] . "',
                     '" . $campos[14] . "',
                     '" . $campos[15] . "',
                     '" . $campos[16] . "',
                     '" . $campos[17] . "',
                     '" . $campos[18] . "',
                     '" . $campos[19] . "')";

            $Insertar = mysqli_query($connection, $sql);

            if (!$Insertar) {
                die("error:" . mysqli_error($connection));
                return false;
            }

            if ($Insertar) {
                mysqli_query($connection, "COMMIT");
            } else {
                mysqli_query($connection, "ROLLBACK");
            }
        }
        // Close connection
        mysqli_close($connection);
    }

    public function comprueba_cancelacion_transporte_temporal($id) {
        if (!$this->objDateHelper->get_time_day()) {
            $connection = $this->con->conectar1();
            if ($connection) {
                $sql = "SELECT * from Ventana_Permiso_viaje WHERE id = '$id'";
                mysqli_set_charset($connection, 'utf8');
                return mysqli_query($connection, $sql);
            }
        }
    }

    public function cancela_permiso_temporal($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Ventana_Permiso_viaje SET estatus = 4 WHERE id =$id";
            mysqli_set_charset($connection, 'utf8');
            mysqli_query($connection, $sql);
            return true;
        }
        return false;
    }

}

?>