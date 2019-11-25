// Reservaciones
/*
 * fn-reservaciones.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {

	'use strict';

	$("#frm-cambio-fecha-rsv").validate({
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
            modificarHorarioReservacion();
        }
    });

    /* --------------------------------------------------------- */

    $("#frm-nvareservacion").validate({
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
            if (!placement.get(0)) {  placement = element;  }
            if (error.text() !== '') { placement.after(error); }
        },
        submitHandler: function(form) {
            ingresarReservacion();
        }
    });
    
    /* --------------------------------------------------------- */

    $(".frm-cancelar-rsv").validate({
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
            cancelarReservacion();
        }
    });
	
	/* --------------------------------------------------------- */
    
    $("#frm-reg-asistencia").validate({
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
            $("#ft_guardar_reg_asist").hide();
            registrarAsistencia();
        }
    });

    /* --------------------------------------------------------- */

    $(".lnk_cancelar_rsv").on( "click", function(){
        // Mostrar confirmación para cancelar reservación
        $(this).hide();
        $(".conf-canc_rsv").fadeIn();
    });

    $(".noconf_canc_rsv").on( "click", function(){
        // Cancelar acción para cancelar reservación
        $(".conf-canc_rsv").hide();
        $(".lnk_cancelar_rsv").fadeIn();
    });

    $(".lnk_conf_canc_rsv").on( "click", function(){
        // Invoca el envío del formulario para cancelar una reservación
        $("#frm-cancelar-rsv").submit();
    });

    $(".btn-act-cal").on( "click", function(){
        // Muestra / Oculta los horarios disponibles para reservar desde calendario
        $( ".hor_nvarsv" ).slideUp(250);
        var trg = $(this).attr("data-trg");
        $("#" + trg).slideToggle(300);
    });

    $(".bnva_rsv").on( "click", function(){
        // Muestra los datos de una actividad para una nueva reservación
        $("#id_horario_act").val( $(this).attr("data-idh") );
        $("#desc_actividad").html( $(this).attr("data-nactividad") );
        $("#hact_nvarsv").html( $(this).attr("data-horario") );
    });

    $(".cnc_nr").on( "click", function(){
        //Reinicia el formulario de nueva reservación al cerrar la ventana emergente
        $("#frm-nvareservacion")[0].reset();
    });

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

    var enl_vr = "reservacion.php?r=" + reservacion.id;
    $("#ax_ver_reservacion").attr( "href", enl_vr );

	if( reservacion.estado == "caducada" || reservacion.estado == "efectiva" ) {
		$("#ax_mod_fecha").hide();
		$("#ax_cancelar").hide();
        $("#ax_reg_asistencia").hide();
	}

    if( reservacion.estado != "efectiva" ) {
        $("#ax_ver_reservacion").hide();
    }

    if( reservacion.estado == "pendiente" ) {
        if( reservacion.fecha_pasada == 1 ){
            $("#ax_cancelar").hide();
            $("#ax_mod_fecha").hide();
        }
        else
            $("#ax_reg_asistencia").hide();
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
    $("#idrsv").val( reservacion.id );
    $(".rsv_nactividad").html( reservacion.actividad );
    $("#nombre_rsv").html( reservacion.nombre );
    $("#apellido_rsv").html( reservacion.apellido );
    $("#email_rsv").html( reservacion.email );
    $("#telefono_rsv").html( reservacion.telefono );
    $("#fecha_rsv").html( reservacion.fecha );
    $("#estado_rsv").html( reservacion.estado );
    $("#i_estado_rsv").removeClass();
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
function ingresarReservacion(){
    //Invoca al servidor para registrar nueva reservación
    var frm = $('#frm-nvareservacion').serialize();
    $.ajax({
        type:"POST",
        url:"database/data-reservacion.php",
        data:{ reservar: frm },
        success: function( response ){
            
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
            console.log(response);
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
function registrarAsistencia(){
    //Invoca al servidor para registrar la asistencia / compra de un participante
    var frm = $('#frm-reg-asistencia').serialize();
    $.ajax({
        type:"POST",
        url:"database/data-reservacion.php",
        data:{ asistencia: frm },
        success: function( response ){
            console.log(response);
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