jQuery(document).ready(function($) {
    var numeroElementos = 0;

    init();

    $('#formOmisos').validate();
    agregaValidacionesElementos($('#formOmisos'));

    $('#fechaOficio').datepicker({
        format:    'dd/mm/yyyy',
        autoclose: true,
        language:  'es'
    });

    // buscar
    $('#buscar').on('click', function () {
        var url = $(this).data('url');

        $.ajax({
            url:      $('#formFiltro').attr('action'),
            type:     'post',
            dataType: 'json',
            data:     $('#formFiltro').serialize(),
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
    });

    // añadir una coincidencia a la lista de retorno
    $('#resultadoBusqueda').on('click', 'li.omiso', function() {
        $(this).addClass('active');
        $(this).siblings('li.active').removeClass('active');

        var yaSeHaSeleccionado = false,
            servidorPublico    = $(this).find('p.servidorPublico').text(),
            declaracionId      = $(this).find('p.servidorPublico').data('id'),
            curp               = $(this).find('li.curp').text(),
            dependencia        = $(this).find('li.dependencia').text(),
            declaracionTipo    = $(this).find('li.declaracionTipo').text(),
            tr                 = '<tr id="tr_' + declaracionId + '">' +
                '<td>' + servidorPublico + '</td>' +
                '<td>' + curp + '</td>' +
                '<td>' + dependencia + '</td>' +
                '<td>' + declaracionTipo + '</td>' +
                '<td><button type="button" class="btn btn-info btn-xs eliminarDeLista" data-toggle="tooltip" data-original-title="ELIMINAR DE LA LISTA" data-placement="left"><i class="fa fa-times"></i></button><input type="hidden" name="declaracionId[]" class="declaracionId" value="' + declaracionId + '"></td>' +
                '</tr>';

        $('#tbody').find('input.declaracionId').each(function(){
            if ($(this).val() === declaracionId) {
                yaSeHaSeleccionado = true;
                return false;
            }
        });

        if (yaSeHaSeleccionado) {
            bootbox.alert('YA SE HA AGREGADO A LA LISTA.');
            return false;
        }

        $('#tbody').append(tr);
        $('#tablaResultados').removeClass('hide');
        numeroElementos++;
    });

    // eliminar un elemento de la lista
    $('#tbody').on('click', 'button.eliminarDeLista', function() {
        var declaracionId = $(this).parent('td').parent('tr').remove();

        numeroElementos--;

        if (numeroElementos === 0) {
            $('#tablaResultados').addClass('hide');
        }
    });

    $('#guardar').on('click', function() {
        if ($('#formOmisos').valid()) {
            if (numeroElementos === 0) {
                bootbox.alert('POR FAVOR, SELECCIONE Y AGREGUE AL MENOS A UN ELEMENTO A LA LISTA.');
                return false;
            }

            $.ajax({
                url:      $('#formOmisos').attr('action'),
                type:     'post',
                dataType: 'json',
                data:     $('#formOmisos').serialize(),
                beforeSend: function () {
                    $('#loadingGuardar').modal('show');
                }

            }).done(function (respuesta) {
                $('#loadingGuardar').modal('hide');

                if (respuesta.estatus === 'fail') {
                    bootbox.alert('OCURRIÓ UN ERROR AL MARCAR EL RETORNO DE LOS REQUERIMIENTOS SELECCIONADOS.');
                }

                if (respuesta.estatus === 'OK') {
                    bootbox.alert('EL RETORNO DE LOS REQUERIMIENTOS FUE MARCADO CON ÉXITO.', function () {
                        window.location.reload(true);
                    });
                }

            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                $('#loadingGuardar').modal('hide');
                console.log(textStatus + ': ' + errorThrown);
                bootbox.alert('OCURRIÓ UN ERROR AL MARCAR EL RETORNO DE LOS REQUERIMIENTOS SELECCIONADOS.');
            });
        }
    });
});