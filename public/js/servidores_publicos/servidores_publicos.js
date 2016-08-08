jQuery(document).ready(function($) {
    // variables
    var $busquedaServidores          = $('#busquedaServidores'),
        $formBusqueda                = $('#formBusqueda'),
        $fichaTecnicaLoading         = $('#fichaTecnicaLoading'),
        $fichaTecnica                = $('#fichaTecnica'),
        $dato                        = $('#dato'),
        $resultadoBusquedaServidores = $('#resultadoBusquedaServidores'),
        _token                       = $formBusqueda.find('input[name="_token"]').val();

    // focus
    setTimeout(function() {
        $dato.focus();
    }, 500);

    $('#fechaBaja').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'es'
    }).on('show', function() {
        // Obtener valores actuales z-index de cada elemento
        var zIndexModal = $('#modalMotivoBaja').css('z-index'),
            zIndexFecha = $('.datepicker').css('z-index');

        $('.datepicker').css('z-index', zIndexModal + 1);
    });

    // iniciar validaciones
    init();

    // validar forms
    $('#formBaja').validate();
    $('#formCambioAdscripcion').validate();
    $('#formPromocion').validate();
    // validar el formulario
    agregaValidacionesElementos($('#formBaja'));
    agregaValidacionesElementos($('#formCambioAdscripcion'));
    agregaValidacionesElementos($('#formPromocion'));

    // select 2
    $('#puesto').select2();

    // evento de búsqueda de encargos de servidores públicos
    $dato.on('keypress', function (event) {
        if (event === 13 || event.which === 13) {
            return false;
        }
    });

    $dato.on('keyup', function (event) {
        if (event === 13 || event.which === 13) {
            $.ajax({
                url:      $formBusqueda.attr('action'),
                type:     'post',
                dataType: 'json',
                data:     $formBusqueda.serialize(),
                beforeSend: function () {
                    $('#loadingGuardar').modal('show');
                }
            }).done(function(resultado) {
                $('#loadingGuardar').modal('hide');
                $resultadoBusquedaServidores.html(resultado.contenido);

            }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
                $('#loadingGuardar').modal('hide');
                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('Imposible realizar la operación solicitada')
            });
        }
    });

    /* click sobre un elemento de la lista de servidores
    borrar al que quedó activo previamente
    y setear al nuevo activo.
    En seguida realizar la búsqueda AJAX
     */
    $resultadoBusquedaServidores.on('click', 'li.list-group-item', function (event) {
        $resultadoBusquedaServidores.find('li.active').removeClass('active');
        $(this).addClass('active');
        var id = $(this).data('id');

        $.ajax({
            url:      $resultadoBusquedaServidores.data('url'),
            type:     'post',
            dataType: 'json',
            data:     {id: id, _token: _token},
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }
        }).done(function (resultado){
            $('#loadingGuardar').modal('hide');
            $fichaTecnica.removeClass('hide');
            $fichaTecnica.html(resultado.contenido);

        }).fail(function (a, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('Imposible realizar la operación solicitada')
        });
    });

    // click para dar de baja a servidor público
    $fichaTecnica.on('click', 'button.baja', function () {
        // setear el id del encargo
        $('#formBaja').find('input.encargoId').val($(this).data('id'));
        $('#modalMotivoBaja').modal('show');
    });

    // click para confirmar la baja
    $('#confirmarBaja').on('click', function () {
        if (!$('#formBaja').valid()) {
            return false;
        }

        bootbox.confirm('SE PROCEDERÁ A REALIZAR LA BAJA DE ENCARGO DE ESTE SERVIDOR PÚBLICO, ¿DESEA CONTINUAR?', function(e) {
            if (e) {
                $.ajax({
                    url:      $('#formBaja').attr('action'),
                    type:     'post',
                    dataType: 'json',
                    data:     $('#formBaja').serialize(),
                    beforeSend: function () {
                        $('#loadingGuardar').modal('show');
                    }

                }).done(function (resultado){
                    $('#loadingGuardar').modal('hide');

                    if (resultado.estatus === 'fail') {
                        bootbox.alert("OCURRIÓ UN ERROR AL REALIZAR LA BAJA DE ENCARGO DEL SERVIDOR PÚBLICO.\n" + resultado.error);
                    }

                    if (resultado.estatus === 'OK') {
                        $fichaTecnica.html(resultado.html);
                        bootbox.alert("SE REGISTRÓ LA BAJA DE ENCARGO DEL SERVIDOR PÚBLICO DE MANERA EXITOSA.", function () {
                            $('#modalMotivoBaja').modal('hide');
                        });
                    }

                }).fail(function (a, textStatus, errorThrown) {
                    $('#loadingGuardar').modal('hide');
                    console.log(textStatus + ': ' + errorThrown);
                    bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BAJA DE ENCARGO DEL SERVIDOR PÚBLICO.');
                });
            }
        });
    });

    // click para abrir modal de cambio de adscripción
    $fichaTecnica.on('click', 'button.cambioAdscripcion', function() {
        $('#formCambioAdscripcion').find('input.encargoId').val($(this).data('id'));
        $('#adscripcionActual').text($(this).data('adscripcion'));
        $('#modalCambioAdscripcion').modal('show');
    });

    // click para realizar el cambio de adscripción
    $('#actualizarAdscripcion').on('click', function() {
        if (!$('#formCambioAdscripcion').valid()) {
            return false;
        }

        $.ajax({
            url:      $('#formCambioAdscripcion').attr('action'),
            type:     'post',
            dataType: 'json',
            data:     $('#formCambioAdscripcion').serialize(),
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }

        }).done(function (resultado){
            $('#loadingGuardar').modal('hide');

            if (resultado.estatus === 'fail') {
                var error = resultado.error !== '' ? resultado.error : '';
                bootbox.alert("OCURRIÓ UN ERROR AL REALIZAR EL CAMBIO DE ADSCRIPCIÓN AL ENCARGO DEL SERVIDOR PÚBLICO.\n" + error);
            }

            if (resultado.estatus === 'OK') {
                $fichaTecnica.html(resultado.html);
                bootbox.alert("SE REGISTRÓ EL CAMBIO DE ADSCRIPCIÓN DEL ENCARGO DEL SERVIDOR PÚBLICO DE MANERA EXITOSA.", function () {
                    $('#modalCambioAdscripcion').modal('hide');
                });
            }

        }).fail(function (a, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR EL CAMBIO DE ADSCRIPCIÓN AL ENCARGO DEL SERVIDOR PÚBLICO.');
        });
    });

    // click para abrir modal de promoción
    $fichaTecnica.on('click', 'button.promocion', function() {
        $('#formPromocion').find('input.encargoId').val($(this).data('id'));
        $('#formPromocion').find('input.adscripcion').val($(this).data('adscripcion'));
        $('#modalPromocion').modal('show');
    });

    // registrar la promoción
    $('#realizarPromocion').on('click', function() {
        if (!$('#formPromocion').valid()) {
            return false;
        }

        $.ajax({
            url:      $('#formPromocion').attr('action'),
            type:     'post',
            dataType: 'json',
            data:     $('#formPromocion').serialize(),
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }

        }).done(function (resultado){
            $('#loadingGuardar').modal('hide');

            if (resultado.estatus === 'fail') {
                var error = resultado.error !== '' ? resultado.error : '';
                bootbox.alert("OCURRIÓ UN ERROR AL REALIZAR LA PROMOCIÓN DEL ENCARGO DEL SERVIDOR PÚBLICO.\n" + error);
            }

            if (resultado.estatus === 'OK') {
                $fichaTecnica.html(resultado.html);
                bootbox.alert("SE REGISTRÓ LA PROMOCIÓN DEL ENCARGO DEL SERVIDOR PÚBLICO DE MANERA EXITOSA.", function () {
                    window.open($('#rutaCartaCompromiso').val() + '/' + resultado.id, '_blank');
                    $('#modalPromocion').modal('hide');
                });
            }

        }).fail(function (a, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA PROMOCIÓN DEL ENCARGO DEL SERVIDOR PÚBLICO.');
        });
    });
});