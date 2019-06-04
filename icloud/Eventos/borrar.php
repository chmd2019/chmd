 <?php 
 
 $resultado = $_POST['archivo']; 
 $comite = $_POST['comite']; 
 

 
    $link = mysqli_connect("localhost", "root", "RootChmd=2014", "rfc");
if($link === false)
    {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
                         
                   $sql ="delete from evento_archivo where nombre='".$resultado."'";  
                
if(mysqli_query($link, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);

$borrar='uploads/';

$final="$comite/";
$otro=$borrar.$final.$resultado;
echo $otro; //haciendo este echo estas respondiendo la solicitud ajax
//unlink("'$final'"); 

unlink($otro);  
?>