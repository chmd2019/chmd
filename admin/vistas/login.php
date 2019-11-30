<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="author" content="@AnahiAnndroid">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>Administrador</title>
  <!-- Bootstrap core CSS -->
  <link href="dist/css/bootstrap.css" rel="stylesheet">
  <!-- Custom styles for this template
   -->
  
  <!-- Dependencias Globales --> 
  <?php include 'components/header.php'; ?>

  <link href="css/index.css" rel="stylesheet">
</head>
<body>
 <nav class="navbar navbar-light" style="background: #12487E !important; padding: 20px; text-align: center; border-radius:0px; margin: 0">
    <a class="navbar-brand" href="https://www.chmd.edu.mx/pruebascd/icloud/">
    <img width="100%" class="logo" src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/LogoMaguenWT.png">
    </a>
</nav>
<div class="container" >
  <div class="box-login" >
    <form class="form-signin" method='POST' action='get_login.php'>
        <h2 class="form-signin-heading" style="text-align: center; font-family: 'Varela Round'; color: #12487E !important;margin-top: 20px;">ADMINISTRADOR CHMD</h2>
        <?php if (isset($error) && $error){
         ?>
        <div id="error" class="form-signin alert alert-danger" role="alert">
        El Correo y/o Contraseña son Incorrectos, ¡Vuelva a Intentarlo!
        </div>
        <?php 
        } ?>
        <br>
        <input name="usuario" type="text" class="form-control"
          placeholder="Correo" required autofocus>
        <input name="contrasena"
          type="password" class="form-control" placeholder="Contraseña"
          required>
          <!--
         <label class="checkbox">
           <input type="checkbox" value="remember-me">Recordar
        </label>
          -->
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="entrar"><b>ENTRAR</b></button>
        <br> <br> <br> <br>
      </form>
  </div>
</div>
  <!-- Site footer -->
<?php include_once 'components/footer.php'; ?>
<script type="text/javascript" src="dist/js/bootstrap.js"></script>
</body>
</html>
