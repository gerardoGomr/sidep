/**
 * inicializar validador
 * @return void
 */

function init()
{
	// overriding default values
	$.validator.setDefaults({
		highlight: function(element) {
			jQuery(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-error');
		},
		errorElement: 'span',
		errorClass: 'label label-danger',
		errorPlacement: function(error, element) {
			if(element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		}
	});

	// inicializar mensajes
	$.validator.messages.digits   = 'Ingrese solo números';
	$.validator.messages.required = 'Campo obligatorio';
	$.validator.messages.email    = 'Ingrese un email válido';

	// inicializar metodos
	$.validator.addMethod("numeros", function(value,element){
        return this.optional(element) || /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/i.test(value);
    },"Ingrese una fecha con formato dd/mm/aaaa");
}

/**
 * agregar validaciones a inputs a través de una clase
 * @param  string clase
 * @return bool
 */
function validaClase(clase)
{
	// objeto reglas
	var rules;

	switch(clase) {
		case 'required':
			rules = {
				required: true
			};
			break;

		case 'numerosEnteros':
			rules = {
				digits: true
			};
			break;

		case 'fechas':
			rules = {
				numeros: true
			};
			break;

		case 'imagenJpg':
			rules = {
				extension: 'jpg',
				messages: {
					extension: 'Adjuntar en formato jpg'
				}
			};
			break;

		default:
			return false;
	}

	$.validator.addClassRules(clase, rules);

	return true;
}

/**
 * agregar validaciones a un elemento del formulario
 * @param  string id
 * @return void
 */
function agregaValidacionAElemento(elemento, validacion)
{
	switch(validacion) {
		case 'required':
			rules = {
				required: true
			};
			break;

		case 'numerosEnteros':
			rules = {
				digits: true
			};
			break;

		case 'fechas':
			rules = {
				numeros: true
			};
			break;

		case 'imagenJpg':
			rules = {
				extension: 'jpg',
				messages: {
					extension: 'Adjuntar en formato jpg'
				}
			};
			break;

		default:
			return false;
	}

	$('#' + elemento).rules('add', rules);
}

/**
 * remover todas la validaciones agregadas al elementp
 * @return void
 */
function quitarValidacionesAElemento(elemento)
{
	$('#' + elemento).rules('remove');
	$('#' + elemento).removeClass("error");
}

/**
 * agregar validaciones a elementos del formulario
 * @param  $.form $form
 * @return void
 */
function agregaValidacionesElementos($form)
{
	$form.find('.required').each(function() {
		$(this).rules('add', {
			required: true
		});
	});

	$form.find('.numerosEnteros').each(function() {
		$(this).rules('add', {
			digits: true
		});
	});

	$form.find('.fechas').each(function() {
		$(this).rules('add', {
			numeros: true
		});
	});

	$form.find('.imagenJpg').each(function() {
		$(this).rules('add', {
			extension: 'jpg'
		});
	});

	$form.find('.email').each(function() {
		$(this).rules('add', {
			email: true
		});
	});

	$form.find('.pdf').each(function() {
		$(this).rules('add', {
			extension: 'pdf',
			messages: {
				extension: 'EL ARCHIVO DEBE ESTAR EN .pdf'
			}
		});
	});

	$form.find('.xlsx').each(function() {
		$(this).rules('add', {
			extension: 'xlsx',
			messages: {
				extension: 'EL ARCHIVO DEBE ESTAR EN .xlsx'
			}
		});
	});
}