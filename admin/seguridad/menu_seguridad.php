<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('12', $capacidades)){
    header('Location: ../menu.php');
}else{
    header('Location: PseguridadPadres.php');
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
  <title>CHMD :: Menu</title>
  <link href="../dist/css/bootstrap.css" rel="stylesheet">
  <link href="../css/menu.css" rel="stylesheet">
      <!-- Dependencias Globales -->
  <?php include '../components/header.php'; ?>

</head>

<body>
     <?php include_once "../components/navbar.php"; ?>
  <div class="container">
    <div class="masthead">
      <a class="btn-lg" href="../cerrar_sesion.php" style="float: right; cursor: pointer;"
      role="button" class="btn btnfamilia-default btn-sm"> <span
      class="glyphicon glyphicon-user"></span> Cerrar Sesión
    </a> &nbsp <a href="../menu.php">
      <button style="float: right; cursor: pointer;" type="button"
      class="btn btn-default btn-lg ">
      <span class="glyphicon glyphicon-th"></span> Menu
    </button>
    </a>
      <h3 class="text-muted">Colegio Hebreo Maguen David</h3>
      <hr>
    </div>
    <div class="row" style="margin-top:150px">
    <?php   $perfiles= mysqli_query($conexion, "SELECT id,modulo,link  FROM Ventana_modulos_transporte WHERE  idseccion=6 order by id;");

      while($perfil = mysqli_fetch_assoc($perfiles)){
        $id=$perfil['id'];
        $modulo = $perfil ['modulo'];
        $link = $perfil ['link'];

            ?>
      <div class="col-lg-6" style="margin-bottom:30px">
        <center>
          <a href="<?=$link?>">
            <button style="width:100%;height:150px; font-size: 1.5em" class="btn btn-large btn-primary" type="button"><?=$modulo?></button>
          </a>
        </center>
      </div>
      <?php
    }
      ?>
   </div>

  </div>
   <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
</body>
</html>
