@extends('layouts.app')
@section('title', 'Asignar revisores')
@section('content')
    @if($maximorev==0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Se deben asignar 3 revisores</h3>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">

        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Agregar revisores al periodo</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Revisores en el periodo</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <table id="asesores" class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Agregar revisores al periodo</th>

                    </tr>
                    </thead>

                    <tbody>
                    @foreach($plantillas as $plantilla)
                        <tr>
                            <td>{{ $plantilla->nombre }}</td>
                            @if($maximorev==1)
                            <td class="text-center">
                                <a class="mensaje_revisores" ><i class="glyphicon glyphicon-log-in em2"></i></a>
                            </td>
                                @else
                                <td class="text-center">
                                    <a class="agregar_revisores" id="{{ $plantilla->id_personal }}"><i class="glyphicon glyphicon-log-in em2"></i></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <table id="revisores" class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Eliminar</th>

                    </tr>
                    </thead>

                    <tbody>
                    @foreach($revisores as $revisor)
                        <tr>
                            <td>{{ $revisor->nombre }}</td>
                            <td class="text-center">
                                <a class="eliminar" id="{{ $revisor->id_revisores }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Modal para agregar asesor-->
    <form  class="form" role="form" action="{{url("/residencia/periodo_asesor")}}" method="POST">
        <div class="modal fade bs-example-modal-sm" id="modal_asignar_asesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Asignar revisores al periodo</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div id="contenedor_asignar_asesor">

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary acepta">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- eliminar revisores -->
    <div id="modal_eliminar_revisores" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/residencia/eliminar_revisor")}}" method="POST" role="form" >
                    <div class="modal-body">
                        {{method_field('DELETE') }}
                        {{ csrf_field() }}
                        ¿Realmente deseas eliminar este revisor?
                        <input type="hidden" id="id_revisores" name="id_revisores" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_elimina_oficio" type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--Mensaje de maximo de revisores--}}
    <div id="modal_revisor_maximo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <p class="text-center">El maximo de revisores son 3</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#asesores").on('click','.agregar_revisores',function(){
                var id_asesor=$(this).attr('id');
                $.get("/residencia/agregar_revisores/"+id_asesor,function (request) {
                    $("#contenedor_asignar_asesor").html(request);
                    $("#modal_asignar_asesor").modal('show');
                });


            });
            $("#asesores").on('click','.mensaje_revisores',function(){

                    $("#modal_revisor_maximo").modal('show');
            });
            $("#revisores").on('click','.eliminar',function(){
                var id_profesor=$(this).attr('id');
               $('#id_revisores').val(id_profesor);
              $('#modal_eliminar_revisores').modal('show');

            });

            $('#asesores').DataTable( {

            } );
            $('#revisores').DataTable( {

            } );
        });
    </script>

@endsection