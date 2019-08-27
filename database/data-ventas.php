<?php
	/* --------------------------------------------------------- */
	/* CBC - Datos sobre ventas */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerReservacionesConVentas( $dbh ){
		// Devuelve el registro de las reservaciones con ventas asociadas

		$q = "select r.id, r.nombre, r.apellido, date_format(h.fecha,'%d/%m/%Y ') as fecha
		from horario h, reservacion r 
		where r.HORARIO_id = h.id and r.id in (select RESERVACION_id from compra) 
		order by h.fecha DESC";
		
		return obtenerListaRegistros( mysqli_query( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
	function obtenerVentasPorReservacion( $dbh, $idr ){
		// Devuelve el registro de una reservación dado su token de creación

		$q = "select c.id, p.nombre as producto, p.valor, c.cantidad 
		from compra c, producto p, reservacion r 
		where c.PRODUCTO_id = p.id and c.RESERVACION_id = r.id and r.id = $idr";

		return obtenerListaRegistros( mysqli_query( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
?>