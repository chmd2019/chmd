<?php

//require_once("Class_login.php");
include_once("../Model/DBManager.php");
include_once '../Helpers/DateHelper.php';

class Control_dia {

    //constructor
    public $con;
    public $objDateHelper;

    public function Control_dia() {
        $this->con = new DBManager;
        $this->objDateHelper = new DateHelper();
    }

    public function mostrar_diario($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * from Ventana_Permiso_diario WHERE nfamilia='$familia' AND year(fecha)=YEAR(NOW()) AND MONTH(fecha)=MONTH(NOW()) order by id desc";
            return mysqli_query($connection, $sql);
        }
    }

    public function mostrar_domicilio($fam) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT papa,calle,colonia,cp from usuarios WHERE PASSWORD='$fam'";
            return mysqli_query($connection, $sql);
        }
    }

    public function mostrar_dias($folio) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT vpd.id,
                    vpd.fecha2,
                    vs.correo,
                    usu.calle,
                    usu.colonia,
                    usu.cp,
                    vpd.calle_numero,
                    vpd.colonia,
                    vpd.cp,
                    vpd.ruta,
                    vpd.comentarios,
                    vpd.alumno1,
                    vpd.alumno2,
                    vpd.alumno3,
                    vpd.alumno4,
                    vpd.alumno5,
                    vpd.mensaje,
                    vpd.fecha1
                    from Ventana_Permiso_diario vpd LEFT JOIN Ventana_user vs on vpd.idusuario=vs.id LEFT JOIN usuarios usu on vpd.nfamilia=usu.`password` where vpd.id='$folio'";
            return mysqli_query($connection, $sql);
        }
    }

    ///formato DIario
    public function Diario_Alta($campos) {
        $hoy = date("Y-m-d");
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql1 = "SET NAMES 'utf8'";
            $sql2 = "SET AUTOCOMMIT=0";
            $sql3 = "START TRANSACTION";
            mysqli_query($connection, $sql1);
            mysqli_query($connection, $sql2);
            mysqli_query($connection, $sql3);
            $sql4 = "INSERT INTO Ventana_Permiso_diario(
                        idusuario,
                        alumno1,
                        alumno2,
                        alumno3,
                        alumno4,
                        alumno5,
                        calle_numero,
                        colonia,
                        cp,
                        ruta,
                        comentarios,
                        talumnos,
                        nfamilia,
                        fecha2,fecha1)
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
                        '" . $campos[14] . "')";
            $Insertar = mysqli_query($connection, $sql4);

            if (!$Insertar) {
                die("error:" . mysqli_error($connection));
                return false;
            }

            if ($Insertar) {
                $sql = "COMMIT";
                mysqli_query($connection, $sql);
            } else {
                $sql = "ROLLBACK";
                mysqli_query($connection, $sql);
            }
        }
        // Close connection
        mysqli_close($connection);
    }

    public function comprueba_cancelacion_transporte($id) {
        if (!$this->objDateHelper->obtener_hora_limite()) {
            $connection = $this->con->conectar1();
            if ($connection) {
                $sql = "SELECT * from Ventana_Permiso_diario WHERE id = '$id'";
                mysqli_set_charset($connection, 'utf8');
                return mysqli_query($connection, $sql);
            }
        }
    }
    
    public function cancela_permiso_diario($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Ventana_Permiso_diario SET estatus = 4 WHERE id =$id";
            mysqli_set_charset($connection,'utf8');
            mysqli_query($connection, $sql);
            return true;
        }
        return false;
    }

}
