
<?php
class DBManager
{
    public $BaseDatos;
    public $Servidor;
    public $Usuario;
    public $Clave;
    public function DBManager()
    {
        $this->BaseDatos = "chmd_sistemas";
        $this->Servidor = "132.148.43.14";
        $this->Usuario = "sistemas";
        $this->Clave = "S4st3m4s2019.";
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