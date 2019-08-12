<div id="nueva-reservacion" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<form id="frm-nvareservacion" class="form-horizontal mb-lg">
			
			<input id="id_horario_act" type="hidden" name="horario">
			<input type="hidden" name="uadmin" value="<?php echo $idu?>">
			<section class="panel">
				<header class="panel-heading bg-dark">
					<h4>
						<span id="desc_actividad"></span> <span id="hact_nvarsv"></span>
					</h4>
					<p class="panel-subtitle">NUEVA RESERVACIÓN</p>
				</header>
				<div class="panel-body">
					<div class="validation-message">
						<ul></ul>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre
							<span class="required">*</span></label>
						<div class="col-sm-9">
							<input type="text" name="nombre" class="form-control" 
							title="Ingrese un nombre" placeholder="" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Apellido<span class="required">*</span></label>
						<div class="col-sm-9">
							<input type="text" name="apellido" class="form-control" 
							title="Ingrese un apellido" placeholder="" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Email <span class="required">*</span></label>
						<div class="col-sm-9">
							<input type="email" name="email" class="form-control" 
							title="Ingrese un correo electrónico" placeholder="" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Teléfono</label>
						<div class="col-sm-9">
							<input type="text" name="telefono" title="Ingrese número telefónico" 
							class="form-control" placeholder=""/>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-12 text-right">
							<button class="btn btn-default modal-dismiss cnc_nr">Cancelar</button>
							<button class="btn btn-primary">Guardar</button>
						</div>
					</div>
				</footer>
			</section>
			
		</form>
	</section>
</div>