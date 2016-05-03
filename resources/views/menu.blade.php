<!-- menu de la izquierda -->
<div id="menu" class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">
	<div id="sidebar-fusion-wrapper">
		<div id="brandWrapper" class="custom-logo" style="background: url('public/img/fondo.png') repeat-x">
			 <a href="{{ url('/') }}" class="display-block-inline pull-left">
			 	<img src="{{ asset('public/img/logo_255.png') }}" border="0" alt="Centro Estatal de Control de Confianza Certificado">
			 </a>
		</div>
		<div id="logoWrapper">
			<div id="logo">
				<a href="{{ url('/') }}" class="btn btn-sm btn-inverse"><i class="fa fa-home"></i></a>
				<a href="email.html?lang=en" class="btn btn-sm btn-inverse"><i class="fa fa-envelope"></i><span class="badge pull-right badge-primary">2</span></a>
			</div>
		</div>
		<ul class="menu list-unstyled" id="navigation_current_page">
			<li class="reset profile-avatar">
				<div class="tab-content">
					<div class="tab-pane active" id="profile_avatar_large">
						<div class="profile-avatar innerT">
							<div class="text-center innerTB">
								<span class="display-block-inline animated bounceIn"><img src="{{ asset('public/img/50x50.png') }}" class="img-responsive img-circle thumb" /></span>
							</div>
						</div>
						<div class="innerAll">
							<h4 class="text-white margin-none"><i class="fa text-small fa-circle text-success pull-right"></i> {{ request()->session()->get('usuario')->nombreCompleto() }}</h4>
							<p class="margin-none text-muted text-small">Director</p>
						</div>
					</div>
				</div>
			</li>
			<li class="active">
				<a href="{{ url('registrar') }}" class="glyphicons file_import"><i></i><span>Registrar oficios</span></a>
			</li>
			<li>
				<a href="{{ url('redactar') }}" class="glyphicons circle_plus"><i></i><span>Redactar documento</span></a>
			</li>

			<li>
				<a href="{{ url('oficios-recibidos') }}" class="glyphicons file_import"><i></i><span>Oficios recibidos</span></a>
			</li>
		</ul>
	</div>
</div>
<!-- fin de menú -->