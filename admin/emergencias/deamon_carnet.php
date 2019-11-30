<?php
include '../sesion_admin.php';
include '../conexion.php';
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
//seleccionar los usuarios a modificar
$sql = "SELECT id,numero FROM usuarios WHERE tipo = 7";
$query = mysqli_query($conexion, $sql);
while ($row = mysqli_fetch_assoc($query)){
  //seleccionar el id
  $id_usuario = $row['id'];
  $id_familia = $row['numero'];
  //busqueda de tarjetones
  $sql_tarjetones = "SELECT idtarjeton FROM tarjeton_automoviles WHERE idfamilia = $id_familia LIMIT 2";
  $query_tarjetones = mysqli_query($conexion, $sql_tarjetones);
  $row_cnt = mysqli_num_rows($query_tarjetones);
  $n=0;
  $Ntarjeton1='';
  $Ntarjeton2='';
  if ($row_cnt>0){
    echo 'Usuario: '.$id_usuario.'<br>';
    echo 'Numero de tarjetones de la Familia: '.$row_cnt.'<br>';
    while($tarjeton = mysqli_fetch_assoc($query_tarjetones)){
      if ($n==1){
        $Ntarjeton2 = $tarjeton['idtarjeton'];
        $n++;
      }
      if ($n==0){
        $Ntarjeton1 = $tarjeton['idtarjeton'];
        $n++;
      }
    }
    //actualizar columnos tarjeton1 y tarjeton 2  en usuarios
    if (!$Ntarjeton1==''){
      $sql_update = "UPDATE usuarios SET ntarjeton1='$Ntarjeton1' WHERE id='$id_usuario' ";
    }
    if (!$Ntarjeton2=='') {
      $sql_update = "UPDATE usuarios SET ntarjeton1='$Ntarjeton1', ntarjeton2='$Ntarjeton2' WHERE id='$id_usuario' ";
    }
    //hacer el $query
    $insertar = mysqli_query($conexion, $sql_update);
    if ($insertar){
      mysqli_query($conexion, 'COMMIT');
      echo 'Insertado Tarjetones en Usuario: '.$id_usuario.'<br>';
    }
  }
}
?>
