var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.less('admin/admin.less')
		.scripts([
				'components/library/jquery/jquery.min.js',
				'components/plugins/ajaxify/script.min.js',
				'components/library/modernizr/modernizr.js',
				'components/library/bootstrap/js/bootstrap.min.js',
				'components/library/jquery/jquery-migrate.min.js',
				'components/plugins/nicescroll/jquery.nicescroll.min.js',
				'components/plugins/breakpoints/breakpoints.js',
				'components/plugins/ajaxify/davis.min.js',
				'components/plugins/ajaxify/jquery.lazyjaxdavis.min.js',
				'components/plugins/preload/pace/pace.min.js',
				'components/modules/admin/modals/assets/js/bootbox.min.js',
				'components/plugins/less-js/less.min.js',
				'components/core/js/preload.pace.init.js',
				'components/core/js/sidebar.main.init.js',
				'components/core/js/sidebar.collapse.init.js',
				'components/core/js/sidebar.kis.init.js',
				'components/core/js/core.init.js',
				'components/core/js/animations.init.js',
				'components/core/js/hack768-1024.js',
				'components/common/forms/validator/assets/lib/jquery-validation/dist/jquery.validate.min.js',
				'components/common/forms/validator/assets/lib/jquery-validation/dist/additional-methods.min.js',
				'components/common/forms/validator/assets/lib/jquery-validation/dist/jquery.form.js',
				'components/common/forms/validator/assets/lib/jquery-validation/dist/validaciones.js',
				'components/common/forms/elements/bootstrap-datepicker/assets/lib/js/bootstrap-datepicker.js',
				'components/common/forms/elements/bootstrap-datepicker/assets/lib/js/locales/bootstrap-datepicker.es.js',
				'components/common/forms/elements/select2/assets/lib/js/select2.js',
				'components/common/forms/elements/fuelux-radio/fuelux-radio.js',
				'components/common/forms/elements/fuelux-checkbox/fuelux-checkbox.js',
				'components/common/forms/validaciones.js'
			],
			'public/js/base-scripts.js',
			'resources/assets'
		)
		.styles([
				'components/library/bootstrap/css/bootstrap.min.css',
				'components/library/icons/fontawesome/assets/css/font-awesome.min.css',
				'components/library/icons/glyphicons/assets/css/glyphicons_filetypes.css',
				'components/library/icons/glyphicons/assets/css/glyphicons_regular.css',
				'components/library/icons/glyphicons/assets/css/glyphicons_social.css',
				'components/library/jquery-ui/css/jquery-ui.min.css',
				'components/modules/admin/notifications/gritter/assets/lib/css/jquery.gritter.css',
				'components/modules/admin/notifications/notyfy/assets/lib/css/jquery.notyfy.css',
				'components/modules/admin/notifications/notyfy/assets/lib/css/notyfy.theme.default.css',
				'components/modules/admin/page-tour/assets/css/pageguide.css',
				'components/plugins/prettyprint/assets/css/prettify.css',
				'components/library/animate/animate.min.css',
				'components/common/forms/elements/bootstrap-datepicker/assets/lib/css/bootstrap-datepicker.css',
				'components/common/forms/elements/select2/assets/lib/css/select2.css',
				'components/library/icons/glyphicons/assets/css/glyphicons_filetypes.css',
				'components/library/icons/glyphicons/assets/css/glyphicons_regular.css',
				'components/library/icons/glyphicons/assets/css/glyphicons_social.css',
				'components/library/icons/pictoicons/css/picto.css',
				'components/library/icons/pictoicons/css/picto-foundry-general.css',
				],
			'public/css/base-styles.css',
			'resources/assets'
		)
		.copy([
				'resources/assets/components/library/icons/fontawesome/assets/fonts',
				'resources/assets/components/library/icons/glyphicons/assets/fonts',
				'resources/assets/components/library/icons/pictoicons/fonts',
				'resources/assets/components/core/fonts/'
			],
			'public/fonts'
		)
		.copy([
				'resources/assets/components/common/forms/elements/select2/assets/lib/css/select2.png',
				'resources/assets/components/common/forms/elements/select2/assets/lib/css/select2-spinner.gif',
				'resources/assets/components/common/forms/elements/select2/assets/lib/css/select2x2.png'
			], 'public/css'
		);
});