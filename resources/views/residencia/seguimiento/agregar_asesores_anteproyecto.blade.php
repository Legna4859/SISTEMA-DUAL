@extends('layouts.app')
@section('title', 'Agregar asesores')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Anteproyectos aceptados</h3>
                    </div>
                </div>
            </div>
        </div>
        @if($no_plantilla ==0)
            <div class="row">
                <div class="col-md-5 col-md-offset-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">No se ha asignado plantilla de profesores al siguiente periodo </h3>
                        </div>
                    </div>
                </div>
            </div>

            @else
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>No.cuenta</th>
                        <th>Nombre del alumno</th>
                        <th>Nombre del anteproyecto</th>
                        <th>Nombre del asesor</th>
                        <th>Agregar asesor</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($anteproyectos as $anteproyecto)
                        <tr>
                            <td>{{$anteproyecto->cuenta}}</td>
                            <td>{{$anteproyecto->nombre}} {{$anteproyecto->apaterno}} {{$anteproyecto->amaterno}}</td>
                            <td>{{$anteproyecto->nom_proyecto}}</td>
                            @if($anteproyecto->asesor == 0)
                          <th>No tiene asesor</th>
                                @else
                                <th>{{$anteproyecto->titulo}}  {{$anteproyecto->profesor}}</th>
                           @endif

                            <td>
                                @if($anteproyecto->asesor == 0)

                                          <a href="#!" class="agregar" data-id="{{ $anteproyecto->id_anteproyecto}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>


                                @else
                                    <a href="#!" class="modificar" data-id="{{ $anteproyecto->id_anteproyecto}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>

                                @endif
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
       @endif
        <br>
    </main>


    <div class="modal fade" id="modal_agregar_asesores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Agregar Asesor</h4>
                    </div>
                    <div id="contenedor_agregar_asesores">


                    </div>



            </div>

        </div>
    </div>


    <div class="modal fade" id="modal_modificar_asesores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Modificar Asesor</h4>
                </div>
                <div id="contenedor_modificar_asesores">


                </div>



            </div>

        </div>
    </div>



    <script type="text/javascript">

        $(document).ready(function() {

            $(".agregar").click(function(){
                var id_anteproyecto=$(this).data("id");
                $.get("/residencia/mostrar_asesores_anteproyecto/"+id_anteproyecto,function(request){
                    $("#contenedor_agregar_asesores").html(request);
                    $("#modal_agregar_asesores").modal('show');

                });
            });
            $(".modificar").click(function(){
                var id_anteproyecto=$(this).data("id");
                $.get("/residencia/modificar_asesores_anteproyecto/"+id_anteproyecto,function(request){
                    $("#contenedor_modificar_asesores").html(request);
                    $("#modal_modificar_asesores").modal('show');

                });

            });
        });
    </script>
@endsection