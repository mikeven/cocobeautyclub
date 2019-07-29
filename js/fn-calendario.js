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
			hiddenDays: [ 0, 6 ],			// Oculta los sáb y dom
			allDaySlot:false,				// Oculta bloque "Todo el día"
			businessHours: false,			// Oculta los días hábiles

			// Horas
			minTime: "12:00",
			maxTime: "21:00",
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
	                alert('Hubo un error al obtener las tareas');
	            }
	        },
			eventClick: function( info ) {
	        	// Asignación de datos de actividad por clic en evento de calendario
	        	console.log( info.event );
			}
		});

	    calendar.render();
	});

	$("#evtsrsv").on( "click", function(){
        ajaxRSR();
    });

	/* --------------------------------------------------------- */
}).apply(this, [ jQuery ]);


function ajaxRSR(){
    //Invoca al servidor para editar datos de área
    
    $.ajax({
        type:"POST",
        data:{ reservaciones_cal: 1 },
	    url:"database/data-reservacion.php",
        success: function( response ){
            console.log( response );
        }
    });
}