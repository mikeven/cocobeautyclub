<?php
    /*
     * CBC Admin - Reporte de actividades
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
 	
 	$titulo_pagina = "Reporte general de actividades";
 	$actividades = obtenerActividadesHorarios( $dbh );

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

		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
	
		<!-- <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" /> -->
		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		<style type="text/css">
			.dataTables_wrapper .dataTables_filter input {
			    width: 100%;
			    display: block;
			    height: 34px;
			    padding: 6px 12px;
			    font-size: 14px;
			    line-height: 1.42857143;
			    color: #555555;
			    background-color: #ffffff;
			    background-image: none;
			    border: 1px solid #cccccc;
			    margin-left: 0 !important;
			    border-radius: 0px;
			    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
			    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
			    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
			}

			.cbcreportes thead tr { background: #000; color: #FFF; }

			.conf-canc_rsv{ display: none; }

			#ficha-reservacion .fa, .panel-rsv-acciones a:hover{ color: #ed145b }
			.panel-rsv-acciones a{ color: #999; font-weight: bolder; }
			.data-info-reg{ color: #666; font-size: 14px; }
			.info-reservacion-cal{ padding: 20px 0 }
			.datafe, .hor_nvarsv{ display: none; }
			#hact_nvarsv, .cdispcal{ color: #ed145b }
			.cdispcal{ font-size: 14px; font-weight: bolder; }
			.lab_cupos_dsp { color: #ed145b; font-size: 13px; }
		</style>
	</head>
	
	<body>
		<section class="body">

			<?php include( "sections/header.php" ); ?>

			<div class="inner-wrapper">
				
				<!-- start: sidebar -->
				<?php include( "sections/left-sidebar.php" );?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Reporte general de actividades</h2>
					
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
						
						<div class="panel-body">
							<table class="table table-bordered table-striped mb-none cbcreportes" 
							id="tabla-actividades">
								<thead>
									<tr>
										<th>Actividad</th>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Inscritos</th>
										<th>Participantes</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach ( $actividades as $a ) {
											 $cant_insc = obtenerInscritosHorario( $dbh, $a["idh"] );
											 $lista_ins = 
											 obtenerParticipantesPorHorarioActividad( $dbh, $a["idh"] );
									?>
									<tr class="gradeX">
										<td><?php echo $a["nombre"] ?></td>
										<td><?php echo $a["fecha"] ?> </td>
										<td style="color: #ed145b; font-weight: bolder">
											<?php echo $a["hora"] ?> 
										</td>
										<td><?php echo $cant_insc["num"]."/".$cant_insc["cupo"] ?></td>
										<td> 
											<?php foreach ( $lista_ins as $l ) { ?>
											<div>
												<a href="#reservacion-calendario" 
													class="modal-sizes modal-with-zoom-anim selector_rsv_cal" 
													data-idr="<?php echo $l['id'] ?>">
													<?php echo $l["nombre"]." ".$l["apellido"]." ( $l[telefono])";?>
												</a>
											</div>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</section>
				</section>
			</div>
		</section>

		<?php include( "sections/modals/ficha-reservacion.php" ); ?>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/jquery-form/jquery.form.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/owl-carousel/owl.carousel.js"></script>
		<script src="assets/vendor/pnotify/pnotify.custom.js"></script>

		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>	

		<script src='assets/vendor/packages/core/main.js'></script>
		<script src='assets/vendor/packages/interaction/main.js'></script>
		<script src='assets/vendor/packages/daygrid/main.js'></script>
		<script src='assets/vendor/packages/timegrid/main.js'></script>
		<script src='assets/vendor/packages/list/main.js'></script>
		<script src='assets/vendor/packages/core/locales/es.js'></script>
		<script src="assets/vendor/fullcalendar/lib/moment.min.js"></script>

			
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->

		<!-- Examples -->
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		
		<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
		<script src="assets/javascripts/ui-elements/examples.modals.js"></script>
		
		<script src="js/fn-ui.js"></script>
		<script src="js/fn-reportes.js"></script>
		<script src="js/fn-reservacion.js"></script>
		
	</body>
</html>