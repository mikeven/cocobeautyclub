<div id="reservacion-calendario" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<form id="ficha-reservacion" class="form-horizontal mb-lg">
			<header id="tit-reservacion" class="panel-heading">
				<h2 class="panel-title"> </h2>
			</header>
			<div class="panel-body">
				<input id="id_reservacion_cal" type="hidden" name="id_reservacion">
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div>
							<i class="fa fa-user" aria-hidden="true"></i>
							<span id="nombre_rsv"></span> <span id="apellido_rsv"></span>
						</div>
						<div>
							<i class="fa fa-envelope-square" aria-hidden="true"></i> 
							<span id="email_rsv"></span>
						</div> 
						<div>
							<i class="fa fa-mobile" aria-hidden="true"></i> 
							<span id="telefono_rsv"></span>
						</div>
						<hr>
						<div>
							<i class="fa fa-calendar" aria-hidden="true"></i> 
							<span id="fecha_rsv"></span>
						</div>
						<div>
							<i id="i_estado_rsv" class="" aria-hidden="true"></i> 
							<span id="estado_rsv"></span>
						</div>
						
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="data-info-reg">
							Realizada:  
							<span id="fecha_reg_rsv"></span>
						</div>
						<div class="data-info-reg">
							Registrada por:  
							<span id="autor_reg_rsv">Participante</span>
						</div>
						<div class="data-info-reg">
							Cancelada por:  
							<span id="autor_reg_rsv">Nombre administrador</span>
							(<span id="fecha_canc_rsv"></span>)
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<a href="#!">Cambiar</a> | 
						<a href="#!">Cancelar</a> | 
						<a href="#!">Registrar asistencia</a>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button id="cl_frm_act_cal" class="btn btn-default modal-dismiss">Cerrar</button>
					</div>
				</div>
			</footer>
		</form>
	</section>
</div>