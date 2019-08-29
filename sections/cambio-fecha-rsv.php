<section class="panel">
	<header class="panel-heading bg-dark">
		<h4>Fechas y cupos disponibles</h4>
	</header>

	<form id="frm-cambio-fecha-rsv" class="form-bordered">
		<input type="hidden" name="idreservacion" value="<?php echo $idr ?>">
		<input type="hidden" name="iduadmin" value="<?php echo $idu ?>">
		<div class="panel-body">
			<div class="form-group">
				<div class="col-sm-12">
					<div><?php echo $reservacion["actividad"] ?> </div>
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
					<?php include( "pautas-disponibles.php" ); ?> 
				</div>
			</div>
		</div>
		<?php if( count( $horarios ) > 0 ) { ?>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-12" style="text-align: right;">
						<button class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</footer>
		<?php } ?>
	</form>
</section>