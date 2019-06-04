
        <?php 

include_once("../Model/DBManager.php");



class Ctr_uniformes
{
 	var $con;
 	function Ctr_uniformes()
        {
 		$this->con=new DBManager;
 	}

	     function mostrar_Alumnos_familia($familia)
        {
		if($this->con->conectar1()==true)
                {
                   
                     $thijos = mysql_query("SELECT COUNT(*) FROM uniformes_alumnos where idfamilia='".$familia."'  ");
					 if($row=mysql_fetch_array($thijos))
					 {
					 $hijos=$row[0]; 
					 }
					 
					  $npedidos = mysql_query("SELECT count(*) FROM pedido_uniforme  where nfamilia= '".$familia."' and status=1");
					   if($row1=mysql_fetch_array($npedidos))
					 {
					 $pedidos=$row1[0]; 
					 }
					   if($hijos == $pedidos)
                      {
					       $update = mysql_query("update pedido_uniforme set `status`=2 where nfamilia='".$familia."'  ");
                          return mysql_query("SELECT * FROM uniformes_alumnos where idfamilia='".$familia."'  "); 
                          
                      }
                    else
                    {
                       return mysql_query("SELECT * FROM uniformes_alumnos where idfamilia='".$familia."'  ");
                    }
					 mysqli_close($conexion);
					 ////////////////////////
					 
                      
                    
                  
		}
	} 
        ///////////////busqueda de alumnos pedido adicional///////////////////////
        function mostrar_alumnos_adicional($familia)
        {
		if($this->con->conectar1()==true)
                {
                     mysql_query("SET NAMES 'utf8'");
                     $thijos = mysql_query("SELECT COUNT(*) FROM uniformes_alumnos_adicional where idfamilia=".$familia."  ");
					 if($row=mysql_fetch_array($thijos))
					 {
					 $hijos=$row[0]; 
					 }
					 
					  $npedidos = mysql_query("SELECT count(*) FROM pedido_uniforme_adicional  where nfamilia= ".$familia." and status=3");
					   if($row1=mysql_fetch_array($npedidos))
					 {
					 $pedidos=$row1[0]; 
                                         
                                         if($pedidos>0){$valor=10;}else{$valor=0;}
					 }
					   if($hijos < $valor)
                      {
					      // $update = mysql_query("update pedido_uniforme set `status`=2 where nfamilia=".$_SESSION['n_familia']."  ");
                          return mysql_query("SELECT * FROM uniformes_alumnos_adicional where idfamilia=".$familia." ORDER BY `status` desc  limit 1 "); 
                          
                      }
                    else
                    {
                       return mysql_query("SELECT * FROM uniformes_alumnos_adicional where idfamilia=".$familia." ");
                    }
					
					 ////////////////////////
					 
                      
                    
                  
		}
	} 
       
      ///////////////////////////////////
        function mostrar_cliente($id){
		if($this->con->conectar1()==true){
			return mysql_query("SELECT * FROM uniformes_alumnos WHERE id=".$id);
		}
	}  
        
       /////////////////pedidos adicionales////////////////////////////////////////////////////// 

	   function VerPedido_Adicional($id){
		if($this->con->conectar1()==true){
			return mysql_query("SELECT * FROM uniformes_alumnos_adicional WHERE id=".$id);
		}
	}  
        
        /////////////////////////consulta de alumnos por familia///////////////////////////////////////////
        
       
 function actualizar($campos,$correo){
		if($this->con->conectar1()==true)
                    {

			return mysql_query("INSERT INTO pedido_uniforme(talla_sudadera,"
                                                                      . "talla_pants,"
                                                                      . "talla_playera,"
                                                                      . "talla_educacionf,"
                                                                      . "talla_kinder,"
                                                                      . "idalumno,"
                                                                      . "status,"
                                                                      . "nfamilia,"
                                                                      . "fecha,"
                                                                      . "tiposuda,"
                                                                      . "tipoplayera,"
                                                                      . "tipopants,"
                                                                      . "tipoedu,"
                                                                       . "correo) VALUES ('".$campos[0]."', '".$campos[1]."','".$campos[2]."','".$campos[3]."','".$campos[4]."','".$campos[5]."','".$campos[6]."','".$campos[7]."',now(),'".$campos[8]."','".$campos[9]."','".$campos[10]."','".$campos[11]."','".$correo."')");
		}
	}
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
      function actualizar_pedido($campos,$correo)
              {
		if($this->con->conectar1()==true)
                    {

               
                $Insertar=  mysql_query("update  pedido_uniforme set "
                        . "talla_sudadera='".$campos[0]."',"
                        . "talla_pants='".$campos[1]."',"
                        . "talla_playera='".$campos[2]."',"
                        . "talla_educacionf='".$campos[3]."',"
                        . "talla_kinder='".$campos[4]."',"
                        . "tiposuda='".$campos[8]."',"
                        . "modificar='1', "
                        . "tipoplayera='".$campos[9]."',"
                        . "tipopants='".$campos[10]."',"
                        . "tipoedu='".$campos[11]."',"
                        . "correo='".$correo."' "
                        . " where idalumno='".$campos[5]."'");  
 if (!$Insertar) {die("error:". mysql_error());  return false;}
if ($Insertar){mysql_query("COMMIT");}
 else 
 { mysql_query("ROLLBACK");}
               
                    }
	       
	}
        /////////////////////////////////terminar pedido adicional///////////////////////////////////////////
         function Terminar_pedido_adicional($campos)
        {
		if($this->con->conectar1()==true)
                {
			
			return mysql_query("UPDATE pedido_uniforme_adicional SET status = '3' WHERE nfamilia = '".$campos[0]."'");
		}
	}
        ////////////////////////////////////////Pedido adicional//////////////////////////////////////////////
        function Pedido_Adicional($campos,$correo)
                {
		if($this->con->conectar1()==true)
                         {
			//print_r($campos);
			return mysql_query("INSERT INTO pedido_uniforme_adicional(talla_sudadera,talla_pants,talla_playera,talla_educacionf,talla_kinder,idalumno,status,nfamilia,fecha,tiposuda,tipoplayera,tipopants,tipoedu,cantidad_kinder,cantidad_sudadera,cantidad_pants,cantidad_playera,cantidad_educacionf,correo) VALUES ('".$campos[0]."', '".$campos[1]."','".$campos[2]."','".$campos[3]."','".$campos[4]."','".$campos[5]."','".$campos[6]."','".$campos[7]."',now(),'".$campos[8]."','".$campos[9]."','".$campos[10]."','".$campos[11]."','".$campos[12]."','".$campos[13]."','".$campos[14]."','".$campos[15]."','".$campos[16]."','".$correo."')");
			//return mysql_query("INSERT INTO cliente (nombres, ciudad, sexo, telefono, fecha_nacimiento) VALUES ('".$campos[0]."', '".$campos[1]."','".$campos[2]."','".$campos[3]."','".$campos[4]."')");
			//return mysql_query("UPDATE cliente SET nombres = '".$campos[0]."', ciudad = '".$campos[1]."', sexo = '".$campos[2]."', telefono = '".$campos[3]."', fecha_nacimiento = '".$campos[4]."' WHERE id = ".$id);
		         }
	        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
         function Correo()
        {
		if($this->con->conectar1()==true){
                   // return mysql_query("select id,nfamilia,correo from pedido_uniforme where `status`=2 and tipo_pedido=2 and notificacion=0 GROUP BY nfamilia limit 1");
                    return mysql_query("select id,nfamilia,correo from pedido_uniforme where  tipo_pedido=2 and notificacion=0 GROUP BY nfamilia limit 1");
		}
        }
        
        
            function Correo_pedido_casico($nfamilia)
        {
		if($this->con->conectar1()==true){
                    return mysql_query("SELECT * FROM uniformes_alumnos where idfamilia="."' $nfamilia' and grupo='nuevo_ingreso' ");
		}
        }  
   /////////////////////////proceso de correo adicional//////
          function Correo_adicional()
        {
		if($this->con->conectar1()==true){
                    return mysql_query("select id,nfamilia,correo,notificacion from pedido_uniforme_adicional where notificacion=0 GROUP BY nfamilia limit 1");
                    //return mysql_query("select id,nfamilia,correo,notificacion from pedido_uniforme_adicional ");

		}
        }
        
             function Correo_pedido_adicional($nfamilia)
        {
		if($this->con->conectar1()==true){
                    return mysql_query("SELECT * FROM uniformes_alumnos_adicional where idfamilia="."' $nfamilia'");
		}
        }  
          
     
        
        
        
        
        /////////////////////////////
 function Actualizar_basico($campos)
 {
		
            if($this->con->conectar1()==true)
               {
            // $actualizar = mysql_query("update evento_tema_pendiente set estatus=1  where id_comite='".$campos[7]."' and tema='".$campos[$i2]."' "); 
              
 $Insertar=  mysql_query("update  pedido_uniforme set notificacion='1' where nfamilia='".$campos[0]."'");  
 if (!$Insertar) {die("error:". mysql_error());  return false;}
if ($Insertar){mysql_query("COMMIT");}
 else 
 { mysql_query("ROLLBACK");}
		}
  }
  
  
  
  
  ////////////////////////////////
   function Actualizar_Adicional($campos)
 {
		
            if($this->con->conectar1()==true)
               {
            // $actualizar = mysql_query("update evento_tema_pendiente set estatus=1  where id_comite='".$campos[7]."' and tema='".$campos[$i2]."' "); 
              
 $Insertar=  mysql_query("update  pedido_uniforme_adicional set notificacion='1' where nfamilia='".$campos[0]."'");  
 if (!$Insertar) {die("error:". mysql_error());  return false;}
if ($Insertar){mysql_query("COMMIT");}
 else 
 { mysql_query("ROLLBACK");}
		}
  }
  //////////////////////////
      
}
?>