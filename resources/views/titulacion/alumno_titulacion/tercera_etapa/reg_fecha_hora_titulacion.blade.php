@extends('layouts.app')
@section('title', 'Titulación')
@section('content')

    <main class="col-md-12">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">Enviar registro de jurado y fecha de titulación</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       <h3 style="text-align: center">Fecha de titulación: {{ $fecha_titulacion }}</h3>
                        <h3 style="text-align: center"> Sala de titulación: {{ $sala->nombre_sala }}</h3>

                        @if($disponibilidad_dia == 0)
                            <h3 style="color: #942a25">No hay disponibilidad en esta sala, en esta fecha.</h3>
                        @else
                            <form id="form_registro_hora_titulacion" class="form" action="{{url("/titulacion/registrar_fecha_jurado/".$id_alumno)}}" role="form" method="POST" >
                                {{ csrf_field() }}
                            <div class="form-group">
                                <input class="form-control" type="hidden"  id="fecha_titulacion" name="fecha_titulacion"  value="{{ $fecha_titulacion }}" />
                                <input class="form-control" type="hidden"  id="sala_titulacion" name="sala_titulacion"  value="{{ $sala->id_sala }}" />

                                <div class="dropdown">
                                    <h3 style="color: blue" for="hora">Selecciona hora de titulación</h3>
                                    <select name="hora_titulacion" id="hora_titulacion" class="form-control " >
                                        <option  disabled selected hidden>Selecciona hora de titulación</option>
                                        @foreach($horas_disponible as $hora)
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            <option value="{{$hora['id_horario_dias']}}" >{{$hora['nombre_hora']}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                            </form>

                            <p style="text-align: center"> <button id="eliminar_fecha" class="btn btn-danger">Eliminar Fecha</button>  <button id="guardar_hora_titulacion" class="btn btn-primary">Guardar fecha de titulación</button></p>


                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--eliminar la fecha de titulación --}}

        <div class="modal fade" id="modal_eliminar_fecha_jurado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Eliminar la fecha de titulación</h4>
                    </div>
                    <form id="form_eliminar_fecha_jurado" class="form" action="{{url("/titulacion/elim_fe_titulacion/".$id_alumno)}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-body">


                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h3>Seguro que quiere eliminar la fecha de titulación </h3>
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{--fin de eliminar fecha de titulación--}}


    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_hora_titulacion").click(function (event) {

                var horario_titulacion=$("#hora_titulacion").val();



                    if(horario_titulacion == null ){
                        swal({
                            position: "top",
                            type: "error",
                            title: "Selecciona hora Titulación",
                            showConfirmButton: false,
                        });
                    }else{
                        $("#form_registro_hora_titulacion").submit();
                        $("#guardar_hora_titulacion").attr("disabled", true);
                        swal({
                            type: "success",
                            title: "Registro exitoso",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }

            });
            $("#eliminar_fecha").click(function (){
                $("#modal_eliminar_fecha_jurado").modal('show');
            });
        });

    </script>



@endsection