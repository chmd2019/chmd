<?php
include 'user_session.php';
include 'conexion.php';

$session = new UserSession();

if (isset ( $_POST ['entrar'] ))
{
  $usuario_get = $_POST ["usuario"];
  $contrasena_get = $_POST ["contrasena"];
  //si usuario
  $resultado = mysqli_query ($conexion, "SELECT COUNT(*) as login, usuario, id  FROM Administrador_usuarios WHERE usuario ='$usuario_get' and contrasena= MD5('$contrasena_get')  LIMIT 1" );
  if ($extraido = mysqli_fetch_array ( $resultado )){
    $login =$extraido['login'];
    $usuario  = $extraido['usuario'];
    $id_usuario = $extraido['id'];

    if ($login>0){
    $session->setCurrentUser($id_usuario );
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    header('Location: menu.php');
    }else{
    $session->setCurrentUser('','');
    header('Location: https://www.chmd.edu.mx/');
    }
  }else{
    header('Location: index.php');
  }

}
 ?>
