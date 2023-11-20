@extends('layouts.app')
@section('title', 'Modificar de CCT')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Selecciona tu escuela de procedencia (bachillerato o preparatoria, etc.) correcta y despues dar clic en el botón modificar. <br>
                    <b>Observación: la búsqueda de tu escuela puede ser por medio del CCT para que sea más fácil encontrarla</b></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <form class="form" id="form_cct" action="{{url("/datos_alumnos/guardar_mod_cct/".$id_alumno)}}" role="form" method="POST" >
                {{ csrf_field() }}
                <table class="table table-bordered"  id="registro_cct">
                    <thead>
                    <tr>
                        <th>SELECCIONA ESCUELA</th>
                        <th>CCT</th>
                        <th>NOMBRE DE LA ESCUELA</th>
                        <th>DOMICILIO</th>
                        <th>MUNICIPIO</th>
                        <th>LOCALIDAD</th>
                        <th>TURNO</th>
                        <th>SERVICIO</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($escuelas as $escuela)
                        @if($escuela->id_institucion == $alumno->id_institucion)

                        <tr style="background: #b8daff;">

                            <th style="text-align: center"> <input type="radio" name="id_escuela" id="id_escuela" value="{{ $escuela->id_institucion }}" checked> </th>
                            <td>{{ $escuela->cct }}</td>
                            <td>{{ $escuela->nombre_escuela }}</td>
                            <td>{{ $escuela->domicilio }}</td>
                            <td>{{ $escuela->municipio }}</td>
                            <td>{{ $escuela->localidad }}</td>
                            <td>{{ $escuela->turno }}</td>
                            <td>{{ $escuela->servicio }}</td>

                        </tr>
                        @else
                            <tr>

                                <th style="text-align: center"> <input type="radio" name="id_escuela" id="id_escuela" value="{{ $escuela->id_institucion }}"> </th>
                                <td>{{ $escuela->cct }}</td>
                                <td>{{ $escuela->nombre_escuela }}</td>
                                <td>{{ $escuela->domicilio }}</td>
                                <td>{{ $escuela->municipio }}</td>
                                <td>{{ $escuela->localidad }}</td>
                                <td>{{ $escuela->turno }}</td>
                                <td>{{ $escuela->servicio }}</td>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="col-md-1">
            <a class=" btn btn-primary flotante" id="enviar" type="button" >Modificar<span class="glyphicon glyphicon-ok " aria-hidden="true"/></a>
        </div>
        <div class="col-md-1">
            <a class=" btn btn-danger flotante" href="{{url('/datos_alumno')}}" type="button" >Cancelar</a>
        </div>
    </div>

    <script type="text/javascript">


        $(document).ready(function() {
            $('#registro_cct').DataTable();
            $("#enviar").click(function (){
                var estado_radio = $("input[type='radio'][name='id_escuela']:checked").val();;
//alert(estado_radio);
                if( estado_radio != undefined){
                    $("#form_cct").submit();
                    swal({
                        position: "top",
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 3500
                    });

                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "No se ha seleccionado ningún  centro de trabajo.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }

            });
        });
    </script>
@endsection