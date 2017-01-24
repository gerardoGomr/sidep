<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html class=""> <![endif]-->
<!--[if !IE]><!--><html class=""><!-- <![endif]-->
	<head>
		<title>CENTRO ESTATAL DE CONTROL DE CONFIANZA CERTIFICADO.- SIDEP</title>

		<!-- Meta -->
		<meta charset="utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

		<!-- CSS DEFINITION -->
		<link rel="shortcut icon" href="{{ asset('public/img/logo.png') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/base-styles.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/front.css') }}" />

		@yield('css')

		<script>
			if (/*@cc_on!@*/false && document.documentMode === 10) {
				document.documentElement.className+=' ie ie10';
			}
		</script>

	</head>

	<body>
		<!-- Main Container Fluid -->
		<div class="container-fluid">
			@include('declarantes.navbar')
			<!-- Content -->
			<div id="content">
				@yield('contenido')
			</div>

			<!-- Footer -->
			<div id="footer" class="hidden-print">
				<div class="container">
					<ul class="list-unstyled center">
						<li><a href="index.html?lang=en" >Declaración de situación patrimonial</a></li>
						<li><a href="portfolio.html?lang=en">Ley de Responsabilidad de Servidores Públicos del Estado</a></li>
						<li><a href="pricing.html?lang=en">Acuerdo de Declaración de Situación Patrimonial</a></li>
						<li><a href="blog.html">Tutorial</a></li>
						<li><a href="contact.html?lang=en">Datos de Contacto</a></li>
					</ul>
					<!--  Copyright Line -->
					<div class="copy">&copy; {{ date('Y') }} - <a href="#">SIDEP v2.0</a> - SISTEMA INTEGRAL DE DECLARACIONES PATRIMONIALES C3 - UNIDAD DE INFORMÁTICA</div>
					<!--  End Copyright Line -->
					<div class="copy margin-none"><a>1a. Av. Sur Oriente #290 Esq. 2a Oriente Sur Col. Centro, C. P. 29000; Tuxtla Gutiérrez, Chiapas. Conmutador: 01 961 618 93 00 ext. red. 64009, 64115, 64136 y 64138 patrimonialchiapas@gmail.com</a></div>
				</div>
			</div>
			<!-- Footer END -->
		</div>

		<script data-id="App.Config">
			var basePath           = '',
				commonPath         = '/assets/',
				rootPath           = '',
				DEV                = false,
				componentsPath     = '/assets/components/',
				layoutApp          = false,
				module             = 'admin',
				primaryColor       = '#013f78',
				dangerColor        = '#b55151',
				successColor       = '#609450',
				infoColor          = '#4a8bc2',
				warningColor   	   = '#ab7a4b',
				inverseColor   	   = '#45484d',
				themerPrimaryColor = primaryColor;
		</script>

		<script src="{{ asset('public/js/base-scripts.js') }}"></script>
		@yield('js')
	</body>
</html>