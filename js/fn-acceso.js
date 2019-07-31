// Acceso
/*
 * fn-acceso.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {
	
	'use strict';

	// basic
	$("#loginform").validate({
		highlight: function( label ) {
			$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function( label ) {
			$(label).closest('.form-group').removeClass('has-error');
			label.remove();
		},
		rules: {
		    valor: { digits: true },
		    nombre: {
		        remote: {
		        	url: "database/data-productos.php",
		        	method: 'POST'       	
				}
			}
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
            log_in();
        }
	});
	// validation summary
	var $summaryForm = $("#summary-form");
	$summaryForm.validate({
		errorContainer: $summaryForm.find( 'div.validation-message' ),
		errorLabelContainer: $summaryForm.find( 'div.validation-message ul' ),
		wrapper: "li"
	});

}).apply( this, [ jQuery ]);

/* --------------------------------------------------------- */

function log_in(){
	
	var form = $('#loginform').serialize();

	$.ajax({
        type:"POST",
        url:"database/data-acceso.php",
        data:{ login: form },
        success: function( response ){
        	console.log( response );
        	res = jQuery.parseJSON( response );
			if( res.exito == 1 )
				window.location = "reservaciones.php";
			else
				alertaMensaje( res.exito, res.mje );
        }
    });
}
/* --------------------------------------------------------- */