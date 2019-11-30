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
				<li><a href="{{ url('circulares') }}">Todos</a></li>
				<li class="active"><a href="circulares/create">Nuevo</a></li>
				<li><a href="{{ url('dashboard') }}">Menú Principal</a></li>
			</ul>	
		</div>	

	</div>
</nav>

<div class="panel panel-success">
	<div class="panel-heading">
		<h4>Nueva Circular</h4>
	</div>

	<div class="panel-body">
		<form method="post" action="store">
		@csrf
				<p>
					<input name="titulo" placeholder="titulo de la circular" class="form-control" required>
				</p>
				
				<p>
					Nivel
					<select name="cboNivel" class="form-control">
						@foreach($niveles as $nivel)
      						<option value="<?php echo $nivel->id; ?>"><?php echo $nivel->nivel; ?></option>
    					@endforeach
					</select>
				</p>
				<p>
					Grado
					<select name="cboGrado" class="form-control">
						@foreach($grados as $grado)
      						<option value="<?php echo $grado->idcursar; ?>"><?php echo $grado->grado; ?></option>
    					@endforeach
					</select>
				</p>
				<p>
					Grupo
					<select name="cboGrupo" class="form-control">
						@foreach($grupos as $grupo)
      						<option value="<?php echo $grupo->id; ?>"><?php echo $grupo->grupo; ?></option>
    					@endforeach
					</select>
				</p>
				<p>
				<input type="checkbox" name="chkAdjunto" value="0" class="form-control" >
					<label for="chkAdjunto">Adjunto</label>
				</p>

				<p>
					Grupo Especial
					<select name="cboGrupoEsp" class="form-control">
						@foreach($grupos_esp as $grupo)
      						<option value="<?php echo $grupo->id; ?>"><?php echo $grupo->grupo; ?></option>
    					@endforeach
					</select>
				</p>	

				<p>
					Grupo Administrativo
					<select name="cboGrupoEsp" class="form-control">
						@foreach($grupos_admin as $grupo)
      						<option value="<?php echo $grupo->id; ?>"><?php echo $grupo->grupo; ?></option>
    					@endforeach
					</select>
				</p>	


				<p>


				Adjunto
					<select name="cboAdjunto" class="form-control">
					<option value='1' selected>Sí</option>
					<option value='0'>No</option>"
					</select>
				</p>

				<p>
					Contenido de la circular
				<textarea name="contenido">
				
				</textarea>
        		<script>
            		CKEDITOR.replace( 'contenido' );
				</script>
				</p>
				<p>
					<input name="ciclo_escolar_id" placeholder="Ciclo Escolar" class="form-control" required>
				</p>
				<p>
					Enviar a todos
				<select name="cboEnviar" class="form-control">
					<option value="1">Sí</option>
					<option value="0">No</option>
				</select>
				</p>
				<p>
					<input type="submit" class="btn btn-success btn-block" value="Guardar Circular">
				</p>	



		</form>	



</body>
</html>		