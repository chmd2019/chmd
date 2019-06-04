<?php
$idchofer=$_GET['idchofer'];
$correo=$_GET['correo'];


require('Control_choferes.php');
$objCliente=new Control_choferes;





         if( $objCliente->Cancelar_chofer($idchofer,$correo) == true)
        {
	echo "¡SE HA CANCELADO EL CHOFER";
         }
        else{echo "¡OCURRIÓ UN ERROR INTENTE DE NUEVO MÁS TARDE¡";}
        
        
        
        ?>

