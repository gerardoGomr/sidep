jQuery(document).ready(function ($) {
    // variables
    var $tablaResultados     = $('#tablaResultados'),
        $formAltaEncargo     = $('#formAltaEncargo'),
        $campoOtroPuesto     = $('#campoOtroPuesto'),
        $otroPuesto          = $('#otroPuesto');

    // focus
    setTimeout(function () {
        $('#servidor').focus();
    }, 500);

    // iniciar validaciones
    init();

    // validar form
    $formAltaEncargo.validate();
    agregaValidacionesElementos($formAltaEncargo);

    // datepicker
    $formAltaEncargo.find('input.fecha').datepicker({
        format:    'dd/mm/yyyy',
        language:  'es',
        autoclose: true
    });

    $('#puesto').select2();

    // click en tabla
    $tablaResultados.on('click', 'tr.resultados', function () {
        bootbox.confirm('¿Usar a este servidor público?', function (event) {
            if (event === true) {
                $('#busquedaServidores').addClass('hide');
                $('#contenedorFormPrincipal').removeClass('hide').addClass('pull-left');
            }
        });
    });

    // click en botón nuevo servidor
    $('#nuevoServidor').on('click', function () {
        bootbox.confirm('Ingrese los datos del servidor público para agregarlo al padrón.', function (event) {
            if (event === true) {
                $('#busquedaServidores').addClass('hide');
                $('#contenedorFormServidor').removeClass('hide').addClass('pull-left');
                $('#contenedorFormPrincipal').removeClass('hide').addClass('pull-left');

                // validaciones
                agregarValidacionesCamposServidorPublico();

                // focus
                setTimeout(function () {
                    $('#nombre').focus();
                }, 500);
            }
        });
    });

    // click en exento
    $('#exento').on('click', function () {
        if ($(this).attr('checked') === 'checked') {
            bootbox.alert('Al elegir esta opción, NO se generará una declaración inicial', function () {
                $('#textoExento').removeClass('hide');
            });
        } else {
            $('#textoExento').addClass('hide');
        }
    });

    // click en guardar
    $('#guardar').on('click', function () {
        if ($formAltaEncargo.valid() === true) {
            alert('guardado');
        }
    });

    // seleccion de otro puesto
    $('#puesto').on('change', function () {
        if ($(this).val() === '1') {
            $campoOtroPuesto.removeClass('hide');
            $otroPuesto.addClass('required').focus();
        } else {
            $campoOtroPuesto.addClass('hide');
            $otroPuesto.rules('remove');
            $otroPuesto.removeClass('required').removeClass('error').val('');
        }
    });

    // click en cancelar
    $('#cancelar').on('click', function (event) {
        event.preventDefault();
        
        bootbox.confirm('¿Desea cancelar el registro de alta del servidor público?', function (e) {
            if (e === true) {
                window.location.href = $('#cancelar').attr('href');
            }
        });
    });

    function agregarValidacionesCamposServidorPublico()
    {
        $('#nombre, #paterno, #materno, #fechaNacimiento, #calle, #noExterior, #coloniaLocalidad, #municipio').addClass('required');
        $('#curp')
            .addClass('required')
            .rules('add', {
            'maxlength': 18,
            'minlength': 18,
            messages: {
                'maxlength': 'Se necesitan al menos 18 caracteres',
                'minlength': 'Se necesitan al menos 18 caracteres'
            }
        });
        $('#rfc')
            .addClass('required')
            .rules('add', {
            'maxlength': 13,
            'minlength': 10,
            messages: {
                'maxlength': 'Máximo 13 caracteres',
                'minlength': 'Se necesitan al menos 10 caracteres'
            }
        });
    }
});