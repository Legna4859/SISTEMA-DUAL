@extends('layouts.app')
@section('title', 'Anteproyecto Institucional')
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Proyectos de Residencia  del periodo {{ $periodo->periodo  }}<br> ( Oficio de aceptación de proyecto)</h3>
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
                            <th>Nombre del alumno</th>
                            <th>Nombre del proyecto</th>
                            <th>Asesor</th>
                            <th>Ver calificaciones </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($datos_alumn as $anteproyecto)

                            <tr>
                                <td>{{$anteproyecto['cuenta']}}</td>
                                <td>{{$anteproyecto['nombre']}} </td>
                                <td>{{$anteproyecto['nom_proyecto']}}</td>
                                <td>{{$anteproyecto['nombre_profesor']}}</td>
                                @if($anteproyecto['estado'] ==1)
                                    <td><button class="btn btn-primary agregar" id="{{ $anteproyecto['id_asesores'] }}">agregar no. oficio</button></td>
                                @else

                                <td style="text-align: center;">Numero oficio: <b>{{ $anteproyecto['numero_oficio'] }}</b> <br>
                                    <button class="btn btn-primary edita" id="{{ $anteproyecto['id_asesores'] }}"><i class="glyphicon glyphicon-edit"></i></button> <br>
                                    <button type="button" class="btn btn-success center" onclick="window.open('{{url('/residentes/oficio_aceptacion_proyecto/'.$anteproyecto['id_asesores'])}}')">Imprimir</button>
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
    <div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Agregar número de oficio</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_agregar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="guardar_nuevo" class="btn btn-primary acepta">Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar número de oficio</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_modificar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="guardar_modificar" class="btn btn-primary acepta">Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".agregar").click(function (){
                var id_asesor=$(this).attr('id');

                $.get("/residencia/agregar_no_oficio_aceptacion/"+id_asesor,function (request) {
                    $("#contenedor_agregar").html(request);
                    $("#modal_agregar").modal('show');
                });
            });
            $("#guardar_nuevo").click(function (){
                var numero_oficio = $("#numero_oficio").val();
                if(numero_oficio != ''){
                    $("#guardar_no_oficio").submit();
                    $("#guardar_no_oficio").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresa número de oficio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".edita").click(function (){
                var id_asesor=$(this).attr('id');

                $.get("/residencia/modificar_no_oficio_aceptacion/"+id_asesor,function (request) {
                    $("#contenedor_modificar").html(request);
                    $("#modal_modificar").modal('show');
                });
            });
            $("#guardar_modificar").click(function (){
                var numero_oficio = $("#mod_numero_oficio").val();
                if(numero_oficio != ''){
                    $("#guardar_mod_no_oficio").submit();
                    $("#guardar_modificar").attr("disabled", true);
                    swal({
                        type: "success",
                        title: "Registro exitoso",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    swal({
                        position: "top",
                        type: "error",
                        title: "Ingresa número de oficio",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });


        });
    </script>
@endsection