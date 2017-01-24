jQuery(document).ready(function($) {

    // tampoco recuerda su usuario
    $('#noRecuerdoUsuario').on('click', function() {
        $('#otraBusqueda').removeClass('hide');
        $('#busquedaUsuario').addClass('hide');
    });

    // volver a buscar por nombre de usuario
    $('#cancelarPorNombreDeUsuario').on('click', function () {
        $('#otraBusqueda').addClass('hide');
        $('#busquedaUsuario').removeClass('hide');
    });

    // paso 2
    $('#irAPaso2').on('click', function () {
        // buscar mediante ajax los datos del servidor público actual para que lo confirme
        // y desplegar también el correo al que se le mandará la contraseñña
        // caso contrario, pedirle un correo válido
    });
});