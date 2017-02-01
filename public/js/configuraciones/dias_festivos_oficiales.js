jQuery(document).ready(function ($) {
    // variables
    var $formDiaFestivo = $('#formDiaFestivo'),
        _token          = $('#diasFestivos').data('token');

    // validar form
    init();
    $formDiaFestivo.validate();
    agregaValidacionesElementos($formDiaFestivo);
    
    $('#modalAgregarDiaFestivo').on('click', function () {
        $('#diaFestivoId').val('');
        $('#agregarDiaFestivo').html('<i class="fa fa-plus-square"></i> GUARDAR DÍA FESTIVO');

        $('#modalAgregarDia').modal('show');
    });

    // si existen usuarios, generar datatables
    if ($('#existenDiasFestivos').val() === '1') {
        datatables('#tablaDias', 1);

        // editar día festivo
        $('#diasFestivos').on('click', 'button.editar', function () {
            var diaFestivoId = $(this).data('id'),
                fecha        = $(this).data('fecha'),
                celebracion  = $(this).data('celebracion'),
                fecha        = fecha.split('/'),
                dia          = fecha[0],
                mes          = fecha[1];

            $('#dia').val(dia);
            $('#mes>option:eq('+ mes +')').attr('selected', true);
            $('#celebracion').val(celebracion);
            $('#diaFestivoId').val(diaFestivoId);
            $('#agregarDiaFestivo').html('<i class="fa fa-plus-square"></i> ACTUALIZAR DÍA FESTIVO');

            $('#modalAgregarDia').modal('show');
        });

        // eliminar día festivo
        $('#diasFestivos').on('click', 'button.eliminar', function () {
            var diaFestivoId = $(this).data('id');
            
            bootbox.confirm('¿REALMENTE DESEA ELIMINAR EL DÍA FESTIVO?', function (respuesta) {
                if (respuesta) {
                    $.ajax({
                        url:        $('#tablaDias').data('urlEliminar'),
                        type:       'post',
                        dataType:   'json',
                        data:       {
                            diaFestivoId: diaFestivoId,
                            _token:       _token
                        },
                        beforeSend: function () {
                            $('#loadingGuardar').modal('show');
                        }

                    }).done(function (respuesta) {
                        console.log(respuesta.estatus);
                        if (respuesta.estatus === 'OK') {
                            bootbox.alert('DÍA FESTIVO ELIMINADO CON ÉXITO.', function () {
                                recargarTabla();
                            });
                        }

                        if (respuesta.estatus === 'fail') {
                            bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR EL DÍA FESTIVO. INTENTE DE NUEVO');
                        }

                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus + ': ' + errorThrown);
                        $('#loadingGuardar').modal('hide');

                        bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR EL DÍA FESTIVO. INTENTE DE NUEVO');
                    });
                }
            }); 
        });
    }

    // crear nuevo dia festivo
    $('#agregarDiaFestivo').on('click', function () {
        if ($formDiaFestivo.valid()) {
            $.ajax({
                url:        $formDiaFestivo.attr('action'),
                type:       'post',
                dataType:   'json',
                data:       $formDiaFestivo.serialize(),
                beforeSend: function () {
                    $('#loadingGuardar').modal('show');
                }

            }).done(function (respuesta) {
                $('#loadingGuardar').modal('hide');

                if (respuesta.estatus === 'fail') {
                    bootbox.alert('OCURRIÓ UN GUARDAR|ACTUALIZAR EL NUEVO DÍA FESTIVO.');
                }

                if (respuesta.estatus === 'OK') {
                    bootbox.alert('DÍA FESTIVO AGREGADO|ACTUALIZADO CON ÉXITO.', function () {
                        $('#modalAgregarDia').modal('hide');

                        // recargar tabla
                        recargarTabla();
                    });
                }

            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus + ': ' + errorThrown);
                $('#loadingGuardar').modal('hide');
                bootbox.alert('OCURRIÓ UN GUARDAR|ACTUALIZAR EL NUEVO DÍA FESTIVO.');
            });
        }
    });

    // recargar tabla listando los nuevos días festivos
    function recargarTabla() {
        $.ajax({
            url:        $('#diasFestivos').data('url'),
            type:       'post',
            dataType:   'json',
            data:       {
                _token: _token
            },
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }

        }).done(function (respuesta) {
            $('#loadingGuardar').modal('hide');
            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL REFRESCAR LA TABLA.');
                return false;
            }

            $('#diasFestivos').html(respuesta.html);
            datatables('#tablaDias', 1)

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loadingGuardar').modal('hide');
            bootbox.alert('OCURRIÓ UN ERROR AL REFRESCAR LA TABLA.');
        });
    }
});