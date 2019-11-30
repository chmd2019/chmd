<?php
class UserSession
{
  public function __construct(){
    session_start();
    }
  /*New get Login*/  
  public function setCurrentUser($admin,$user){
    $_SESSION['user']=$admin;
    $_SESSION['id_user']=$user;
  }
  /*old get_Login
  public function setCurrentUser($admin){
    $_SESSION['user']=$admin;
  }
  */  

  public function existeSession(){
    if (isset($_SESSION['user']) && $_SESSION['user']!=''){
      return true;
    }else{
      return false;
    }
  }
  public function getCurrentUser(){
    return $_SESSION['user'];
  }
  public function getCurrentIdUser(){
    return $_SESSION['id_user'];
  }

  public function closeSession(){
    $_SESSION = array();
  /*  if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    */
    session_unset();
    session_destroy();
  }
}
 ?>
