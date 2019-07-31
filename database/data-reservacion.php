<?php
	/* --------------------------------------------------------- */
	/* CBC - Datos sobre Reservaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerReservacionPorId( $dbh, $idr ){
		// Devuelve el registro de una reservación dado su id

		mysqli_query( $dbh, "SET lc_time_names = 'es_ES';" );
		$q = "select r.id, r.nombre, r.apellido, r.email, r.telefono, r.estado, 
		a.nombre as actividad, a.descripcion, a.imagen, 
		date_format(h.fecha,'%W %d de %M %h:%i %p') as fecha  
		from actividad a, horario h, reservacion r where r.HORARIO_id = h.id and 
		h.ACTIVIDAD_id = a.id and r.id = $idr";
		
		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		
		return $registro;
	}
	/* --------------------------------------------------------- */
	function obtenerReservacionPorToken( $dbh, $token ){
		// Devuelve el registro de una reservación dado su token de creación

		mysqli_query( $dbh, "SET lc_time_names = 'es_ES';" );
		$q = "select r.id, r.nombre, r.apellido, r.email, r.telefono, r.estado, 
		a.nombre as actividad, a.descripcion, a.imagen, 
		date_format(h.fecha,'%W %d de %M %h:%i %p') as fecha  
		from actividad a, horario h, reservacion r where r.HORARIO_id = h.id and 
		h.ACTIVIDAD_id = a.id and r.token_creacion = '$token'";
		
		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		return $registro;
	}
	/* --------------------------------------------------------- */
	function obtenerReservaciones( $dbh ){

		mysqli_query( $dbh, "SET lc_time_names = 'es_ES';" );
		$q = "select r.id, r.nombre, r.apellido, r.email, r.telefono, r.estado, 
		a.nombre as actividad, a.descripcion, a.imagen, a.id as ida,  
		date_format(h.fecha,'%W %d de %M %h:%i %p') as fecha_dia,
		date_format(h.fecha,'%Y-%m-%d %H:%i') as fecha_cal from actividad a, horario h, 
		reservacion r where r.HORARIO_id = h.id and h.ACTIVIDAD_id = a.id";

		return obtenerListaRegistros( mysqli_query( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
	function obtenerTokenReservacion( $param ){
		//Genera un código provisional enviado por email para confirmar y verificar cuenta
		$fecha = date_create();
		$date = date_timestamp_get( $fecha );
		return sha1( md5( $date.$param ) );
	}
	/* --------------------------------------------------------- */
	function reservar( $dbh, $reservacion ){
		// Procesa el registro de nueva reservación
		$estado = "pendiente";
		$q = "insert into reservacion (fecha, nombre, apellido, email, 
		telefono, token_creacion, estado, HORARIO_id) 
		values ( NOW(), '$reservacion[nombre]', '$reservacion[apellido]', 
		'$reservacion[email]', '$reservacion[telefono]', '$reservacion[token]', 
		'$estado', $reservacion[horario] )";

		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	function cancelarReservacion( $dbh, $idr ){
		// Cambia una reservación a estado cancelada
		$actualizado = 1;
		$estado = "cancelada";
		$q = "update reservacion set estado = '$estado', fecha_cancelacion = NOW() 
		where id = $idr";
		
		mysqli_query ( $dbh, $q );
		if( mysqli_affected_rows( $dbh ) == -1 ) $actualizado = 0;
		
		return $actualizado;
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["reservar"] ) ){ 
		// Invocación desde: js/fn-actividad.js
		include( "bd.php" );
		include( "../fn/fn-mailing.php" );
		
		parse_str( $_POST["reservar"], $reservacion );
		$reservacion = escaparCampos( $dbh, $reservacion );
		$reservacion["token"] = obtenerTokenReservacion( $reservacion["email"] );
		$rsp = reservar( $dbh, $reservacion );
		
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$reservacion["id"] = $rsp;
			$res["mje"] = "Su reservación se ha registrado con éxito";
			//enviarMensajeEmail( "nueva_reservacion", $reservacion, $reservacion["email"] );
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al registrar reservación";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["cancelar_r"] ) ){ 
		// Invocación desde: js/fn-actividad.js
		include( "bd.php" );
		include( "../fn/fn-mailing.php" );

		$token = $_POST["cancelar_r"];
		$reservacion = obtenerReservacionPorToken( $dbh, $token );
		$rsp = cancelarReservacion( $dbh, $reservacion["id"] );
		
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$res["mje"] = "Su reservación se ha cancelado con éxito";
			//enviarMensajeEmail( "cancelacion_reservacion", $reservacion, $reservacion["email"] );
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al cancelar reservación";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	function obtenerFechasReservadas( $dbh ){
		// Devuelve arreglo de las reservaciones asignadas a participantes (Calendario)

		$e = array();
	
		$reservaciones = obtenerReservaciones( $dbh );
		$eventos = array();
		
		foreach ( $reservaciones as $r ) {
			
			$e['id'] 			= $r["id"];
	    	$e['title'] 		= tituloEvento( $r );
	    	$e['start'] 		= $r["fecha_cal"];
	    	$e['end']			= $r["fecha_cal"];
	    	$e['constraint'] 	= "ACT".$r["ida"];
	    	
	    	array_push( $eventos, $e );
		}
		return $eventos;
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["mostrar_rsv"] ) ){ 
		// Invocación desde: js/fn-actividad.js
		include( "bd.php" );

		$idr = $_POST["mostrar_rsv"];
		$actividad = obtenerReservacionPorId( $dbh, $idr );
		
		if( $actividad != NULL ){
			$res["exito"] = 1;
			$res["reg"] = $actividad;
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al obtener actividad";
		}
		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
?>