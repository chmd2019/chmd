<?php
include '../../sesion_admin.php';
include '../../conexion.php';

if (!in_array('2', $capacidades)){
    header('Location: ../../menu.php');
}
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';

$niveles = mysqli_query ( $conexion,"SELECT id,nivel from Catalogo_nivel");
$grados = mysqli_query($conexion,"SELECT distinct idcursar,grado from alumnoschmd order by idcursar desc");
$grupos = mysqli_query ( $conexion,"SELECT id,grupo from catalago_grupos_cch");
$gruposEsp = mysqli_query ( $conexion,"SELECT id,grupo from App_grupos_especiales");
$gruposAdmin = mysqli_query ( $conexion,"SELECT id,grupo from App_grupos_administrativos");
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
    <title>CHMD (Administrador de circulares) :: Circulares</title>
    <link href="../../dist/css/bootstrap.css" rel="stylesheet">
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
  </head>
  <body>


  <div class="reload"></div>
    <div class="container" id='principal'>
      <div class="masthead">
        <a href="../../cerrar_sesion.php" style="float: right; cursor: pointer;"
          role="button" class="btn btnfamilia-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a> &nbsp
        <a href="../../menu.php">
          <button style="float: right; cursor: pointer;" type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-th"></span> Menu
          </button>
        </a>
        <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
        <hr>
       
      </div>

<center>
      <h2>Mantenimiento de circulares (Nuevo)</h2>
      
      <form method="post" action="common/crearCircular.php">
	
				<p>
					<input name="titulo" placeholder="titulo de la circular" class="form-control" required>
				</p>
				
				<p>
					Nivel
					<select name="cboNivel" class="form-control">
                        <?
                        while ($row = mysqli_fetch_array($niveles, MYSQLI_ASSOC)){
                            echo "<option value=\"".$row['id']."\"";
                            echo ">".$row['nivel']."</option>\n";
                        }
                        ?>
					</select>
				</p>
				<p>
					Grado
					<select name="cboGrado" class="form-control">
                    <?
                        while ($row = mysqli_fetch_array($grados, MYSQLI_ASSOC)){
                            echo "<option value=\"".$row['idcursar']."\"";
                            echo ">".$row['grado']."</option>\n";
                        }
                        ?>
					</select>
				</p>
				<p>
					Grupo
					<select name="cboGrupo" class="form-control">
					<?
                        while ($row = mysqli_fetch_array($grupos, MYSQLI_ASSOC)){
                            echo "<option value=\"".$row['id']."\"";
                            echo ">".$row['grupo']."</option>\n";
                        }
                        ?>
					</select>
				</p>
				<p>
				<input type="checkbox" name="chkAdjunto" value="0" class="form-control" >
					<label for="chkAdjunto">Adjunto</label>
				</p>

				<p>
					Grupo Especial
					<select name="cboGrupoEsp" class="form-control">
                    <?
                        while ($row = mysqli_fetch_array($gruposEsp, MYSQLI_ASSOC)){
                            echo "<option value=\"".$row['id']."\"";
                            echo ">".$row['grupo']."</option>\n";
                        }
                        ?>
					</select>
				</p>	

				<p>
					Grupo Administrativo
					<select name="cboGrupoEsp" class="form-control">
                    <?
                        while ($row = mysqli_fetch_array($gruposAdmin, MYSQLI_ASSOC)){
                            echo "<option value=\"".$row['id']."\"";
                            echo ">".$row['grupo']."</option>\n";
                        }
                        ?>
					</select>
				</p>	


				<p>


				Adjunto
					<select name="cboAdjunto" class="form-control">
					<option value='1' selected>Sí</option>
					<option value='0'>No</option>"
					</select>
				</p>

				<p>
					Contenido de la circular
				<textarea name="contenido">
				
				</textarea>
        		<script>
            		CKEDITOR.replace( 'contenido' );
				</script>
				</p>
				<p>
					<input name="ciclo_escolar_id" placeholder="Ciclo Escolar" class="form-control" required>
				</p>
				<p>
					Enviar a todos
				<select name="cboEnviar" class="form-control">
					<option value="1">Sí</option>
					<option value="0">No</option>
				</select>
				</p>
				<p>
					<input type="submit" class="btn btn-success btn-block" value="Guardar Circular">
				</p>	



		</form>	


</center>



    <div class="footer">
  <p>&copy; Aplicaciones CHMD 2019</p>
</div>
</div>
<!-- /container -->
<!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
    function descargarpdf(id){
      setTimeout(() => {
         window.location='./common/pdf_chofer.php?idchofer='+id;
       }, 1000);
    }
  </script>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../dist/js/bootstrap.js"></script>
   <script type="text/javascript" src="../../js/1min_inactivo.js" ></script>
</body>

    </div>
    


  </body>
  </html>