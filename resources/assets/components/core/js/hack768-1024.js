jQuery(document).ready(function($) {
    /**
     * crear un hack para resoluciones entre 768 & 1024
     * para que el menu de la izquierda no sea visible
     */
    var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    if (w >= 768 && w <= 1024) {
        setTimeout(function () {
            $('body').find('div.container-fluid').toggleClass('menu-hidden');
        }, 300);
    }
});