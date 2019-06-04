<?php 
session_start();
include_once("conexion.php");
//include_once("../Model/DBManager.php");


class Control
{
 	var $con;
 	function Control()
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
        
      
        
        //alta de auto///////
        
        
        
     function mostrar_evento($dato)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select ev.id_evento,ev.titulo,ev.fecha,ev.hora,ev.convocado,ev.director,ev.invitados,ev.estatus,ev.id_comite,ec.nombre from evento_principal ev
LEFT join evento_comites ec on ev.id_comite=ec.id_comite
where ev.id_evento=".$dato."");
                       
		   }
	}
        
        
        
         function integrantes($dato)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select ev.id_evento,ev.titulo,ev.fecha,ev.hora,ev.convocado,ev.director,ev.invitados,ev.estatus,ev.id_comite,ec.nombre from evento_principal ev
LEFT join evento_comites ec on ev.id_comite=ec.id_comite
where ev.id_evento=".$dato."");
                       
		   }
	}
      
        
        
                                 }
?>