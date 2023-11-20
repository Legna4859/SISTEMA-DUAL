@extends('layouts.app')
@section('title', 'Empresa')
@section('content')

    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Empresas</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 col-md-offset-5">
        <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar empresa" data-target="#modal_crear" type="button" class="btn btn-success ">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="tabla_empresa" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Nombre de la empresa</th>
                        <th>Domicilio</th>
                        <th>Tel_empresa</th>
                        <th>Correo</th>
                        <th>Director General</th>
                        <th>Modificar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($empresas as $empresa)
                        <tr>
                            <td>{{$empresa->nombre }}</td>
                            <td>{{$empresa->domicilio }}</td>
                            <td>{{$empresa->tel_empresa }}</td>
                            <td>{{$empresa->correo }}</td>
                            <td>{{$empresa->dir_gral }}</td>
                            <td>
                                <a href="#!" class="modificar" data-id="{{ $empresa->id_empresa}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    {{---modificar empresa--}}
    <div class="modal fade" id="modal_modificar_empresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="{{url("/residencia/modificacion_empresa/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Empresa</h4>
                    </div>
                    <div id="contenedor_modificar_empresa">


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input  type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>

        </div>
    </div>
    {{--Modal crear empresa--}}
    <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar empresa</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/residencia/insertar_empresa/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10  col-md-offset-1">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la empresa</label>
                                    <textarea class="form-control" id="nombre" name="nombre"  rows="2" placeholder="Ingresa nombre de la empresa" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10  col-md-offset-1">
                                <div class="form-group">
                                    <label for="domicilio">Domiclio de la empresa</label>
                                    <textarea class="form-control" id="domicilio" name="domicilio"  rows="2" placeholder="Ingresa el domicilio de la empresa"  required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10  col-md-offset-1">
                                <div class="form-group">
                                    <label for="telefono">Telefono de la empresa</label>
                                    <input class="form-control" type="text" id="telefono" name="telefono"  placeholder="Ingresa el telefono" value=""  required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10  col-md-offset-1">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input class="form-control"  type="email" id="correo" name="correo"  placeholder="Ingresa correo" value=""  required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10  col-md-offset-1">
                                <div class="form-group">
                                    <label for="director_general">Director General</label>
                                    <input class="form-control"  type="text" id="director_general" name="director_general"  placeholder="Ingresa director general" value=""  required>
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
    <script type="text/javascript">

        $(document).ready(function() {
            $("#tabla_empresa").DataTable();
            $("#tabla_empresa").on('click','.modificar',function(){
                var id_empresa=$(this).data("id");
                $.get("/residencia/modificar_empresa/"+id_empresa,function(request){
                    $("#contenedor_modificar_empresa").html(request);
                    $("#modal_modificar_empresa").modal('show');
                });
            });
        });
    </script>
@endsection