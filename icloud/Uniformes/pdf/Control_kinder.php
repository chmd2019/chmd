<?php 

include_once("conexion.php");



class Control_kinder
{
 	var $con;
 	function Control_kinder()
        {
 		$this->con=new DBManager;
 	}

	

     
      //////////////////////////////////////prueba de PDF CCH////////////////////////////////////////////////////
           function Pdfkinder($idmaestro)
        {
if($idmaestro==1){$profe="SUSANA CHALOM";}
if($idmaestro==2){$profe="CELIA MUSTRI";}
if($idmaestro==3){$profe="JAQUELINE FRIDMAN";}
if($idmaestro==4){$profe="LIZETTE DALVA";}
if($idmaestro==5){$profe="DEBORA WLODAWER";}
if($idmaestro==6){$profe="BRENDA TREPMAN";}
if($idmaestro==7){$profe="MARGARITA ZONANA";}
if($idmaestro==8){$profe="REGINA RAYEK";}
if($idmaestro==9){$profe="NICOLE SONSINO";}
if($idmaestro==10){$profe="JEANETTE MARCOS";}
if($idmaestro==11){$profe="SOFIA PAGOVICH";}
if($idmaestro==12){$profe="DENISSE YAKIN";}
if($idmaestro==13){$profe="SHEILA AYSSENMESER";}
if($idmaestro==14){$profe="PAOLA CHEREM";}

    
               
               
               
               
		if($this->con->conectar1()==true)
                {
                    mysql_set_charset('utf8');
	           return mysql_query("SELECT k.id,k.orden,k.horario,k.date,k.idalumno,al.idfamilia,k.profesor,al.nombre,al.grado,al.grupo
FROM citaskinder k LEFT JOIN alumnoschmd al 
on k.idalumno=al.id where k.profesor='$profe' 
ORDER BY k.id,k.orden,k.date");
		}                       
	}
          
        //////////////////////////////////////////////////////////////////////////////////////
        
        ////////////////////mostrar asistentes por evento///////////////////////////////////////////////////////////////
              function mostrar_integrantes_evento($id_evento)
        {
             $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_asistencia_usuario es LEFT join  evento_usuarios usu on es.id_usuario=usu.id_usuario where id_evento='$id_evento'");
                       
		   }
	} 
        
        //alta de auto
      
        
        
                                 }
?>