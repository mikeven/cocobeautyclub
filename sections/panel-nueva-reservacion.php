<section class="panel">
	<header class="panel-heading bg-dark">
		<h4>Actividades</h4>
	</header>
	<div class="panel-body">
		<?php 
			foreach ( $actividades as $a ) {
				$horarios = obtenerHorariosActividad( $dbh, $a["id"] );
				$color = colorActividad( $a["id"] );
		?>
			<div class="menu_act_cal" >
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default btn-act-cal" data-trg="hor<?php echo $a['id'] ?>" 
				style="background: <?php echo $color?>">
					<i class="fa fa-book">
					</i> <?php echo $a["nombre"] ?>
				</button>
			</div>
			<div id="hor<?php echo $a['id'] ?>" class="hor_nvarsv">
				<?php 
					foreach ( $horarios as $h ) { 
						$cupos_dsp = cuposDisponibles( $dbh, $h["id"] );
				?>
				<div>
					<span style="color: #777"><?php echo $h["fecha_horam"]?></span>
					<a href="#nueva-reservacion" 
					class="modal-sizes modal-with-zoom-anim bnva_rsv" 
					data-idh="<?php echo $h['id'] ?>" 
					data-nactividad="<?php echo $a['nombre'] ?>" 
					data-horario="<?php echo $h['fecha_horam']?>">
						<button class="mb-xs mt-xs mr-xs btn btn-xs btn-dark">
							<i class="fa fa-plus"></i><i class="fa fa-book"></i>
						</button>
					</a> &nbsp;
					<span class="cdispcal"><?php echo $cupos_dsp."/".$h["cupo"]; ?></span>
				</div>
				<?php } ?>
			</div>
		<?php } ?>	
	</div>
</section>
<?php include( "modals/form-nueva-reservacion.php" ); ?>