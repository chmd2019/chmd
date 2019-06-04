<?php 

include_once("conexion.php");



class Control_cch
{
 	var $con;
 	function Control_cch()
        {
 		$this->con=new DBManager;
 	}

	

        

   
        
          function mostrar_choferes($familia)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("SELECT * from Vista_choferes where nfamilia='$familia' and parentesco='OTRO'  ORDER BY estatus");
		}                       
	} 
        
          function Validar_choferes($familia)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("SELECT count(*) from Vista_choferes where nfamilia='$familia' and parentesco='OTRO' ");
		}                       
	} 
        
        
            function mostrar_pdf($idchofer)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("select * from Acceso_responsables where id='$idchofer'");
		}                       
	} 
        
         
          function mostrar_padres($familia)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("SELECT * from Vista_choferes where nfamilia='$familia' and not parentesco='OTRO' ORDER BY estatus");
		}                       
	} 
        
        
           function obtener_ID()
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("select MAX(id) as id from Acceso_responsables");
		}                       
	} 
        /****************************mostrar auto*******************************************/
        
           function mostrar_autos($familia)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("select * from tarjeton_autos where nfamilia='$familia' and  idstatus=1");
		}                       
	}
        
        
            function mostrar_autosid($valor)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("select * from tarjeton_autos where id='$valor' and  idstatus=1");
		}                       
	}
        
       //cancelar chofer
        
        
          function Cancelar_chofer($idchofer,$correo)
        {
		if($this->con->conectar1()==true)
                {
                    
			return mysql_query("update Acceso_responsables SET fotografia='CANCELADO',correo='$correo'   WHERE id=".$idchofer);
		}
	}
        
        
        //notificacion de cancelacion
        
     
      
        
        
              function mostrar_alumnonos($familia)
        {
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("select * from alumnoschmd where idfamilia='$familia'");
		}                       
	}
      //////////////////////////////////////prueba de PDF CCH////////////////////////////////////////////////////
           function Pdfcch($idmaestro)
        {
    if($idmaestro==422){$profe="BELLA PICCIOTTO";}
   if($idmaestro==246){$profe="CECILIA GONZALEZ";}
   if($idmaestro==1){$profe="CECILIA RODRIGUEZ";}
   if($idmaestro==187){$profe="CINTHIA CRUZ ";}
   if($idmaestro==720){$profe="EDGAR HUERTA";}
   if($idmaestro==296){$profe="GUILLERMO VARGAS";}
   if($idmaestro==771){$profe="LEA MAMAN";}
   if($idmaestro==496){$profe="LIDIA GARCIA";}
   if($idmaestro==557){$profe="MERCEDES ORDOÑEZ";}
   if($idmaestro==669){$profe="ROSALIA MEDINA";}
   if($idmaestro==120){$profe="SOFY DAYAN";}
   if($idmaestro==599){$profe="THELMA SANDLER";}
    
               
               
               
               
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("SELECT k.id,k.orden,k.horario,k.date,k.idalumno,al.idfamilia,k.profesor,al.nombre,al.grado,al.grupo
FROM citascch k LEFT JOIN alumnoschmd al 
on k.idalumno=al.id where k.profesor='$profe' 
ORDER BY k.id,k.orden,k.date");
		}                       
	}
          
        //////////////////////////////////////////////////////////////////////////////////////
        
              ///formato Permanente
	function Alta_chofer($campos)
        {
		$hoy = date("Y-m-d"); 
          
            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              

                      
$Insertar=  mysql_query("INSERT INTO Acceso_responsables(id,nfamilia,
nombre,
idtipo,
idstatus,
fotografia,
tipo,
correo)
 VALUES (
 '".$campos[7]."',
 '".$campos[0]."',
 '".$campos[1]."',
 '3',
 '2',
 '".$campos[8]."',
 'CHOFER',
 '".$campos[2]."')");  

$Insertar1=  mysql_query("INSERT INTO tarjeton_autos(marca,
modelo,
color,
placas,
idstatus,
nfamilia)
 VALUES ( 
 '".$campos[3]."',
 '".$campos[4]."',
 '".$campos[5]."',
 '".$campos[6]."',
 '1',
 '".$campos[0]."')"); 
                if (!$Insertar) 
              {
                    
                    die("Error:INSERT INTO Acceso_responsables(id,nfamilia,
nombre,
idtipo,
idstatus,
fotofrafia,
tipo,
correo)
 VALUES (
 '".$campos[7]."',
 '".$campos[0]."',
 '".$campos[1]."',
 '3',
 '2',
 '".$campos[8]."',
 'CHOFER',
 '".$campos[2]."')". mysql_error());
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
      

        
        //alta de auto
        function Alta_auto($campos)
        {
		
          
            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              

$actualizar=  mysql_query("update tarjeton_autos set marca='".$campos[2]."',modelo='".$campos[3]."',color='".$campos[4]."',placas='".$campos[5]."' where id='".$campos[6]."'  and nfamilia='".$campos[0]."' and  idstatus=1"); 
                if (!$actualizar) 
              {
                    
                    die("Error en accion:comucarse a sistemas". mysql_error());
                    return false;
               
                
              }
           
             if ($actualizar)
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