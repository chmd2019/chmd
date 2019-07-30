<ul class="nav nav-justified">
  <?php
  $perfiles= mysqli_query($conexion, "SELECT id,modulo,link,id_capacidad  FROM Ventana_modulos_transporte WHERE  idseccion=4 order by id;");

  while($perfil = mysqli_fetch_assoc($perfiles)){
    $id=$perfil['id'];
    $modulo = $perfil ['modulo'];
    $link = $perfil ['link'];
    $id_capacidad= $perfil['id_capacidad'];

    if (in_array($id_capacidad, $capacidades)){

      if ($id==$perfil_actual){
        ?>
        <li class="active"><a href="<?=$link?>"><?=$modulo?></a></li>
        <?php
      }else{
        ?>
        <li><a href="<?=$link?>"><?=$modulo?></a></li>
        <?php
      }
    }
  }
  ?>
</ul>
