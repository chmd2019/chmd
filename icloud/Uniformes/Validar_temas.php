
<?php
include_once("../Model/DBManager.php");
 require('Ctr_minuta.php');

if (isset ( $_GET ['ValidaTutulo'] )) 
{
 $tema=$_GET ["titulo"];
 $objTema=new Ctr_minuta();
$consulta1=$objTema->Buscar_titulo($tema);
$contador=0;
$total = mysql_num_rows($consulta1);

  if($total>0) 
      {
      
     $datos = array ("id" => - 1 );
       
       echo json_encode ( $datos );
	
  }
  else
      {
  
     $datos = array (
				'id' => $id 
		);
     echo json_encode ( $datos );
	
  }
}
/////////////////////////valida tema//////////////////////////////

if (isset ( $_GET ['ValidaTema'] )) 
{
    
$temavalida=$_GET ["temavalida"];



$objTema=new Ctr_minuta();
$consulta1=$objTema->Buscar_tema($temavalida);
$contador=0;
$total = mysql_num_rows($consulta1);

  if($total>0) 
      {
      
     $datos = array ("id" => - 1 );
       
       echo json_encode ( $datos );
	
  }
  else
      {
  
     $datos = array (
				'id' => $id 
		);
     echo json_encode ( $datos );
	
  }
}





////////////////////////////////////////////////

if (isset ( $_GET ['temanpendientes'] )) 
{
 $id_tema1=$_GET ["id_tema1"];
 $acuerdos=$_GET ["acuerdos1"];
 $status1=$_GET ["status1"];
  $tema1=$_GET ["tema1"];
  $idusuario=$_GET ["idusuario"];
 
 if($status1=="1")
{
      $objTema_pendiente=new Ctr_minuta();
	if ( $objTema_pendiente->Tema_Pendiente(array($id_tema1,
                                          $acuerdos,
                                          $status1,$tema1,$idusuario)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
     
     
     
     
 }
 else if($status1=="2")
  {
//////////////////////////revisar si este en estatus pendiente///////////////////////////////////////
 $objbuscar=new Ctr_minuta();
$consulta2=$objbuscar->Buscar_tema_estatus2($id_tema1,$idusuario);
$total2 = mysql_num_rows($consulta2);
if($total2>0) 
 {
    $objTemaborrar=new Ctr_minuta();
	if ( $objTemaborrar->Tema_Borrar(array($id_tema1,$idusuario)) == false)
                {
            
            
          
            
                   $objTema_concluido=new Ctr_minuta();
	if ( $objTema_concluido->Tema_concluido(array($id_tema1,
                                          $acuerdos,
                                          $status1)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
           
            
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
    
}
else
{
   
     ///////////////////////////cambiar a estatus concluido////////////////////////////////////////////
         $objTema_concluido=new Ctr_minuta();
	if ( $objTema_concluido->Tema_concluido(array($id_tema1,
                                          $acuerdos,
                                          $status1)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
    
}

 
 
 
 ////////////////////////////////////////////////////////////////////    
  }
     
 

}


///////////////////////////guardar en automatico acuerdos/////////////////////////////////
 
if (isset ( $_GET ['acuerdos'] )) 
{
 $idusuario=$_GET ["idusuario"];
 $acuerdos=$_GET ["acuerdos"];
 $id_tema=$_GET ["id_tema"];
 
 $objTema_acuerdo=new Ctr_minuta();
if ( $objTema_acuerdo->Acuerdos(array($idusuario,$acuerdos,$id_tema)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
}

/*


if (isset ( $_GET ['Insertpendientes'] )) 
{
 $id_tema=$_GET ["id_tema"];
 $tema=$_GET ["tema"];
 $id_evento=$_GET ["id_evento"];
 $id_comite=$_GET ["id_comite"];
 
 $objInsert_pendientes=new Ctr_minuta();
if ( $objInsert_pendientes->InserPendientesTemas(array($id_tema,$tema,$id_evento,$id_comite)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
}


*/



/////////////////////////////////////////////agregar asistentes de evento//////////////////////////////////////////////////////////////


if (isset ( $_GET ['AsistenciaUsuario'] )) 
{

 $id_evento=$_GET ["id_evento"];
 $id_comite=$_GET ["comite"];
    
    
    $objInt=new Ctr_minuta();
$consulta4=$objInt->mostrar_integrantes();
  $salida = "";
 while( $cliente4 = mysql_fetch_array($consulta4) )
 {
     $id_usuario=$cliente4[0];
     $nombre=$cliente4[1];
     
     
     
     
      $objInsert_asistentes=new Ctr_minuta();
if ( $objInsert_asistentes->InsertAsistentes(array($id_evento,$id_usuario)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
 
      
 }
    
    
    

 

}

//////////////////////cambiar estatus de asistencia///////////////////////////////////////////////////////////////




if (isset ( $_GET ['CambioAsistencia'] )) 
{
      
    
 $idusuario=$_GET ["idusuario"];
 $id_evento=$_GET ["id_evento"];
 $status1=$_GET ["status1"];
 
 $objTema_Asist=new Ctr_minuta();
if ( $objTema_Asist->AsistenciaComite(array($idusuario,$id_evento,$status1)) == false)
                {
            
             $datos = array ('id' => $id );
              echo json_encode ( $datos );
	         }
                 
                 else
                {
		 $datos = array ("id" => - 1 );
       
                 echo json_encode ( $datos );
	
	        }
}

?>