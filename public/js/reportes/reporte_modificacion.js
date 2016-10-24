jQuery(document).ready(function($) {
    var $formFiltro = $('#formFiltro');
    
    init();

    $formFiltro.validate();

    agregaValidacionesElementos($formFiltro);

    // buscar
    $('#buscar').on('click', function () {
        var url = $(this).data('url');

        if ($formFiltro.valid()) {
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

            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                $('#loadingGuardar').modal('hide');

                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
            });
        }
    });

    // exportar a PDF
    $('#resultadoBusqueda').on('click', 'button.pdf', function() {
        $('#opcion').val('excel');

        $formFiltro.submit();
    });
});