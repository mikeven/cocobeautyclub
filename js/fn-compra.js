// Compras
/*
 * fn-compra.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {

	'use strict';

    /* --------------------------------------------------------- */

    $(".bt_agitem").on( "click", function(){
        //Agrega un ítem de compra a la lista
        var idp = $("#producto").val();
        var producto = $("#producto option:selected").text();
        var cant = $("#cant").val();
        if( !pAgregado( idp ) )
            agregarItemCompra( idp, producto, cant );
    });

    /* --------------------------------------------------------- */
    
    $("#compra").on( 'click', '.icon_elim_ic', function() {
        //Elimina un ítem de compra de la lista
        
        var trg = $(this).attr("data-trg");
        $( "#" + trg ).fadeOut( 300, function(){ 
            $( "#" + trg ).remove(); 
        });
    });

    /* --------------------------------------------------------- */

}).apply( this, [ jQuery ]);
/* --------------------------------------------------------- */
function pAgregado( idp ){
    // 
    agregado = false;
    
    $("#compra input[type=hidden]").each(function(){
        if( $(this).attr("name") == "p" + idp ) agregado = true;
    }); 

    return agregado;   
}
/* --------------------------------------------------------- */
function agregarItemCompra( idp, producto, cant ){
    // Devuelve la clase ícono correspondiente a una actividad según su tipo

    var idi = "id='it" + idp + "'";
    var input_cant = "<input name='p-"+idp+"' type='hidden' value='"+cant+"'>";
    var tx_cant = "<span class='qcompra'>" + cant + "</span>";
    var x_elim = "<i class='fa fa-times'></i>";
    var xe_wrp = "<div class='icon_elim_ic' data-trg='it" + idp + "'>" + x_elim + "</div>"
    
    var item = "<div "  + idi + " class='item_cmp'>"  + input_cant 
                        + producto + "X " + tx_cant + xe_wrp + "</div>";
    
    $("#compra").append(item);
}
/* --------------------------------------------------------- */