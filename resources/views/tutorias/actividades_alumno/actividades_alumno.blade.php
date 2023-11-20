@extends('tutorias.app_tutorias')
@section('content')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="container card">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="primero" role="tabpanel" aria-labelledby="primero-tab">
                <br>
                <div class="form-group row">
                    <div class="col-sm-11" align="center"><h5>Actividades</h5></div>
                </div>
                <table class="table table-hover table-sm">
                    <tr>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Actividad</th>
                        <th>Objetivo</th>
                        <th>Estrategia</th>
                        <th>Evidencia</th>
                    </tr>
                    @foreach ($datos as $plan)
                        <tr onmouseover="this.style.backgroundColor='#DBE7F3'" onmouseout="this.style.backgroundColor='white'">
                            <td>{{$plan->fi_actividad}}</td>
                            <td>{{$plan->ff_actividad}}</td>
                            <td>{{$plan->desc_actividad}}</td>
                            <td>{{$plan->objetivo_actividad}}</td>
                            <td>{{$plan->estrategia}}</td>
                            <td>
                                @if($plan->requiere_evidencia==null)
                                    <h6>No requiere evidencia</h6>
                                @endif
                                @if(isset($plan->evidencia[0]) && $plan->requiere_evidencia==1)
                                    <a href="{{url('/pdf/',$plan->evidencia[0]->evidencia)}}" target="_blank"
                                       class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i>
                                    </a>
                            <td>
                                <button class="btn edit_evidencia btn-outline-primary" data-toggle="tooltip"
                                        data-placement="bottom" title="Modificar Evidencia" data-id="{{$plan->evidencia[0]->id_evidencia}}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            @else
                                @if($plan->requiere_evidencia==1)
                                    <div class="text-center">
                                        <button class="btn edit btn-outline-success m-1" data-toggle="tooltip" data-placement="bottom"
                                                title="Subir Evidencia" data-id="{{$plan->id_asigna_planeacion_tutor}}">
                                            <i class="fas fa-file-upload"></i>
                                        </button>
                                    </div>
                                    @endif
                                    @endif
                                    </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form action="{{url('tutorias/actividad')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="container-fluid">
                            <div class="form-group col-md-12">
                                <input type="file" class="form-control" name="evidencia" id="evidencia" accept=".pdf">
                                <input type="number" id="id_asigna_planeacion_tutor" name="id_asigna_planeacion_tutor" hidden>
                                <input type="number" id="id_evidencia" name="id_evidencia" hidden>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.edit').click(function(){

                $('#id_asigna_planeacion_tutor').val("");
                $('#id_evidencia').val("");

                var id=$(this).data("id");
                $('#edit').modal('show');
                $('#id_asigna_planeacion_tutor').val(id);
            });
            $('.edit_evidencia').click(function(){
                $('#id_asigna_planeacion_tutor').val("");
                $('#id_evidencia').val("");

                var id=$(this).data("id");

                $('#edit').modal('show');
                $('#id_evidencia').val(id);
            });
        });
    </script>
@endsection












