 <ul class="list-unstyled components">
  <li><a href="<?=$root_menu_session?>">INICIO</a></li>
 </ul>
 <ul class="list-unstyled components">
  <?php
  $perfiles= mysqli_query($conexion, "SELECT id,modulo,link,id_capacidad  FROM Ventana_modulos_transporte WHERE  idseccion=5 order by id;");

  while($perfil = mysqli_fetch_assoc($perfiles)){
    $id=$perfil['id'];
    $modulo = $perfil ['modulo'];
    $link = $perfil ['link'];
    $id_capacidad= $perfil['id_capacidad'];

    if (in_array($id_capacidad, $capacidades)){

      if ($id==$perfil_actual){
        ?>
        <li><a class="activo" href="<?=$link?>"><?=$modulo?></a></li>
        <?php
      }else{
        ?>
        <li><a class="" href="<?=$link?>"><?=$modulo?></a></li>
        <?php
      }
    }
  }
  ?>
 </ul>

  <ul class="list-unstyled components">
  <li><a href="<?=$root_close_session?>"><span class="glyphicon glyphicon-user" ></span> CERRAR SESION</a></li>
 </ul>
