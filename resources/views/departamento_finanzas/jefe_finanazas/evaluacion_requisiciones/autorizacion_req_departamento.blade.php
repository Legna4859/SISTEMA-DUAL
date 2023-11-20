@extends('layouts.app')
@section('title', 'Revisión de requisiciones')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Revisión de requisiciones del anteproyecto de presupuesto {{ $year }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-md-11 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li>
                <a href="{{ url('/presupuesto_anteproyecto/revicion_requisiciones_anteproyecto') }}" >Revisar requisiciones</a>
            </li>
            <li>
                <a href="{{ url('/presupuesto_anteproyecto/permiso_mod_jefe_depart/') }}" >En proceso de Modificación</a>
            </li>
            <li class="active">
                <a href="#">Requisiciones revisadas</a>
            </li>
        </ul>
        <p>
            <br>
        </p>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-body">

                    <table id="table_autorizar_doc_final" class="table table-bordered table-resposive">
                        <thead>
                        <tr>
                            <th>No. </th>
                            <th>JEFE(A)</th>
                            <th>DEPARTAMENTO O JEFATURA</th>
                            <th>VER REQUISICIONES REVISADAS</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach ($registros_atorizados as $registro)

                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $registro->titulo }} {{ $registro->nombre}}</td>
                                <td>{{ $registro->nom_departamento }}</td>
                                <td><a   href="/presupuesto_anteproyecto/autorizados_req_departamento/{{ $registro->id_req_mat_ante }}" class="btn btn-primary ">Ver requisiciones</a></td>



                            </tr>


                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fullscreen-modal fade" id="autorizar_doc_finales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Autorización de documentación</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_doc_finales">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fullscreen-modal fade" id="autorizar_doc_finales_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Autorización de documentación modificada</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_doc_finales_mod">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>
        /*
Full screen Modal
*/
        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }
        @media (min-width: 768px) {
            .fullscreen-modal .modal-dialog {
                width: 768px;
            }
        }
        @media (min-width: 992px) {
            .fullscreen-modal .modal-dialog {
                width: 999px;
            }
        }
        @media (min-width: 1200px) {
            .fullscreen-modal .modal-dialog {
                width: 1200px;
            }
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_autorizar_doc_final').DataTable( );
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/residencia/revision_doc_finales/'+id_carrera ;
            });
            $("#table_autorizar_doc_final").on('click','.autorizar_documentos',function(){
                var id_liberacion_documentos=$(this).attr('id');
                $.get("/residencia/alumno_liberacion_final/doc/"+id_liberacion_documentos,function (request) {
                    $("#contenedor_doc_finales").html(request);
                    $("#autorizar_doc_finales").modal('show');
                });
            });
            $("#table_autorizar_doc_final").on('click','.autorizar_modificacion_documentos',function(){
                var id_liberacion_documentos=$(this).attr('id');
                $.get("/residencia/alumno_liberacion_final_mod/doc/"+id_liberacion_documentos,function (request) {
                    $("#contenedor_doc_finales_mod").html(request);
                    $("#autorizar_doc_finales_mod").modal('show');
                });
            });
        });
    </script>
@endsection