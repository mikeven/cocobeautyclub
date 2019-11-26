// Funciones sobre calendario
/*
 * fn-calendario.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
(function( $ ) {

	'use strict';
	/* --------------------------------------------------------- */
	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');

	    var calendar = new FullCalendar.Calendar(calendarEl, {
	    	plugins: [ 'interaction', 'dayGrid',  'timeGrid', 'list' ],
	      	themeSystem: 'bootstrap',
			
			/* Formato */
			// Botones disponibles
			header: {
				left: 'prev,next today',	
				center: 'title',
				right: 'dayGridMonth, timeGridWeek, timeGridDay, listMonth'
			},

			// Idioma
			locale: 'es',

			// Opciones de vista
			defaultView: 'timeGridWeek',	// Vista por defecto: semana
			hiddenDays: [ 0 ],				// Oculta los días domingo
			allDaySlot:false,				// Oculta bloque "Todo el día"
			businessHours: false,			// Oculta los días hábiles

			// Horas
			minTime: "11:00",				// Hora mínima visible
			maxTime: "21:00",				// Hora máxima visible
			slotDuration: '00:30:00', 		// Intérvalo de horas
			slotLabelInterval: '00:30:00',	// Intérvalo para mostrar texto en las horas
			omitZeroMinute: false,
			slotLabelFormat: {				// Formato de horas
				hour12: true,
				hour: '2-digit',
				minute: '2-digit',
				omitZeroMinute: false,
				meridiem: 'short' //am
			},

			// Horas en eventos
			eventTimeFormat:{
				hour12: true,
				hour: '2-digit',
				minute: '2-digit',
				omitZeroMinute: false,
				meridiem: 'short' //am
			},

			/* Valores iniciales */		 
			// Fecha
			defaultDate: new Date(),		// Fecha actual para mostrar calendario

			/* Acciones */		 
			navLinks: true, 
			editable: true,
			eventResizableFromStart: false,
			eventDurationEditable: false,
			
			/* Eventos */
			events: {
	            url:"database/reg-reservaciones.php",
	            failure: function() {
		          document.getElementById('script-warning').style.display = 'block'
		        },
	            error: function() {
	                alert('Hubo un error al obtener las actividades');
	            }
	        },
			eventClick: function( info ) {
	        	// Asignación de datos de actividad por clic en evento de calendario

	        	var idr = info.event.id;

			    if( info.event.rendering != "background" ){
			    	$("#selector_rsv_cal").attr( "data-idr", idr );
			    	$("#selector_rsv_cal").click();
			    }else{
			    	console.log( info.event );
			    }
			},
			eventDrop: function( info ) {
				
				var fecha = obtenerFechaDestino( info.event.start );
				obtenerActividadesFechaDestino( fecha, info.event.id );
				$("#rvt_drag_cal").on( "click", function(){
			        info.revert();
			    });
			}
		});

	    calendar.render();
	});

	$("#evtsrsv").on( "click", function(){
        ajaxRSR();
    });

    $("#selector_rsv_cal").on( "click", function(){
        // Evento invocador para mostrar datos de reservación en calendario
        var idr = $(this).attr( "data-idr" );
        mostrarReservacion( idr, "ventana_cal" );
    });

	/* --------------------------------------------------------- */
}).apply(this, [ jQuery ]);

/* --------------------------------------------------------- */
function ajaxRSR(){
    
    $.ajax({
        type:"POST",
        data:{ reservaciones_cal: 1 },
	    url:"database/data-reservacion.php",
        success: function( response ){
            console.log( response );
        }
    });
}
/* --------------------------------------------------------- */
function obtenerFechaDestino( datafecha ){
	// Devuelve la fecha destino a la que fue movida una actividad en calendario

	let str = FullCalendar.formatDate( datafecha, {
	  month: '2-digit',
	  year: 'numeric',
	  day: '2-digit',
	  hour: '2-digit',
	  timeZoneName: 'short',				 
	  locale: 'en'
	});

	return moment(new Date( str )).format('YYYY-MM-DD HH:mm');
}
/* --------------------------------------------------------- */