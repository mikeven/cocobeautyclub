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
	// Actividades
	$actividades 	= obtenerActividades( $dbh );
	

	// Reservaciones registradas
	$eventos 		= obtenerFechasReservadas( $dbh );

	// Pautas de actividades: horarios en que pueden asignarse reservaciones
	// Se suman las pautas de actividades (como eventos de calendario) a las reservaciones registradas
	foreach ( $actividades as $a ) {
		$horarios 	= obtenerHorariosActividad( $dbh, $a["id"] );
		$pautas 	= vectorHorarios( $horarios );
		$eventos 	= array_merge( $eventos, $pautas );
	}

	/*$horarios1 	= obtenerHorariosActividad( $dbh, 1 );
	$pautas1 	= vectorHorarios( $horarios1 );
	$eventos 	= array_merge( $eventos, $pautas1 );

	$horarios2 	= obtenerHorariosActividad( $dbh, 2 );
	$pautas2 	= vectorHorarios( $horarios2 );

	$eventos 	= array_merge( $eventos, $pautas2 );*/

    /* $je = json_encode( $eventos );

	$json = $je;//file_get_contents('events.json');
	$input_arrays = json_decode($json, true); */

	echo json_encode( $eventos );	
	/* --------------------------------------------------------- */
	function tituloEvento( $r ){
		//Devuelve el título de evento a mostrar en calendario
		return $r["nombre"]." >> ".$r["actividad"];
	}
	/* --------------------------------------------------------- */
	function vectorHorarios( $horarios ){
		// Devuelve arreglo de las fechas pautadas de una actividad

		$e = array();
		$pautas = array();
		
		foreach ( $horarios as $h ) {
			
			$e['id'] 		= $h["id"];
			$e['groupId'] 	= "RESERVABLE";//"ACT".$h["ida"];
	    	$e['start'] 	= $h["fecha_cal"];
	    	$e['end'] 		= $h["fecha_cal"];
	    	$e['rendering'] = 'background';
	    	$e['color'] 	= colorActividad( $h["ida"] );

	    	array_push( $pautas, $e );
		}

		return $pautas;
	}
?>