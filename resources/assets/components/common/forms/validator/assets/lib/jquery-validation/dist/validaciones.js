/**
 * inicializar validador
 * @return void
 */

function init()
{
	// overriding default values
	$.validator.setDefaults({
		showErrors: function(map, list) {
			this.currentElements.parents('label:first, div:first').find('.has-error').remove();
			this.currentElements.parents('.form-group:first').removeClass('has-error');

			$.each(list, function(index, error) {
				var ee = $(error.element);
				var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');

				ee.parents('.form-group:first').addClass('has-error');
				eep.find('.has-error').remove();
				eep.append('<p class="has-error help-block">' + error.message + '</p>');
			});
		}
	});

	// inicializar mensajes
	$.validator.messages.digits   = 'Ingrese solo números';
	$.validator.messages.required = 'Campo obligatorio';

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
}