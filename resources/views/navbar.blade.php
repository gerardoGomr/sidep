<!-- NAVBAR -->
<div class="navbar hidden-print box main" role="navigation" style="background: url('public/img/fondo.png') repeat-x">
	<div class="user-action user-action-btn-navbar pull-left border-right">
		<button class="btn btn-sm btn-navbar btn-primary btn-stroke"><i class="fa fa-bars fa-2x"></i></button>
	</div>

	<h3 class="innerAll pull-left text-white border-right">Sistema Integral de Gestión Documental C3</h3>

	<form id="formBusquedaGeneral" name="formBusquedaGeneral">
	  	<div class="col-md-3 visible-md visible-lg padding-none">
	    	<div class="input-group innerL">
	      		<input id="txtBusqueda" name="txtBusqueda" type="text" class="form-control input-sm" placeholder="Busqueda rápida" autocomplete="off">
	      		<span class="input-group-btn">
	        		<button id="btnBuscar" name="btnBuscar" class="no-ajaxify btn btn-default" type="submit"><i class="fa fa-search"></i></button>
	      		</span>
	    	</div>
	  	</div>
  	</form>

  	<div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
		<div class="dropdown username hidden-xs pull-left">
			<a class="dropdown-toggle  dropdown-hover" data-toggle="dropdown" href="#">
				<span class="media margin-none">
					<span class="pull-left"></span>
					<span class="media-body">
						<span class="strong"><i class="fa fa-user"></i> {{ request()->session()->get('usuario')->nombreCompleto() }}</span><span class="caret"></span>
					</span>
				</span>
			</a>
			<ul class="dropdown-menu pull-right">
				<li><a href="{{ url('logout') }}" class="no-ajaxify">Cerrar sesión</a></li>
		    </ul>
		</div>

	</div>
	<div class="clearfix"></div>
</div>
<!-- fin de navbar -->