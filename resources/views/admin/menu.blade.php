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
		<ul class="menu list-unstyled text-small" id="navigation_components">
			{!! $menu !!}
		</ul>
	</div>
</div>
<!-- fin de menú -->