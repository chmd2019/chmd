  <ul class="list-unstyled components">
  <li><a href="<?=$root_menu_session?>">INICIO</a></li>
 </ul>
 
   <ul class="list-unstyled components">
  <?php
  $perfiles= mysqli_query($conexion, "SELECT id,modulo,link FROM Ventana_modulos_transporte WHERE  idseccion=3 order by id;");//colocer idseccion=3, para nuevo de choferes
  while($perfil = mysqli_fetch_array($perfiles)){

    $id=$perfil['id'];
    $modulo = $perfil ['modulo'];
    $link = $perfil ['link'];

    if ($id==$perfil_actual){
      ?>
      <li><a class="activo" href="<?=$perfil['link']?>"><?=$perfil['modulo'];?></a></li>
      <?php
    }else{
      ?>
      <li><a class="" href="<?=$perfil['link']?>"><?=$perfil['modulo'];?></a></li>
      <?php
    }
    ?>
    <?php
  }
  ?>
 </ul>

  <ul class="list-unstyled components">
  <li><a href="<?=$root_close_session?>"><span class="glyphicon glyphicon-user" ></span> CERRAR SESION</a></li>
 </ul>
