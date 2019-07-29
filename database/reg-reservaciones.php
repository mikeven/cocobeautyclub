<?php
	/* --------------------------------------------------------- */
	/* CBC - Registros de reservaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	include( "bd.php" );
	include( "data-actividad.php" );
	include( "data-reservacion.php" );

    require dirname(__FILE__) . '/utils.php';

	// Parse the start/end parameters.
	// These are assumed to be ISO8601 strings with no time nor timeZone, like "2013-12-29".
	// Since no timeZone will be present, they will parsed as UTC.
	$range_start = parseDateTime($_GET['start']);
	$range_end = parseDateTime($_GET['end']);

	// Parse the timeZone parameter if it is present.
	$timeZone = null;
	if (isset($_GET['timeZone'])) {
	  $timeZone = new DateTimeZone($_GET['timeZone']);
	}

	$eventos = obtenerFechasReservadas( $dbh );
	$horarios1 = obtenerHorariosActividad( $dbh, 1 );
	$pautas1 = obtenerPautasActividad( $horarios1 );
	$eventos = array_merge($eventos, $pautas1);

	$horarios2 = obtenerHorariosActividad( $dbh, 2 );
	$pautas2 = obtenerPautasActividad( $horarios2 );

	$eventos = array_merge($eventos, $pautas2);
    /* $je = json_encode( $eventos );

	$json = $je;//file_get_contents('events.json');
	$input_arrays = json_decode($json, true); */

	echo json_encode( $eventos );	
	/* --------------------------------------------------------- */
	function tituloEvento( $r ){
		//Devuelve el título de evento a mostrar en calendario
		return $r["nombre"]." > ".$r["actividad"];
	}
	/* --------------------------------------------------------- */
?>