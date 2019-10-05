
<?php
class DBManager
{
    public $BaseDatos;
    public $Servidor;
    public $Usuario;
    public $Clave;
    
    public function __construct()
    {
        $this->BaseDatos = "icloud";
        $this->Servidor = "72.167.210.176";
        $this->Usuario = "icloud";
        $this->Clave = "Icloud2019.";
    }

    public function conectar1()
    {
        $connection = mysqli_connect($this->Servidor, $this->Usuario, $this->Clave, $this->BaseDatos);
        if (!$connection) {
            echo"<h1> [:(] Error al conectar a la base de datos</h1>";
        }
        return $connection;
    }
}
        
?>