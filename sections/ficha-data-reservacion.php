<section class="panel">
	
	<section class="panel panel-group">
		<header class="panel-heading bg-dark">
			<div class="widget-profile-info">
				<div class="profile-picture">
					<img id="img-rsv-act" 
					src="<?php echo "../images/".$reservacion["imagen"]?>">
				</div>
				<div class="profile-info">
					<h4 class="name text-semibold">
						<?php echo $reservacion["actividad"]?>
					</h4>
					<h5 id="fecha_rsv" class="role">
						<?php echo $reservacion["fecha"]?>
					</h5>
					<div class="profile-footer icono_estado">
						<?php echo $icono_e ?>
						<span id="estado_rsv"><?php echo $reservacion["estado"]?></span>
					</div>
				</div>
			</div>
		</header>
		<div id="ficha-reservacion" class="panel-body">
			<div class="row" style="padding: 20px 0">
				<div class="col-md-12 col-xs-12">
					<div>
						<i class="fa fa-user" aria-hidden="true"></i>
						<span><?php echo $reservacion["nombre"]?></span> 
						<span><?php echo $reservacion["apellido"]?></span>
					</div>
					<div>
						<i class="fa fa-envelope-square" aria-hidden="true"></i> 
						<span><?php echo $reservacion["email"]?></span>
					</div> 
					<div>
						<i class="fa fa-mobile" aria-hidden="true"></i> 
						<span><?php echo $reservacion["telefono"]?></span>
					</div>
					
					<hr>
					<div class="data-info-reg">
						Reservada el 
						<span><?php echo $reservacion["fecha_registro"]?></span>
						<span class="txautor">Por 
							<?php autorAccion( $dbh, $reservacion["usuario_registro"] ) ?>
						</span>
					</div>

					<?php if( $reservacion["usuario_modificacion"] != NULL ) { ?>
						<div class="data-info-reg">
							Actualizada el 
							<span><?php echo $reservacion["fecha_actualizacion"]?></span>
							<span class="txautor">Por  
								<?php autorAccion( $dbh, $reservacion["usuario_modificacion"] ) ?>
							</span>
						</div>
					<?php } ?>
					
					<?php if( $reservacion["estado"] == "cancelada" ) { ?>
						<div class="data-info-reg">
							Cancelada el 
							<span><?php echo $reservacion["fecha_cancelacion"]?></span>
							<span class="txautor">Por  
								<?php autorAccion( $dbh, $reservacion["usuario_cancelacion"] ) ?>
							</span> 
						</div>
					<?php } ?>
					<hr>
					<?php if( $reservacion["estado"] == "pendiente" ) { ?>
						<form class="frm-cancelar-rsv">
							<input type="hidden" name="idreservacion" 
							value="<?php echo $idr ?>" required>
							<input type="hidden" name="iduadmin" 
							value="<?php echo $idu ?>" required>
							<a href="#!" class="lnk_cancelar_rsv">
								<i class='fa fa-times-circle' aria-hidden='true'></i>
								Cancelar reservación
							</a>
							<div class="conf-canc_rsv">
								<button type="submit" class="mb-xs mt-xs mr-xs btn btn-xs btn-default lnk_conf_canc_rsv">Confirmar</button> | 
								<a href="#!" class="noconf_canc_rsv"> Regresar </a>
							</div>
						</form>
					<?php } ?>
				</div>
			</div>
		</div>
		
	</section>
	
</section>