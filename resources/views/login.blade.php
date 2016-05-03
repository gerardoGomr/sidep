@extends('app_no_sidebar')

@section('contenido')
	<div class="login">
		<div class="placeholder text-center"><img src="{{ asset('public/img/logo_255.png') }}" border="0"></div>
		<div class="panel panel-default col-sm-6 col-sm-offset-3">

			<div class="panel-body">
				@if(isset($error))
					<div class="alert alert-danger">
						<strong>Error de inicio de sesión</strong>
						{{ $error }}
					</div>
				@endif
				<span class="text-primary center">Escriba su nombre de usuario y contraseña para ingresar al sistema.</span>
				<div class="separator"></div>
				<form role="form" action="{{ url('login') }}" method="post" name="formLogin">
					{{ csrf_field() }}
					<div class="form-group">
				    	<input type="text" class="form-control" name="txtUsername" id="txtUsername" placeholder="Usuario">
				 	</div>
				  	<div class="form-group">
				    	<input type="password" class="form-control" name="txtPassword" id="txtPassword" autocomplete="off" placeholder="Contraseña">
				  	</div>
				  	<input type="submit" class="btn btn-primary btn-block no-ajaxify" value="Ingresar" />
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	@section('js')
		<script src="{{ asset('public/js/login.js') }}"></script>
	@stop
@stop