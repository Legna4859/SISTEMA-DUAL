@extends('layouts.app')
@section('title', 'Procesos')
@section('content')
    @if(\Illuminate\Support\Facades\Session::get('errors'))
        <div class="alert alert-danger" role="alert">
            @foreach(\Illuminate\Support\Facades\Session::get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        @if(\Illuminate\Support\Facades\Session::forget('errors'))@endif
    @endif
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a href="#" class="add_proceso pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar proceso"></span></a>
                    <h3 class="panel-title text-center">Procesos</h3>
                </div>
                @if(sizeof($procesos)>0)
                    <div class="panel-body">
                        <table class="table table-bordered" id="paginar_table">
                            <thead>
                                <tr>
                                <th rowspan="2">Nombre</th>
                                <th>Sistema</th>
                                <th rowspan="2">Acciones</th>
                                </tr>
                                <tr>
                                    <th>
                                    <div class="row">
                                        <div class="col-md-4">COCODI</div>
                                        <div class="col-md-4">SGC</div>
                                        <div class="col-md-4">Auditorias Internas</div>
                                    </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($procesos as $proceso)
                                <tr>
                                    <td><strong>{{$proceso->clave.' '}}</strong>{{\App\audParseCase::parseProceso($proceso->des_proceso)}}</td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="radio" name="sistemas{{$proceso->id_proceso}}" data-id="{{$proceso->id_proceso}}" data-value="1" class="sistema" {{$proceso->id_sistema==1?'checked':''}}>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" name="sistemas{{$proceso->id_proceso}}" data-id="{{$proceso->id_proceso}}" data-value="2" class="sistema" {{$proceso->id_sistema==2?'checked':''}}>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" name="sistemas{{$proceso->id_proceso}}" data-id="{{$proceso->id_proceso}}" data-value="3" class="sistema" {{$proceso->id_sistema==3?'checked':''}}>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="#!" class="pull-left btn_edit_proceso" data-all="{{$proceso}}" data-toggle="tooltip" title="Editar proceso"><span class="glyphicon glyphicon-cog"></span></a>
                                        <a href="#!" class="pull-right btn_delete_proceso" data-id="{{$proceso->id_proceso}}" data-toggle="tooltip" title="Eliminar proceso"><span class="glyphicon glyphicon-trash"></span></a>
                                        <a href="{{url('/auditorias/procesos',$proceso->id_proceso)}}" class="" data-id="{{$proceso->id_proceso}}" data-toggle="tooltip" title="Ver unidades administrativas"><span class="glyphicon glyphicon-list"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="#" class="add_proceso pull-right" data-type="2"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar proceso"></span></a>
                    </div>
                @endif
            </div>
        </div>
    </main>


    <div class="modal fade" id="modal_add_proceso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de proceso</h4>
                </div>
                <form id="form_add_proceso" class="form" role="form" method="POST" action="{{url('/auditorias/procesos')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nuevo_proceso">Clave</label>
                            <input class="form-control" name="clave" type="text" placeholder="Clave del proceso">
                        </div>
                        <div class="form-group">
                            <label for="nuevo_proceso">Descripción</label>
                            <textarea class="form-control" name="des_proceso" placeholder="Descripción del proceso"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="id_sistema">Sistema</label>
                            <select name="id_sistema" class="form-control">
                                <option value="" selected disabled="true">Selecciona...</option>
                                @foreach($sistemas as $sistema)
                                    <option value="{{$sistema->id_sistema}}">{{$sistema->desc_sistema}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Ok"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_proceso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Editar proceso</h4>
                </div>
                <form id="form_edit_proceso" class="form" role="form" method="POST" action="{{url('/auditorias/procesos')}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nuevo_proceso">Clave</label>
                            <input class="form-control" name="clave" id="clave" type="text" placeholder="Clave del proceso">
                        </div>
                        <div class="form-group">
                            <label for="nuevo_proceso">Descripción</label>
                            <textarea class="form-control" name="des_proceso" id="des_proceso" placeholder="Descripción del proceso"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="id_sistema">Sistema</label>
                            <select name="id_sistema" id="id_sistema" class="form-control">
                                <option value="" selected disabled="true">Selecciona...</option>
                                @foreach($sistemas as $sistema)
                                    <option value="{{$sistema->id_sistema}}">{{$sistema->desc_sistema}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Ok"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form  method="POST" role="form" id="form_delete_proceso">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>


    <script>
        $(document).ready(function () {
           $('#paginar_table').DataTable();
          //
            $('.guardar_sistema').click(function () {
                var data=[];
                $('input:radio:checked').each(function () {
                    data.push({"id_proceso":$(this).data('id'),"id_sistema":$(this).data('value')});
                });
                $.ajax({
                    url: '{{url("auditorias/procesos")}}/'+JSON.stringify(data)+'/edit',
                    method: 'GET',
                    data: {},
                    success: function () {
                        Swal.fire({
                            title: 'Guardado',
                            timer: 1000,
                            showConfirmButton: false,
                            type: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        },500);
                    }
                })
            });

            $(".add_proceso").click(function () {
                $("#modal_add_proceso").modal('show');
            });

            $('.btn_edit_proceso').click(function () {
                var datos=$(this).data('all');
                $('#form_edit_proceso').attr('action',"{{url('auditorias/procesos')}}/"+datos['id_proceso'])
                $('#clave').val(datos['clave'])
                $('#des_proceso').val(datos['des_proceso'])
                $('#id_sistema').val(datos['id_sistema'])
                $("#modal_edit_proceso").modal('show');

            });

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
                        $("#form_delete_proceso").attr("action","/auditorias/procesos/"+id)
                        $("#form_delete_proceso").submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                });
            });

            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

@endsection