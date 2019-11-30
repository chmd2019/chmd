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

<p>


<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">CHMD</a>
		</div>	
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="{{ url('dashboard') }}">Menú Principal</a></li>
			</ul>	
		</div>	

	</div>
</nav>


	<div class="container">


	<form action="padres/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="q"
            placeholder="Buscar por nombre, apellido o correo"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </div>
</form>


		<div class="row">
 <div class="col-md-12">
 	<h2 align="center">Catálogo de padres </h2>
 	<table class="table table-bordered">
 		<tr>
 			<th>Código</th>
 			<th>Nombre</th>
             <th>Apellidos</th>
             <th>Rol</th>
             <th>Correo</th>
 			<th>Familia</th>

 		</tr>
 		<?php foreach ($padres as $padre):?>
 		<tr>
 			<td><?php echo $padre->id; ?></td>
 			<td><?php echo $padre->nombre; ?></td>
             <td><?php echo $padre->apellidos; ?></td>
             <td><?php echo $padre->Rol; ?></td>
             <td><?php echo $padre->correo; ?></td>
 			<td><a href='familia/show/<?php echo $padre->Familia; ?>'><?php echo $padre->Familia; ?></a></td>
 			
 			
 		</tr>
 		  <?php endforeach; ?>
 	</table>
 	{{ $padres->links() }}
 </div>
</div>
	</div>
</body>
</html>