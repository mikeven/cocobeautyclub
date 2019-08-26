<section class="panel">
	<header class="panel-heading bg-dark">
		<h4>Registrar asistencia</h4>
	</header>
	<form id="frm-reg-asistencia" class="form-bordered">
		<input type="hidden" name="idreservacion" value="<?php echo $idr ?>">
		<input type="hidden" name="iduadmin" value="<?php echo $idu ?>">
		
		<div class="panel-body">
			<div id="reg_asistencia" class="form-group">
				<div class="radio-custom">
					<input type="radio" id="si_asistio" name="asistio" class="rb_asist" required>
					<label for="si_asistio">Asistió</label>
				</div>
				<div class="radio-custom">
					<input type="radio" id="no_asistio" name="asistio" class="rb_asist" required>
					<label for="no_asistio">No asistió</label>
				</div>
			</div>
			<div id="campos_compra">
				<p>Registrar compra realizada</p>
				<table>
					<thead>
						<tr> 
							<th style="width: 50%;">Producto</th>
							<th style="width: 20%" class="text-center">Cant</th>
							<th style="width: 20%" class="text-center"></th>
						</tr>
					</thead>
					<tbody>
						<tr class="gradeX">
							<td>
								<select id="producto" class="form-control lsprods" required>
									<?php foreach ( $productos as $p ) { ?>
										<option value="<?php echo $p['id']?>">
											<?php echo $p["nombre"]?>
										</option>
									<?php } ?>
								</select>
							</td>
							<td align="center" class="text-center">
								<select id="cant" class="form-control qcompra" required>
									<?php for( $i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i?>"><?php echo $i?></option>
									<?php } ?>
								</select>
							</td>
							<td align="center">
								<button type="button" class="btn btn-primary bt_agitem">+</button>
							</td>
						</tr>
					</tbody>
				</table>
				
				<hr>
				
				<div id="compra"> </div>
			</div>
			
			<hr>

			<p class="nota-compra">Clic en Guardar para registrar asistencia</p>
		</div>
		<footer id="ft_guardar_reg_asist" class="panel-footer">
			<div class="row">
				<div class="col-sm-12" style="text-align: right;">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</footer>
	</form>
</section>