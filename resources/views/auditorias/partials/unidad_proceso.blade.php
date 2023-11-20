@extends('layouts.app')
@section('title', 'Unidades administrativas')
@section('content')
    <main class="col-md-12">
        <div class="col-md-10 col-md-offset-1">

        <p>
            <span class="glyphicon glyphicon-arrow-right"></span>
            <a href="{{url("auditorias/procesos/")}}">Procesos</a>

        </p>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" data-toggle="modal" data-target="#modal_crear" class="add_proceso pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Unidad Administrativa"></span></a>
                    <h3 class="panel-title text-center">Unidades Administrativas del proceso:  <br>
                        {{$id->des_proceso}}
                    </h3>
                </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <th>Unidad Administrativa</th>
                            </thead>
                            <tbody>
                            @foreach($procesos as $proceso)
                                <tr>
                                    <td>
                                        {{$proceso->nom_departamento}}
                                        <a href="#!" class="pull-right btn_delete_proceso" data-id="{{$proceso->id_proceso_unidad}}" data-toggle="tooltip" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>

                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </main>

    <form id="form_proceso_crea" class="form" role="form" method="POST" action="{{url("auditorias/procesos_unidad")}}">
        <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar Unidad Administrativa</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="proceso" value="{{$id->id_proceso}}">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="id_admin" id="id_admin">
                                        <option value="" disabled="true" selected="true">Seleccione una opción</option>
                                        @foreach($unidades as $unidad)
                                            <option value="{{$unidad->id_unidad_admin}}">{{$unidad->nom_departamento}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="save_unidad" type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form  method="POST" role="form" id="form_delete_proceso">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".btn_delete_proceso").click(function(){
                var id=$(this).data('id');
                swal({
                    title: "Seguro que desea eliminar?",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar',
                })
                    .then((result) => {
                        if (result.value) { //Si presionas boton aceptar
                            $("#form_delete_proceso").attr("action","/auditorias/procesos_unidad/"+id)
                            $("#form_delete_proceso").submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection