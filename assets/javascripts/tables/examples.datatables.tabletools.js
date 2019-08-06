

(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#datatable-tabletools');

		$table.dataTable({
			sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
			oTableTools: {
				
				"aButtons": [
                    "copy",
                    
                    {
                        
                        
                        "aButtons":    [ "csv", "xls", "pdf" ]
                    }
                ]
			}
		});

	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);
