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
				<li><a href=".{{ url('dashboard') }}">Menú Principal</a></li>
			</ul>	
		</div>	

	</div>
</nav>

<div class="panel panel-success">
	<div class="panel-heading">
        <h4>Asociar alumnos al grupo</h4>
        <h5>Grupo a asociar: {{$grupoEspecial->grupo}} </h5>
	</div>

	<div class="panel-body">
        <form method="post" action="{{action('GrupoEspecialController@asoc',$grupoEspecial->id)}}">
        @csrf
				<p>
					<select name="cboAlumnos" id="cboAlumnos" class="form-control">
                    @foreach($alumnos as $alumno)
      						<option value="<?php echo $alumno->id; ?>"><?php echo $alumno->nombre; ?></option>
    					@endforeach
                    </select>

                </p>
							
				<p>
					<input type="submit" class="btn btn-success " value="Asociar alumno al grupo">
				</p>	



		</form>	


        <div class="row">
 <div class="col-md-12">
 	<h4 align="center">Alumnos asociados al grupo </h4>
 	<table class="table table-bordered">
 		<tr>
         <th>Código</th>    
         <th>Código del grupo</th>
             <th>Código del alumno</th>
 			<th>Nombre</th>
 			<th>Código de familia</th>
 			<th>Grado</th>
             <th>Eliminar</th>
 		</tr>
 		<?php foreach ($alumnosAsociados as $a):?>
 		<tr>
         <td><?php echo $a->id; ?></td>
 			<td><?php echo $a->grupoEspecial; ?></td>
 			<td><?php echo $a->alumno_id; ?></td>
 			<td><?php echo $a->nombre; ?></td>
 			<td><?php echo $a->idfamilia; ?></td>
 			<td><?php echo $a->grado; ?></td>
 			<td><a class="btn btn-danger btn-xs" href="../deasoc/{{$a->id}}"><span class="glyphicon glyphicon-trash"></a></td>
 		</tr>
 		  <?php endforeach; ?>
 	</table>
 	{{ $alumnosAsociados->links() }}
 </div>
</div>



</body>
</html>	