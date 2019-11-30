<!-- Button trigger modal -->
<button type="button" style="cursor: pointer; margin:2px" class="btn btn-primary btn-default pull-right btn-nuevo" data-toggle="modal" data-target="#listModal">
<b><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;LISTA</b>
</button>
<!---- Modal --->
<div id="listModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog" role="document"  style="max-width:750px;"  >
    <div class="modal-content">
      <div class="modal-header d-block">
        <h5 class="modal-title" width="100%" id="ModalCenterTitle">Añadir Alumnos a la Lista de Permisos</h5>
        <input width="100%" type="text" class="form-control filter"
        placeholder="Buscar Solicitud..." onkeyup="filter(this)">
      </div>
      <div class="modal-body" style="height:60vh ; overflow-y: scroll;">
        <table class="table" width="100%"  style="font-size: 14px;"  >
          <thead style="border-bottom: 2px solid #333">
            <th>Nombre</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th style="text-align:center">Acciones</th>
          </thead >
          <tbody id="lista_alumnos_new" class="searchable" >
            <?php
            if (isset($nivel_or_area)){
              $sql =  "SELECT * FROM alumnoschmd WHERE  id_nivel='$nivel_or_area' order by idcursar";
            }else{
              $sql =  "SELECT * FROM alumnoschmd  order by idcursar";
            }

            $existe = mysqli_query ($conexion, $sql );
            while($alumno = mysqli_fetch_array($existe)){

              $nombre = $alumno['nombre'];
              $grado = $alumno['grado'];
              $grupo = $alumno['grupo'];
              $id_alumno = $alumno['id'];
              ?>
              <tr style="border-bottom: 1px solid #eee" id="tr_<?=$id_alumno?>">
                <td id="nombre_<?=$id_alumno?>"><?=$nombre?></td>
                <td id="grado_<?=$id_alumno?>"><?=$grado?></td>
                <td id="grupo_<?=$id_alumno?>"><?=$grupo?></td>
                <td style="text-align:center">
                  <button type="button" class="btn btn-primary" onclick="enlistar_alumno(<?=$id_alumno?>)" style ="font-family: 'Varela Round'" >
                    <span class="glyphicon glyphicon-plus" ></span> AÑADIR
                  </button>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> CERRAR</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function filter(element){
//  alert($(element).val());
  var rex = new RegExp($(element).val(), 'i');
  $('.searchable tr').hide();
  $('.searchable tr').filter(function() {
    return rex.test( $(this).text() );
  }).show();


  /*
  */
}
</script>