<div id="reservacion-calendario" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<form id="ficha-reservacion" class="form-horizontal mb-lg">
			
			<input id="id_reservacion_cal" type="hidden" name="id_reservacion">
				<section class="panel panel-group">
					<header class="panel-heading bg-dark">
						<div class="widget-profile-info">
							<div class="profile-picture">
								<img src="assets/images/!logged-user.jpg">
							</div>
							<div class="profile-info">
								<h4 class="name text-semibold rsv_nactividad"></h4>
								<h5 id="fecha_rsv" class="role"></h5>
								<div class="profile-footer">
									<i id="i_estado_rsv" class="" aria-hidden="true"></i> 
									<span id="estado_rsv"></span>
								</div>
							</div>
						</div>
					</header>
					<div class="panel-body">
						<div class="row" style="padding: 20px 0">
							<div class="col-md-12 col-xs-12">
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
								<div class="data-info-reg">
									Reservada el 
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
					</div>
					<div class="panel-footer panel-footer-btn-group panel-rsv-acciones">
						<a href="#">
							<i class="fa fa-calendar mr-xs"></i> Cambiar fecha
						</a>
						<a href="#">
							<i class="fa fa-times mr-xs"></i> Cancelar reservación
						</a>
						<a href="#">
							<i class="fa fa-check-square mr-xs"></i> Registrar asistencia
						</a>
					</div>
					<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button id="cl_frm_act_cal" class="btn btn-default modal-dismiss">Cerrar</button>
					</div>
				</div>
			</footer>
				</section>
			
		</form>
	</section>
</div>