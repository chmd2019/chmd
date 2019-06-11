<?php

//require_once("Class_login.php");
require_once("../Model/DBManager.php");
//zona horaria para America/Mexico_city 
require_once '../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();

class Control_permanente {

    //constructor	
    var $con;
    var $objDateHelper;
    function Control_permanente() {
        $this->con = new DBManager;
        $this->objDateHelper = new DateHelper();
    }

    function mostrar_permanentes($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            if ($this->con->conectar1() == true) {
                mysqli_set_charset($connection, 'utf8');
                $sql = "select * from Ventana_Permiso_permanente where nfamilia='$familia' and  "
                        . "year(fecha)=YEAR(NOW()) and MONTH(fecha)=MONTH(NOW()) order by id desc limit 3";
            }
            return mysqli_query($connection, $sql);
        }
    }

    function mostrar_domicilio($fam) {
        $connection = $this->con->conectar1();
        if ($connection) {
            mysqli_set_charset($connection, 'utf8');
            $sql = "select papa,calle,colonia,cp from usuarios where password='$fam'";
            return mysqli_query($connection, $sql);
        }
    }

    function mostrar_permanente($folio) {
        $connection = $this->con->conectar1();
        if ($connection) {
            mysqli_set_charset($connection, 'utf8');
            $sql = "select vpp.id,vpp.fecha2,vs.correo,usu.calle,usu.colonia,usu.cp,vpp.calle_numero,vpp.colonia,
                    vpp.cp,vpp.ruta,vpp.comentarios,vpp.lunes,vpp.martes,vpp.miercoles,vpp.jueves,vpp.viernes,
                    vpp.alumno1,vpp.alumno2,vpp.alumno3,vpp.alumno4,vpp.alumno5,vpp.mensaje
                    from 
                    Ventana_Permiso_permanente vpp
                    LEFT JOIN Ventana_user vs on vpp.idusuario=vs.id
                    LEFT JOIN usuarios usu on vpp.nfamilia=usu.`password`
                    where vpp.id='$folio'";
            return mysqli_query($connection, $sql);
        }
    }

    ///formato Permanente
    function Permanente_Alta($campos) {
        $hoy = date("Y-m-d");
        $connection = $this->con->conectar1();
        if ($connection) {
            mysqli_query($connection, "SET NAMES 'utf8'");
            mysqli_query($connection, "SET AUTOCOMMIT=0");
            mysqli_query($connection, "START TRANSACTION");
            $sql = "INSERT INTO Ventana_Permiso_permanente(
                        idusuario,
                        alumno1,
                        alumno2,
                        alumno3,
                        alumno4,
                        alumno5,
                        calle_numero,
                        colonia,
                        cp,
                        lunes,
                        martes,
                        miercoles,
                        jueves,
                        viernes,
                        ruta,
                        comentarios,
                        talumnos,
                        nfamilia,
                        fecha2)
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
                         '" . $campos[18] . "')";
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
        mysql_close($connection);
    }
    
    public function comprueba_cancelacion_transporte_permanente($id) {
        if (!$this->objDateHelper->obtener_hora_limite()) {
            $connection = $this->con->conectar1();
            if ($connection) {
                $sql = "SELECT * from Ventana_Permiso_permanente WHERE id = '$id'";
                mysqli_set_charset($connection, 'utf8');
                return mysqli_query($connection, $sql);
            }
        }
    }

    public function cancela_permiso_permanente($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "UPDATE Ventana_Permiso_permanente SET estatus = 4 WHERE id =$id";
            mysqli_set_charset($connection, 'utf8');
            mysqli_query($connection, $sql);
            return true;
        }
        return false;
    }
}
?>