<div id="menu-top" style="background: url('{{ url('public/img/fondo.png') }}') repeat-x; border: none;"></div>
<div class="navbar navbar-coral navbar-fixed-top" style="background: url('{{ url('public/img/fondo.png') }}') repeat-x">
	<!-- Nav Bar Header -->
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle " data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar "></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ url('declarantes') }}"><img src="{{ asset('public/img/logo_255.png') }}"></a>
		</div>
		<!-- Nav Bar Collapse -->
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav main-menu">
				<li class="active"><a href="index.html?lang=en" >Declaración de situación patrimonial</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Normatividad <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class=""><a href="#" class="">Ley de Responsabilidades de los Servidores Públicos del Estado</a></li>
						<li class=""><a href="#" class="">Acuerdo de Declaración de Situación Patrimonial</a></li>
					</ul>
				</li>
				<li><a href="pricing.html?lang=en">Tutorial</a></li>
				<li><a href="blog.html?lang=en">Datos de contacto</a></li>
			</ul>
		</div>
		<!-- NavBar Collapse -->
		{{--<!-- Nav Bar Right -->--}}
		{{--<ul class="nav navbar-nav navbar-right right-side">--}}
			{{--<!-- User LogIn Button -->--}}
			{{--<li>--}}
				{{--<div class="btn-group">--}}
					{{--<a href="#login-menu" class="btn btn-login" data-toggle="collapse"> Login</a>--}}
					{{--<div class="collapse login" id="login-menu">--}}
						{{--<form action="">--}}
							{{--<div>--}}
								{{--<div class="input-group input-group-sm">--}}
									{{--<input type="text" class="form-control" placeholder="Email">--}}
									{{--<span class="input-group-addon"><i class="fa fa-check"></i></span>--}}
								{{--</div>--}}
								{{--<div class="input-group input-group-sm">--}}
									{{--<input type="password" class="form-control" placeholder="Password">--}}
									{{--<span class="input-group-addon"><i class="fa fa-times"></i></span>--}}
								{{--</div>--}}
							{{--</div>--}}
							{{--<div class="pull-right">--}}
								{{--<i class="fa fa-refresh fa-spin"></i> <button type="button" class="btn btn-login">Login</button>--}}
							{{--</div>--}}
							{{--<div class="center">--}}
								{{--<a href="" class="recover-password">Recover Password <i class="fa fa-lock"></i></a>--}}
							{{--</div>--}}
						{{--</form>--}}
					{{--</div>--}}
					{{--<a href="" class="btn btn-signup glyphicons user_add"><i></i>Sign up</a>--}}
				{{--</div>--}}
			{{--</li>--}}
		{{--</ul>--}}
	</div>
</div>