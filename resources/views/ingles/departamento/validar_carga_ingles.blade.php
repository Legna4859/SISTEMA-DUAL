@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Validar cargas academicas de ingles')
@section('content')
    <main class="col-md-12">

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Cargas academicas  de ingles autorizadas</h3>
                    </div>
                </div>
            </div>
        </div>

            <div class="row" id="consultar">
                <div class="col-md-10 col-md-offset-1">
                    <br>
                    <table id="table_enviado" class="table table-bordered text-center" style="table-layout:fixed;">
                        <thead>
                        <tr>
                            <th>No. cuenta</th>
                            <th>Nombre del usuario</th>
                            <th>Nivel</th>
                            <th>Grupo</th>
                            <th>Permiso de modificación</th>
                        </tr>
                        </thead>
                        <tbody>
                       @foreach($alumnos as $alumno)
                                <tr>
                                    <td >{{ $alumno->cuenta }}</td>
                                    <td >{{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                                    <td>{{ $alumno->nivel_ingles }}</td>
                                    <td>{{ $alumno->grupo_ingles }}</td>
                                     <td>  <a class="editar" id="{{ $alumno->id_validar_carga }}"><i class="glyphicon glyphicon-edit " ></i></a>
                                     </td>


                                </tr>


                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
    </main>
    <div class="modal modal fade bs-example-modal-sm" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header btn-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mostrar">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( {

            } );
            $("#table_enviado").on('click','.editar',function(){
                var id_validar_carga=$(this).attr('id');
                $.get("/ingles/modificar_carga_academica_ingles/"+id_validar_carga,function (request) {
                    $("#contenedor_mostrar").html(request);
                    $("#modal_mostrar").modal('show');
                });


            });

        });
    </script>
@endsection
