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
                <li><a href="dashboard">Menú Principal</a></li>
				<li class="active"><a href="gruposAdmin/create">Nuevo</a></li>
			</ul>	
		</div>	

	</div>
</nav>


	<div class="container">
		<div class="row">
 <div class="col-md-12">
 	<h2 align="center">Catálogo de grupos administrativos </h2>
 	<table class="table table-bordered">
 		<tr>
 			<th>Código</th>
 			<th>Nombre</th>
			 <th>Descripción</th>
			 <th>Asociar usuarios al grupo</th>
 			<th colspan="2">Acciones</th>
 		</tr>
 		<?php foreach ($grupoAdmin as $g):?>
 		<tr>
 			<td>{{$g->id}}</td>
 			<td>{{$g->grupo}}</td>
			 <td>{{$g->descripcion}}</td>
			 <td><a class="btn btn-warning btn-xs" href="gruposAdmin/asociar/{{$g->id}}"><span class="glyphicon glyphicon-paperclip"></a></td>
 			<td><a class="btn btn-primary btn-xs" href="gruposAdmin/edit/{{$g->id}}"><span class="glyphicon glyphicon-pencil"></a></td>
 			<td><a class="btn btn-danger btn-xs" href="{{url('gruposAdmin/eliminar',$g->id)}}"><span class="glyphicon glyphicon-trash"></a></td>
 		</tr>
 		  <?php endforeach; ?>
 	</table>
 	{{ $grupoAdmin->links() }}
 </div>
</div>
	</div>
</body>
</html>