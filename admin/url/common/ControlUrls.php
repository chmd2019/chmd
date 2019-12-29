<?php
$root = dirname(dirname(__DIR__));
require "{$root}/DBManager.php";

class ControlUrls
{
    var $conexion;

    public function __construct()
    {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function select_url()
    {
        $sql = "SELECT a.id, a.url FROM Urls a";
        mysqli_set_charset($this->conexion, "utf");
        return mysqli_fetch_assoc(mysqli_query($this->conexion, $sql));
    }

    public function insert_url($url)
    {
        try {
            mysqli_autocommit($this->conexion, false);
            $sql_delete_url = "DELETE FROM Urls WHERE id > 0";
            $sql_insert = "INSERT INTO `Urls` (`url`) VALUES ('{$url}');";
            mysqli_set_charset($this->conexion, "utf8");
            if (!mysqli_query($this->conexion, $sql_delete_url) ||
                !mysqli_query($this->conexion, $sql_insert)) {
                throw new Exception(mysqli_error($this->conexion));
            }
            return mysqli_commit($this->conexion);

        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
    }
}