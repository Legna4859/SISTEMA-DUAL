@extends('layouts.app')
@section('title', 'Residencia')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Autorizar impresión de acta de residencia</h3>
                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-body">

                    <table id="table_enviado" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No. cuenta</th>
                            <th>Nombre del estudiante</th>
                            <th>Carrera</th>
                            <th>Calificar</th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumnos)

                            <tr>
                                <td>{{ $alumnos->cuenta }}</td>
                                <td>{{ $alumnos->nombre }} {{ $alumnos->apaterno }} {{ $alumnos->amaterno }}</td>
                                <td>{{ $alumnos->carrera }}</td>
                                @if($alumnos->id_calificar_departamento == 0)
                                <td>  <button class="btn btn-primary edita" id="{{ $alumnos->id_promedio_general }}">Autorizar</button>
                                </td>
                                @else
                                    <td>
                                        Autorizado
                                    </td>
                                @endif




                            </tr>


                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2" id="container">

        </div>
    </div>
    <div class="row">
        <br>
        <br>
    </div>
    {{-- Modal para poder imprimir la acta de residencia y registrar su calificacion --}}
    <form id="form_registar_calificacion" action="{{url("/residencia/registrar_estado_acta/")}}" class="form" role="form" method="POST">
        <div class="modal fade bs-example-modal-lg" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Autorizar</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}

                        <div class="row">
                            <div id="contenedor_agregar">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary " id="aceptar">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script language="JavaScript">
        $(document).ready(function() {
            $("#table_enviado").DataTable( {
            } );

            $("#table_enviado").on('click','.edita',function(){
                var id_promedio_general=$(this).attr('id');

                $.get("/residencia/autorizacion_acta_alumno/"+id_promedio_general,function (request) {
                    $("#contenedor_agregar").html(request);
                    $("#modal_agregar").modal('show');
                });
            });
            $("#aceptar").click(function (){
                $("#aceptar").attr("disabled", true);
                $("#form_registar_calificacion").submit();
                swal({
                    position: "top",
                    type: "success",
                    title: "Autorización exitosa",
                    showConfirmButton: false,
                    timer: 3500
                });
            });



        });
    </script>


@endsection