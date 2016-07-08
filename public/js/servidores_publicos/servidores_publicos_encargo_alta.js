jQuery(document).ready(function ($) {
    // variables
    var $formAltaEncargo     = $('#formAltaEncargo'),
        $campoOtroPuesto     = $('#campoOtroPuesto'),
        $otroPuesto          = $('#otroPuesto'),
        $datoServidor        = $('#datoServidor'),
        $loadingBusqueda     = $('#loadingBusqueda'),
        $rutaBusqueda        = $('#rutaBusqueda'),
        $servidorRegistrado  = $('#servidorRegistrado'),
        $idServidorPublico   = $('#idServidorPublico'),
        $resultadosBusqueda  = $('#resultadosBusqueda');

    // focus
    setTimeout(function () {
        $datoServidor.focus();
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
    $datoServidor.on('keypress', function (event) {
        if (event === 13 || event.which === 13) {
            return false;
        }
    });

    $datoServidor.on('keyup', function (event) {
        if (event === 13 || event.which === 13) {
            buscarServidorPublico($(this).val());
        }
    });

    $('#buscarServidor').on('click', function(event) {
        event.preventDefault();
        buscarServidorPublico($datoServidor.val());
    });
    // ***************************************************************************

    // click en tabla de resultado de servidor público
    $resultadosBusqueda.on('click', 'tr.resultados', function () {
        var id       = $(this).data('id'),
            elemento = $(this);

        bootbox.confirm('SE REGISTRARÁ UNA NUEVA ALTA DE ENCARGO A ' + $(this).children('td.nombre').text() + ', ¿DESEA CONTINUAR?', function (event) {
            if (event === true) {

                setearDatosDeServidorAContenedor(elemento);

                $('#contenedorBusquedaServidorPublico').addClass('hide');

                $('#contenedorServidorPublico').removeClass('hide');
                $('#presentaDatosPersonales').removeClass('hide');
                $servidorRegistrado.val('1');
                $('#busquedaServidor').val('1');
                $idServidorPublico.val(id);
                $('#cerrrModal').click();
            }
        });
    });

    // cambiar servidor
    $('#cambiarServidor').on('click', function () {
        $('#contenedorBusquedaServidorPublico').removeClass('hide');

        $('#contenedorServidorPublico').addClass('hide');
        $('#presentaDatosPersonales').addClass('hide');
    });

    // click en exento
    $('#exento').on('click', function () {
        if ($(this).attr('checked') === 'checked') {
            bootbox.alert('AL ELEGIR EXENTO, NO SE GENERARÁ LA DECLARACIÓN INICIAL A ESTE ENCARGO DE SERVIDOR PÚBLICO.', function () {
                $('#textoExento').removeClass('hide');
            });
        } else {
            $('#textoExento').addClass('hide');
        }
    });

    // click en guardar
    $('#guardar').on('click', function () {
        if ($formAltaEncargo.valid() === true) {

            if ($('#busquedaServidor').val() === '0') {
                bootbox.alert('POR FAVOR, BUSQUE Y SELECCIONE A UN SERVIDOR PÚBLICO DEL CATÁLOGO O AGREGUE SUS DATOS EN CASO DE QUE NO EXISTA.');
                $datoServidor.focus();
                return false;
            }

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
                if (respuesta.estatus === 'fail') {
                    bootbox.alert("OCURRIÓ UN ERROR AL GUARDAR EL ENCARGO DEL SERVIDOR PÚBLICO. INTENTE DE NUEVO.\n" + respuesta.error);
                }

                if (respuesta.estatus === 'OK') {
                    bootbox.alert('ALTA DE ENCARGO DE SERVIDOR PÚBLICO GUARDADA CON ÉXITO.', function () {
                        // abrir carta compromiso
                        window.open($('#rutaCartaCompromiso').val() + '/' + respuesta.id, '_blank');

                        // abrir comprobante cuenta acceso
                        window.open($('#rutaComprobanteCuentaAcceso').val() + '/' + respuesta.id + '/' + btoa(respuesta.pass), '_blank');

                        // redireccionar a vista de administración de usuarios
                        window.location.href = $('#rutaBase').val();
                    });
                }
            })
            .fail(function (jQxr, textStatus, errorThrown) {
                $('#loadingGuardar').addClass('hide');
                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('OCURRIÓ UN ERROR AL GUARDAR EL ENCARGO DEL SERVIDOR PÚBLICO. INTENTE DE NUEVO.');
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

        bootbox.confirm('¿DESEA CANCELAR EL REGISTRO DE ALTA DE ENCARGO DE SERVIDOR PÚBLICO?', function (e) {
            if (e === true) {
                window.location.href = $('#cancelar').attr('href');
            }
        });
    });

    function setearDatosDeServidorAContenedor(elementoConDatos)
    {
        $('#presentaNombre').text(elementoConDatos.children('td.nombre').text());
        $('#presentaFechaNacimiento').text(elementoConDatos.children('td.otrosDatos').children('input.fechaNacimiento').val());
        $('#presentaCurp').text(elementoConDatos.children('td.curp').text());
        $('#presentaRfc').text(elementoConDatos.children('td.rfc').text());
        $('#presentaTelefono').text(elementoConDatos.children('td.otrosDatos').children('input.telefono').val());
        $('#presentaEmail').text(elementoConDatos.children('td.otrosDatos').children('input.email').val());
        $('#presentaEstadoCivil').text(elementoConDatos.children('td.otrosDatos').children('input.estadoCivil').val());
        $('#presentaDomicilio').text(elementoConDatos.children('td.domicilio').text());
    }

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
                bootbox.alert('NO SE ENCONTRARON COINCIDENCIAS CON EL DATO DE BÚSQUEDA. POR FAVOR, CAPTURE LOS DATOS DEL SERVIDOR PÚBLICO.', function () {
                    $resultadosBusqueda.html('');
                    $servidorRegistrado.val('0');
                    nuevoServidor();
                })
                return false;
            }

            $resultadosBusqueda.html(respuesta.contenido);
            $('#abrirModal').click();
            //$('#resultadoServidor').modal('show');
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
        //bootbox.confirm('Ingrese los datos del servidor público para agregarlo al padrón.', function (event) {
           // if (event === true) {
        $('#contenedorBusquedaServidorPublico').addClass('hide');

        $('#contenedorServidorPublico').removeClass('hide');
        $('#capturaDatosPersonales').removeClass('hide');
        $('#capturaDatosDomicilio').removeClass('hide');

        // validaciones
        agregarValidacionesCamposServidorPublico();

        $('#busquedaServidor').val('1');

        // focus
        setTimeout(function () {
            $('#nombre').focus();
        }, 500);
            //}
        //});
    }
});