

(function( $ ) {

	'use strict';

	var datatableInit = function() {
		var $table = $('#datatable-tabletools');

		$table.dataTable({

			sDom: "<'text-right mb-md'BT>" + $.fn.dataTable.defaults.sDom,
			"oTableTools": {
            "aButtons": [
                "copy",
                
                {
                    sExtends: 'xls',
					sButtonText: 'Excel'
                }
            ]
        }
		});

	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);
