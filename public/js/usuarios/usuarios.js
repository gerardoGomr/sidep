jQuery(document).ready(function ($) {
    // variables
    var $formBusquedaServidores = $('#formBusquedaServidores'),
        _token                  = $('#formPrivilegios').find('input[name="_token"]').val();

    // validar form
    init();
    $formBusquedaServidores.validate();
    agregaValidacionesElementos($formBusquedaServidores);

    // select 2
    $('#encargo').select2();

    // si existen usuarios, generar datatables
    if ($('#existenUsuarios').val() === '1') {
        datatables('#tablaUsuarios', 1);

        // editar privilegios de usuario
        $('#usuariosRegistrados').on('click', 'button.editarPrivilegios', function () {
            var encargoId = $(this).data('id'),
                nombre    = $(this).data('nombre');

            $.ajax({
                url:        $('#tablaUsuarios').data('url'),
                type:       'post',
                dataType:   'json',
                data:       {
                    encargoId: encargoId,
                    _token:    _token
                },
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

        // eliminar usuario
        $('#usuariosRegistrados').on('click', 'button.removerUsuario', function () {
            var encargoId = $(this).data('id');
            
            bootbox.confirm('¿REALMENTE DESEA REMOVER AL USUARIO?', function (respuesta) {
                if (respuesta) {
                    $.ajax({
                        url:        $('#tablaUsuarios').data('urlEliminar'),
                        type:       'post',
                        dataType:   'json',
                        data:       {
                            encargoId: encargoId,
                            _token:    _token
                        },
                        beforeSend: function () {
                            $('#loadingGuardar').modal('show');
                        }

                    }).done(function (respuesta) {
                        console.log(respuesta.estatus);
                        if (respuesta.estatus === 'OK') {
                            bootbox.alert('USUARIO ELIMINADO CON ÉXITO.', function () {
                                recargarTabla();
                            });
                        }

                        if (respuesta.estatus === 'fail') {
                            bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR AL USUARIO. INTENTE DE NUEVO');
                        }

                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus + ': ' + errorThrown);
                        $('#loadingGuardar').modal('hide');

                        bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR AL USUARIO. INTENTE DE NUEVO');
                    });
                }
            }); 
        });
    }

    // crear nuevo usuario
    $('#crearUsuario').on('click', function () {
        if ($formBusquedaServidores.valid()) {
            $.ajax({
                url:        $formBusquedaServidores.attr('action'),
                type:       'post',
                dataType:   'json',
                data:       $formBusquedaServidores.serialize(),
                beforeSend: function () {
                    $('#loadingGuardar').modal('show');
                }

            }).done(function (respuesta) {
                $('#loadingGuardar').modal('hide');

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
                $('#loadingGuardar').modal('hide');
                bootbox.alert('OCURRIÓ UN ERROR AL CREAR AL USUARIO.');
            });
        }
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
            url:        $('#usuariosRegistrados').data('url'),
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

            $('#usuariosRegistrados').html(respuesta.html);

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loadingGuardar').modal('hide');
            bootbox.alert('OCURRIÓ UN ERROR AL REFRESCAR LA TABLA.');
        });
    }
});