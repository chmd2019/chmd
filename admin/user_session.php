<?php
class UserSession
{
  public function __construct(){
    session_start();
    }
  public function setCurrentUser($user){
    $_SESSION['user']=$user;
  }
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


  public function closeSession(){
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_unset();
    session_destroy();
  }
}
 ?>
