@extends('layouts.app')
@section('title', 'Academia')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Academia</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-md-offset-2">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Nombre del docente</th>
                        <th>Cargo</th>
                        <th>Editar</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($academias as $academia)
                        <tr>
                            <td>{{$academia->nombre}}</td>
                            <td>{{$academia->cargo}}</td>

                            <td>
                                <a href="#!" class="modificar" data-id="{{ $academia->id_academia}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            @if($maximo_academia==1)
            @else
            <div class="col-md-1 col-md-offset-2">
                <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar " data-target="#modal_agregar_academia" type="button" class="btn btn-success btn-lg flotante">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
            @endif
 <br><br>
        </div>
        <br>
    </main>



    <div class="modal fade" id="modal_agregar_academia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar comisionado</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/residencia/agregar_academia")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                          <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <div class="dropdown">
                                    <label for="selectPersonal">Plantilla de docentes</label>
                                    <select class="form-control" id="id_profesor" name="id_profesor" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($plantillas as $plantilla)
                                            <option value="{{$plantilla->id_personal}}"> {{$plantilla->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <div class="dropdown">
                                    <label for="selectPersonal">Cargos de academia</label>
                                    <select class="form-control" id="id_cargo" name="id_cargo" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($cargos_academia as $cargo_academia)
                                            <option value="{{$cargo_academia->id_cargo_academia}}"> {{$cargo_academia->cargo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit"  class="btn btn-primary" >Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{---modificar miembro de academia--}}
    <div class="modal fade" id="modal_modificar_academia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="{{url("/residencia/modificacion_academia/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Academia</h4>
                    </div>
                    <div id="contenedor_modificar_academia">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <form action="" method="POST" role="form" id="form_delete">
        {{method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
    <script type="text/javascript">

        $(document).ready(function() {

            $(".modificar").click(function(){
                var id_academia=$(this).data("id");
                $.get("/residencia/modificar_academia/"+id_academia,function(request){
                    $("#contenedor_modificar_academia").html(request);
                    $("#modal_modificar_academia").modal('show');

                });
            });
        });
    </script>
@endsection