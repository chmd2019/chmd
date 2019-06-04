
<?php
class DBManager
{
	var $conect;
  
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function DBManager()
        {
		$this->BaseDatos = "chmd_sistemas";
		$this->Servidor = "localhost";
		$this->Usuario = "sistemas";
		$this->Clave = "S4st3m4s2019.";
	}

	 function conectar1() 
        {

		if(!($con=@mysql_connect($this->Servidor,$this->Usuario,$this->Clave)))
                  {
			echo"<h1> [:(] Error al conectar a la base de datos</h1>";	
			exit();
		}
                
		if (!@mysql_select_db($this->BaseDatos,$con)){
			echo "<h1> [:(] Error al seleccionar la base de datos</h1>";  
			exit();
		}
		$this->conect=$con;
                mysql_close(DBManager);
		return true;	
	}

        
   
}
?>