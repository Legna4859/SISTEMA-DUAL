<form id="form_modificar_requisicion" class="form" action="{{url("/presupuesto_anteproyecto/guardar_modificacion_requisicion_materiales/".$requsicion_material->id_actividades_req_ante)}}" role="form" method="POST" >
    {{ csrf_field() }}


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Elige mes de adquisición</label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="mes_mod" name="mes_mod" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($meses as $mes)
                    @if($requsicion_material->id_mes == $mes->id_mes)
                        <option value="{{$mes->id_mes}}" selected="selected" >{{  $mes->mes }}</option>

                    @else
                        <option value="{{$mes->id_mes}}" data-esta="{{$mes->mes}}">{{$mes->mes}} </option>
                    @endif
                @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 ">
            <div class="form-group">
                <label for="justificacion">Ingresa justificación</label>
                <textarea class="form-control" id="justificacion_mod" name="justificacion_mod" rows="3" placeholder="Ingresa juestificación" onkeyup="javascript:this.value=this.value.toUpperCase();">{{ $requsicion_material->justificacion }}</textarea>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="dropdown">
            <label for="exampleInputEmail1">Elige proyecto</label>
            <select class="form-control  "placeholder="selecciona una Opcion" id="proyecto_mod" name="proyecto_mod" required>
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($proyectos as $proyecto)
                        @if($requsicion_material->id_proyecto == $proyecto->id_proyecto)
                            <option value="{{$proyecto->id_proyecto}}" selected="selected" >{{  $proyecto->nombre_proyecto }}</option>

                        @else
                        <option value="{{$proyecto->id_proyecto}}" data-esta="{{$proyecto->nombre_proyecto }}">{{ $proyecto->nombre_proyecto }} </option>
                        @endif
                @endforeach
            </select>
            <br>
        </div>
    </div>
    <br>
</div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="dropdown">
                <label for="exampleInputEmail1">Elige el nombre de la partida presupuestal</label>
                <select class="form-control  "placeholder="selecciona una Opcion" id="partida_presupuestal_mod" name="partida_presupuestal_mod" required>
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($partidas_presupuestales as $partida)
                        @if($requsicion_material->id_partida_pres == $partida['id_partida_pres'])
                            <option value="{{$partida['id_partida_pres']}}" selected="selected" >{{$partida['clave_presupuestal'] }}   {{$partida['nombre_partida'] }}</option>

                        @else
                            <option value="{{$partida['id_partida_pres']}}" >{{$partida['clave_presupuestal'] }}   {{$partida['nombre_partida'] }}</option>
                        @endif
                    @endforeach
                </select>
                <br>
            </div>
        </div>
        <br>
    </div>
<div class="row">
    <div class="col-md-10 col-md-offset-1 ">

        <label for="exampleInputEmail1">Selecciona meta</label>
        <div id="meta_m">

                @foreach($metas as $meta)
                    @if($requsicion_material->id_meta == $meta->id_meta)
                    <div class="radio">
                        <label><input type="radio" name="meta_mod" value="{{ $meta->id_meta }}" checked>{{ $meta->meta }}</label>
                    </div>
                    @else
                    <div class="radio">
                        <label><input type="radio" name="meta_mod"  value="{{ $meta->id_meta }}">{{ $meta->meta }}</label>
                    </div>
                    @endif
                @endforeach
            </select>
        </div>

    </div>
</div>
</form>
<script>
    $(document).ready(function() {
        $("#proyecto_mod").change(function (e) {

            var id_proyecto = e.target.value;
            $.get('/presupuesto_anteproyecto/ver_partida_presupuestal/'+id_proyecto,function(data){

                $('#partida_presupuestal_mod').empty();
                $.each(data,function(datos_alumn,subcatObj){
                    //  alert(subcatObj);
                    $('#partida_presupuestal_mod').append('<option value="'+subcatObj.id_partida_pres+'" data-muni="'+subcatObj.nombre_partida+'" >'+subcatObj.clave_presupuestal+' '+subcatObj.nombre_partida+'</option>');
                });
            });
            $.get('/presupuesto_anteproyecto/ver_meta/' + id_proyecto, function (data) {

                $('#meta_m').empty();
                $.each(data, function (datos_alumno, subcatObj) {
                    //   alert(subcatObj);
                    $('#meta_m').append('<div class="radio"><label><input class="form-check-input"  type="radio" name="meta_mod" value="'+subcatObj.id_meta+'" required>'+subcatObj.meta+'</label></div>');

                });
            });
        });
    });
</script>
