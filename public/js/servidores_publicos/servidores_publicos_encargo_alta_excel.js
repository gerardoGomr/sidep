jQuery(document).ready(function($) {
    // variables
    var $formImportar = $('#formImportar');

    $('#fechaAlta').datepicker({
        format:    'dd/mm/yyyy',
        autoclose: true,
        language:  'es'
    });

    // iniciar validaciones
    init();

    // validar form
    $formImportar.validate();
    agregaValidacionesElementos($formImportar);

    var opciones = {
        dataType:   'json',
        beforeSend: function () {
            if (!$formImportar.valid()) {
                return false;
            }

            $('#loadingGuardar').modal('show');
        },
        success:    function (respuesta, statusText, xhr, $form) {
            $('#loadingGuardar').modal('hide');

            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA IMPORTACIÓN DEL ARCHIVO. INTENTE DE NUEVO.');
            }

            if (respuesta.estatus === 'OK') {
                $('#resultadoImportacion').html(respuesta.html);
                $('#resultadoImportacion').find('table.tablaResultados').dataTable();
            }
        },
        error:      function (XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingGuardar').modal('hide');
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA IMPORTACIÓN DEL ARCHIVO. INTENTE DE NUEVO.');
        }
    };

    // convertir form en ajax form
    $formImportar.ajaxForm(opciones);
});