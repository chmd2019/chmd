<?php


 
if(!empty($_POST))
{
 require('Ctr_minuta.php');
 $objCliente=new Ctr_minuta();
 

$id_archivo = $_POST["id_archivo"]; 
$id_evento = $_POST["id_evento"]; 
   $id_comite = $_POST["id_comite"]; 

///////////////////////////////////////////////////////////////////////
if ( $objCliente->BorrarArchivo(array($id_archivo)) == false)
 {
    //////////////////////////////////////
    $objArchivo=new Ctr_minuta();
  $consulta44=$objArchivo->mostrar_archivos($id_evento);
  
 while( $cliente44 = mysql_fetch_array($consulta44) )
 {
 $id_archivo=$cliente44[0];
  $archivo=$cliente44[1];
?>
        <td><a href="uploads/<?php echo "$id_comite";?>/<?php echo "$archivo"; ?>" download="<?php echo "$archivo"; ?>"><img src="../pics/activos/comites/adjunto.png" width="50" height="50" /><?php echo "$archivo"; ?></a></td>
        <td><form method="post" id="EliminarImagen">
              <input type="hidden" name="id_archivo" id="id_archivo" class="form-control" value="<?php echo "$id_archivo";?>"/>
               <input type="hidden" name="id_evento" id="id_evento" class="form-control" value="<?php echo "$id_evento";?>"/>
                <input type="hidden" name="id_comite" id="id_comite" class="form-control" value="<?php echo "$id_comite";?>"/>
             <input type="submit" name="insert" id="insert" value="Borrar" class="btn btn-success" />
            </form></td>
      


    <?php
}
    
///////////////////////////////////////////
  }
 else
 {
		echo 'Se produjo un error. Intente nuevamente ';
     
 }

}
?>
