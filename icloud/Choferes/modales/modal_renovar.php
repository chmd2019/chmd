<a class="waves-effect waves-light modal-trigger" tooltip="Renovar" onclick="renovar(<?=$id_chofer?>, <?=$familia?>)">
    <img src='https://www.chmd.edu.mx/pruebascd/icloud/pics/Renovar.svg' style="width: 45px"> 
</a>

<script type="text/javascript">
  function renovar(id, nfamilia){
    M.toast({html: 'Renovando datos de Chofer.', classes: 'green accent-4'});
    //Verifica la cantidad de tarjetones asignados a la familia
    $.get("./common/get_cantidad_tarjetones.php", {nfamilia:nfamilia }).done(function(data){
      //alert(data);
      var res = JSON.parse(data);
      if(res.n_tajetones>1){
        //si es mayor a cero -- enviar a renovacion de estatus

        $.ajax({
          url: './common/update_renovar_chofer.php',
          type:'POST',
          data: {id_chofer: id },
          success: function(data){
            //alert(data);
            if (data==true){
                window.location.reload();

          return;
            }else{
              M.toast({html: 'Ha ocurrido un Error', classes: 'red accent-4'});
            }
          }

        });
      }else{
        //enviar a actualizacion de autos
        setTimeout(() => {
          window.location="./vistas/vista_actualizar_autos.php?idchofer=<?=$id_chofer?>";
        }, 1500);
      }
    });
  }
</script>
