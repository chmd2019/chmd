
<?php 
//require_once("Class_login.php");
include_once("Model/DBManager.php");


class Control_permanente
{
 //constructor	
 	var $con;
 	function Control_permanente(){
 		$this->con=new DBManager;
 	    }
            
            
   function mostrar_permanentes($familia)
        {
		if($this->con->conectar1()==true)
               {
                mysql_set_charset('utf8');
	        return mysql_query("select * from Ventana_Permiso_permanente where nfamilia='$familia' and  year(fecha)=YEAR(NOW())  and MONTH(fecha)=MONTH(NOW())  order by id desc limit 3");
		}
	}
          
        
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
            
            
            
            
              ///formato Permanente
	function Permanente_Alta($campos)
        {
		$hoy = date("Y-m-d"); 
          
            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              
                         
$Insertar=  mysql_query("INSERT INTO Ventana_Permiso_permanente(
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
 '".$campos[0]."',
 '".$campos[1]."',
 '".$campos[2]."',
 '".$campos[3]."',
 '".$campos[4]."',
 '".$campos[5]."',
 '".$campos[6]."', 
 '".$campos[7]."',
 '".$campos[8]."',
 '".$campos[9]."',
 '".$campos[10]."',
 '".$campos[11]."',
 '".$campos[12]."',
 '".$campos[13]."',
 '".$campos[14]."',
 '".$campos[15]."',
  '".$campos[16]."',
 '".$campos[17]."',
 '".$campos[18]."')");  
                if (!$Insertar) 
              {
                    
                    die("error:". mysql_error());
                    return false;
               
                
              }
           
             if ($Insertar)
                             {
                             mysql_query("COMMIT");
                             }
                             else 
                                 {        
                             mysql_query("ROLLBACK");
                                 }
		}
               // Close connection
                mysql_close($conexion);
	}
      

  
        
}
?>