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
                    $busquedaServidores.removeClass('hide');
                }
            })
            .done(function(resultado) {
                $busquedaServidores.addClass('hide');
                $resultadoBusquedaServidores.html(resultado.contenido);
            })
            .fail(function(XMLHttpRequest, textStatus, errorThrown) {
                $busquedaServidores.addClass('hide')
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
                $fichaTecnicaLoading.removeClass('hide');
            }
        })
        .done(function (resultado){
            $fichaTecnicaLoading.addClass('hide');
            $fichaTecnica.removeClass('hide');
            $fichaTecnica.html(resultado.contenido);
        })
        .fail(function (a, textStatus, errorThrown) {
            $fichaTecnicaLoading.addClass('hide');
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('Imposible realizar la operación solicitada')
        });
    });
});