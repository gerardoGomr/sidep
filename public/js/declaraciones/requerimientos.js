jQuery(document).ready(function($) {
    generarDatatables('tablaResultados');

    var $formFiltro = $('#formFiltro');

    init();

    $formFiltro.validate();

    agregaValidacionesElementos($formFiltro);

    // buscar
    $('#buscar').on('click', function () {
        var url = $(this).data('url');

        if ($formFiltro.valid()) {
            buscar(url);
        }
    });

    // eliminar totalmente el requerimiento generado
    $('#resultadoBusqueda').on('click', 'button.eliminar', function() {
        var declaracionId = $(this).data('id');

        bootbox.confirm('SE PROCEDERÁ A ELIMINAR EL REQUERIMIENTO DE ESTA DECLARACIÓN, ¿DESEA CONTINUAR?', function(event) {
            if (event) {
                $.ajax({
                    url:      $('#resultadoBusqueda').data('url'),
                    type:     'post',
                    dataType: 'json',
                    data:     {declaracionId: declaracionId, _token: $formFiltro.find('input[name="_token"]').val()},
                    beforeSend: function () {
                        $('#loadingGuardar').modal('show');
                    }

                }).done(function (respuesta) {
                    $('#loadingGuardar').modal('hide');

                    if (respuesta.estatus === 'fail') {
                        var mensaje = '';

                        if (respuesta.mensaje !== '') {
                            mensaje = respuesta.mensaje;
                        }

                        bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR EL REQUERIMIENTO DE ESTA DECLARACIÓN. ' + mensaje);
                    }

                    if (respuesta.estatus === 'OK') {
                        bootbox.alert('REQUERIMIENTO ELIMINADO CON ÉXITO', function () {
                            // recargar sección
                            buscar($('#buscar').data('url'));
                        });
                    }

                }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#loadingGuardar').modal('hide');

                    console.log(textStatus + ': ' + errorThrown);
                    bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR EL REQUERIMIENTO DE ESTA DECLARACIÓN.');
                });
            }
        });
    });

    $('#resultadoBusqueda').on('click', 'a.pdf', function() {
        $(this).parents('td').siblings('td.columna').children('span').removeClass('envelope').addClass('message_empty');
    });

    // desmarcar recepción de requerimiento
    $('#resultadoBusqueda').on('click', 'button.desmarcar', function() {
        var declaracionId = $(this).data('id');

        bootbox.confirm('SE PROCEDERÁ A DESMARCAR LA RECEPCIÓN DE REQUERIMIENTO DE ESTA DECLARACIÓN, ¿DESEA CONTINUAR?', function(event) {
            if (event) {
                $.ajax({
                    url:      $('#resultadoBusqueda').data('url-desmarcar'),
                    type:     'post',
                    dataType: 'json',
                    data:     {declaracionId: declaracionId, _token: $formFiltro.find('input[name="_token"]').val()},
                    beforeSend: function () {
                        $('#loadingGuardar').modal('show');
                    }

                }).done(function (respuesta) {
                    $('#loadingGuardar').modal('hide');

                    if (respuesta.estatus === 'fail') {
                        bootbox.alert('OCURRIÓ UN ERROR AL DESMARCAR LA RECEPCIÓN DE REQUERIMIENTO DE ESTA DECLARACIÓN.');
                    }

                    if (respuesta.estatus === 'OK') {
                        bootbox.alert('RECEPCIÓN DE REQUERIMIENTO DESMARCADO CON ÉXITO', function () {
                            // recargar sección
                            buscar($('#buscar').data('url'));
                        });
                    }

                }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#loadingGuardar').modal('hide');

                    console.log(textStatus + ': ' + errorThrown);
                    bootbox.alert('OCURRIÓ UN ERROR AL DESMARCAR LA RECEPCIÓN DE REQUERIMIENTO DE ESTA DECLARACIÓN.');
                });
            }
        });
    });

    function buscar(url) {
        $.ajax({
            url:      url,
            type:     'post',
            dataType: 'json',
            data:     $formFiltro.serialize(),
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }

        }).done(function (respuesta) {
            $('#loadingGuardar').modal('hide');

            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
                return false;
            }

            $('#resultadoBusqueda').html(respuesta.html);

            generarDatatables('tablaResultados');
            $('#resultadoBusqueda').find('#tablaResultados').niceScroll();

        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');

            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
        });
    }
});