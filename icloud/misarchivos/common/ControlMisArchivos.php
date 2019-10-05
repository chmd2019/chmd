<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Model/DBManager.php";

class ControlArchivos{
  public $con;
  public function __construct(){
      $this->con = new DBManager();
  }
  public function listado_archivos($familia) {
    $connection = $this->con->conectar1();
    if ($connection) {
      $sql = "SELECT * from lista_mis_archivos order by idarchivo;";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
    }
  }

  public function listado_archivos_autorizados($nfamilia) {
    $connection = $this->con->conectar1();
    if ($connection) {
      $sql = "SELECT * from Archivos_autorizacion where idfamilia= $nfamilia; ";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
    }
  }
  public function listado_choferes($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT id, nombre, estatus, fecha, vigencia from usuarios where tipo=7 and numero=$familia; ";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function listado_hijos($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT id, nombre, grupo, grado from alumnoschmd where  idfamilia=$familia; ";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function listado_tarjetones_activos($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT * from tarjeton_automoviles where idfamilia=$familia and estatus='2' LIMIT 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function listado_autos($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT * from tarjeton_automoviles where idfamilia=$familia;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }


    public function listado_marcas() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT marca from catalogo_marcas_automoviles;";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }
    public function listado_colores() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT color from catalogo_colores_automoviles;";
            mysqli_set_charset($connection, 'utf8');
            return mysqli_query($connection, $sql);
        }
    }

  public function get_auto($id_auto) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT * from tarjeton_automoviles where idtarjeton=$id_auto limit 1;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function get_chofer($id_chofer) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT id, nombre, numero from usuarios where tipo=7 and id=$id_chofer limit 1; ";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function get_padres($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT  id, nombre,tipo,fotografia,responsable from usuarios where tipo>=3 and tipo<=4 and numero=$familia limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function get_padre_actual($familia, $correo) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT  nombre,tipo from usuarios where (tipo>=3 and tipo<=4) and numero=$familia and correo='$correo' limit 1;";
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

  public function get_familia($familia) {
    $connection = $this->con->conectar1();
    if ($connection) {
      $sql = "SELECT familia from usuarios where numero=$familia limit 1;";
      mysqli_set_charset($connection, 'utf8');
      return mysqli_query($connection, $sql);
    }
  }

  public function Cant_Auto($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT count(*) as nautos from tarjeton_automoviles where idfamilia=$familia limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function cant_tarjetones_activos($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT count(*) as ntarjetones from tarjeton_automoviles where idfamilia=$familia and estatus='2' limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function cant_tarjetones_cancelados($familia) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "SELECT count(*) as ntarjetones from tarjeton_automoviles where idfamilia=$familia and estatus='4' limit 2;";
          mysqli_set_charset($connection, 'utf8');
          return mysqli_query($connection, $sql);
      }
  }

  public function renovar_chofer($id_chofer) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "UPDATE usuarios SET estatus = 1, vigencia=1, fotografia='vencido' WHERE id ='$id_chofer'";
          mysqli_set_charset($connection, 'utf8');
          mysqli_query($connection, $sql);
          return true;
      }
      return false;
  }

  public function cancelar_chofer($id_chofer) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "UPDATE usuarios SET estatus = 4, fotografia=''  WHERE id ='$id_chofer'";
          mysqli_set_charset($connection, 'utf8');
          mysqli_query($connection, $sql);
          return true;
      }
      return false;
  }

  public function cancelar_auto($id_auto) {
      $connection = $this->con->conectar1();
      if ($connection) {
          $sql = "UPDATE tarjeton_automoviles SET estatus='4' WHERE idtarjeton ='$id_auto'";
          mysqli_set_charset($connection, 'utf8');
          mysqli_query($connection, $sql);
          return true;
      }
      return false;
  }

}
 ?>
