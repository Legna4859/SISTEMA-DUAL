@foreach($array_requisiciones as $req)
    <form id="form_guardar_aut_req" class="form" action="{{url("/presupuesto_autorizado/guardar_aut_requisicion/".$req['id_actividades_req_ante'])}}" role="form" method="POST" >
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="form-group">
                    <label>Ingresar descripcion solicitud</label>
                    <textarea class="form-control" id="des_solicitud" name="des_solicitud" rows="3" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                </div>
            </div>
        </div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h4>Clave presupuestal: {{ $req['clave_presupuestal'] }}</h4>
        <h4>Denominación: {{ $req['nombre_partida'] }}</h4>
        <h4>MES: {{ $req['mes'] }}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h4 style="text-align: center">Materiales o servicios</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Descripcion</th>
                <th>Unidad de medida</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Importe</th>
            </tr>
            </thead>
            <tbody>
            <?php $total_req=0; ?>
            @foreach($req['materiales'] as $mat)
                    <?php
                    $importe=$mat['cantidad']*$mat['precio_unitario'];
                    $total_req=$total_req+$importe;
                    ?>
                <tr>
                    <td>{{$mat['descripcion']}}</td>
                    <td>{{$mat['unidad_medida']}}</td>
                    <td>{{$mat['cantidad']}}</td>
                    <td>{{ number_format($mat['precio_unitario'], 2, '.', ',')  }}</td>
                    <td>{{ number_format($importe, 2, '.', ',')  }}</td>
                </tr>
          @endforeach
            <tr>
                <td colspan="4" style="text-align: right">Total</td>
                <td>{{ number_format($total_req, 2, '.', ',')  }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
    </form>
    @endforeach

