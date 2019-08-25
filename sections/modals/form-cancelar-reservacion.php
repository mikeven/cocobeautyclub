<div id="frm-canc-rsv">
	<form class="frm-cancelar-rsv">
		<input id="idrsv" type="hidden" name="idreservacion" value="" required>
		<input type="hidden" name="iduadmin" value="<?php echo $idu ?>" required>
		<a id="ax_cancelar" href="#" class="ax_rsv lnk_cancelar_rsv">
			<i class="fa fa-times mr-xs"></i> Cancelar reservación
		</a>
		<div class="conf-canc_rsv">
			<button type="submit" class="mb-xs mt-xs mr-xs btn btn-xs btn-default lnk_conf_canc_rsv">Confirmar</button> | 
			<a href="#!" class="noconf_canc_rsv"> Regresar </a>
		</div>
	
	</form>
</div>