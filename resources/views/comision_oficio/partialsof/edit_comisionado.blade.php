
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="descripcion_oficio">Nombre del comisionado</label>
            <input type="hidden" id="id_oficio_comisionado" name="id_oficio_comisionado" value="{{ $comisionado->id_oficio_personal }}">
            <input class="form-control" type="text" id="nombre" readonly="readonly" name="nombre" value="{{ $comisionado->nombre }}">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5 col-md-offset-1">
        <div class="dropdown">
            <label for="selectLugar_s">Viaticos</label>
            <select class="form-control" id="viaticos" name="viaticos"  required >
                <option disabled selected hidden>Selecciona una opción</option>
                @foreach($respuestas as $respuestas)
                    @if($comisionado->viaticos==$respuestas->id_respuesta)
                        <option value="{{$respuestas->id_respuesta}}" selected="selected" >{{$respuestas->respuesta}}</option>
                    @else
                        <option value="{{$respuestas->id_respuesta}}"> {{$respuestas->respuesta}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="dropdown">
            <label for="selectLugar_s">Automovil</label>
            <select class="form-control" id="automoviles" name="automoviles"  required >
                <option disabled selected>Selecciona...</option>
                @foreach($respuestass as $respuestass)
                    @if($comisionado->automovil==$respuestass->id_respuesta)
                        <option value="{{$respuestass->id_respuesta}}" selected="selected" >{{$respuestass->respuesta}}</option>
                    @else
                        <option value="{{$respuestass->id_respuesta}}"> {{$respuestass->respuesta}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
@if($auto ==1)
<div class="row" style="display: none" id="lleva_auto">
    <div class="col-md-4 col-md-offset-1">
        <div class="form-group">
            <label for="automovil">Automovil</label>

                <select class="form-control required " placeholder="selecciona una Opcion" id="automovil" name="automovil"  >
                    <option disabled selected hidden>Selecciona una opción</option>
                    @foreach($automoviles as $automoviles)
                        <option value="{{$automoviles->id_vehiculo}}" data-esta="{{$automoviles->modelo}}">{{$automoviles->modelo}} {{$automoviles->placas}}</option>
                    @endforeach
                </select>



        </div>
        <br>
    </div>
    <div class="col-md-4 col-md-offset-1">
        <div class="form-group">
            <label for="licencia">licencia</label>
            <input class="form-control required " id="licencia" name="licencia" />
        </div>
        <br>
    </div>
</div>
    @elseif($auto ==2)
    <div class="row" style="display: inline" id="lleva_auto">
        <div class="col-md-4 col-md-offset-1">
            <div class="dropdown">
                <label for="automovil">Automovil</label>
                <select class="form-control " id="automovil" name="automovil" >
                    @foreach($automoviles as $automoviles)
                        @if($auto_comisionado->id_vehiculo==$automoviles->id_vehiculo)
                            <option value="{{$automoviles->id_vehiculo}}" selected="selected" >{{$automoviles->modelo}} {{$automoviles->placas}}</option>
                        @else
                            <option value="{{$automoviles->id_vehiculo}}"> {{$automoviles->modelo}} {{$automoviles->placas}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <br>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <div class="form-group">
                <label for="licencia">licencia</label>
                <input class="form-control required" id="licencia" name="licencia" value="{{$auto_comisionado->licencia}}" />
            </div>
            <br>
        </div>
    </div>
@endif
<script>

    $(document).ready(function() {

        $("#automoviles").change(function() {
            var auto=$(this).val();
            if(auto ==2){
                $("#lleva_auto").css("display", "block");




            } if(auto ==1){
                $("#lleva_auto").css("display", "none");




            }
        });
    });

</script>