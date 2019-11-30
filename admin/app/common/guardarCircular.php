<?php
include '../../sesion_admin.php';
include '../../conexion.php';
$titulo = $_POST["titulo"];
$nivel = $_POST["cboNivel"];
$grado = $_POST["cboGrado"];
$grupo = $_POST["cboGrupo"];
$grupoEsp = $_POST["cboGrupoEsp"];
$grupoAdmin = $_POST["grupoAdmin"];
$adjunto = $_POST["cboAdjunto"];
$contenido = $_POST["contenido"];
$cicloEscolar = $_POST["cicloEscolar"];
$enviar = $_POST["cboEnviar"];
$descripcion = $_POST["descripcion"]; 
$estatus = $_POST["cboEstatus"];
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

if($connection){

//Guardar en la tabla de circulares
//Comando de insercion
$sql = "INSERT INTO App_circulares(titulo,contenido,fecha,descripcion,estatus,adjunto,ciclo_escolar_id,created_at,envio_todos) VALUES('$titulo','$contenido',CURDATE(),'$descripcion','$estatus','$adjunto','$cicloEscolar',CURDATE(),'$enviar')";
mysqli_set_charset($connection, "utf8");
$insertar = mysqli_query($connection, $sql);
if (!$insertar) {
  die("error:" . mysqli_error($connection));
  echo "No se insertó ". mysqli_error($connection);
  $isgood=false;
}else{
    //$last_id = $connection->insert_id;
    header("Location: ../PCirculares.php");  
}

}