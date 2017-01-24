jQuery(document).ready(function ($) {
    // variables
    var $formBusquedaServidores = $('#formBusquedaServidores');

    // validar form
    init();
    $formBusquedaServidores.validate();
    agregaValidacionesElementos($formBusquedaServidores);

    // select 2
    $('#encargo').select2();

    // si existen usuarios, generar datatables
    if ($('#existenUsuarios').val() === '1') {
        datatables('#tablaUsuarios');

        $('#tablaUsuarios').on('click', 'button.editarPrivilegios', function () {
            var encargoId = $(this).data('id'),
                nombre    = $(this).data('nombre');

            $.ajax({
                url:        $('#tablaUsuarios').data('url'),
                type:       'post',
                dataType:   'json',
                data:       {encargoId: encargoId, _token: $('#formPrivilegios').find('input[name="_token"]').val()},
                beforeSend: function () {
                    $('#loadingGuardar').modal('show');
                }

            }).done(function (respuesta) {
                console.log(respuesta.estatus);
                $('#loadingGuardar').modal('hide');

                $('#cuerpoFormPrivilegios').html(respuesta.html);
                $('#nombreUsuario').text(nombre);
                $('#encargoId').val(encargoId);
                $('#modalPrivilegios').modal('show');

            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus + ': ' + errorThrown);
                $('#loadingGuardar').modal('hide');

                bootbox.alert('OCURRIÓ UN ERROR AL CONSTRUIR EL FORMULARIO. POR FAVOR, INTENTE DE NUEVO.')
            });
        });
    }

    // crear nuevo usuario
    $('#crearUsuario').on('click', function () {
        if ($formBusquedaServidores.valid()) {
        }
        $.ajax({
            url:        $formBusquedaServidores.attr('action'),
            type:       'post',
            dataType:   'json',
            data:       $formBusquedaServidores.serialize(),
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }

        }).done(function (respuesta) {
            $('#loadingGuardar').modal('show');

            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL CREAR AL USUARIO.');
            }

            if (respuesta.estatus === 'OK') {
                bootbox.alert('USUARIO CREADO CON ÉXITO.', function () {
                    $('#modalAgregarUsuario').modal('hide');

                    // recargar tabla
                    recargarTabla();
                });
            }

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loadingGuardar').modal('show');
            bootbox.alert('OCURRIÓ UN ERROR AL CREAR AL USUARIO.');
        });
    });
    
    // asignar privilegios
    $('#asignarPrivilegios').on('click', function () {
        $.ajax({
            url:        $('#formPrivilegios').attr('action'),
            type:       'post',
            dataType:   'json',
            data:       $('#formPrivilegios').serialize(),
            beforeSend: function () {
                $('#loadingGuardar').modal('show');
            }

        }).done(function (respuesta) {
            console.log(respuesta.estatus);
            $('#loadingGuardar').modal('hide');

            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL ASIGNAR PRIVILEGIOS AL USUARIO.');
            }

            if (respuesta.estatus === 'OK') {
                bootbox.alert('PRIVILEGIOS ASIGNADOS CON ÉXITO.', function () {
                    $('#modalPrivilegios').modal('hide');
                });
            }

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loadingGuardar').modal('hide');

            bootbox.alert('OCURRIÓ UN ERROR AL ASIGNAR PRIVILEGIOS AL USUARIO.');
        });
    });

    // recargar tabla listando los usuarios creados
    function recargarTabla() {
        $.ajax({
            url:      $('#usuariosRegistrados').data('url'),
            type:     'post',
            dataType: 'json',
            data:     {_token: $('#usuariosRegistrados').data('token')},

        }).done(function (respuesta) {
            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL CREAR AL USUARIO.');
                return false;
            }

            $('#usuariosRegistrados').html(respuesta.html);

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL CREAR AL USUARIO.');
        });
    }
});