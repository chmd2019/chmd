<?php 

include_once("../Model/DBManager.php");



class Login
{
 	var $con;
 	function Login()
        {
 		$this->con=new DBManager;
 	}
         ////////////////////////////Perfil eventos comites//////////////////////////////////////////////////
        function AccesoEventos($correo)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select  vs.id,vs.correo,vs.estatus,es.nombre,es.id_comite,es.id_perfil from Ventana_user vs
                                            LEFT join evento_usuarios es on vs.id=es.id_correo
where vs.correo='$correo'
");
                       
		   }
	}
    //////////////////////////////////////////perfil permisos//////////////////////////////////////////////////////////////    
        function AccesoPermisos($correo,$comite)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select  vs.id,vs.correo,vs.estatus,es.nombre,es.id_comite,es.id_perfil from Ventana_user vs
                                            LEFT join evento_usuarios es on vs.id=es.id_correo
where vs.correo='$correo' and id_comite='$comite'
");
                       
		   }
	}
        ////////////////////////////////////////////////////////////////////
	function Acceso($correo)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from Ventana_user where correo='$correo'");
                       
		   }
	}

        
        function Acceso1($id)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select sec.seccion,sec.imagen,sec.idperfil,sec.idmodulo,sec.id,sec.estatus from Ventana_user us
LEFT JOIN Ventana_perfil p on us.idperfil=p.id
LEFT JOIN Ventana_secciones sec on sec.idperfil=p.id
where us.id=$id");
                       
		   }
	}
        
        
            function Acceso2($correo,$idseccion)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select md.modulo,md.link,md.imagen,md.idseccion,md.estatus,us.id,md.id,us.nfamilia
from Ventana_user us
LEFT JOIN Ventana_perfil p on us.idperfil=p.id
LEFT JOIN Ventana_secciones sec on sec.idperfil=p.id
LEFT JOIN Ventana_modulos md on md.idseccion=sec.id
 where us.correo='$correo' and md.idseccion=$idseccion ORDER BY md.id desc");
                       
		   }
	}
        
        
        
        
        function Cambios($mod)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from Ventana_modulos where id=$mod");
                       
		   }
	}
        
        
      /*  
     function mostrar_permanentes($fam)
        {
		if($this->con->conectar1()==true)
               {
                mysql_set_charset('utf8');
	        return mysql_query("select * from Ventana_Permiso_permanente where nfamilia='$fam' order by id desc limit 5");
		}
	}

        */
        
        function mostrar_alumnos($fam)
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("SELECT * FROM alumnoschmd where idfamilia=$fam ");
		}
	}
        /***********************mostrar alumno para el permiso*****************************************/
          function mostrar_alumnos_permiso($alumno1,$alumno2,$alumno3,$alumno4,$alumno5)
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("select id,nombre,grado,grupo from alumnoschmd where id in($alumno1,$alumno2,$alumno3,$alumno4,$alumno5)");
		}
	}
        
        ///////////////////////////////mostrar datos d epermiso de diario
        
               function mostrar_permiso_diario($id)
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("select vpd.id,vpd.fecha2,vs.correo,usu.calle,usu.colonia,usu.cp,vpd.calle_numero,vpd.colonia,
    vpd.cp,vpd.ruta,vpd.comentarios,vpd.alumno1,vpd.alumno2,vpd.alumno3,vpd.alumno4,vpd.alumno5,vpd.mensaje,vpd.fecha1
from 
Ventana_Permiso_diario vpd
LEFT JOIN Ventana_user vs on vpd.idusuario=vs.id
LEFT JOIN usuarios usu on vpd.nfamilia=usu.`password` where vpd.id=$id");
		}
	}
        
        
        
        
        /********************************************************************/
        
           function mostrar_alumnos2($alumno1,$alumno2,$alumno3,$alumno4,$alumno5)
        {
		if($this->con->conectar1()==true)
                    {
                mysql_set_charset('utf8');
	       return mysql_query("select id,nombre,grado,grupo from alumnoschmd where id in($alumno1,$alumno2,$alumno3,$alumno4,$alumno5)");
		}
	}
        
        
        
         function cron_cancelacion()
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("select * from Acceso_responsables where fotografia='CANCELADO' AND notificacion=0");
		}
	}
        
        
           function notificacion_chofer($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Acceso_responsables set notificacion=1 where id=".$id);
		}
        }
        
        /***********************monitoreo*************************************************************/
      
        /////////////////////////////////////////////del dia
          function diario()
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,vp.notificacion3,vp.mensaje from Ventana_Permiso_diario  vp
LEFT JOIN Ventana_user vs on vp.idusuario=vs.id ");
		}
	}
        
        
         
          function notificacion_dia_solicitud($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_diario set notificacion1=1 where id=".$id);
		}
        }  
      
          function notificacion_dia_autorizdo($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_diario set notificacion2=1 where id=".$id);
		}
        }  
        
        
           function notificacion_dia_declinado($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_diario set notificacion3=1 where id=".$id);
		}
        }  
        
        
        /////////////////////////////////////////////////fin del dia
        
        //////////////////////////viaje
        
              function Viaje()
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,vp.notificacion3,vp.mensaje from Ventana_Permiso_viaje  vp
LEFT JOIN Ventana_user vs on vp.idusuario=vs.id");
		}
	}
        
        
        
            function notificacion_viaje_solicitud($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_viaje set notificacion1=1 where id=".$id);
		}
        }  
      
          function notificacion_viaje_autorizdo($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_viaje set notificacion2=1 where id=".$id);
		}
        }  
        
        
           function notificacion_viaje_declinado($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_viaje set notificacion3=1 where id=".$id);
		}
        }  
        
        
        ////////////////////////fin de viaje
      /////////////////////////////// permanente  
        
            function permanente()
        {
		if($this->con->conectar1()==true){
                    mysql_set_charset('utf8');
			return mysql_query("select vp.id,vs.correo,vp.estatus,vp.notificacion1,vp.notificacion2,
    vp.notificacion3,vp.mensaje from Ventana_Permiso_permanente  vp
LEFT JOIN Ventana_user vs on vp.idusuario=vs.id");
		}
	}
        
        
          function notificacion_permanente_solicitud($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_permanente set notificacion1=1 where id=".$id);
		}
        }  
      
          function notificacion_permanente_autorizdo($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_permanente set notificacion2=1 where id=".$id);
		}
        }  
        
        
           function notificacion_permanente_declinado($id)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Ventana_Permiso_permanente set notificacion3=1 where id=".$id);
		}
        }  
        //////////////////////////////////////fin permanente
        /*
          function mostrar_domicilio($fam)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
		   return mysql_query("select papa,calle,colonia,cp from usuarios where password='$fam'");
		}
	} 
        
        
        
          function mostrar_permanente($folio)
        {
		if($this->con->conectar1()==true)
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
?>


//permanente
select * from Ventana_Permisos  vp
LEFT JOIN usuarios vs on vp.idusuario=vs.id
where vp.tipo_permiso=3

//diario
select * from Ventana_Permisos  vp
LEFT JOIN usuarios vs on vp.idusuario=vs.id
where vp.tipo_permiso=1

//viaje o temporal
select * from Ventana_Permisos  vp
LEFT JOIN usuarios vs on vp.idusuario=vs.id
where vp.tipo_permiso=2