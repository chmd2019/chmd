<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/DBManager.php";

class ControlNiveles{
    public $con;
    public function __construct(){
        $this->con = new DBManager();
    }


    public function listado_niveles() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT id,nivel from Catalogo_nivel";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

public function crearNivel(){
    $connection = $this->con->conectar1();
    if (isset($_POST['nnivel']))
            {
                $nivel = $_POST["nnivel"];
                if ($connection) {
                    $sql = "INSERT INTO Catalogo_nivel(nivel) VALUES('".$nivel."')";
                    mysqli_set_charset($connection, 'utf8');
                    mysqli_query($connection, $sql);
                    return true;
                }
                return false;
            }
  
}


public function actualizarNivel($id,$nivel){
    $connection = $this->con->conectar1();
    if ($connection) {
        $sql = "UPDATE Catalogo_nivel SET nivel ='$nivel' WHERE id ='$id'";
        mysqli_set_charset($connection, 'utf8');
        mysqli_query($connection, $sql);
        return true;
    }
    return false;
}

public function eliminarNivel($id){
    $connection = $this->con->conectar1();
    if ($connection) {
        $sql = "DELETE FROM Catalogo_nivel id ='$id'";
        mysqli_set_charset($connection, 'utf8');
        mysqli_query($connection, $sql);
        return true;
    }
    return false;
}




}
?>