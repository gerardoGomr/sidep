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

    // validar form
    $('#formBaja').validate();

    agregaValidacionesElementos($('#formBaja'));

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

    // click para dar de baja a servidor público
    $fichaTecnica.on('click', 'button.baja', function () {
        // setear el id del encargo
        $('#encargoId').val($(this).data('id'));

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
                })
                .done(function (resultado){
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
                })
                .fail(function (a, textStatus, errorThrown) {
                    $('#loadingGuardar').modal('hide');
                    console.log(textStatus + ': ' + errorThrown);
                    bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BAJA DE ENCARGO DEL SERVIDOR PÚBLICO.');
                });
            }
        });
    });
});