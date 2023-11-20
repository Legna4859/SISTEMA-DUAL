@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Agregar plantilla de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">

            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Agregar plantilla al periodo</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Facilitador en plantilla</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <table id="paginar_table" class="table table-bordered ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Agregar facilitador a plantilla</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($profesores as $profesor)
                            <tr>
                                <td>{{ $profesor->nombre }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</td>
                                <td class="text-center">
                                    <a class="agrega" id="{{ $profesor->id_profesores }}"><i class="glyphicon glyphicon-log-in em2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <table id="paginar_plantilla" class="table table-bordered ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Eliminar</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($profesores_periodo as $profesor_periodo)
                            <tr>
                                <td>{{ $profesor_periodo->nombre }} {{ $profesor_periodo->apellido_paterno }} {{ $profesor_periodo->apellido_materno }}</td>
                                <td class="text-center">
                                    <a class="eliminar" id="{{ $profesor_periodo->id_profesores }}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
    <!-- Modal para agregar plantilla-->
    <form  class="form" role="form" action="{{url("/agregar_profesor/agregar_ingles_plantilla/")}}" method="POST">
        <div class="modal fade bs-example-modal-sm" id="modal_asignar_plantilla" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Asignar a plantilla</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div id="contenedor_asignar_plantilla">

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary acepta">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- eliminar profesor plantilla -->
    <div id="modal_eliminar_profesor_plantilla" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{url("/profesor_ingles/eliminar/")}}" method="POST" role="form" >
                    <div class="modal-body">
                        {{method_field('DELETE') }}
                        {{ csrf_field() }}
                        ¿Realmente deseas eliminar este profesor?
                        <input type="hidden" id="id_prof" name="id_prof" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_elimina_oficio" type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {
            $("#paginar_table").on('click','.agrega',function(){
                var id_profesor=$(this).attr('id');


                $.get("/agregar_profesor/ingles_plantilla/"+id_profesor,function (request) {
                    $("#contenedor_asignar_plantilla").html(request);
                    $("#modal_asignar_plantilla").modal('show');
                });
            });
            $("#paginar_plantilla").on('click','.eliminar',function(){
                var id_profesor=$(this).attr('id');
                $('#id_prof').val(id_profesor);
                $('#modal_eliminar_profesor_plantilla').modal('show');

            });

            $('#paginar_table').DataTable( {

            } );
            $('#paginar_plantilla').DataTable( {

            } );
        });
    </script>
@endsection