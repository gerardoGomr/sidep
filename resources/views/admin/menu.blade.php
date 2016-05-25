<!-- menu de la izquierda -->
<div id="menu" class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">
	<div id="sidebar-fusion-wrapper">
		<div id="brandWrapper" class="custom-logo">
			 <a href="{{ url('/') }}" class="display-block-inline pull-left">
			 	<img src="{{ asset('public/img/logo_255.png') }}" class="border-none" alt="Centro Estatal de Control de Confianza Certificado">
			 </a>
		</div>
		<div id="logoWrapper">
			<div id="logo">
				<a href="{{ url('/') }}" class="btn btn-sm btn-inverse"><i class="fa fa-home"></i></a>
				<a href="email.html?lang=en" class="btn btn-sm btn-inverse"><i class="fa fa-envelope"></i><span class="badge pull-right badge-primary">2</span></a>
			</div>
		</div>
		<ul class="menu list-unstyled" id="navigation_components">
			<li class="hasSubmenu">
				<a href="#submenuServidores" class="glyphicons group" data-toggle="collapse"><i></i><span>Servidores públicos</span></a>
				<ul id="submenuServidores" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('admin/servidores/alta') }}" class="glyphicons circle_plus"><i></i><span>Alta</span></a></li>
					<li class="text-small"><a href="{{ url('admin/servidores') }}" class="glyphicons nameplate_alt"><i></i><span>Administración</span></a></li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuAdmon" class="glyphicons cogwheels" data-toggle="collapse"><i></i><span>Administración</span></a>
				<ul id="submenuAdmon" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('registrar') }}" class="glyphicons ban"><i></i><span>Declaraciones no realizadas</span></a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- fin de menú -->