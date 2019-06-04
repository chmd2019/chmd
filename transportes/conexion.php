<?php
$host = "localhost";
$usuario = "sistemas";
$password = "S4st3m4s2019.";
$db = "chmd_sistemas";
// $password = "";
// $db = "escuela";




class DBManager{
  var $conect;
     function DBManager(){
	 }
	 
	 function conectar() {
	     if(!($con=@mysqli_connect("localhost","sistemas","S4st3m4s2019.")))
		 {
		     echo"Error al conectar a la base de datos";	
			 exit();
	      }
		  if (!@mysqli_select_db("chmd_sistemas",$con)) {
		   echo "error al seleccionar la base de datos";  
		   exit();
		  }
               mysqli_query("SET NAMES 'utf8'");
	       $this->conect=$con;
		   return true;	
	 }
}

?>

