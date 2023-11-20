@extends('layouts.app')
@section('title', 'Catalogo Generales')
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
                    <h3 class="panel-title text-center">Catalogo Generales</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <a href="#" class="pull-right" data-toggle="modal" data-target="#modal_add_grupo_adm"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Grupo Administrativo"></span></a>
                                    <h3 class="panel-title text-center">Grupos Administrativos</h3>
                                </div>
                                @if($areas_generales->count()>0)
                                    <div class="panel-body">
                                        @foreach($areas_generales as $area)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <li>{{\App\audParseCase::parseNombre($area->descripcion)}}</li>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" class="pull-right delete-admon" data-id="{{$area->id_area_general}}" data-toggle="tooltip" title="Eliminar grupo"><span class="glyphicon glyphicon-trash"></span></a>
                                                    <a href="#" class="pull-left edit_admon" data-all="{{$area}}" data-toggle="tooltip" title="Editar grupo"><span class="glyphicon glyphicon-cog"></span></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="panel-body alert-danger text-center" role="alert">No existen registros</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <a href="#" class="pull-right" data-toggle="modal" data-target="#modal_add_grupo_per"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Agregar Grupo de Personas"></span></a>
                                    <h3 class="panel-title text-center">Grupos de Personas</h3>
                                </div>
                                @if($personal_generales->count()>0)
                                    <div class="panel-body">
                                        @foreach($personal_generales as $personal)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <li>{{\App\audParseCase::parseNombre($personal->descripcion)}}</li>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" class="pull-right delete-personal" data-id="{{$personal->id_personal_general}}" data-toggle="tooltip" title="Eliminar grupo"><span class="glyphicon glyphicon-trash"></span></a>
                                                    <a href="#" class="pull-left edit_personal" data-all="{{$personal}}" data-toggle="tooltip" title="Editar grupo"><span class="glyphicon glyphicon-cog"></span></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="panel-body alert-warning text-center" role="alert">No existen registros</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modal_add_grupo_adm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de grupo administrativo</h4>
                </div>
                <form id="form_add_grupo_adm" class="form" role="form" method="POST" action="{{url('/auditorias/generales')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descripcion">Nombre del grupo</label>
                            <input class="form-control" type="text" name="descripcion">
                        </div>
                        <label for="">Areas para el grupo</label>
                        <div class="row">
                            @foreach($areas as $area)
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input class="areaG" type="checkbox" data-id="{{$area->id_unidad_admin}}">
                                        {{\App\audParseCase::parseNombre($area->nom_departamento)}}
                                    </label>
                                </div>
                                @if($loop->iteration%3==0)
                        </div>
                        <div class="row">
                            @endif
                            @endforeach
                        </div>
                        <input type="text" id="areas" name="areas" hidden value="">
                        <input type="text" name="catalogo" hidden value="areas">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_add_grupo_per" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registro de grupo de personas</h4>
                </div>
                <form id="form_add_grupo_per" class="form" role="form" method="POST" action="{{url('/auditorias/generales')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descripcion">Nombre del grupo</label>
                            <input class="form-control" type="text" name="descripcion">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-6">
                                <input class="form-control search-persona" type="search" placeholder="Buscar">
                            </div>
                            <div class="col-md-2">
                                <strong class="pull-right seleccion">0 Seleccionados</strong>
                            </div>
                        </div>
                        <label for="">Auditores para el grupo</label>
                        <br>
                        <div class="row">
                            @foreach($auditores as $auditor)
                                <div class="col-md-4" >
                                    <label class="checkbox-inline" id="{{$auditor->id_personal}}">
                                        <input class="personalG" type="checkbox" data-id="{{$auditor->id_personal}}">
                                        <strong>{{$auditor->categoria}}</strong> ({{\App\audParseCase::parseNombre($auditor->nombre)}})
                                    </label>
                                </div>
                                @if($loop->iteration%3==0)
                        </div>
                        <div class="row">
                            @endif
                            @endforeach
                        </div>
                        <br>
                        <label for="">Personal para el grupo</label>
                        <br>
                        <div class="row">
                            @foreach($personalT as $persona)
                                <div class="col-md-4 personas_u" data-name="{{$persona->nombre}}">
                                    <label class="checkbox-inline " id="{{$persona->id_personal}}">
                                        <input class="personalG" type="checkbox" data-id="{{$persona->id_personal}}">
                                        {{\App\audParseCase::parseAbr($persona->titulo)}} {{\App\audParseCase::parseNombre($persona->nombre)}}
                                    </label>
                                </div>

                            @endforeach
                        </div>
                        <input type="text" id="personal" name="personal" hidden value="">
                        <input type="text" name="catalogo" hidden value="personal">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_grupo_adm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Editar grupo administrativo</h4>
                </div>
                <form id="form_edit_grupo_adm" class="form" role="form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descripcion">Nombre del grupo</label>
                            <input class="form-control" type="text" name="descripcion" id="descripcionA">
                        </div>
                        <label for="">Areas para el grupo</label>
                        <div class="row">
                            @foreach($areas as $area)
                                <div class="col-md-4">
                                    <label class="checkbox-inline" id="areaGE{{$area->id_unidad_admin}}">
                                        <input class="areaGE" type="checkbox" data-id="{{$area->id_unidad_admin}}">
                                        {{\App\audParseCase::parseNombre($area->nom_departamento)}}
                                    </label>
                                </div>
                                @if($loop->iteration%3==0)
                        </div>
                        <div class="row">
                            @endif
                            @endforeach
                        </div>
                        <input type="text" id="areasE" name="areas" hidden value="">
                        <input type="text" name="catalogo" hidden value="areas">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_edit_grupo_per" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Editar grupo de personas</h4>
                </div>
                <form id="form_edit_grupo_per" class="form" role="form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descripcion">Nombre del grupo</label>
                            <input class="form-control" type="text" name="descripcion" id="descripcionP">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-6">
                                <input class="form-control search-personaE" type="search" placeholder="Buscar">
                            </div>
                            <div class="col-md-2">
                                <strong class="pull-right seleccionE">0 Seleccionados</strong>
                            </div>
                        </div>
                        <label for="">Auditores para el grupo</label>
                        <br>
                        <div class="row">
                            @foreach($auditores as $auditor)
                                <div class="col-md-4" >
                                    <label class="checkbox-inline" id="personalGE{{$auditor->id_personal}}">
                                        <input class="personalGE" type="checkbox" data-id="{{$auditor->id_personal}}">
                                        <strong>{{$auditor->categoria}}</strong> ({{\App\audParseCase::parseNombre($auditor->nombre)}})
                                    </label>
                                </div>
                                @if($loop->iteration%3==0)
                        </div>
                        <div class="row">
                            @endif
                            @endforeach
                        </div>
                        <br>
                        <label for="">Personal para el grupo</label>
                        <br>
                        <div class="row">
                            @foreach($personalT as $persona)
                                <div class="col-md-4 personas_uE" data-name="{{$persona->nombre}}">
                                    <label class="checkbox-inline " id="personalGE{{$persona->id_personal}}">
                                        <input class="personalGE" type="checkbox" data-id="{{$persona->id_personal}}">
                                        {{\App\audParseCase::parseAbr($persona->titulo)}} {{\App\audParseCase::parseNombre($persona->nombre)}}
                                    </label>
                                </div>

                            @endforeach
                        </div>
                        <input type="text" id="personalE" name="personal" hidden value="">
                        <input type="text" name="catalogo" hidden value="personal">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form  method="POST" role="form" id="form_delete_admon">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="text" name="accion" value="area" hidden>
    </form>
    <form  method="POST" role="form" id="form_delete_personal">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="text" name="accion" value="personal" hidden>
    </form>

    <script>
        $(document).ready(function () {
            $('.search-persona').keyup(function () {
                val = $('.search-persona').val();
                if (val != "")
                    $('.personas_u').each(function () {
                        if ($(this).data('name').toLowerCase().indexOf(val.toLowerCase())<0) $(this).fadeOut();
                        else $(this).fadeIn();
                    });
                else $('.personas_u').fadeIn();
            });

            var areas=[];
            $('.areaG').click(function () {
                areas=[];
                $('.areaG:checked').each(function () {
                    areas.push($(this).data('id'))
                });
                $('#areas').attr('value',JSON.stringify(areas));
            });

            var personal=[];
            $('.personalG').click(function () {
                if ($('.search-persona').val('')!=''){
                    $('.search-persona').val('');
                    $('.personas_u').fadeIn();
                }

                id=$(this).data('id');
                if ($(this).prop('checked')==true) $('#'+id).addClass('bg-success text-success')
                else $('#'+id).removeClass('bg-success text-success')

                personal=[];
                $('.personalG:checked').each(function () {
                    personal.push($(this).data('id'))
                });
                $('.seleccion').empty().html(personal.length+' Seleccionados');
                $('#personal').attr('value',JSON.stringify(personal));
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('.delete-admon').click(function () {
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
                            $("#form_delete_admon").attr("action","/auditorias/generales/"+id).submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });
            });

            $('.delete-personal').click(function () {
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
                            $("#form_delete_personal").attr("action","/auditorias/generales/"+id).submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) { //Si presionas boton cancelar
                            swal.close()
                        }
                    });
            });

            $('.edit_admon').click(function () {
                data=$(this).data('all');
                $('#form_edit_grupo_adm').attr('action','/auditorias/generales/'+data.id_area_general);
                $('#descripcionA').val(data.descripcion);

                $('.areaGE').each(function () {
                    id=$(this).data('id');
                    if ($.inArray(id,data.areas)!==-1) {
                        $(this).prop('checked',true);
                        $('#areaGE'+id).addClass('bg-success text-success')
                    }
                    else{
                        $(this).prop('checked',false);
                        $('#areaGE'+id).removeClass('bg-success text-success')
                    }
                });


                $('#areasE').attr('value',JSON.stringify(data.areas));
                $('#modal_edit_grupo_adm').modal('show');
            });

            $('.edit_personal').click(function () {
                data=$(this).data('all');
                $('#form_edit_grupo_per').attr('action','/auditorias/generales/'+data.id_personal_general);
                $('#descripcionP').val(data.descripcion);

                $('.personalGE').each(function () {
                    id=$(this).data('id');
                    if ($.inArray(id,data.personal)!==-1) {
                        $(this).prop('checked',true);
                        $('#personalGE'+id).addClass('bg-success text-success')
                    }
                    else{
                        $(this).prop('checked',false);
                        $('#personalGE'+id).removeClass('bg-success text-success')
                    }
                });
                $('#personalE').attr('value',JSON.stringify(data.personal));
                $('.seleccionE').empty().html(data.personal.length+' Seleccionados');
                $('#modal_edit_grupo_per').modal('show');
            });

            $('.search-personaE').keyup(function () {
                val = $('.search-personaE').val();
                if (val != "")
                    $('.personas_uE').each(function () {
                        if ($(this).data('name').toLowerCase().indexOf(val.toLowerCase())<0) $(this).fadeOut();
                        else $(this).fadeIn();
                    });
                else $('.personas_uE').fadeIn();
            });

            var areasE=[];
            $('.areaGE').click(function () {
                areasE=[];
                $('.areaGE:checked').each(function () {
                    areasE.push($(this).data('id'))
                });
                $('#areasE').attr('value',JSON.stringify(areasE));
            });

            var personalE=[];
            $('.personalGE').click(function () {
                if ($('.search-personaE').val('')!=''){
                    $('.search-personaE').val('');
                    $('.personas_uE').fadeIn();
                }

                id=$(this).data('id');
                if ($(this).prop('checked')==true) $('#personalGE'+id).addClass('bg-success text-success')
                else $('#personalGE'+id).removeClass('bg-success text-success')

                personalE=[];
                $('.personalGE:checked').each(function () {
                    personalE.push($(this).data('id'))
                });
                $('.seleccionE').empty().html(personalE.length+' Seleccionados');
                $('#personalE').attr('value',JSON.stringify(personalE));
            });
        })
    </script>

@endsection