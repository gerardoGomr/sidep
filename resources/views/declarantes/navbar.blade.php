<!-- NAVBAR -->
<div class="navbar hidden-print main navbar-default" role="navigation" style="background: url('public/img/fondo.png') repeat-x">
	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a id="logo" href="{{ url('declarantes') }}" class="animated fadeInDown pull-left"><img src="{{ asset('public/img/logo_255.png') }}" class="border-none" alt="Centro Estatal de Control de Confianza Certificado"></a>
		</div>

		<div class="navbar-collapse collapse">
			<div class="user-action visible-xs user-action-btn-navbar pull-right">
				<button class="btn btn-sm btn-navbar-right btn-primary btn-stroke"><i class="fa fa-fw fa-arrow-right"></i><span class="menu-left-hidden-xs"> Modules</span></button>
			</div>

			<div class="col-md-3 visible-md visible-lg pull-right padding-none">
				<div class="input-group">
					<input type="text" class="form-control input-sm" placeholder="Search stories ...">
		      		<span class="input-group-btn">
		        		<button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
		      		</span>
				</div><!-- /input-group -->
			</div>

			<div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs hidden-xs">
				<div class="dropdown dropdown-icons padding-none">
					<a data-toggle="dropdown" href="#" class="btn btn-primary btn-circle dropdown-toggle"><i class="fa fa-user"></i> </a>
					<ul class="dropdown-menu">
						<li data-toggle="tooltip" data-title="Photo Gallery" data-placement="left" data-container="body"><a href="gallery_photo.html?lang=en"><i class="fa fa-camera"></i></a></li>
						<li data-toggle="tooltip" data-title="Tasks" data-placement="left" data-container="body"><a href="tasks.html?lang=en"><i class="fa fa-code-fork"></i></a></li>
						<li data-toggle="tooltip" data-title="Employees" data-placement="left" data-container="body"><a href="employees.html?lang=en"><i class="fa fa-group"></i></a></li>
						<li data-toggle="tooltip" data-title="Contacts" data-placement="left" data-container="body"><a href="contacts_2.html?lang=en"><i class="fa fa-phone-square"></i></a></li>
					</ul>
				</div>
			</div>

			<ul class="notifications pull-right hidden-xs">
				<li class="dropdown notif">
					<a href="" class="dropdown-toggle"  data-toggle="dropdown"><i class="notif-block fa fa-comments-o"></i><span class="badge badge-primary">7</span></a>
					<ul class="dropdown-menu chat media-list">
						<li class="media">
							<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/15.jpg" alt="50x50" width="50"/></a>
							<div class="media-body">
								<span class="label label-default pull-right">5 min</span>
								<h5 class="media-heading">Adrian D.</h5>
								<p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							</div>
						</li>
						<li class="media">
							<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/16.jpg" alt="50x50" width="50"/></a>
							<div class="media-body">
								<span class="label label-default pull-right">2 days</span>
								<h5 class="media-heading">Jane B.</h5>
								<p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							</div>
						</li>
						<li class="media">
							<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/17.jpg" alt="50x50" width="50"/></a>
							<div class="media-body">
								<span class="label label-default pull-right">3 days</span>
								<h5 class="media-heading">Andrew M.</h5>
								<p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							</div>
						</li>
						<li><a href="#" class="btn btn-primary"><i class="fa fa-list"></i> <span>View all messages</span></a></li>
					</ul>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!-- fin de navbar -->

<div id="menu-top" class="menu-top-inverse">
	<div class="container">
		<ul class="main pull-left">
			<li>
				<a class="" href=""><i class="fa fa-fw fa-cog"></i> Declaración de situación patrimonial</a>
			</li>
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-suitcase"></i> Normatividad <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="ui.html?lang=en">Ley de Responsabilidades de los Servidores Públicos del Estado de Chiapas</a></li>
					<li><a href="ui.html?lang=en">Acuerdo de Declaración de Situación Patrimonial</a></li>
				</ul>
			</li>
			<li>
				<a class="" href=""><i class="fa fa-fw fa-check-square-o"></i> Tutorial</a>
			</li>
			<li>
				<a class="" href=""><i class="fa fa-fw fa-file"></i> Manual de Usuario</a>
			</li>
		</ul>
	</div>
</div>