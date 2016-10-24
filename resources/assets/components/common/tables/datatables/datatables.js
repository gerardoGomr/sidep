function generarDatatables(idTabla) {

    $('#'+idTabla).DataTable({
        "language": {
            "lengthMenu" : "Registros por pagina: _MENU_ ",
            "zeroRecords": "No hay registros",
            "info"       : "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty"  : "No hay registros disponibles",
            "search"     : "Buscar:",
            "paginate"   : {
                "first"   : "Inicio",
                "previous": "Anterior",
                "next"    : "Siguiente",
                "last"    : "Fin"
            },
            "processing"  : "Cargando datos ... espere",
            "infoFiltered": "(filtrado desde _MAX_ registros)"
        },
        "dom"           : "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'>>" +
                          "<'row'<'col-sm-12'tr>>" +
                          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "destroy"       : true,
        "processing"    : true,
        "autoWidth"     : false
    });
}