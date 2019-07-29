<?php
    /*
     * CBC Admin - Pagina de inicio
     * 
     */
    session_start();
    ini_set( 'display_errors', 1 );
    include( "database/bd.php" );
    include( "database/data-acceso.php" );
    include( "database/data-reservacion.php" );

    include( "fn/fn-acceso.php" );

    checkSession();
 	
 	$titulo_pagina = "Actividades";
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
		<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />

		<link href='assets/vendor/packages/core/main.css' rel='stylesheet' />
		<link href='assets/vendor/packages/daygrid/main.css' rel='stylesheet' />
		<link href='assets/vendor/packages/timegrid/main.css' rel='stylesheet' />
		<link href='assets/vendor/packages/list/main.css' rel='stylesheet' />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<link rel="stylesheet" href="assets/vendor/owl-carousel/owl.carousel.css" />
		<link rel="stylesheet" href="assets/vendor/owl-carousel/owl.theme.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">
		<link rel="stylesheet" href="assets/stylesheets/cupfsa-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
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
						<h2>Actividades</h2>
					
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

					<div class="row">
						<section class="panel">
						<div class="col-sm-9 col-xs-12">
							
							<div id='calendar'> </div>
							<a id="evtsrsv" href="#!" class="hidden">EVENTOS</a>
							
						</div>
						<div class="col-sm-3 col-xs-12">
							<div id='script-warning'>
							    
							</div>
						</div>
						<div class="col-sm-4 col-xs-12 hidden"></div>
						</section>
					</div>
				</section>
			</div>

		</section>

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

		<script src="js/fn-calendario.js"></script>	
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/fn-ui.js"></script>
		<script src="assets/javascripts/theme.init.js"></script>
		<script src="js/fn-nominaciones.js"></script>

		<!-- Examples -->
		<!--
		<script src="assets/javascripts/dashboard/examples.dashboard.js"></script>-->
	</body>
</html>