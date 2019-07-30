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
  <!-- Custom styles for this template -->
  <link href="css/index.css" rel="stylesheet">
</head>
<body>
<div class="container">
<form class="form-signin" method='POST' action='get_login.php'>
    <h2 class="form-signin-heading">Administrador CHMD</h2>
    <input name="usuario" type="text" class="form-control"
      placeholder="Usuario" required autofocus>
    <input name="contrasena"
      type="password" class="form-control" placeholder="Contraseña"
      required>
     <label class="checkbox">
       <input type="checkbox" value="remember-me">Recordar
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="entrar">Entrar</button>
    <br> <br> <br> <br>
  </form>
</div>
</body>
</html>
