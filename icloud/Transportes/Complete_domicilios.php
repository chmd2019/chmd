<?php
session_start();
	# conectare la base de datos
    $con=@mysqli_connect("localhost", "root", "RootChmd=2014", "rfc");
    //$valor78=1;
    $valor78=$_SESSION['nickname'];
    $tpermiso=$_SESSION['permiso'];
    
    
    if($tpermiso==1){$permiso='Vista_domicilio_diario';}
    if($tpermiso==2){$permiso='Vista_domicilio_permanente';}
    if($tpermiso==3){$permiso='Vista_domicilio_viaje';}
    
    
    
    
$return_arr = array();
/* Si la conexión a la base de datos , ejecuta instrucción SQL. */
if ($con)
{
	$fetch = mysqli_query($con,"SELECT * FROM $permiso where calle_numero like _utf8  '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%'  and nfamilia='$valor78' LIMIT 7 "); 
	
	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	while ($row = mysqli_fetch_array($fetch)) 
                {
		$id_producto=$row['id'];
		//$precio=number_format($row['precio_venta'],2,".","");
		$row_array['value'] = $row['calle_numero'];
		$row_array['id']=$row['id'];
		$row_array['calle_numero']=$row['calle_numero'];
		$row_array['colonia']=$row['colonia'];
                $row_array['cp']=$row['cp'];
		
		array_push($return_arr,$row_array);
                 }
}

/* Cierra la conexión. */
mysqli_close($con);

/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);


?>