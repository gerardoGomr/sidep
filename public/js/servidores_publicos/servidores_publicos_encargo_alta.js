jQuery(document).ready(function ($) {
    // variables
    var $formAltaEncargo     = $('#formAltaEncargo'),
        $campoOtroPuesto     = $('#campoOtroPuesto'),
        $otroPuesto          = $('#otroPuesto'),
        $servidor            = $('#servidor'),
        $loadingBusqueda     = $('#loadingBusqueda'),
        $rutaBusqueda        = $('#rutaBusqueda'),
        $servidorRegistrado  = $('#servidorRegistrado'),
        $idServidorPublico   = $('#idServidorPublico'),
        $resultadosBusqueda  = $('#resultadosBusqueda');

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

    // select 2
    $('#puesto').select2();

    // buscar servidores públicos.- prevenir submit
    $servidor.on('keypress', function (event) {
        if (event === 13 || event.which === 13) {
            return false;
        }
    });

    $servidor.on('keyup', function (event) {
        if (event === 13 || event.which === 13) {
            buscarServidorPublico($(this).val());
        }
    });

    $('#buscarServidor').on('click', function(event) {
        event.preventDefault();
        buscarServidorPublico($servidor.val());
    });
    // ***************************************************************************

    // click en tabla
    $resultadosBusqueda.on('click', 'tr.resultados', function () {
        var id = $(this).data('id');
        bootbox.confirm('¿Usar a este servidor público?', function (event) {
            if (event === true) {
                $('#busquedaServidores').addClass('hide');
                $('#contenedorDatosServidor').removeClass('hide').addClass('pull-left');
                $('#contenedorFormPrincipal').removeClass('hide').addClass('pull-left');
                $servidorRegistrado.val('1');
                $idServidorPublico.val(id);
            }
        });
    });

    // click en botón nuevo servidor
    $('#nuevoServidor').on('click', function () {
        nuevoServidor();
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
            $.ajax({
                url:      $formAltaEncargo.attr('action'),
                type:     'post',
                dataType: 'json',
                data:     $formAltaEncargo.serialize(),
                beforeSend: function () {
                    $('#loadingGuardar').removeClass('hide');
                }
            })
            .done(function (respuesta) {
                $('#loadingGuardar').addClass('hide');
                if (respuesta.resultado === 'fail') {
                    bootbox.alert('Ocurrió un error al generar el alta del encargo del servidor público. Por favor, intente de nuevo.');
                    return false;
                }

                bootbox.alert('Alta de encargo de servidor público generada con éxito.', function () {
                    window.location.href = $('#rutaBase').val();
                });
            })
            .fail(function (jQxr, textStatus, errorThrown) {
                $('#loadingGuardar').addClass('hide');
                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('Ocurrió un error al realizar la operación solicitada. Intente de nuevo.');
            });
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

    /**
     * agregar las validaciones pertinentes al formulario de captura
     */
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

    /**
     * buscar un servidor mediante el dato enviado
     * @param string dato
     */
    function buscarServidorPublico(dato)
    {
        $.ajax({
            url:      $rutaBusqueda.val(),
            type:     'post',
            dataType: 'json',
            data:     {dato: dato, _token: $formAltaEncargo.find('input[name="_token"]').val(), origen: 'alta'},
            beforeSend: function () {
                $loadingBusqueda.removeClass('hide');
            }
        })
        .done(function (respuesta) {
            $loadingBusqueda.addClass('hide');
            if (respuesta.resultado === 'fail') {
                bootbox.alert('No se encontraron coincidencias.', function () {
                    $resultadosBusqueda.html('');
                    $servidorRegistrado.val('0');
                    nuevoServidor();
                })
                return false;
            }

            $resultadosBusqueda.html(respuesta.contenido);
        })
        .fail(function (jQxr, textStatus, errorThrown) {
            $loadingBusqueda.addClass('hide');
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('Ocurrió un error al realizar la operación solicitada. Intente de nuevo.')
        });
    }

    /**
     * registrar a nuevo servidor público
     */
    function nuevoServidor()
    {
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
    }
});