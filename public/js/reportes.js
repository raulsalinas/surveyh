$(function(){    
    reporteRespuestaPeriodoActual();
});

function funcDatatables() {
    var idioma = {
        "sProcessing":     "<div class='spinner'></div>",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate":
        {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria":
        {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
    var dtdom = 'lBfrtip'; //l=lenght / B=button / f=filter / rt=read table
    var dtbuttons = [
        {extend: 'copy', text: '<i class="fas fa-copy"></i>'},
        {extend: 'excel', text: '<i class="fas fa-file-excel"></i>'},
        {extend: 'pdf', text: '<i class="fas fa-file-pdf"></i>'},
        {extend: 'print', text: '<i class="fas fa-print"></i>'}
        //falta agregar titulos a los export
    ];

    var array = [idioma, dtdom, dtbuttons];
    return array;
}

function reporteRespuestaPeriodoActual(){

    var vardataTables = funcDatatables();
    $('#resultadosPeriodoActualTable').DataTable({
      'dom': 'lBfrtip',
        'buttons': vardataTables[2],
        "paging":   false,
        'language' : vardataTables[0],
        'ajax': '/reporte_respuesta_periodo_actual/',
        'bDestroy': true,
        'retrieve': true,
        'columns': [
            {'data': 'id_respuesta'},
            {'data': 'pregunta'},
            {'data': 'respuesta'},
            {'data': 'user_name'},
            {'data': 'escala_fecha_inicio'},
            {'data': 'escala_fecha_fin'},
        ],
        'order': [
            [0, 'asc']
        ],
        'columnDefs': [{ 'width': '20%', 'aTargets': [0], 'sClass': 'invisible'}],
        'fixedColumns': true

    });

}