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
    $('#resultadoBusqueda').on('click', 'button.marcar', function() {
        var $formMarcar = $('#resultadoBusqueda').find('#formMarcar');

        if ($formMarcar.valid()) {
            bootbox.confirm('SE PROCEDERÁ A MARCAR A ESTAS DECLARACIONES PARA ENVÍO A SECRETARÍA DE LA FUNCIÓN PÚBLICA CON FECHA ' + $formMarcar.find('input.fecha').val() + '. ¿DESEA CONTINUAR?', function(event) {
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
                            bootbox.alert('OCURRIÓ UN ERROR AL MARCAR PARA ENVÍO A SECRETARÍA DE LA FUNCIÓN PÚBLICA.');
                            return false;
                        }

                        if (respuesta.estatus === 'OK') {
                            bootbox.alert('DECLARACIONES MARCADAS CON ÉXITO', function () {
                                // redirigir a pantalla de requerimientos
                                window.location.href = $('#urlRequerimientos').val();
                            });
                        }

                    }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                        $('#loadingGuardar').modal('hide');

                        console.log(textStatus + ': ' + errorThrown);
                        bootbox.alert('OCURRIÓ UN ERROR AL MARCAR PARA ENVÍO A SECRETARÍA DE LA FUNCIÓN PÚBLICA.');
                    });
                }
            });
        }
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
        var $formMarcar = $('#resultadoBusqueda').find('#formMarcar');
        $formMarcar.validate();
        agregaValidacionesElementos($formMarcar);
        $formMarcar.find('input.fecha').datepicker({
            format:    'dd/mm/yyyy',
            autoclose: true,
            language:  'es'
        });

        $('#resultadoBusqueda').find('#tabla').niceScroll();
    }
});