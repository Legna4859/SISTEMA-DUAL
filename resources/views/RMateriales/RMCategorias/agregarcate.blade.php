@extends('layouts.app')
@section('title', 'Categorias')
@section('content')


    <main class="main">

        <div class="container">
            <div class="panel panel-info">

                <div class="panel-heading center-block">
                    <h2 class="panel-title text-center" style="font-size: large">Gestionar Categorías del TESVB</h2>
                </div>

            </div>
            <div class="container">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="open">Agregar Categoría</button>


                <form id="form" name="formmarca" method="post" action="{{route('guardarcat')}}">
                    @csrf
                    <div class="text-success">
                        @if(Session::has('message'))
                            {{Session::get('message')}}
                        @endif
                    </div>

                    <!-- Modal Insertar -->
                    <div class="modal" tabindex="-1" role="dialog" id="myModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="alert alert-danger" style="display:none"></div>
                                <div class="modal-header">

                                    <h3 class="modal-title" style="text-align: center">Agregar Nueva Categoría</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" style="display: none"></div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="Name">Nombre de la Categoria:</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" required>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="Name">Descripción de la Categoría:</label>
                                            <input type="text" name="descripcion" id="descripcion" class="form-control">
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit"  class="btn btn-success" >Guardar Categoria</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Modal Insertar-->

        </div>
        <br>
        <!-- listado de marcas -->
        <div class="container-fluid" >
            <div class="container">

                <div class="card-body">
                    @if($categorias->isEmpty())
                        <div style="text-align: center; background-color: lightgoldenrodyellow">No hay Categorías</div><br>
                    @else
                        @if(Session::has('message'))
                            {!! Session::get('message') !!}
                        @endif
                        <table class="table table-bordered table-striped table-sm" style="color: black;text-align: center; background-color: lightyellow" >
                            <thead>
                            <tr>

                                <th style="text-align: center">No.de Categoria</th>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Opciones</th>
                                <th style="text-align: center">Estado</th>
                            </tr>
                            </thead>
                            @foreach($categorias as $categoria)<!-- se crea un objeto para acceder a los datos-->
                            <tbody>
                            <tr>

                                <td>{{$categoria->id}}</td>
                                <td>{{$categoria->nombre}}</td>
                                <td>{{$categoria->descripcion}}</td>
                                <td>

                                @if($categoria-> condicion == 1)
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$categoria->id}}">Editar</button> <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target='#desModal{{$categoria->id}}'>Desactivar</button>
                                    <!--Modal Editar -->
                                    <form method="POST" action="{{route('editarcat',$categoria->id)}}" >
                                        @csrf @method('PUT')

                                        <div class="modal" tabindex="-1" role="dialog" id="editModal{{$categoria->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="alert alert-danger" style="display:none"></div>
                                                    <div class="modal-header">

                                                        <h3 class="modal-title" >Actualizar Categoría</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="Name">Nombre de la Categoria:</label>
                                                                <input type="text" class="form-control" name="nombre" value="{{$categoria->nombre}}" id="nombre">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="Name">Descripción de la Categoría:</label>
                                                                <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{$categoria->descripcion}}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button  class="btn btn-success" type="submit">Actualizar Categoría</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--Modal Editar -->
                                    <!--Modal Desactivar -->
                                        <form method="POST" action="{{route('desactivarcat',$categoria->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="desModal{{$categoria->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Desactivar Categoría</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 style="color: red">¿Desea Desactivar la Categoría?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-danger btn-sm" type="submit">Desactivar Categoría</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Desactivar -->
                                @else
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target='#actModal{{$categoria->id}}'>Activar</button>

                                        <!--Modal Activar -->
                                        <form method="POST" action="{{route('activarcat',$categoria->id)}}" >
                                            @csrf @method('PUT')

                                            <div class="modal" tabindex="-1" role="dialog" id="actModal{{$categoria->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="alert alert-danger" style="display:none"></div>
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: black" >Activar Categoría</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>¿Desea Activar la Categoría?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                            <button  class="btn btn-success btn-sm" type="submit">Activar Categoría</button>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--Modal Activar -->

                                    @endif

                                </td>
                                <td>
                                    @if($categoria-> condicion == 1)
                                        <span class="text-success" style="color: green">Activada</span>
                                    @else
                                        <span class="text-danger">Desactivada</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </table>
                        {{$categorias->links()}}<!--para la paginacion-->
                    @endif
                </div>
            </div>
        </div>
        <script >
        /*
            $('#deleteModal').on('show.bs.modal', function (event)
            {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

                action = $('#formDelete').attr('data-action').slice(0,-1);
                action+= id;
                $('#formDelete').attr('action',action);
                var modal = $(this)
                modal.find('.modal-title').text('Se va a eliminar la Categoría seleccionada ' )

            });*/
        </script>
        <script>
        /*
            jQuery(document).ready(function ()
            {
                jQuery('#ajaxSubmit').click(function (e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{'/Agregar-Categoria'}}",
                        method: 'post',
                        data: {
                            name: jQuery('#nombre').val(),
                        },
                        success: function (result) {
                            if(result.errors)
                            {
                                jQuery('.alert-danger').html('');
                                jQuery.each(result.errors,function (key, value) {
                                    jQuery('.alert-danger').show();
                                    jQuery('.alert-danger').append('<li>'+value+'<li>');
                                });
                            }
                            else
                            {
                                jQuery('.alert-danger').hide();
                                $('#open').hide();
                                $('#myModal').modal({show: true});
                            }
                        }});
                });
            });
        */
        </script>


    </main>



@endsection