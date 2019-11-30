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
				<li><a href="{{ url('gruposEspeciales') }}">Todos</a></li>
				<li class="active"><a href="gruposEspeciales/create">Nuevo</a></li>
				<li><a href="{{ url('dashboard') }}">Menú Principal</a></li>
			</ul>	
		</div>	

	</div>
</nav>


	<div class="container">
		<div class="row">
 <div class="col-md-12">
 	<h2 align="center">Catálogo de grupos especiales </h2>
 	<table class="table table-bordered">
 		<tr>
 			<th>Código</th>
 			<th>Título</th>
 			<th>Descripcion</th>
             <th>Asociar alumnos al grupo</th> 
             <th colspan="2">Acciones</th>
 		</tr>
 		<?php foreach ($grupoEspecial as $g):?>
 		<tr>
 			<td><?php echo $g->id; ?></td>
 			<td><?php echo $g->grupo; ?></td>
 			<td><?php echo $g->descripcion; ?></td>
            
             <td><a class="btn btn-warning btn-xs" href="gruposEspeciales/asociar/{{$g->id}}"><span class="glyphicon glyphicon-paperclip"></a></td>
 			<td><a class="btn btn-primary btn-xs" href="gruposEspeciales/edit/{{$g->id}}"><span class="glyphicon glyphicon-pencil"></a></td>
 			<td><a class="btn btn-danger btn-xs" href="{{url('gruposEspeciales/',$g->id)}}"><span class="glyphicon glyphicon-trash"></a></td>
 		</tr>
 		  <?php endforeach; ?>
 	</table>
 	{{ $grupoEspecial->links() }}
 </div>
</div>
	</div>
</body>
</html>