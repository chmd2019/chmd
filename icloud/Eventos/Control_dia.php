
<?php 
//require_once("Class_login.php");
include_once("../Model/DBManager.php");


class Control_dia
{
 //constructor	
 	var $con;
 	function Control_dia(){
 		$this->con=new DBManager;
 	    }
            
    
             function mostrar_diario($familia)
        {
		if($this->con->conectar1()==true)
               {
	        return mysql_query("select * from Ventana_Permiso_diario where nfamilia='$familia' and  year(fecha)=YEAR(NOW())  and MONTH(fecha)=MONTH(NOW())  order by id desc limit 3");
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
        
        
        
          function mostrar_dias($folio)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select vpd.id,
                                                   vpd.fecha2,
                                                   vs.correo,
                                                   usu.calle,
                                                   usu.colonia,
                                                   usu.cp,
                                                   vpd.calle_numero,
                                                   vpd.colonia,
                                                   vpd.cp,
                                                   vpd.ruta,
                                                   vpd.comentarios,
                                                   vpd.alumno1,
                                                   vpd.alumno2,
                                                   vpd.alumno3,
                                                   vpd.alumno4,
                                                   vpd.alumno5,
                                                   vpd.mensaje,
                                                   vpd.fecha1
from 
Ventana_Permiso_diario vpd
LEFT JOIN Ventana_user vs on vpd.idusuario=vs.id
LEFT JOIN usuarios usu on vpd.nfamilia=usu.`password` where vpd.id='$folio'");
		}
	} 
            
            
            
        ///formato DIario
        function Diario_Alta($campos)
        {
		$hoy = date("Y-m-d"); 
          
            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              
                         
                    $Insertar=  mysql_query("INSERT INTO Ventana_Permiso_diario(
idusuario,
alumno1,
alumno2,
alumno3,
alumno4,
alumno5,
calle_numero,
colonia,
cp,
ruta,
comentarios,
talumnos,
nfamilia,
fecha2,fecha1)
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
 '".$campos[14]."')");  
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