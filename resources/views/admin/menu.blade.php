<!-- menu de la izquierda -->
<div id="menu" class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">
	<div id="sidebar-fusion-wrapper">
		<div id="brandWrapper" class="custom-logo">
			 <a href="{{ url('/') }}" class="display-block-inline pull-left">
			 	<img src="{{ asset('public/img/logo_255.png') }}" class="border-none" alt="Centro Estatal de Control de Confianza Certificado">
			 </a>
		</div>
		<div id="logoWrapper">

		</div>
		<ul class="menu list-unstyled" id="navigation_components">
			<li class="hasSubmenu">
				<a href="#submenuServidores" class="glyphicons group" data-toggle="collapse"><i></i><span>SERVIDORES PÚBLICOS</span></a>
				<ul id="submenuServidores" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('admin/servidores/alta') }}" class="glyphicons circle_plus"><i></i><span>ALTA</span></a></li>
					<li class="text-small"><a href="{{ url('admin/servidores') }}" class="glyphicons nameplate_alt"><i></i><span>ADMINISTRACIÓN</span></a></li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuDeclaraciones" class="glyphicons list" data-toggle="collapse"><i></i><span>DECLARACIONES</span></a>
				<ul id="submenuDeclaraciones" class="animated fadeIn collapse">
					<li class="menu hasSubmenu">
						<a href="#requerimientos" data-toggle="collapse" class="glyphicons file"><i></i>REQUERIMIENTOS</a>
						<ul id="requerimientos" class="menu collapse">
							<li class="text-small"><a href="{{ url('admin/declaraciones/requerimientos') }}" class="glyphicons file"><i></i><span>REQUERIMIENTOS</span></a></li>
							<li class="text-small"><a href="{{ url('admin/declaraciones/requerimientos/retorno') }}" class="glyphicons circle_ok"><i></i><span style="font-size: 8pt;">RETORNO DE REQUERIMIENTOS</span></a></li>
						</ul>
					</li>
					<li class="menu hasSubmenu">
						<a href="#enviosASFP" data-toggle="collapse" class="glyphicons file"><i></i>SFP</a>
						<ul id="enviosASFP" class="menu collapse">
							<li class="text-small"><a href="{{ url('admin/declaraciones/enviados-sfp') }}" class="glyphicons file"><i></i><span>ENVIADOS A SFP</span></a></li>
							<li class="text-small"><a href="{{ url('admin/declaraciones/envios-sfp/marcar') }}" class="glyphicons circle_ok"><i></i><span>MARCAR ENVÍO A SFP</span></a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuConsultas" class="glyphicons notes_2" data-toggle="collapse"><i></i><span>CONSULTAS</span></a>
				<ul id="submenuConsultas" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('admin/consultas/reporte-del-dia') }}" class="glyphicons history"><i></i><span>REPORTE DEL DÍA</span></a></li>
					<li><a href="{{ url('admin/consultas/declaraciones/realizadas') }}" class="glyphicons circle_plus"><i></i><span style="font-size: 8pt;">DECLARACIONES REALIZADAS</span></a></li>
					<li><a href="{{ url('admin/consultas/declaraciones/no-realizadas') }}" class="glyphicons circle_minus"><i></i><span style="font-size: 8pt;">DECLARACIONES NO REALIZADAS</span></a></li>
					<li class="text-small"><a href="{{ url('admin/consultas/declaraciones/omisos') }}" class="glyphicons remove"><i></i><span>OMISOS</span></a></li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuReportes" class="glyphicons stats" data-toggle="collapse"><i></i><span>REPORTES</span></a>
				<ul id="submenuReportes" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('admin/reportes/reporte-modificacion') }}" class="glyphicons collapse"><i></i><span>REPORTE DE MODIFICACIÓN</span></a></li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuAdmon" class="glyphicons cogwheels" data-toggle="collapse"><i></i><span>CONFIGURACIÓN</span></a>
				<ul id="submenuAdmon" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('registrar') }}" class="glyphicons ban"><i></i><span>DECLARACIONES NO REALIZADAS</span></a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- fin de menú -->