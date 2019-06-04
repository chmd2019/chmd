  <script type="text/javascript">
$(document).ready(function()
{
  
    
	// mostrar formulario de actualizar datos
	
        ///
        $("#modi a").click(function(){
		$('#tabla').hide();
		$("#formulario").show();
		$.ajax({
                    url: this.href,
			type: "GET",
			
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
	
	// llamar a formulario nuevo
	$("#nuevo a").click(function(){
		$("#formulario").show();
		$("#tabla").hide();
		$.ajax({
			type: "GET",
			url: 'Alta_evento.php',
			success: function(datos){
				$("#formulario").html(datos);
			}
		});
		return false;
	});
});

</script>  

<?php


session_start(); //session start
include_once("../Model/DBManager.php");
 require('Ctr_minuta.php');
       $objCliente=new Ctr_minuta();
       $consulta=$objCliente->minuta();
       
       
         if (isset($_POST['consulta'])) 
   {
        $q =$_POST['consulta'];
         $consulta=$objCliente->minutas($q);
   }
 
   else 
{
      $consulta=$objCliente->minuta();  
}
////////////////////////////////////////////
//	$servername = "localhost";
//         $username = "root";
//  	$password = "RootChmd=2014";
 // 	$dbname = "prueba";

//	$conn = new mysqli($servername, $username, $password, $dbname);
//      if($conn->connect_error){
//        die("Conexión fallida: ".$conn->connect_error);
//      }
    
       
       
       
       
       
          $salida = "";
          	$salida.="<table border=1 class='tabla_datos'>
    			<thead>
    				<tr id='titulo'>
    					
    					<td>Titulo</td>
    					<td>Estatus</td>
    					<td>Fecha de Evento</td>
    					<td>Detalles</td>
    				</tr>

    			</thead>
    			

    	<tbody>";
        $perfil=$_SESSION['perfil'];
     	if($consulta) //if user already exist change greeting text to "Welcome Back"
    {
            
                 while( $cliente = mysql_fetch_array($consulta) )
              
                   {
                     $id=$cliente[0];
                     $titulo=$cliente[1];
                     $fecha=$cliente[2];
                     $hora=$cliente[3];
                     $fevento=$fecha." ".$hora;
                     $estatus=$cliente[7];
                     if($estatus=="Concluido")
                       {
                           $salida.="<tr>
    					
    					<td>".$titulo."</td>
    					
    					<td><font color='#468C00'><b>".$estatus."</b></font></td>
                                        <td>".$fevento."</td>
    					 <td><a href='pdf/listas.php?id=$id' target='_blank' title='Nuevo'> <img src='../images/dowload.png' width='25px' height='25px' alt='Nueva'></a></td>
    				        </tr>";
                         
                       }
                       else
                       {
                           
                           
                           
                           ////////////////////////////////////validacion de perfil///////////////////////////////////////////////////
             if($perfil=="3" )
            {
                 $salida.="<tr>
    					
    					<td>".$titulo."</td>
    					
    					<td><font color='#FF9999'><b>".$estatus."</b></font></td>
                                        <td>".$fevento."</td>
    					 <td><a href='pdf/listas.php?id=$id' target='_blank' title='Nuevo'> <img src='../images/dowload.png' width='25px' height='25px' alt='Nueva'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='modi' id='modi'></span> <span class='modi' id='modi'><a href='Detalle_evento.php?id=$id' title='Nuevo'><font color='#6ec2ed'><b>VER</b></font></a></td>
    				        </tr>";
          
            }
            elseif ($perfil=="2") 
                {
                $salida.="<tr>
    					
    					<td>".$titulo."</td>
    					
    					<td><font color='#FF9999'><b>".$estatus."</b></font></td>
                                        <td>".$fevento."</td>
    					 <td><a href='pdf/listas.php?id=$id' target='_blank' title='Nuevo'> <img src='../images/dowload.png' width='25px' height='25px' alt='Nueva'></a></td>
    				        </tr>";
            
                }
                 else
                {
                     $salida.="<tr>
    					
    					<td>".$titulo."</td>
    					
    					<td><font color='#FF9999'><b>".$estatus."</b></font></td>
                                        <td>".$fevento."</td>
    					 <td><a href='pdf/listas.php?id=$id' target='_blank' title='Nuevo'> <img src='../images/dowload.png' width='25px' height='25px' alt='Nueva'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='modi' id='modi'></span> <span class='modi' id='modi'><a href='Detalle_evento.php?id=$id' title='Nuevo'><font color='#6ec2ed'><b>VER</b></font></a></td>
    				        </tr>";
             
                }
                           
                           
                           /////////////////////////////////////////////////////////////////////////////////////
                             
                           
                       }
                     
                     
                     
                 
                  }
            
   
                  $salida.="</tbody></table>";
            
            
    }
    else //error en cosulta
	{ 
            
            echo 'Error en cosulta';
          
                //echo 'Hi '.$user->email.',<br> Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		//$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
		//$statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
		//$statement->execute();
		///echo $mysqli->error;
          
         }
	
          

 

   // $query = "SELECT * FROM jugadores WHERE Name NOT LIKE '' ORDER By Id_no LIMIT 25";
/*
    if (isset($_POST['consulta'])) 
   {
        $q =$_POST['consulta'];
        echo "prueba de valor:$q";
   	//$q = $conn->real_escape_string($_POST['consulta']);
   	//$query = "SELECT * FROM jugadores WHERE Id_no LIKE '%$q%' OR Name LIKE '%$q%' OR ClubName LIKE '%$q%' OR Rtg_Nat LIKE '%$q%' OR Title LIKE '$q' ";
   }
  
   $resultado = $conn->query($query);

    if ($resultado->num_rows>0) {
    	$salida.="<table border=1 class='tabla_datos'>
    			<thead>
    				<tr id='titulo'>
    					<td>ID</td>
    					<td>JUGADOR</td>
    					<td>CLUB NAME</td>
    					<td>RATING NACIONAL</td>
    					<td>TITULO</td>
    				</tr>

    			</thead>
    			

    	<tbody>";

    	while ($fila = $resultado->fetch_assoc()) {
    		                        $salida.="<tr>
    					<td>".$fila['Id_no']."</td>
    					<td>".$fila['Name']."</td>
    					<td>".$fila['ClubName']."</td>
    					<td>".$fila['Rtg_Nat']."</td>
    					<td>".$fila['Title']."</td>
    				        </tr>";

    	}
    	$salida.="</tbody></table>";
    }
    else{
    	$salida.="NO HAY DATOS :(";
    }

*/
    echo $salida;

   // $conn->close();



?>