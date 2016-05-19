jQuery(document).ready(function($) {
    var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

    if (w <= 1024) {
        $('#acciones').toggleClass('btn-group-sm');
    }

    // variables
    var $servidoresPublicos     = $('#servidoresPublicos'),
        $fichaTecnicaLoading    = $('#fichaTecnicaLoading'),
        $fichaTecnica           = $('#fichaTecnica');

    // focus
    setTimeout(function() {
        $('#servidor').focus();
    }, 500);

    /* click sobre un elemento de la lista de servidores
    borrar al que quedó activo previamente
    y setear al nuevo activo.
    En seguida realizar la búsqueda AJAX
     */
    $servidoresPublicos.on('click', 'li', function(event) {
        $servidoresPublicos.find('li.active').removeClass('active');
        $(this).addClass('active');
        $fichaTecnicaLoading.show(300);
        $fichaTecnica.show(200);
        $fichaTecnicaLoading.hide(300);
        /*$.ajax({
            url: '',
            type: 'post',
            dataType: 'json',
            data: '',
            beforeSend: function () {
                $fichaTecnicaServidores.show(300);
            }
        })
        .done(function(resultado){
            $fichaTecnicaServidores.hide(300);

        })
        .fail(function(a, textStatus, errorThrown) {
            $fichaTecnicaServidores.hide(300);
            console.log(textStatus + ': ' + errorThrown);
            bootbox.alert('Imposible realizar la operación solicitada')
        });*/
    });
});