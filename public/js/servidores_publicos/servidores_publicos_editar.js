jQuery(document).ready(function ($) {
    // variables
    var $formEditarDatos = $('#formEditarDatos');

    // focus
    setTimeout(function () {
        $('#nombre').focus();
    }, 500);

    // iniciar validaciones
    init();

    // validar form
    $formEditarDatos.validate();

    agregaValidacionesElementos($formEditarDatos);

    // datepicker
    $formEditarDatos.find('input.fecha').datepicker({
        format:    'dd/mm/yyyy',
        language:  'es',
        autoclose: true
    });

    $('#guardar').on('click', function () {
        if ($formEditarDatos.valid() === true) {

            $.ajax({
                url:      $formEditarDatos.attr('action'),
                type:     'post',
                dataType: 'json',
                data:     $formEditarDatos.serialize(),
                beforeSend: function () {
                    $('#loadingGuardar').removeClass('hide');
                }
            })
            .done(function (respuesta) {
                $('#loadingGuardar').addClass('hide');
                if (respuesta.resultado === 'fail') {
                    bootbox.alert('OCURRIÓ UN ERROR AL ACTUALIZAR LOS DATOS DEL SERVIDOR PÚBLICO. INTENTE DE NUEVO.');
                    return false;
                }

                bootbox.alert('DATOS DE SERVIDOR PÚBLICO ACTUALIZADOS CON ÉXITO.', function () {
                    window.location.href = $('#cancelar').attr('href');
                });
            })
            .fail(function (jQxr, textStatus, errorThrown) {
                $('#loadingGuardar').addClass('hide');
                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('OCURRIÓ UN ERROR AL ACTUALIZAR LOS DATOS DEL SERVIDOR PÚBLICO. INTENTE DE NUEVO.');
            });
        }
    });

    // click en cancelar
    $('#cancelar').on('click', function (event) {
        event.preventDefault();

        bootbox.confirm('¿DESEA CANCELAR LA ACTUALIZACIÓN DE DATOS DEL SERVIDOR PÚBLICO?', function (e) {
            if (e === true) {
                window.location.href = $('#cancelar').attr('href');
            }
        });
    });
});