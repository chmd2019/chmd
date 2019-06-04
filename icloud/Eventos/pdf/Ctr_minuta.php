<?php 
session_start();
include_once("conexion.php");



class Ctr_minuta
{
 	var $con;
 	function Ctr_minuta()
        {
 		$this->con=new DBManager;
 	}

	function mostrar_comite()
        {
              $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
                  
			return mysql_query("select * from evento_comites where id_comite=$id_comite");
                       
		   }
	}
      /////////////////////////////////////////////////  
        
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
        //////////////////////////////////////////////////////
        
        function mostrar_director()
        {
              $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
                  
			return mysql_query("select * from evento_usuarios where id_comite=$id_comite and director=1");
                       
		   }
	}
        
        
        
        
        function minuta()
        {
              $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
                  
			return mysql_query("SELECT * FROM evento_principal WHERE titulo NOT LIKE '' and id_comite=$id_comite ORDER By id desc ");
                       
		   }
	}


        
        function minutas($q)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("SELECT * FROM evento_principal WHERE titulo LIKE '%$q%' OR fecha LIKE '%$q%' OR estatus LIKE '%$q%' order by id desc ");
                       
		   }
	}
        
        
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
        
      /////////////////////////////////////////////////////////////////////////////////////////////////////  
        function mostrar_tema_pendiente($dato)
        {
             $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_tema_pendiente where  estatus=0 and id_comite=$id_comite and cerrado='1'");
                       
		   }
	}
        /////////////////////////////////////////////////////////////////////////////////////////
              function mostrar_integrantes()
        {
             $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_usuarios where id_comite=$id_comite");
                       
		   }
	}
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
        
       ////////////////////////////////////////validacion de tema pendiente para quitar de la lista de pendientes/////////////////////////////////////////////////// 
              function mostrar_tema_pendiente2($tema)
        {
             $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_tema_pendiente where  estatus=1 and tema='".$tema."' and id_comite=$id_comite");
                       
		   }
	}
        
       ///////////////////////////////////////////////////////////////////////////// 
         function validar_tema_pendiente($dato)
        {
             
             $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_tema_pendiente where  estatus=0 and id_comite=$id_comite and tema='".$dato."'");
                       
		   }
	}
        
        ///////////////////////////valida tema no repetido por id_comite/////////////////////////////////////////
         function Buscar_tema($tema)
        {
              $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_tema where tema='$tema' and id_comite=$id_comite");
                       
		   }
	}
        ///////////////////////////////////////////////////////////////////////////////////////////
        function Buscar_titulo($tema)
        {
              $id_comite=$_SESSION['idseccion'];
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_principal where titulo='$tema' and id_comite=$id_comite");
                       
		   }
	}
        
        
        /////////////////////////insertar pendientes a otro evento tema pendiente/////////////////////////////////////////////
        /*
        
               function InserPendientesTemas($campos)
        {

              $id_comite=$_SESSION['idseccion'];
            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");

            
 
                 $insertar = mysql_query("insert into evento_tema(tema,acuerdos,id_tema,id_comite,id_evento) VALUES ('".$campos[3]."','".$campos[1]."','".$campos[0]."','".$id_comite."','".$campos[4]."' ) "); 
   
                  if (!$insertar) 
              {
                 die("Error:mysql: $insertar  " . mysql_error());
              }
             
          if ($insertar)
          {
             mysql_query("COMMIT");
             }
              else 
               {        
                mysql_query("ROLLBACK");
                 }
                             
		
                 
                 
                 
               }
           
                
	}
        
        
        
        
        */
        ///////////////////////////////////insertar asistentes evento////////////////////////////////////////////////////
           function InsertAsistentes($campos)
        {

              $id_comite=$_SESSION['idseccion'];
            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");

            
 
                 $insertar = mysql_query("insert into evento_asistencia_usuario(id_evento,id_usuario) VALUES ('".$campos[0]."','".$campos[1]."' ) "); 
   
                  if (!$insertar) 
              {
                 die("Error:mysql: $insertar  " . mysql_error());
              }
             
          if ($insertar)
          {
             mysql_query("COMMIT");
             }
              else 
               {        
                mysql_query("ROLLBACK");
                 }
                             
		
                 
                 
                 
               }
           
                
	}
        ////////////////////////////////////////////////////////////////////////////////////////////
        
           function mostrar_temas($dato)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_tema where id_evento=".$dato."");
                       
		   }
	}
        
      ////////////////////////////////proceso de Tema_Pendiente/////////////////////////////////////////////////////
            function Tema_Pendiente($campos)
        {

              $id_comite=$_SESSION['idseccion'];
            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");

                $actualizar = mysql_query("update evento_tema SET status='".$campos[2]."',acuerdos='".$campos[1]."' WHERE id_tema=$campos[0]"); 
 
                 $insertar = mysql_query("insert into evento_tema_pendiente(tema,acuerdos,id_tema,id_comite,id_evento) VALUES ('".$campos[3]."','".$campos[1]."','".$campos[0]."','".$id_comite."','".$campos[4]."' ) "); 
   
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
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
           
                
	}
//////////////////////////////////////////////////////////////////////////////////
        
        
     /////////////////////actualiza cuando cambia de estatus por tema///////////////////////
        
         function Tema_concluido($campos)
        {

            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");

                 $actualizar = mysql_query("update evento_tema SET status='".$campos[2]."',acuerdos='".$campos[1]."' WHERE id_tema='".$campos[0]."' "); 
                
   
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
          if ($actualizar )
          {
             mysql_query("COMMIT");
             }
              else 
               {        
                mysql_query("ROLLBACK");
                 }
                             
		
                 
                 
                 
               }
           
                
	}
        //////////////////////////actualiza por evento ////////////////////////////////////////////////
        
           function Acuerdos($campos)
        {

            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");

                 $actualizar = mysql_query("update evento_tema SET acuerdos='".$campos[1]."',update1='1' WHERE id_tema='".$campos[2]."' and id_evento='".$campos[0]."' "); 
                
   
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
          if ($actualizar )
          {
             mysql_query("COMMIT");
             }
              else 
               {        
                mysql_query("ROLLBACK");
                 }
                             
		
                 
                 
                 
               }
           
                
	}
        ///////////////////////////////proceso de asitencia usuasrios comite///////////////////////////////////////////////////////////////////////
            function AsistenciaComite($campos)
        {
                                                          
            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");

                 $actualizar = mysql_query("update evento_asistencia_usuario SET asistencia='".$campos[2]."' WHERE id_evento='".$campos[1]."' and id_usuario='".$campos[0]."'"); 
                
   
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
          if ($actualizar )
          {
             mysql_query("COMMIT");
             }
              else 
               {        
                mysql_query("ROLLBACK");
                 }
                             
		
                 
                 
                 
               }
           
                
	}
        
  ///////////////////////////////////busca si ya tenia estatus el tema///////////////////////////////////////////////////////      
            function Buscar_tema_pendinete($dato)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_archivo where id_evento=".$dato."");
                       
		   }
	}
        
   ////////////////////////////////////////////////////////////////////////////////////////     
            function Buscar_tema_estatus2($id_tema1,$idusuario)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_tema_pendiente where id_tema='".$id_tema1."' and id_evento='".$idusuario."'");
                       
		   }
	}
     ////////////////////////////////tema borrar pendientes/////////////////////////////////////////////////   
        
             function Tema_Borrar($campos)
        {
		if($this->con->conectar1()==true)
                    {
                          mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              
			
                        $actualizar = mysql_query("delete from evento_tema_pendiente where id_tema='".$campos[0]."'  and id_evento='".$campos[1]."'");
		   
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
        
           
               
                         if ($actualizar )
                             {
                             mysql_query("COMMIT");
                             }
                             else 
                                 {        
                             mysql_query("ROLLBACK");
                                 }
                        
                        
                        
                    }
	}
        
        /////////////////////////////////////////////
           function mostrar_archivos($dato)
        {
		if($this->con->conectar1()==true)
                    {
                    mysql_set_charset('utf8');
			return mysql_query("select * from evento_archivo where id_evento=".$dato."");
                       
		   }
	}
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
          function Evento_Alta2($campos)
        {
              $id_comite=$_SESSION['idseccion'];
              
              if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");
                 
                 
                 
$actualizar = mysql_query(" INSERT INTO evento_tema(tema,acuerdos,status,id_evento,id_comite)   VALUES ( 
 '".$campos[0]."',
 '".$campos[1]."',
 '0','".$campos[2]."','".$id_comite."')");  

               
               
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
        
           
               
                         if ($actualizar )
                             {
                             mysql_query("COMMIT");
                             }
                             else 
                                 {        
                             mysql_query("ROLLBACK");
                                 }
                             
		}
               // Close connection
                mysqli_close($conexion);
	
              
          }
          /////////////////////////////eliminar archivos//////////////////////////////////////
          
      /*    
           function BorrarArchivo($campos)
        {
              $id_comite=$_SESSION['idseccion'];
              
              if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");
                 
                 
                 
$actualizar = mysql_query("delete from evento_archivo where id_archivo='".$campos[0]."'");  

               
               
                  if (!$actualizar) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
        
           
               
                         if ($actualizar )
                             {
                             mysql_query("COMMIT");
                             }
                             else 
                                 {        
                             mysql_query("ROLLBACK");
                                 }
                             
		}
               // Close connection
                mysqli_close($conexion);
	
              
          }
        */
     ///////////////////////////////////////////////////////////////////////////////////////  
        
          function Evento_Alta($campos)
        {
		$hoy = date("Y-m-d"); 
        
                

            
            if($this->con->conectar1()==true)
               {
               mysql_query("SET NAMES 'utf8'");
               mysql_query("SET AUTOCOMMIT=0");
               mysql_query("START TRANSACTION");
              
                         
                    $Insertar=  mysql_query("INSERT INTO evento_principal(
id_evento,
titulo,
fecha,
hora,
convocado,
director,
invitados,
id_comite)
 VALUES ( 
 '".$campos[0]."',
 '".$campos[1]."',
 '".$campos[2]."',
 '".$campos[3]."',
 '".$campos[4]."',
 '".$campos[5]."',
 '".$campos[6]."', 
 '".$campos[7]."')");  
                
                    
 if (!$Insertar) 
  {
                    
  die("error:". mysql_error());
   return false;
               
                
}
           
if ($Insertar)
 {
$i2=8;
            for ($i = 0; $i < $campos[8]; $i++)
        {
                  $i2 ++;
              
                $Insertar2=  mysql_query("INSERT INTO evento_tema(tema,id_evento,id_comite)
                                          VALUES ( '".$campos[$i2]."','".$campos[0]."','".$campos[7]."')"); 
                
                 if (!$Insertar2) 
                     {
                    
                     die("error:". mysql_error());
                     return false;
               
                
                    }
                    
                    /*************************buscar temas pendientes y cambiar estatus***************************************/
                   $objPendiente=new Ctr_minuta();
                    $consulta=$objPendiente->validar_tema_pendiente($campos[$i2]);
                   $total = mysql_num_rows($consulta);
                    if($total>0 )
                   {
                    
                   $actualizar = mysql_query("update evento_tema_pendiente set estatus=1  where id_comite='".$campos[7]."' and tema='".$campos[$i2]."' "); 
                    }
                   /********************************************************************/
        }
/******************************************************************************************************/

    
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
        
        
        
        
        function Actualizar_evento($campos)
        {

            if($this->con->conectar1()==true)
               {
               mysql_query("SET AUTOCOMMIT=0");
                mysql_query("START TRANSACTION");
                 mysql_query("SET NAMES 'utf8'");
                 
                 

$actualizar = mysql_query("update evento_principal SET estatus='Concluido' WHERE id_evento=".$campos[0]."  ");
$actualizar1 = mysql_query("update evento_tema_pendiente SET cerrado='1' WHERE id_evento=".$campos[0]."  ");
                
               
                  if (!$actualizar && $actualizar1) 
              {
                 die("Error:mysql: $actualizar  " . mysql_error());
              }
             
        
           
               
                         if ($actualizar && $actualizar1)
                             {
                             mysql_query("COMMIT");
                             }
                             else 
                                 {        
                             mysql_query("ROLLBACK");
                                 }
                             
		}
               // Close connection
                mysqli_close($conexion);
	}
        

}
?>