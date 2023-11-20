<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h4 style="text-align:center;color: black;">Número de cuenta del Usuario: {{$modificar_voucher->cuenta}}</h4>
		<h4 style="text-align:center;color: black;">Nombre del Usuario: {{$modificar_voucher->nombre}} {{$modificar_voucher->apaterno}} {{$modificar_voucher->amaterno}}</h4>
	</div>
</div>
<form class="form" role="form" action="{{url("/ingles/guardar_comentario_voucher_rechazado/".$modificar_voucher->id_voucher)}}" method="POST">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="form-group">
				<label style="text-align:center;color: black;">Ingresar por que fue rechazado el voucher de pago</label>
				<textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Ingresa el motivo del porque fue rechazado"></textarea>
			</div>
		</div>
	</div>
		<div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Enviar</button>
	      </div>
</form>
