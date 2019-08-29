<?php 
	/* CBC - Función para ejecutarse a través de cronjob */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	include( "database/bd.php" );
    include( "database/data-reservacion.php" );
	/* --------------------------------------------------------- */
	//Envíos de recordatorios de asistencia a participantes con reservaciones
	enviarRecordatorios( $dbh );
?>