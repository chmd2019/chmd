<?php 

include_once("../Model/DBManager.php");



class Control_rfc
{
 	var $con;
 	function Control_rfc()
        {
 		$this->con=new DBManager;
 	}

	

        

   
        
          function mostrar_rfc($familia)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
	           return mysql_query("select * from rfc where nf='$familia'");
		}
	} 
        
        
            function mostrar_rfcnuevo($folio)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
	           return mysql_query("select * from rfc where idrfc='$folio'");
		}
	} 
        
        
        
        
        
              ///formato Permanente
	function Alta_rfc($campos)
        {
		$hoy = date("Y-m-d"); 
          
            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              
                         
$Insertar=  mysql_query("INSERT INTO rfc(rfc,
rs,
ef,
cn,
col,
municipio,
cp,
nf,
correo,
idusuario)
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
 '".$campos[9]."')");  
                if (!$Insertar) 
              {
                    
                    die("Error". mysql_error());
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