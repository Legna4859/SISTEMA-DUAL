<form class="form" id="formulario_modificar_carta_presentacion" action="{{url("/servicio_social/modificacion_carta_presentacion/")}}" role="form" method="POST" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <p><b>No. Cuenta: </b> {{$registro[0]->cuenta}}  <b>      Nombre del alumno:</b> {{$registro[0]->nombre}} {{$registro[0]->apaterno}} {{$registro[0]->amaterno}}</p>
            <label for="nombre_proyecto">Agregar pdf de  la Carta de Presentación-Aceptación.<b style="color:red; font-size:23px;">*</b></label>
            <input type="hidden"  id="id_alumno" name="id_alumno" value="{{{$registro[0]->id_alumno}}}"   required/>
            <input class="form-control"  id="pdf_documento_carta" name="pdf_documento_carta" type="file"   accept="application/pdf" required/>

            </p>



        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label for="nombre_proyecto">Seleccionar el Periodo que se registrara el estudiante<b style="color:red; font-size:23px;">*</b></label>
            <select class="form-control" id="id_periodo" name="id_periodo" required>
                @foreach($periodos as $periodos)
                    @if($datos_constancia[0]->id_periodo==$periodos->id_periodo)
                        <option value="{{$periodos->id_periodo}}" selected="selected" >{{$periodos->periodo }}</option>
                    @else
                        <option value="{{$periodos->id_periodo}}"> {{$periodos->periodo }}</option>
                    @endif

                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p></p>
        </div></div>

</form>
