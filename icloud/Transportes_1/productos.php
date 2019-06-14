<?php
if (isset($_GET['term'])){
	# conectare la base de datos
    $con=@mysqli_connect("localhost", "root", "RootChmd=2014", "demo");
	
$return_arr = array();
/* Si la conexión a la base de datos , ejecuta instrucción SQL. */
if ($con)
{
	$fetch = mysqli_query($con,"SELECT * FROM domicilios_diario where calle_numero like _utf8  '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%'  LIMIT 20"); 
	
	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	while ($row = mysqli_fetch_array($fetch)) {
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

}
?>