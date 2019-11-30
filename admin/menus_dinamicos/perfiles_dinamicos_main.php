 <ul class="list-unstyled components">
  <li><a class = "activo" href="<?=$root_menu_session?>">INICIO</a></li>
 </ul>
 <ul class="list-unstyled components">
  <?php
  $perfiles= mysqli_query($conexion, "SELECT id,modulo,link,id_capacidad, idseccion  FROM Ventana_modulos_transporte order by modulo;");

  while($perfil = mysqli_fetch_assoc($perfiles)){
    $id=$perfil['id'];
    $modulo = $perfil ['modulo'];
    $link = $perfil ['link'];
    $id_capacidad= $perfil['id_capacidad'];
    $id_seccion = $perfil['idseccion'];
    $seccion = '';
    if ($id_seccion=='1') $seccion = 'transportes/';
    // if ($id_seccion=='2') $seccion = 'admin/';
    if ($id_seccion=='3') $seccion = 'transportes/choferes/';
    if ($id_seccion=='4') $seccion = 'extraordinario/';
    if ($id_seccion=='5') $seccion = 'eventos/';  
    if ($id_seccion=='6') $seccion = 'seguridad/';
    if ($id_seccion=='7') $seccion = 'eventosInternos/';
    if ($id_seccion=='8') $seccion = 'app/';
    if ($id_seccion=='9') $seccion = 'rutas/';
    if(strpos($link, "https")!==false){
        $seccion="";
    }

    if (in_array($id_capacidad, $capacidades)){

      if ($id==$perfil_actual){
        ?>
        <li><a class="activo" href="<?=$seccion.$link?>"><?=$modulo?></a></li>
        <?php
      }else{
        ?>
        <li><a class="" href="<?=$seccion.$link?>"><?=$modulo?></a></li>
        <?php
      }
    }
  }
  ?>
 </ul>

  <ul class="list-unstyled components">
  <li><a href="<?=$root_close_session?>"><span class="glyphicon glyphicon-user" ></span> CERRAR SESION</a></li>
 </ul>
