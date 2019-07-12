<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/DBManager.php";

class ControlChoferes{
  public $con;
  public function __construct(){
      $this->con = new DBManager();
  }

  public function listado_choferes($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT id, nombre, estatus, fecha from usuarios where tipo=7 and numero=$familia; ";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function listado_autos($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT * from Ventana_autos where idfamilia=$familia limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }
  public function get_auto($id_auto) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT * from Ventana_autos where idcarro=$id_auto limit 1;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function get_padres($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT  id, nombre,tipo,fotografia from usuarios where tipo>=3 and tipo<=4 and numero=$familia limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function Cant_choferes($familia) {
    $connection = $this->con->conectar1();
    if ($connection) {
      $sql = "SELECT count(*) as nchoferes from usuarios where not estatus=4 and tipo=7 and numero=$familia limit 2;";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
    }
  }
  public function Cant_Autos($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT count(*) as nautos from Ventana_autos where idfamilia=$familia limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function cancelar_chofer($id_chofer) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "UPDATE usuarios SET estatus = 4 WHERE id ='$id_chofer'";
          mysqli_set_charset($connection, 'utf8');
          mysqli_query($connection, $sql);
          return true;
      }
      return false;
  }

  public function cancelar_auto($id_auto) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "DELETE FROM Ventana_autos WHERE idcarro ='$id_auto'";
          mysqli_set_charset($connection, 'utf8');
          mysqli_query($connection, $sql);
          return true;
      }
      return false;
  }

}
 ?>
