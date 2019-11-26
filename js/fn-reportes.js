// Reportes
/*
 * fn-reportes.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {

	'use strict';

	$('.cbcreportes').DataTable({
        sDom: "<'text-right mb-md'B>" + $.fn.dataTable.defaults.sDom,
        responsive: true,
        buttons: [ 'excel' ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ resultados por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando pág _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros",
            "infoFiltered": "(filtrados de _MAX_ regs)",
            "search": "",
            "paginate": {
              "next": '<span class="fa fa-chevron-right"></span>',
              "previous": '<span class="fa fa-chevron-left"></span>'
            },
        },
    });

    $( ".table-bordered" ).wrap( "<div class='table-responsive'></div>" );
    $(".dt-button").removeClass("dt-button").addClass("btn btn-sm btn-dark");
    $(".dataTables_filter input").attr("placeholder", "Buscar");

    /* --------------------------------------------------------- */
    $("#tabla-actividades").on( "click", ".selector_rsv_cal", function(){
        // Evento invocador para mostrar datos de reservaciÃ³n en calendario
        var idr = $(this).attr( "data-idr" );
        mostrarReservacion( idr, "ventana_cal" );
    });

}).apply( this, [ jQuery ]);
/* --------------------------------------------------------- */

/* --------------------------------------------------------- */