<!-- NAVBAR -->
<div class="navbar hidden-print box main" role="navigation" style="background: url('public/img/fondo.png') repeat-x">
	<div class="user-action user-action-btn-navbar pull-left border-right">
		<button class="btn btn-sm btn-navbar btn-primary btn-stroke"><i class="fa fa-bars fa-2x"></i></button>
	</div>

	<form id="formBusquedaGeneral" name="formBusquedaGeneral">
	  	<div class="col-xs-8 col-md-4 col-lg-6 visible-md visible-lg visible-xs padding-none">
	    	<div class="input-group innerL">
	      		<input id="txtBusqueda" name="txtBusqueda" type="text" class="form-control input-sm" placeholder="Busqueda rápida" autocomplete="off">
	      		<span class="input-group-btn">
	        		<button id="btnBuscar" name="btnBuscar" class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
	      		</span>
	    	</div>
	  	</div>
  	</form>

  	<div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
		<div class="dropdown username hidden-xs pull-left">
			<a class="dropdown-toggle dropdown-hover" data-toggle="dropdown" href="#">
				<span class="media margin-none">
					<span class="pull-left"></span>
					<span class="media-body">
						<span class="strong"><i class="fa fa-user"></i> {{ request()->session()->get('encargo')->servidorPublico()->nombreCompleto() }} </span><span class="caret"></span>
					</span>
				</span>
			</a>
			<ul class="dropdown-menu pull-right">
				<li><a href="{{ url('admin/perfil') }}"><i class="fa fa-gears"></i> Mi perfil</a></li>
				<li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
		    </ul>
		</div>

		<div class="dropdown dropdown-icons padding-none">
			<a class="btn btn-primary btn-circle dropdown-toggle dropdown-hover bg-white" data-toggle="dropdown"><i class="fa fa-info-circle"></i></a>
			<ul class="dropdown-menu">
				<li data-toggle="tooltip" data-title="Manual de usuario" data-placement="bottom" data-container="body" role="presentation">
					<a href=""><i class="fa fa-download"></i></a>
				</li>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<!-- fin de navbar -->