// Reportes
/*
 * fn-reportes.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {

	'use strict';

	$('#example').DataTable({
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

}).apply( this, [ jQuery ]);
/* --------------------------------------------------------- */
function iconoEstadoReservacion( e ){
    // Devuelve la clase ícono correspondiente a una actividad según su tipo
    var iconos = {  "pendiente" : "fa fa-clock-o",
    				"efectiva" 	: "fa fa-check",
                    "cancelada" : "fa fa-times-circle",
                    "caducada" 	: "fa fa-exclamation" }; 
    
    return iconos[e];
}
/* --------------------------------------------------------- */
function autorAccion( reservacion, accion ){
    // Muestra el autor de una acción
    
    var autor_def = "Participante";
    
    if( accion == "registro" ){
        var label = "#autor_reg_rsv";
        var idu = reservacion.usuario_registro;
        if( idu != null ) {
            $(label).html( autorUAdmin( idu, label ) );
        }else $(label).html( autor_def );
    }
    if( accion == "cancelar" ){
        var label = "#autor_canc_rsv";
        var idu = reservacion.usuario_cancelacion;
        if( idu != null ) {
            $(label).html( autorUAdmin( idu, label ) );
        }else $(label).html( autor_def );
    }
    if( accion == "modificar" ){
        var idu = reservacion.usuario_modificacion;
        autorUAdmin( idu, "#autor_mod_rsv" );
    }

}
/* --------------------------------------------------------- */
function ocultarAccionesDisponibles( reservacion ){
	// Oculta las acciones disponibles sobre una reservación según estado
	var enl_ra = "reservacion.php?r=" + reservacion.id + "&accion=asistencia";
	$("#ax_reg_asistencia").attr( "href", enl_ra );

    var enl_mf = "reservacion.php?r=" + reservacion.id + "&accion=cambio-fecha";
    $("#ax_mod_fecha").attr( "href", enl_mf );

	if( reservacion.estado == "caducada" || reservacion.estado == "efectiva" ) {
		$("#ax_mod_fecha").hide();
		$("#ax_cancelar").hide();
	}

}
/* --------------------------------------------------------- */
function fechasEstado( reservacion ){
    // Muestra las fechas en las que ha cambiado de estado una reservación
    
    $("#dataf_registro").show();
    $("#fecha_reg_rsv").html( reservacion.fecha_registro );
    $("#autor_reg_rsv").html( autorAccion( reservacion, "registro" ) );

    if( reservacion.estado == "cancelada" ){
        $("#dataf_cancelacion").show();
        $("#fecha_canc_rsv").html( reservacion.fecha_cancelacion );

    }
    if( reservacion.usuario_modificacion != null ){
        $("#dataf_modificacion").show();
        autorAccion( reservacion, "modificar" );
        $("#fecha_mod_rsv").html( reservacion.fecha_actualizacion );
    }
}
/* --------------------------------------------------------- */
function mostrarReservacionCalendario( reservacion ){
	// Muestra los datos de una reservación en la ficha desde calendario
    $(".ax_rsv").show(); $(".datafe").hide();
    $(".rsv_nactividad").html( reservacion.actividad );
    $("#nombre_rsv").html( reservacion.nombre );
    $("#apellido_rsv").html( reservacion.apellido );
    $("#email_rsv").html( reservacion.email );
    $("#telefono_rsv").html( reservacion.telefono );
    $("#fecha_rsv").html( reservacion.fecha );
    $("#estado_rsv").html( reservacion.estado );
    $("#i_estado_rsv").addClass( iconoEstadoReservacion( reservacion.estado ) );
    
    $("#img-rsv-act").attr( "src", "../images/" + reservacion.imagen );
    
    ocultarAccionesDisponibles( reservacion );
    fechasEstado( reservacion );
    
}
/* --------------------------------------------------------- */
function mostrarReservacion( id, dst ){
    //Invoca al servidor para obtener reservación por id
    $.ajax({
        type:"POST",
        url:"database/data-reservacion.php",
        data:{ mostrar_rsv: id },
        success: function( response ){
            //console.log(response);
            res = jQuery.parseJSON( response );
            if( res.exito == 1 ){ 
                if( dst == "ventana_cal" )
                    mostrarReservacionCalendario( res.reg );
            }
            if( res.exito == -1 ){ 
                
            }
        }
    });
}
/* --------------------------------------------------------- */
function autorUAdmin( idu, rsp ){
    // Devuelve el nombre del usuario administrador dado su id  
    $.ajax({
        type:"POST",
        url:"database/data-acceso.php",
        data:{ uidAdmin: idu },
        success: function( response ){
            res = jQuery.parseJSON( response );
            $(rsp).html( res.nombre + " " + res.apellido );
        }
    });
}
/* --------------------------------------------------------- */
function modificarHorarioReservacion(){
    //Invoca al servidor para modificar el horario de reservación
    var frm = $('#frm-cambio-fecha-rsv').serialize();
    $.ajax({
        type:"POST",
        url:"database/data-reservacion.php",
        data:{ mod_hor_rsv: frm },
        success: function( response ){
            //console.log(response);
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
function cancelarReservacion(){
    //Invoca al servidor para modificar el horario de reservación
    var frm = $('.frm-cancelar-rsv').serialize();
    $.ajax({
        type:"POST",
        url:"database/data-reservacion.php",
        data:{ cancelar_rsv: frm },
        success: function( response ){
            //console.log(response);
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