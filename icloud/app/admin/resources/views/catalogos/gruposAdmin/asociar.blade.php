<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CHMD - Mantenimiento de catalogos</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">CHMD</a>
		</div>	
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="/gruposAdmin">Todos</a></li>
				<li class="active"><a href="gruposAdmin/create">Nuevo</a></li>
				<li><a href="../../dashboard">Menú Principal</a></li>
			</ul>	
		</div>	

	</div>
</nav>

<div class="panel panel-success">
	<div class="panel-heading">
        <h4>Asociar usuarios al grupo</h4>
        <h5>Grupo a asociar: {{$grupoAdmin->grupo}} </h5>
	</div>

	<div class="panel-body">
        <form method="post" action="{{action('GrupoAdminController@asoc',$grupoAdmin->id)}}">
        @csrf
				<p>
					<select name="cboUsuarios" id="cboUsuarios" class="form-control">
                    @foreach($usuarios as $usuario)
      						<option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre; ?></option>
    					@endforeach
                    </select>

                </p>
							
				<p>
					<input type="submit" class="btn btn-success " value="Asociar usuario al grupo">
				</p>	



		</form>	


        <div class="row">
 <div class="col-md-12">
 	<h4 align="center">Usuarios asociados al grupo </h4>
 	<table class="table table-bordered">
 		<tr>
         <th>Código</th>    
         <th>Código del grupo</th>
             <th>Código del usuario</th>
 			<th>Grupo</th>
 			<th>Nombre</th>
             <th>Eliminar</th>
 		</tr>
 		<?php foreach ($usuariosAsociados as $u):?>
 		<tr>
         <td><?php echo $u->id; ?></td>
 			<td><?php echo $u->grupo_id; ?></td>
 			<td><?php echo $u->usuario_id; ?></td>
 			<td><?php echo $u->grupo; ?></td>
 			<td><?php echo $u->nombre; ?></td>
 			<td><a class="btn btn-danger btn-xs" href="../deasoc/{{$u->id}}"><span class="glyphicon glyphicon-trash"></a></td>
 		</tr>
 		  <?php endforeach; ?>
 	</table>
 	{{ $usuariosAsociados->links() }}
 </div>
</div>



</body>
</html>	