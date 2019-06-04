
<?php 
//require_once("Class_login.php");
include_once("Model/DBManager.php");


class Control_temporal
{
 //constructor	
 	var $con;
 	function Control_temporal(){
 		$this->con=new DBManager;
 	    }
            
            
   function mostrar_viaje($familia)
        {
		if($this->con->conectar1()==true)
               {
                mysql_set_charset('utf8');
	        return mysql_query("select * from Ventana_Permiso_viaje where nfamilia='$familia' and  year(fecha)=YEAR(NOW())  and MONTH(fecha)=MONTH(NOW())  order by id desc limit 3");
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
        
        
        
          function mostrar_viajes($folio)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select 
vpv.id,
vpv.fecha2,
vs.correo,
vpv.alumno1,
vpv.alumno2,
vpv.alumno3,
vpv.alumno4,
vpv.alumno5,
vpv.calle_numero,
vpv.colonia,
vpv.cp,
vpv.responsable,
vpv.parentesco,
vpv.celular,
vpv.telefono,
vpv.fecha_inicial,
vpv.ficha_final,
vpv.turno,
vpv.comentarios,
usu.calle,usu.colonia,usu.cp,vpv.mensaje
from 
Ventana_Permiso_viaje vpv
LEFT JOIN Ventana_user vs on vpv.idusuario=vs.id
LEFT JOIN usuarios usu on vpv.nfamilia=usu.`password` 
where vpv.id=$folio");
		}
	} 
            
            
            
            
        ///formato Permanente
	function Temporal_Alta($campos)
        {
		$hoy = date("Y-m-d"); 
          
            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              
                         
$Insertar=  mysql_query("INSERT INTO Ventana_Permiso_viaje( idusuario, alumno1, alumno2, alumno3, alumno4,"
        . " alumno5, calle_numero, colonia, cp, responsable,"
        . " parentesco, celular, telefono, fecha_inicial,"
        . " ficha_final, turno, comentarios, talumnos,"
        . " nfamilia,fecha2) 
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
 '".$campos[18]."',
 '".$campos[19]."')");  
 
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