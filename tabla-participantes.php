<?php
    /*
     * CBC Admin - Reporte participantes
     * 
     */
    session_start();
    ini_set( 'display_errors', 1 );
    include( "database/bd.php" );
    include( "database/data-acceso.php" );
    include( "database/data-actividad.php" );
    include( "database/data-productos.php" );
    include( "database/data-reservacion.php" );

    include( "fn/fn-acceso.php" );
    include( "fn/fn-reservacion.php" );

    checkSession();
 	
 	$titulo_pagina = "Participantes";

    $idu = $_SESSION["user"]["id"];
?>
<!doctype html>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title><?php echo $titulo_pagina; ?> :: Cupfsa Coco Beauty Club</title>
		<meta name="keywords" content="Cupfsa Coco Beauty Club" />
		<meta name="description" content="Sistema backend administrativo para Cupfsa Coco Beauty Club">
		<meta name="author" content="CHANEL">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		
		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans&display=swap" rel="stylesheet">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />

		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		<style type="text/css">
			.icono_estado .fa, .txautor, .lnk_cancelar_rsv{ color: #ed145b  }
			.lab_cupos_dsp { color: #ed145b; font-size: 13px; }
			.conf-canc_rsv{ display: none; }
			.lnk_conf_canc_rsv, #ficha-reservacion .fa{ color: #ed145b }
			.nota-compra{ font-size: 13px; color: #666; text-align: center;
			padding: 8px 2px; }
			.qcompra{ text-align: center; color:#ed145b; font-weight: bolder;  }
		</style>
	</head>
	
	<body>
		<section class="body">

			<?php include( "sections/header.php" ); ?>

			<div class="inner-wrapper">
				
				<!-- start: sidebar -->
				<?php include( "sections/left-sidebar.php" );?>
				<!-- end: sidebar -->

				<section role="main" class="content-body hidden_">
					<header class="page-header">
						<h2>Reservaciones</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="#!">
										<i class="fa fa-home"></i>
									</a>
								</li>
							</ol>
							<a class="sidebar-right-toggle" data-open=""></a>
						</div>
					</header>

					<section class="panel">
						<header class="panel-heading bg-dark">
							<h4>Participantes</h4>
						</header>
						<div class="panel-body">
							<table class="table table-bordered table-striped mb-none" 
							id="datatable-tabletools">
								<thead>
									<tr>
										<th>Rendering engine</th>
										<th>Browser</th>
										<th>Platform(s)</th>
										<th class="hidden-phone">Engine version</th>
										<th class="hidden-phone">CSS grade</th>
									</tr>
								</thead>
								<tbody>
									<tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr>
									<tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr><tr class="gradeX">
										<td>Trident</td>
										<td>Internet
											Explorer 4.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">4</td>
										<td class="center hidden-phone">X</td>
									</tr>
									<tr class="gradeC">
										<td>Trident</td>
										<td>Internet
											Explorer 5.0
										</td>
										<td>Win 95+</td>
										<td class="center hidden-phone">5</td>
										<td class="center hidden-phone">C</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
				</section>
			</div>

		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

			
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->

		<!-- Examples -->
		
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		
		<script>
			/*$(document).ready(function() {
			    $('#example').DataTable( {
			        sDom: "<'text-right mb-md'TB>" + $.fn.dataTable.defaults.sDom,
			        buttons: [
			            'excel'
			        ],
			        "language": {
                    "lengthMenu": "Mostrar _MENU_ resultados por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando pág _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros",
                    "infoFiltered": "(filtrados de _MAX_ regs)",
                    "search": "Buscar:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Próximo",
                        "previous":   "Anterior"
                    },
                },
			    } );
			} );*/
		</script>

		
	</body>
</html>