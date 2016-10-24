jQuery(document).ready(function($) {
    var $formFiltro = $('#formFiltro');
    
    init();

    $formFiltro.validate();

    agregaValidacionesElementos($formFiltro);

    $formFiltro.find('input.fecha').datepicker({
        format:    'dd/mm/yyyy',
        autoclose: true,
        language:  'es'
    });

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
                    bootbox.alert('Ocurrió un error al realizar la búsqueda.');
                    return false;
                }

                $('#resultadoBusqueda').html(respuesta.html);
                generarDatatables('tablaResultados');
                //$('#tablaResultados').DataTable();

            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                $('#loadingGuardar').modal('hide');

                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('Ocurrió un error al realizar la búsqueda.');
            });
        }
    });

    // exportar a excel
    $('#resultadoBusqueda').on('click', 'button.excel', function() {
        $('#opcion').val('excel');

        $formFiltro.submit();
    });
});