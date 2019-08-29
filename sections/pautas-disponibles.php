<?php 
	foreach ( $pautas as $p ) { 
		$horarios = obtenerHorariosActividad( $dbh, $p["id"] );
?>
	<div> <?php echo $p["actividad"] ?> </div>
	<?php 
		foreach ( $horarios as $h ) { 
			$ch = "";
			if( $reservacion["idhorario"] == $h["id"] ) $ch = "checked";
			$cupos_dsp = cuposDisponibles( $dbh, $h["id"] );
			$dis = "";
			if( $cupos_dsp < 1 )  $dis = "disabled";
	?>
				<div class="radio-custom">
					<input type="radio" name="idhorario" required
					value="<?php echo $h['id'] ?>" <?php echo $ch ?> 
					<?php echo $dis ?>>
					<label for="nueva_fecha">
						<?php echo $h["fecha_horam"]; ?>
						<span class="lab_cupos_dsp">
							<?php echo "(Disponibles: $cupos_dsp)"; ?>
						</span>
					</label>
				</div>
	<?php } ?>

<?php } ?>