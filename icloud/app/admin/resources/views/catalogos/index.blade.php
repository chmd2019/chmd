<!DOCTYPE html>
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
				<li><a href="/nivel">Todos</a></li>
				<li class="active"><a href="nivel/create">Nuevo</a></li>
			</ul>	
		</div>	

	</div>
</nav>


	<div class="container">


	<form action="search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="q"
            placeholder="Buscar por nombre o apellido"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </div>
</form>


		<div class="row">
 <div class="col-md-12">
 	<h2 align="center">Catálogo de niveles </h2>
 	<table class="table table-bordered">
 		<tr>
 			<th>Código</th>
 			<th>Nivel</th>
 			<th colspan="3">Acciones</th>
 		</tr>
 		@foreach($nivel as $row)
 		<tr>
 			<td>{{$row['id']}}</td>
 			<td>{{$row['nivel']}}</td>
 			<td><a class="btn btn-info btn-xs" href="/nivel/show/{{$nivel->id}}"><span class="glyphicon glyphicon-eye-open"></a></td>
 			<td><a class="btn btn-primary btn-xs" href="/nivel/edit/{{$nivel->id}}"><span class="glyphicon glyphicon-pencil"></a></td>
 			<td><a class="btn btn-danger btn-xs" href="{{url('nivel/eliminar',$nivel->id)}}"><span class="glyphicon glyphicon-trash"></a></td>

 			
 		</tr>
 		@endforeach
 	</table>
 </div>
</div>
	</div>
</body>
</html>

