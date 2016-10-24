jQuery(document).ready(function($) {
    var $formFiltro = $('#formFiltro');

    init();

    onLoad();

    $formFiltro.validate();

    agregaValidacionesElementos($formFiltro);

    // buscar
    $('#buscar').on('click', function () {
        var url = $(this).data('url');

        if ($formFiltro.valid()) {
            buscar(url);
        }
    });

    // marcar envios a SFP
    $('#resultadoBusqueda').on('click', 'button.eliminar', function() {
        var data = {
            _token:        $formFiltro.find('input[name="_token"]').val(),
            declaracionId: $(this).data('id')
        };
        bootbox.confirm('SE PROCEDERÁ A ELIMINAR LA SANCIÓN DE LA DECLARACIÓN SELECCIONADA. ¿DESEA CONTINUAR?', function(event) {
            if (event) {
                $.ajax({
                    url:      $('#resultadoBusqueda').data('url'),
                    type:     'post',
                    dataType: 'json',
                    data:     data,
                    beforeSend: function () {
                        $('#loadingGuardar').modal('show');
                    }

                }).done(function (respuesta) {
                    $('#loadingGuardar').modal('hide');

                    if (respuesta.estatus === 'fail') {
                        bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR LA SANCIÓN DE LA DECLARACIÓN SELECCIONADA.');
                        return false;
                    }

                    if (respuesta.estatus === 'OK') {
                        bootbox.alert('LA SANCIÓN DE LA DECLARACIÓN FUE ELIMINADA CON ÉXITO', function () {
                            buscar($('#buscar').data('url'));
                        });
                    }

                }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#loadingGuardar').modal('hide');

                    console.log(textStatus + ': ' + errorThrown);
                    bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR LA SANCIÓN DE LA DECLARACIÓN SELECCIONADA.');
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

            onLoad();

        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');

            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
        });
    }

    function onLoad() {
        generarDatatables('tablaResultados');
    }
});