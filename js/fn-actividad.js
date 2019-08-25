// Reservaciones
/*
 * fn-reservaciones.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {

	'use strict';

    $("#frm-opciones-actividades").validate({
        highlight: function( label ) {
            $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function( label ) {
            $(label).closest('.form-group').removeClass('has-error');
            label.remove();
        },
        onkeyup: false,
        errorPlacement: function( error, element ) {
            var placement = element.closest('.input-group');
            if (!placement.get(0)) {
                placement = element;
            }
            if (error.text() !== '') {
                placement.after(error);
            }
        },
        submitHandler: function(form) {
            moverReservacion();
        }
    });

    /* --------------------------------------------------------- */

    $(".lnk_cancelar_rsv").on( "click", function(){
        // Mostrar confirmación para cancelar reservación
        $(this).hide();
        $(".conf-canc_rsv").fadeIn();
    });

    /* --------------------------------------------------------- */

}).apply( this, [ jQuery ]);

/* --------------------------------------------------------- */
function obtenerHTMLOpcionActividad( data ){
    // Devuelve el radio botón con los datos de opción de actividad 
    var opcion = data.nombre + " " + data.fecha + " " + data.hora;
    var dis = "";
    var cupos = data.cupos + " cupos";
    if( data.cupos < 1 ) {
        dis = "disabled"; cupos = "Agotado";
    }

    var elemento = "<div class='radio-custom'>" + 
                    "<input type='radio' name='idhorario' value='" + data.idh + 
                    "' required " + dis + ">" +
                    "<label for='nueva_fecha'>" + opcion + 
                    " &nbsp;<span class='lab_cupos_dsp'>" + cupos + 
                    "</span></label></div>";
    
    return elemento;       
}
/* --------------------------------------------------------- */
function mostrarOpcionesActividades( data ){
    // Muestra las opciones de actividades según fecha en ventana emergente
    var reservacion = data.reservacion;
    var actividades = data.actividades;

    $("#id_reservacion").val( reservacion.id );
    $("#data_reservacion").html( reservacion.nombre + " " + reservacion.apellido );
    
    actividades.forEach( function( a ) {
        elemento = obtenerHTMLOpcionActividad( a );
        $( elemento ).appendTo( "#ls_opciones_actividades" );
    }); 
    
    $("#selector_act_mult").click();
}
/* --------------------------------------------------------- */
function obtenerActividadesFechaDestino( fecha, id_r ){
    // Invoca al servidor para mostrar las actividades pautadas en una fecha
    $("#ls_opciones_actividades").html("");

    $.ajax({
        type:"POST",
        url:"database/data-actividad.php",
        data:{ actividades_fecha: fecha, idr: id_r },
        success: function( response ){
            
            res = jQuery.parseJSON( response );
            //console.log(res);
            mostrarOpcionesActividades( res );
        }
    });
}
/* --------------------------------------------------------- */
function moverReservacion(){
    // Invoca al servidor para cambiar reservación desde calendario
    var frm = $('#frm-opciones-actividades').serialize();
    
    $.ajax({
        type:"POST",
        url:"database/data-reservacion.php",
        data:{ mover_reserva: frm },
        success: function( response ){
            $("#btn_drag_rsv").attr("disabled", true);
            res = jQuery.parseJSON( response );
            
            if( res.exito == 1 ){ 
                notificar( "Reservación", res.mje, "success" );
                setTimeout( function() { location.reload( true ); }, 3000 );
            }
            if( res.exito == -1 ){ 
                 notificar( "Reservación", res.mje, "error" );
            }
        }
    });
}
/* --------------------------------------------------------- */