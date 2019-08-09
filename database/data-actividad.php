<?php
	/* --------------------------------------------------------- */
	/* CBC - Datos sobre Actividades / Eventos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerActividades( $dbh ){
		//Devuelve todos los registros de actividades
		$q = "select id, nombre, descripcion, imagen from actividad";
		
		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerActividadesHorarios( $dbh ){
		//Devuelve todos los registros de actividades y sus horarios
		$q = "select a.id, a.nombre, date_format(h.fecha, '%d-%m-%Y') as fecha, 
		date_format(h.fecha, '%h:%i %p') as hora, h.id as idh from actividad a, horario h 
		where h.ACTIVIDAD_id = a.id order by fecha desc";
		
		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerInscritosHorario( $dbh, $idh ){
		// Devuelve la cantidad de participantes inscritos y el cupo en un horario
		$q = "select count(r.id) as num, h.cupo from reservacion r, horario h 
		where r.HORARIO_id = h.id and h.id = $idh and r.estado <> 'cancelada'";

		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		return $registro;
	}
	/* --------------------------------------------------------- */
	function obtenerActividadPorId( $dbh, $ida ){
		//Devuelve el registro de una actividad dado su id
		$q = "select id, nombre, descripcion, imagen from actividad where id = $ida";
		
		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		return $registro;
	}
	/* --------------------------------------------------------- */
	function obtenerHorariosActividad( $dbh, $ida ){
		// Devuelve los horarios en que está pautada una actividad

		$q = "select id, date_format(fecha,'%Y-%m-%d %H:%i') as fecha_cal,
		date_format(fecha,'%d/%m %h:%i %p') as fecha_horam,  
		ACTIVIDAD_id as ida from horario where ACTIVIDAD_id = $ida 
		and fecha > date_add( NOW(), interval -4 hour )";
		
		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerHorariosActividadPorFecha( $dbh, $ida, $fecha ){
		//Devuelve los registros de horas de una actividad por fecha dado su id
		$q = "select id, date_format(fecha,'%h:%i %p') as hora, cupo 
		from horario where '$fecha' like date_format(fecha,'%Y/%m/%d') 
		and ACTIVIDAD_id = $ida";
		
		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerHorarioPorId( $dbh, $id ){
		// Devuelve los datos de un horario dado su id
		$q = "select id, date_format(fecha,' %d/%m %h:%i %p') as fecha, cupo 
		from horario where id = $id";
		
		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		return $registro;
	}
	/* --------------------------------------------------------- */
	function cuposTomados( $dbh, $idh ){
		// Devuelve la cantidad de reservaciones de una actividad que cubren un cupo
		// Reservaciones en estado: 'pendiente', 'efectiva', 'caducada'
		$q = "select count(id) as reservados from reservacion 
		where estado <> 'cancelada' and HORARIO_id = $idh";
		
		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		return $registro;
	}
	/* --------------------------------------------------------- */
	function cuposDisponibles( $dbh, $idh ){
		// Devuelve la cantidad de cupos disponibles de una actividad en un horario
		$horario = obtenerHorarioPorId( $dbh, $idh );
		$cupo_h = $horario["cupo"];
		$tomados = cuposTomados( $dbh, $idh );

		return $cupo_h - $tomados["reservados"];
	}	
	/* --------------------------------------------------------- */
	function colorActividad( $id ){
		// Devuelve un color asociado a una actividad según su id
		$color = array(
	        1 => '#5cd4e7',
	        2 => '#fda2a2',
	        3 => '#d6a2fd'
	    );

	    return $color[ $id ];
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["nactividad"] ) ){ 
		// Invocación desde: js/fn-actividad.js
		include( "bd.php" );

		parse_str( $_POST["nactividad"], $actividad );
		$actividad = escaparCampos( $dbh, $actividad );
		
		$rsp = 1;//agregarActividad( $dbh, $actividad );
		if( $rsp != 0 ){
			$res["exito"] = 1;
			$res["mje"] = "Actividad registrada con éxito";
		}else{
			$res["exito"] = -1;
			$res["mje"] = "Error al registrar actividad";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
?>