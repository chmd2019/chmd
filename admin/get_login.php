<?php
include 'include/user_session.php';
include 'conexion.php';

$session = new UserSession();

if (isset ( $_POST ['entrar'] ))
{
  $usuario_get = $_POST ["usuario"];
  $contrasena_get = md5($_POST ["contrasena"]);
  //quitar espacios del correo
  $usuario_get = trim($usuario_get);
  $usuario_get = strtolower($usuario_get);

 /*
  $resultado = mysqli_query( $conexion ,"SELECT adm.id,usu.id as id_usuario, usu.correo, MD5(CONCAT(adm.usuario,usu.id)) as contrasena from Administrador_usuarios adm INNER JOIN  usuarios usu on adm.id_usuario=usu.id") ; 
*/
$resultado = mysqli_query( $conexion ,"SELECT adm.id , usu.id as id_usuario, usu.correo, MD5(CONCAT(adm.usuario,usu.id)) as contrasena FROM usuarios usu INNER JOIN Administrador_usuarios adm ON adm.id=usu.perfil_admin WHERE usu.perfil_admin>0;") ; 


  $login=0;
  while ($extraido = mysqli_fetch_array ( $resultado )){
    $id=$extraido['id'];
    $id_usuario=$extraido['id_usuario'];
    $correo  = $extraido['correo'];
    $correo =trim ($correo);
    $correo = strtolower($correo);
    $contrasena = $extraido['contrasena'];
    if ($correo == $usuario_get && $contrasena == $contrasena_get){
      $login++;
      $id_found = $id;
      $id_usuario_found = $id_usuario;
    }
  }
  
  if ($login>0){
    $session->setCurrentUser($id_found,$id_usuario_found );
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    header('Location: menu.php');
    }else{
  //   $session->setCurrentUser('','');
    header('Location: index.php?error=100');
    }
}
 ?>