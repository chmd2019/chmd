
<?php

//require_once("Class_login.php");
include_once("Model/DBManager.php");

class Control_domicilio {

    //constructor	
    var $con;

    function Control_domicilio() {
        $this->con = new DBManager;
    }

    function mostrar_domicilio($familia) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM domicilios_diario where calle_numero like '%teca%' LIMIT 10";
            return mysqli_query($connection, $sql);
        }
    }

}
?>