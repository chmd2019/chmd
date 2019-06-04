<?php
include 'sesion_admin.php';
include 'conexion.php';
$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysql_select_db ( $db );
mysql_query ( "SET NAMES 'utf8'" );
require_once ('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$datos = mysql_query ( "select vpp.id,vpp.fecha2,vs.correo,vpp.calle_numero,vpp.colonia,
       vpp.cp,vpp.ruta,vpp.comentarios,vpp.estatus,vpp.nfamilia,
       usu.calle,usu.colonia as colonia1,
       alu1.nombre as alumno1,
       alu1.grado as grado1,
       alu1.grupo as grupo1,
       alu2.nombre as alumno2,
       alu2.grado as grado2,
       alu2.grupo as grupo2,
       alu3.nombre as alumno3,
       alu3.grado as grado3,
       alu3.grupo as grupo3,
       alu4.nombre as alumno4,
       alu4.grado as grado4,
       alu4.grupo as grupo4,
       alu5.nombre as alumno5,
       alu5.grado as grado5,
       alu5.grupo as grupo5,
       vpp.mensaje,usu.familia,
       vpp.lunes,
       vpp.martes,
       vpp.miercoles,
       vpp.jueves,
       vpp.viernes,usu.telefonomama
from 
Ventana_Permiso_permanente vpp
LEFT JOIN Ventana_user vs on vpp.idusuario=vs.id
LEFT JOIN usuarios usu on vpp.nfamilia=usu.`password`
LEFT JOIN alumnoschmd alu1 on vpp.alumno1=alu1.id
LEFT JOIN alumnoschmd alu2 on vpp.alumno2=alu2.id
LEFT JOIN alumnoschmd alu3 on vpp.alumno3=alu3.id
LEFT JOIN alumnoschmd alu4 on vpp.alumno4=alu4.id
LEFT JOIN alumnoschmd alu5 on vpp.alumno5=alu5.id
where   vpp.archivado=1 order by vpp.id desc" );
if (isset ( $_POST ['nombre_nivel'] )) {

        $nombre = $_POST ['nombre_nivel'];
	$funcion = $_POST ['funcion'];
        $mensaje= $_POST ['mensaje'];
         $status= $_POST ['status'];
	
         if ($nombre) {
		header ( 'Content-type: application/json; charset=utf-8' );
		
		//$existe = mysql_query ( "SELECT * FROM nivel WHERE nombre='$nombre'" );
		//$existe = mysql_fetch_array ( $existe );
		if ($status==3) {
			$query = "UPDATE Ventana_Permiso_permanente SET mensaje = '$mensaje',estatus=3 WHERE id=$funcion";
			mysql_query ( $query );
			$json = array (
					'estatus' => '0' 
			);
		} else if ($status==2)  {
			$query = "UPDATE Ventana_Permiso_permanente SET mensaje = '$mensaje',estatus=2 WHERE id=$funcion";
			mysql_query ( $query );
			$json = array (
					'estatus' => '0' 
			);
		} elseif ($existe) {
			$json = array (
					'estatus' => '-1' 
			);
		}
	} else {
		$json = array (
				'estatus' => '0' 
		);
	}
	echo json_encode ( $json );
	exit ();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="img/favicon.png">
<title>CHMD :: Permanente</title>
<link href="dist/css/bootstrap.css" rel="stylesheet">
<link href="css/menu.css" rel="stylesheet">


</head>

<body>
	<!-- Modal -->
	<div class="modal fade" id="agregarNivel" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width: 800px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="modalNivelTitulo">Agrega Solicitud</h4>
				</div>
				<form class="form-signin save-nivel" method='post'>
					<div class="alert-save"></div>
					<div class="modal-body">
                                            <table border="0" WIDTH="700">
                                                
                                                <tr>
                                                    <td WIDTH="10%" >Folio:
                                                        <input
							name="folio" id="folio" type="text" style="width : 100px; heigth : 4px"
                                                        class="form-control" placeholder="folio" readonly="">  
                                                        
                                                    </td>
                                                    
                                                    <td WIDTH="30%">Fecha de solicitud:
                                                   <input
							name="nombre_nivel" id="nombre_nivel" type="text" style="width : 200px; heigth : 4px"
                                                        class="form-control" placeholder="Fecha" readonly="" >  
                                                    </td>
                                                    
                                                    <td  WIDTH="60%">Solicitante:
                                                           <input
							name="nombre_nivel1" id="nombre_nivel1" type="text"
                                                        class="form-control" placeholder="Correo"  style="width : 400px; heigth : 4px" readonly=""> 
                                                    </td> 
                                                    
                                                </tr>
                                            </table>
                                            
                                        <table>
                                            
                                            <tr>
                                                    <td WIDTH="100%" colspan="3">
                                                        <h4>Solicitantes:</h4>
                                                    </td>
                                              </tr>
                                            
                                            </table>
                                            <table border="0" WIDTH="700">
                                                <tr>
                                                    <td>Alumno</td>
                                                    <td>Grado</td>
                                                    <td>Grupo</td>
                                                </tr>
                                                 <tr>
                                                 
                                                      <td>
                                                        
                                                        <input
							name="alumno1" id="alumno1" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                    </td>   
                                                     
                                                     <td>
                                                         <input
							name="grado1" id="grado1" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                     </td>
                                                      <td>
                                                          <input
							name="grupo1" id="grupo1" type="text"
                                                        class="form-control" placeholder="sin datos" readonly=""> 
                                                         
                                                     </td>
                                                </tr>
                                                <!------------------------------------------------------->
                                                 <tr>
                                                 
                                                      <td>
                                                        
                                                        <input
							name="alumno2" id="alumno2" type="text"
                                                        class="form-control" placeholder="sin datos" readonly="" > 
                                                    </td>   
                                                     
                                                     <td>
                                                         <input
							name="grado2" id="grado2" type="text"
                                                        class="form-control" placeholder="sin datos" readonly="" > 
                                                     </td>
                                                      <td>
                                                          <input
							name="grupo2" id="grupo2" type="text"
                                                        class="form-control" placeholder="sin datos" readonly=""> 
                                                         
                                                     </td>
                                                </tr>
                                                <!-------------------------------------------------------------------->
                                                 <tr>
                                                 
                                                      <td>
                                                        
                                                        <input
							name="alumno3" id="alumno3" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                    </td>   
                                                     
                                                     <td>
                                                         <input
							name="grado3" id="grado3" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                     </td>
                                                      <td>
                                                          <input
							name="grupo3" id="grupo3" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                         
                                                     </td>
                                                </tr>
                                                <!------------------------------------------------------------------>
                                                 <tr>
                                                 
                                                      <td>
                                                        
                                                        <input
							name="alumno4" id="alumno4" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                    </td>   
                                                     
                                                     <td>
                                                         <input
							name="grado4" id="grado4" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                     </td>
                                                      <td>
                                                          <input
							name="grupo4" id="grupo4" type="text"
							class="form-control" placeholder="sin datos" readonly> 
                                                         
                                                     </td>
                                                </tr>
                                                <!------------------------------------------------------------------------->
                                            </table>
                                            
                                            <table border="0" WIDTH="700">
                                                <tr>
                                                    <td WIDTH="100%" colspan="3">
                                                        <h4>Domicilio de Actual:</h4>
                                                    </td>
                                                </tr>
                                                
                                                </table>
                                            <table border="0" WIDTH="700">
                                                 <tr>
                                                    <td colspan="2">
                                                        Calle:
                                                         <input
							name="calle_numero1" id="calle_numero1" type="text"
							class="form-control" placeholder="Calle_numero1"  style="width : 500px; heigth : 4px" readonly>  
                                                    </td>
                                                    <td>
                                                        Colonia:
                                                         <input
							name="colonia1" id="colonia1" type="text"
							class="form-control" placeholder="Colonia1" readonly> 
                                                    </td>
                                                   
                                                </tr>
                                                
                                            </table>
                                            
                                            <table border="0" WIDTH="700">
                                                <tr>
                                                    <td WIDTH="100%" colspan="3">
                                                        <h4>Domicilio de cambio:</h4>
                                                    </td>
                                                </tr>
                                                  <tr>
                                                    <td colspan="2">
                                                        Calle:
                                                         <input
							name="calle_numero" id="calle_numero" type="text"
							class="form-control" placeholder="Calle_numero"  style="width : 500px; heigth : 4px" readonly>  
                                                    </td>
                                                    <td>
                                                        Telefono:
                                                        <input
							name="cp" id="cp" type="text"
							class="form-control" placeholder="Agrega cp" readonly> 
                                                    </td>
                                                   
                                                </tr>
                                                
                                            </table>
                                            
                                            <table border="0" WIDTH="700">
                                                <tr>
                                                    <td colspan="2">Colonia:
                                                     <input
							name="colonia" id="colonia" type="text"
							class="form-control" placeholder="Colonia" readonly> 
                                                    </td> 
                                                    
                                                   
                                                    
                                                    
                                                    <td>Ruta:
                                                        <input
							name="ruta" id="ruta" type="text"
							class="form-control" placeholder="Agrega Ruta" readonly> 
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                               
                                              
                                                <h4>Domicilio de cambio:</h4> 
                                                <table>
                                                    <tr>
                                                        <td> <input
							name="lunes" id="lunes" type="text"
							class="form-control" placeholder="lunes" readonly>  </td>
                                                        <td><input
							name="martes" id="martes" type="text"
							class="form-control" placeholder="martes" readonly>  </td>
                                                        <td><input
							name="miercoles" id="miercoles" type="text"
							class="form-control" placeholder="miercoles" readonly>  </td>
                                                        <td><input
							name="jueves" id="jueves" type="text"
							class="form-control" placeholder="jueves" readonly> </td>
                                                        <td><input
							name="viernes" id="viernes" type="text"
							class="form-control" placeholder="viernes" readonly> </td>
                                                       
                                                    
                                                     </tr>
                                                </table>
                                               
                                           
                                            </table>
                                            Comentarios de solicitud:
                                            <textarea class="form-control"  id="comentarios" name="comentarios"  readonly></textarea>
                                             Comentarios de respuesta.
                                            <textarea class="form-control"  id="mensaje" name="mensaje"  ></textarea>
						<input name="funcion" id="funcion" type="text"
                                                       class="form-control" value="0" required style="display: none;"><br>
                                             Accion:
                                                <select name="status" id="status">
                                                <option value="0">Selecciona</option>
                                               <option value="2"style="color:white;background-color:#0b1d3f;">Autotizado</option>
                                               <option value="3" style="color:red;background-color:yellow;">Rechazado</option>
                                               </select>
                                            
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<div class="container">

		<div class="masthead">

			<a href="cerrar_sesion.php" style="float: right; cursor: pointer;"
				role="button" class="btn btn-default btn-sm"> <span
				class="glyphicon glyphicon-user"></span> Cerrar Sesión
			</a> &nbsp <a href="menu.php">
				<button style="float: right; cursor: pointer;" type="button"
					class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-th"></span> Menu
				</button>
			</a>

			<h3 class="text-muted">Colegio Hebreo Maguén David</h3>

			<hr>
			<ul class="nav nav-justified">
				<li class="active"><a href="#">Historial de Permenente</a></li>
                                <li><a href="HPViaje.php">Historial Temporal</a></li>
                                <li><a href="HPDiario.php">Historial de Diario</a></li>
			</ul>
		</div>
		<br>
		<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
		<!-- Button trigger modal -->
		
                
                
                
                
                
		<h2>Historial de solicitudes Permanentes:</h2>
		<input type="text" class="form-control filter"
			placeholder="Buscar Solicitud..."><br> <br>
		<table class="table table-striped" id="niveles_table">
			<thead><td><b>Folio</b></td>
                        <td><b>Fecha<b></td>
                                
                                <td><b>Estatus</b></td>
                                 <td><b>Nfamilia</b></td>
				<td class="text-right"><b>Acciones</b></td>
			</thead>
			<tbody class="searchable" style="overflow: auto; max-height: 500px;">
			<?php while ( $dato = mysql_fetch_assoc ( $datos ) ) 
                                {
                             $id= $dato['id'];
                                $fecha= $dato['fecha2'];
                                $correo= $dato['correo'];
                                $estatus= $dato['estatus'];
                                $calle_numero=$dato['calle_numero'];
                                $colonia=$dato['colonia'];
                                $cp=$dato['telefonomama'];
                                $ruta=$dato['ruta'];
                                $comentarios=$dato['comentarios'];
                            
                            
                            
                            /*********************************/
                                
                                
                                if($estatus==1){$staus1="Pendiente";}
                                if($estatus==2){$staus1="Autorizado";}
                                if($estatus==3){$staus1="Cancelado";}
                                
                                /***************************************/
                                $nfamila= $dato['nfamilia'];
                                $calle_numero1=$dato['calle'];
                                $colonia1=$dato['colonia1'];
                                $alumno1=$dato['alumno1'];
$grado1=$dato['grado1'];
$grupo1=$dato['grupo1'];
$alumno2=$dato['alumno2'];
$grado2=$dato['grado2'];
$grupo2=$dato['grupo2'];
$alumno3=$dato['alumno3'];
$grado3=$dato['grado3'];
$grupo3=$dato['grupo3'];
$alumno4=$dato['alumno4'];
$grado4=$dato['grado4'];
$grupo4=$dato['grupo4'];
$alumno5=$dato['alumno5'];
$grado5=$dato['grado5'];
$grupo5=$dato['grupo5'];
$mensaje=$dato['mensaje'];
$familia=$dato['familia'];
$lunes=$dato['lunes'];
$martes=$dato['martes'];
$miercoles=$dato['miercoles'];
$jueves=$dato['jueves'];
$viernes=$dato['viernes'];
                                
                                /************************************/
                                
                               
                                
                            
                            ?>
				<tr data-row="<?php echo $dato['id']?>">
                                        <td><?php echo $id ?></td>
					<td><?php echo $fecha?></td>
                                        <td><?php echo $staus1?></td>
					<td><?php echo $familia?></td>
					<td class="text-right">
						<!--
						<button class="btn-autorizar btn btn-success" type="button"
							data-id="<?php echo $id?>"
							data-nombre="<?php echo $nfamila?>">
							<span class="glyphicon glyphicon-cloud">Autorizar</span>
						</button>-->
                                            
                                            <button data-target="#agregarNivel" data-toggle="modal"
							class="btn-editar btn btn-primary" type="button"
							data-id="<?php echo $id?>"
							data-nombre="<?php echo $fecha?>"
                                                        data-nombre1="<?php echo $correo?>"
                                                        data-calle_numero="<?php echo $calle_numero?>"
                                                        data-colonia="<?php echo $colonia?>"
							data-cp="<?php echo $cp?>"
                                                        data-ruta="<?php echo $ruta?>"
                                                        data-comentarios="<?php echo $comentarios?>"
                                                        data-calle_numero1="<?php echo $calle_numero1?>"
                                                        data-colonia1="<?php echo $colonia1?>"
                                                        data-alumno1="<?php echo $alumno1?>"
data-grado1="<?php echo $grado1?>"
data-grupo1="<?php echo $grupo1?>"
data-alumno2="<?php echo $alumno2?>"
data-grado2="<?php echo $grado2?>"
data-grupo2 ="<?php echo $grupo2?>"
data-alumno3="<?php echo $alumno3?>"
data-grado3="<?php echo $grado3?>"
data-grupo3="<?php echo $grupo3?>"
data-alumno4="<?php echo $alumno4?>"
data-grado4="<?php echo $grado4?>"
data-grupo4="<?php echo $grupo4?>"
data-alumno5="<?php echo $alumno5?>"
data-grado5="<?php echo $grado5?>"
data-grupo5="<?php echo $grupo5?>"
data-mensaje="<?php echo $mensaje?>"
data-lunes="<?php echo $lunes?>"
data-martes="<?php echo $martes?>"
data-miercoles="<?php echo $miercoles?>"
data-jueves="<?php echo $jueves?>"
data-viernes="<?php echo $viernes?>"

							<span class="glyphicon glyphicon-pencil">Ver</span>
				             </button>
                                            <!--
                                            <button class="btn-borrar btn btn-danger" type="button"
							data-id="<?php echo $id?>"
							data-nombre="<?php echo $nfamila ?>">
							<span class="glyphicon glyphicon-trash">Cancelar</span>
						</button>
                                            
                                            <!--
                                            <a href="grado.php?qwert=<?php echo $dato['id']?>&amp;nombre=<?php echo $dato['nombre']?>"
                                               style="cursor: pointer;"><img src="img/pdf.png" width="40" height="40"/>
                                            </a>-->
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<!-- Site footer -->
		<div class="footer">
			<p>&copy; Aplicaciones CHMD 2017</p>
		</div>

	</div>
	<!-- /container -->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/PPermanente.js"></script>
</body>
</html>
