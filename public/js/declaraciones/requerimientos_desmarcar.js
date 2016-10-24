jQuery(document).ready(function($) {
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

    // desmarcar recepción de requerimiento
    $('#resultadoBusqueda').on('click', 'button.desmarcar', function() {
        var declaracionId = $(this).data('id');

        bootbox.confirm('SE PROCEDERÁ A DESMARCAR LA RECEPCIÓN DE REQUERIMIENTO DE ESTA DECLARACIÓN, ¿DESEA CONTINUAR?', function(event) {
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

            $('#resultadoBusqueda').find('#tabla').niceScroll();

        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');

            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
        });
    }
});