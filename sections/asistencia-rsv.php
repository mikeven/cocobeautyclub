<section class="panel">
	<header class="panel-heading bg-dark">
		<h4>Registrar asistencia</h4>
	</header>
	<form id="frm-reg-asistencia" class="form-bordered">
		<input type="hidden" name="idreservacion" value="<?php echo $idr ?>">
		<input type="hidden" name="iduadmin" value="<?php echo $idu ?>">
		<div class="panel-body">
			<div class="form-group">
				<p>Registrar compra realizada</p>
				
				<table class="table table-bordered table-striped mb-none" 
				id="datatable-default">
					<thead>
						<tr> 
							<th style="width: 80%">Producto</th>
							<th style="width: 20%">Cantidad</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						foreach ( $productos as $p ) { 
					?>
						<tr class="gradeX">
							<td><?php echo $p["nombre"]?></td>
							<td class="text-center">
								<input  id="q<?php echo $p["id"]?>" type="txt" 
								name="cant" class="qcompra" style="width: 80%" 
								maxlength="3" onkeypress='return isIntegerKey(event)'>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<p class="nota-compra">Dejar en blanco las cantidades si no hay compra. 
					<br>Clic en Guardar para registrar asistencia</p>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-sm-12" style="text-align: right;">
					<button class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</footer>
	</form>
</section>