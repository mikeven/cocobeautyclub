<?php 
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Funciones sobre reservaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	
	/* --------------------------------------------------------- */
	function autorAccion( $dbh, $autor ){

		$usuario = obtenerUsuarioPorId( $dbh, $autor );
		echo ( $autor == NULL ) ? "Participante" : $usuario["nombre"]." ".$usuario["apellido"];
	}
	/* --------------------------------------------------------- */
?>