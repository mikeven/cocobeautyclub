<?php
	/* --------------------------------------------------------- */
	/* CBC - Datos sobre Reservaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerReservacionPorId( $dbh, $idr ){
		// Devuelve el registro de una reservación dado su id

		mysqli_query( $dbh, "SET lc_time_names = 'es_ES';" );
		$q = "select r.id, r.nombre, r.apellido, r.email, r.telefono, r.estado, 
		r.usuario_registro, r.usuario_cancelacion, r.usuario_modificacion, 
		a.id as ida, a.nombre as actividad, a.descripcion, a.imagen, h.id as idhorario, 
		date_format(h.fecha,'%W %d de %M %h:%i %p') as fecha, 
		date_format(r.fecha,'%d/%m/%Y %h:%i %p') as fecha_registro,
		date_format(r.fecha_cambio,'%d/%m/%Y %h:%i %p') as fecha_actualizacion, 
		date_format(r.fecha_cancelacion,'%d/%m/%Y %h:%i %p') as fecha_cancelacion, 
		( NOW() >= h.fecha ) as fecha_pasada
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
		// Devuelve la lista de reservaciones realizadas que no estén canceladas
		mysqli_query( $dbh, "SET lc_time_names = 'es_ES';" );
		$q = "select r.id, r.nombre, r.apellido, r.email, r.telefono, r.estado, 
		a.nombre as actividad, a.descripcion, a.imagen, a.id as ida,  
		date_format(h.fecha,'%W %d de %M %h:%i %p') as fecha_dia,
		date_format(h.fecha,'%Y-%m-%d %H:%i') as fecha_cal from actividad a, horario h, 
		reservacion r where r.HORARIO_id = h.id and h.ACTIVIDAD_id = a.id 
		and r.estado <> 'cancelada'";

		return obtenerListaRegistros( mysqli_query( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
	function obtenerParticipantesPorHorarioActividad( $dbh, $idh ){
		// Devuelve la lista de participantes registrados en una actividad en un horario 
		// (reservaciones no canceladas)
		mysqli_query( $dbh, "SET lc_time_names = 'es_ES';" );
		$q = "select r.id, r.nombre, r.apellido, r.telefono from horario h, 
		reservacion r where r.HORARIO_id = h.id and h.id = $idh and r.estado <> 'cancelada'";

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
	function actualizarReservacion( $dbh, $reservacion ){
		// Actualiza el horario de una reservación
		$actualizado = 1;
		$q = "update reservacion set HORARIO_id = $reservacion[idhorario], 
		usuario_modificacion = $reservacion[iduadmin], fecha_cambio = NOW() 
		where id = $reservacion[idreservacion]";
		
		mysqli_query ( $dbh, $q );
		if( mysqli_affected_rows( $dbh ) == -1 ) $actualizado = 0;
		
		return $actualizado;
	}
	/* --------------------------------------------------------- */
	function cancelarReservacionAdmin( $dbh, $reservacion ){
		// Actualiza una reservación como cancelada
		$actualizado = 1;
		$q = "update reservacion set estado = 'cancelada', 
		usuario_cancelacion = $reservacion[iduadmin], fecha_cancelacion = NOW() 
		where id = $reservacion[idreservacion]";
		
		mysqli_query ( $dbh, $q );
		if( mysqli_affected_rows( $dbh ) == -1 ) $actualizado = 0;
		
		return $actualizado;
	}
	/* --------------------------------------------------------- */
	function hacerReservacionEfectiva( $dbh, $r ){
		// Actualiza una reservación como efectiva
		$actualizado = 1;
		$q = "update reservacion set estado = 'efectiva', 
		asistio = '$r[asistio]' where id = $r[idreservacion]";
		
		mysqli_query ( $dbh, $q );
		if( mysqli_affected_rows( $dbh ) == -1 ) $actualizado = 0;
		
		return $actualizado;
	}
	/* --------------------------------------------------------- */
	function actualizarVigenciaReservaciones( $dbh ){
		// Actualiza el estado de las reservaciones que ya pasaron su fecha de vigencia.
		$q = "update reservacion inner join horario on 
				reservacion.HORARIO_id = horario.id SET estado = 'caducada' 
				where estado = 'pendiente' and ( NOW() >= horario.fecha )";

		mysqli_query ( $dbh, $q );
	}
	/* --------------------------------------------------------- */
	function registarItemCompra( $dbh, $idr, $idp, $cant ){
		// Ingresa un ítem de compra asociado a una reservación
		$q = "insert into compra ( RESERVACION_id, PRODUCTO_id, cantidad ) 
		values ( $idr,  $idp, $cant )";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	function ingresarCompra( $dbh, $reservacion ){
		// Actualiza una reservación a estado efectiva y guarda la compra del participante 
		
		$idr = $reservacion["idreservacion"];
		$rsp = hacerReservacionEfectiva( $dbh, $reservacion );

		foreach ( $reservacion as $item => $cant ){
		    if( $item != "idreservacion" && $item != "iduadmin" && $item != "asistio" ){
		    	list( $x, $idp ) = explode( '-', $item );
		    	registarItemCompra( $dbh, $idr, $idp, $cant );
		    }
		}

		return $rsp;
	}
	/* --------------------------------------------------------- */
	function iconoEstado( $e ){
      // Devuelve el ícono reservación según estado

      $icono_estado = array(
        'pendiente' => "<i class='fa fa-clock-o' aria-hidden='true'></i>",
        'efectiva' 	=> "<i class='fa fa-check' aria-hidden='true'></i>",
        'cancelada' => "<i class='fa fa-times-circle' aria-hidden='true'></i>", 
        'caducada'	=> "<i class='fa fa-exclamation' aria-hidden='true'></i>"
      );

      return $icono_estado[ $e ];
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
	    	$e['constraint'] 	= "RESERVABLE";//"ACT".$r["ida"];
    		$e['color'] 		= colorActividad( $r["ida"] );
	    	
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
	if( isset( $_POST["mod_hor_rsv"] ) ){ 
		// Invocación desde: js/fn-reservacion.js
		include( "bd.php" );

		parse_str( $_POST["mod_hor_rsv"], $reservacion );
		
		$rsp = actualizarReservacion( $dbh, $reservacion );
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$res["mje"] = "Reservación modificada con éxito";
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al modificar reservación";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["cancelar_rsv"] ) ){ 
		// Invocación desde: js/fn-reservacion.js
		include( "bd.php" );

		parse_str( $_POST["cancelar_rsv"], $reservacion );
		
		$rsp = cancelarReservacionAdmin( $dbh, $reservacion );
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$res["mje"] = "Reservación cancelada con éxito";
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al cancelar reservación";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["reservar"] ) ){ 
		// Invocación desde: js/fn-reservacion.js
		include( "bd.php" );
		include( "data-actividad.php" );
		//include( "../fn/fn-mailing.php" );
		
		parse_str( $_POST["reservar"], $reservacion );
		$reservacion = escaparCampos( $dbh, $reservacion );
		$reservacion["token"] = obtenerTokenReservacion( $reservacion["email"] );
		
		if( cuposDisponibles( $dbh, $reservacion["horario"] ) > 0 ){
			
			$rsp = reservar( $dbh, $reservacion );
			
			if( $rsp != 0 ){
				$res["exito"] = 1;
				$reservacion["id"] = $rsp;
				$res["mje"] = "Reservación registrada con éxito";
				//enviarMensajeEmail( "nueva_reservacion", $reservacion, $reservacion["email"] );
			}else{
				$res["exito"] = -1;
				$res["mje"] = "Error al registrar reservación";
			}
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Cupos agotados para este horario";	
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["asistencia"] ) ){ 
		// Invocación desde: js/fn-reservacion.js
		include( "bd.php" );

		parse_str( $_POST["asistencia"], $reservacion );
		
		$rsp = ingresarCompra( $dbh, $reservacion );
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$res["mje"] = "Registro de asistencia exitoso";
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al registrar asistencia";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["mover_reserva"] ) ){
		// Invocación desde: js/fn-actividad.js	
		include( "bd.php" );
		parse_str( $_POST["mover_reserva"], $reservacion );
		
		$rsp = actualizarReservacion( $dbh, $reservacion );
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$res["mje"] = "Reservación modificada con éxito";
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al modificar reservación";
		}

		echo json_encode( $res );
	}
?>