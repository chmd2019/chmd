@extends('layouts.app')
@section('content')


<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<center>
				<h1 class="panel-title">Acceso al administrador de CHMD</h1>
			</div>
				<div class="panel-body">
					<form method="POST" action="{{route('login')}}">
						{{csrf_field()}}
						<div class="form-group">
							<label>Usuario</label>
							<input class="form-control" 
							type="text" 
							name="usuario" 
							placeholder="ingresa tu usuario">
							
						</div>
						<div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
							<label for="password">Contraseña</label>
							<input class="form-control" 
							type="password" 
							name="password" 
							placeholder="ingresa tu clave">
							{!! $errors->first('password','<span class="help-block">:message</span>') !!}
						</div>
						<button class="btn btn-primary btn-block">Acceder</button>
					</form>	
				</div>	
			</center>
		</div>

	</div>
</div>
@endsection