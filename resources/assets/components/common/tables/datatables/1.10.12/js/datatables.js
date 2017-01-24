/**
 * Created by Gerardo on 05/11/2016.
 */
function datatables(tableId, columnOrder) {
    $(tableId).DataTable({
        'language': {
            'lengthMenu':   'Desplegando _MENU_ registros por página',
            'zeroRecords':  'No se encontraron resultados',
            'info':         'Mostrando página _PAGE_ de _PAGES_',
            'infoEmpty':    'Sin resultados',
            'infoFiltered': '(filtrado de _MAX_ registros totales)',
            'search':       'Buscar:',
            'paginate':     {
                'previous': 'Anterior <<',
                'next':     'Siguiente >>'
            }
        },
        'order':    [[columnOrder, 'desc']]
    });
}