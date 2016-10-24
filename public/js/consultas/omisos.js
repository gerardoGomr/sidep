jQuery(document).ready(function($) {
    var $formFiltro = $('#formFiltro');
    
    init();

    $formFiltro.validate();

    agregaValidacionesElementos($formFiltro);

    $('input.fecha').datepicker({
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
                    bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
                    return false;
                }

                $('#resultadoBusqueda').html(respuesta.html);
                //generarDatatables('tablaResultados');

                var $formMarcar = $('#resultadoBusqueda').find('#formMarcar');
                $formMarcar.validate();
                agregaValidacionesElementos($formMarcar);
                $formMarcar.find('input.fecha').datepicker({
                    format:    'dd/mm/yyyy',
                    autoclose: true,
                    language:  'es'
                });

                $('#resultadoBusqueda').find('#tabla').niceScroll();

            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                $('#loadingGuardar').modal('hide');

                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA.');
            });
        }
    });

    // exportar a excel
    $('#resultadoBusqueda').on('click', 'button.excel', function() {
        $('#opcion').val('excel');

        $formFiltro.submit();
    });

    // marcar omisos
    $('#resultadoBusqueda').on('click', 'button.marcar', function() {
        var $formMarcar = $('#resultadoBusqueda').find('#formMarcar');

        if ($formMarcar.valid()) {
            bootbox.confirm('SE PROCEDERÁ A MARCAR A ESTAS DECLARACIONES PARA ENVÍO DE REQUERIMIENTOS CON FECHA ' + $formMarcar.find('input.fecha').val() + '. ¿DESEA CONTINUAR?', function(event) {
                if (event) {
                    $.ajax({
                        url:      $formMarcar.attr('action'),
                        type:     'post',
                        dataType: 'json',
                        data:     $formMarcar.serialize(),
                        beforeSend: function () {
                            $('#loadingGuardar').modal('show');
                        }

                    }).done(function (respuesta) {
                        $('#loadingGuardar').modal('hide');

                        if (respuesta.estatus === 'fail') {
                            bootbox.alert('OCURRIÓ UN ERROR AL MARCAR PARA REQUERIMIENTOS A LOS OMISOS ESPECIFICADOS.');
                            return false;
                        }

                        if (respuesta.estatus === 'OK') {
                            bootbox.alert('OMISOS MARCADOS CON ÉXITO', function () {
                                // redirigir a pantalla de requerimientos
                                window.location.href = $('#urlRequerimientos').val();
                            });
                        }

                    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                        $('#loadingGuardar').modal('hide');

                        console.log(textStatus + ': ' + errorThrown);
                        bootbox.alert('OCURRIÓ UN ERROR AL MARCAR PARA REQUERIMIENTOS A LOS OMISOS ESPECIFICADOS.');
                    });
                }
            });
        }
    });
});