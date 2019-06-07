<?php

include_once("DBManager.php");

class Login {

    public $con;

    public function Login() {
        $this->con = new DBManager;
    }

    /* Método de ejemplo de consulta sql
      $connection = $this->con->conectar1();
      if ($connection) {
      $sql = consulta;
      mysqli_set_charset('utf8');
      return mysqli_query($connection, $sql);
      }
     */

    ////////////////////////////Perfil eventos comites//////////////////////////////////////////////////
    public function AccesoEventos($correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select  vs.id,vs.correo,vs.estatus,es.nombre,es.id_comite,es.id_perfil from Ventana_user vs
                                            LEFT join evento_usuarios es on vs.id=es.id_correo where vs.correo='$correo'";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    //////////////////////////////////////////perfil permisos//////////////////////////////////////////////////////////////
    public function AccesoPermisos($correo, $comite) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select  vs.id,vs.correo,vs.estatus,es.nombre,es.id_comite,es.id_perfil from Ventana_user vs
                                            LEFT join evento_usuarios es on vs.id=es.id_correo where vs.correo='$correo' and id_comite='$comite'";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    ////////////////////////////////////////////////////////////////////
    public function Acceso($correo) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * from Ventana_user WHERE correo = '$correo'";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function Acceso1($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select sec.seccion,sec.imagen,sec.idperfil,sec.idmodulo,sec.id,sec.estatus from Ventana_user us
                                LEFT JOIN Ventana_perfil p on us.idperfil=p.id
                                LEFT JOIN Ventana_secciones sec on sec.idperfil=p.id where us.id=$id";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function Acceso2($correo, $idseccion) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT md.modulo,md.link,md.imagen,md.idseccion,md.estatus,us.id,md.id,us.nfamilia
                    from Ventana_user us
                    LEFT JOIN Ventana_perfil p on us.idperfil=p.id
                    LEFT JOIN Ventana_secciones sec on sec.idperfil=p.id
                    LEFT JOIN Ventana_modulos md on md.idseccion=sec.id
                    WHERE us.correo='$correo' and md.idseccion=$idseccion ORDER BY md.id desc";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function Cambios($mod) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select * from Ventana_modulos where id=$mod";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    /*
      function mostrar_permanentes($fam)
      {
      if($this->con->conectar1())
      {
      mysql_set_charset('utf8');
      return mysql_query("select * from Ventana_Permiso_permanente where nfamilia='$fam' order by id desc limit 5");
      }
      }

     */

    public function mostrar_alumnos($fam) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "SELECT * FROM alumnoschmd where idfamilia=$fam";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    /*     * *********************mostrar alumno para el permiso**************************************** */

    public function mostrar_alumnos_permiso($alumno1, $alumno2, $alumno3, $alumno4, $alumno5) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select id,nombre,grado,grupo from alumnoschmd where id in($alumno1,$alumno2,$alumno3,$alumno4,$alumno5)";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    ///////////////////////////////mostrar datos d epermiso de diario

    public function mostrar_permiso_diario($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select vpd.id,vpd.fecha2,vs.correo,usu.calle,usu.colonia,usu.cp,vpd.calle_numero,vpd.colonia,
                                vpd.cp,vpd.ruta,vpd.comentarios,vpd.alumno1,vpd.alumno2,vpd.alumno3,vpd.alumno4,vpd.alumno5,
                                vpd.mensaje,vpd.fecha1 from Ventana_Permiso_diario vpd LEFT JOIN Ventana_user vs on vpd.idusuario=vs.id
                                LEFT JOIN usuarios usu on vpd.nfamilia=usu.`password` where vpd.id=$id";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    /*     * ***************************************************************** */

    public function mostrar_alumnos2($alumno1, $alumno2, $alumno3, $alumno4, $alumno5) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select id,nombre,grado,grupo from alumnoschmd where id in($alumno1,$alumno2,$alumno3,$alumno4,$alumno5)";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function cron_cancelacion() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select * from Acceso_responsables where fotografia='CANCELADO' AND notificacion=0";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_chofer($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Acceso_responsables set notificacion=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    /*     * *********************monitoreo************************************************************ */

    /////////////////////////////////////////////del dia
    public function diario() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,vp.notificacion3,vp.mensaje from 
                                Ventana_Permiso_diario  vp LEFT JOIN Ventana_user vs on vp.idusuario=vs.id";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_dia_solicitud($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_diario set notificacion1=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_dia_autorizdo($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_diario set notificacion2=1 where id=" . $id;
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_dia_declinado($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_diario set notificacion3=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    /////////////////////////////////////////////////fin del dia
    //////////////////////////viaje
    public function Viaje() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,vp.notificacion3,vp.mensaje from 
                    Ventana_Permiso_viaje  vp LEFT JOIN Ventana_user vs on vp.idusuario=vs.id";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_viaje_solicitud($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_viaje set notificacion1=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_viaje_autorizdo($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_viaje set notificacion2=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_viaje_declinado($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_viaje set notificacion3=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    ////////////////////////fin de viaje
    /////////////////////////////// permanente

    public function permanente() {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,
                    vp.notificacion3,vp.mensaje from Ventana_Permiso_permanente  vp
                    LEFT JOIN Ventana_user vs on vp.idusuario=vs.id";
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_permanente_solicitud($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_permanente set notificacion1=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_permanente_autorizdo($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_permanente set notificacion2=1 where id=" . $id;
            mysqli_set_charset('utf8');
            return mysqli_query($connection, $sql);
        }
    }

    public function notificacion_permanente_declinado($id) {
        $connection = $this->con->conectar1();
        if ($connection) {
            $sql = "update Ventana_Permiso_permanente set notificacion3=1 where id=" . $id;
            return mysqli_query($connection, $sql);
        }
    }

    //////////////////////////////////////fin permanente
    /*
      function mostrar_domicilio($fam)
      {
      if($this->con->conectar1())
      {
      mysql_set_charset('utf8');
      return mysql_query("select papa,calle,colonia,cp from usuarios where password='$fam'");
      }
      }



      function mostrar_permanente($folio)
      {
      if($this->con->conectar1())
      {
      mysql_set_charset('utf8');
      return mysql_query("select vpp.id,vpp.fecha2,vs.correo,usu.calle,usu.colonia,usu.cp,vpp.calle_numero,vpp.colonia,
      vpp.cp,vpp.ruta,vpp.comentarios,vpp.lunes,vpp.martes,vpp.miercoles,vpp.jueves,vpp.viernes,
      vpp.alumno1,vpp.alumno2,vpp.alumno3,vpp.alumno4,vpp.alumno5,vpp.mensaje
      from
      Ventana_Permiso_permanente vpp
      LEFT JOIN Ventana_user vs on vpp.idusuario=vs.id
      LEFT JOIN usuarios usu on vpp.nfamilia=usu.`password`
      where vpp.id='$folio'");
      }
      }

     */
}
