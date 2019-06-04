<?php

$v1 = $_POST['variable1'];
$carpeta = $_POST['id_comite'];

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip','pdf','docx','xlsx','doc','xls','pptx','ppt','jpeg');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0)
    {
    $archivo=$_FILES['upl']['name'];

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed))
        {
            
         
	     
            echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], "uploads/$carpeta/".$_FILES['upl']['name']))
        {
            /***********************proceso de alta de archivo base de datos*****************************************/
       
  $link = mysqli_connect("localhost", "root", "RootChmd=2014", "rfc");
if($link === false)
    {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
                         
                   $sql ="INSERT INTO evento_archivo(
nombre,
id_evento,id_comite)
 VALUES ( 
 '".$archivo."', 
 '".$v1."','".$carpeta."')";  
                
if(mysqli_query($link, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
                    

                /******************************************************/
            
		echo '{"status":"success"}';
             
		exit;
                
	}
}

echo '{"status":"error"}';
exit;