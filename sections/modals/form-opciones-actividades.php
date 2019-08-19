<div id="opciones-actividades" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<form id="frm-opciones-actividades" class="form-horizontal mb-lg">
			
			<input id="id_reservacion" type="hidden" name="idreservacion">
			<input type="hidden" name="iduadmin" value="<?php echo $idu?>">
			<section class="panel">
				<header class="panel-heading bg-dark">
					<h4 id="data_reservacion">
						
					</h4>
					<p class="panel-subtitle">CONFIRME EL CAMBIO DE ACTIVIDAD Y FECHA</p>
				</header>
				<div id="ls_opciones_actividades" class="panel-body">
					
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-12 text-right">
							<button id="rvt_drag_cal" class="btn btn-default modal-dismiss cnc_nr">Cancelar</button>
							<button class="btn btn-primary">Guardar</button>
						</div>
					</div>
				</footer>
			</section>
			
		</form>
	</section>
</div>