@extends('layouts.app')
@section('title', 'Personal comisionado')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Datos de la solicitud de la comisión</h3>
                    </div>
                </div>
            </div>
        </div>

                <div class="row">
                    @if($dependencias_r->dependenciasr == 3)
                        <p style="text-align: center">Agregar otra dependencia <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar otra dependencia" data-target="#modal_dependencia_agregar" type="button" class="btn btn-success" disabled="disabled">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button></p>
                        @elseif($dependencias_r->dependenciasr == 0 || $dependencias_r->dependenciasr == 1|| $dependencias_r->dependenciasr == 2)


<p style="text-align: center">Agregar otra dependencia <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar otra dependencia" data-target="#modal_dependencia_agregar" type="button" class="btn btn-success">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button></p>
                    @endif
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>Dependencia </th>
                                <th>Domicilio</th>
                                <th>Municipio</th>
                                <th>Estado</th>
                                <th>Modificar</th>
                                <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dependencias as $dependencias)
                                <tr>

                                    <td>{{$dependencias->dependencia}}</td>
                                    <td>{{$dependencias->domicilio}}</td>
                                    <td>{{$dependencias->nombre_municipio }}</td>
                                    <td>{{$dependencias->nombre_estado }}</td>
                                    <td>
                                        <a href="#!" class="modificar_dependencia" data-id="{{ $dependencias->id_depend_domicilio}}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                                    </td>

                                    <td>
                                        <a class="eliminar_dependencia" data-id="{{ $dependencias->id_depend_domicilio}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Motivo de la comisión </th>
                        <th>Fecha de salida</th>
                        <th>Hora de salida</th>
                        <th>Fecha de regreso</th>
                        <th>Hora de regreso</th>
                        <th>Lugar de salida</th>
                        <th>Lugar de regreso</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{$solicitudes->desc_comision}}</td>
                            <?php  $fecha_salida=date("d-m-Y",strtotime($solicitudes->fecha_salida )) ?>
                            <td>{{$fecha_salida  }}</td>
                            <td>{{$solicitudes->hora_s  }}</td>
                            <?php  $fecha_regreso=date("d-m-Y",strtotime($solicitudes->fecha_regreso )) ?>
                            <td>{{$fecha_regreso  }}</td>
                            <td>{{$solicitudes->hora_r  }}</td>
                            <td>{{$lugar_salida->descripcion}}</td>
                            <td>{{$lugar_regreso->descripcion}}</td>
                            <td>
                                <a href="#!" class="modificar_oficio" data-id="{{ $solicitudes->id_oficio }}"><span class="glyphicon glyphicon-cog em2" aria-hidden="true"></span></a>
                            </td>

                            <td>
                                <a class="eliminar" data-id="{{ $solicitudes->id_oficio}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>

                        </tr>
                    </tbody>

                </table>
            </div>


        </div>
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Personal comisionado</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-1" >
            <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar comisionado" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            </div>
            <div class="col-md-6 col-md-offset-3">
                <table class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Viaticos</th>
                        <th>Vehiculo</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comisionados as $comisionado)
                        <tr>
                            <td>{{$comisionado->titulo}} {{$comisionado->nombre}}</td>
                            @if($comisionado->viaticos == 2)
                                <td>SI</td>
                            @endif
                            @if($comisionado->viaticos == 1)
                                <td>NO</td>
                            @endif
                            @if($comisionado->automovil == 2)
                                <td><b>Placas: </b>{{$comisionado->placas}}<br><b>Modelo: </b>{{$comisionado->modelo}}<br><b>Licencia: </b>{{$comisionado->licencia}}</td>
                            @endif
                            @if($comisionado->automovil == 1)
                                <td>NO</td>
                            @endif

                            <td>
                                <a class="eliminado" data-id="{{ $comisionado->id_oficio_personal}}"><span class="glyphicon glyphicon-trash em2" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
<div class="row">
    <div class="col-md-2 col-md-offset-5">
        @if($encontrado ==1 and $dependencias_r->dependenciasr > 0 )
        <td class="text-center">
            <button type="button" class="btn btn-success btn-lg btn-block" onclick="window.location='{{ url('/oficios/solicitudenviar/'. $solicitudes->id_oficio ) }}'" title="Enviar">Enviar</button>
        </td>
        @endif
        @if($encontrado ==0 || $dependencias_r->dependenciasr == 0 )
                <td class="text-center">
                    <button id="mensaje" type="button" class="btn btn-success btn-lg btn-block" title="Enviar">Enviar</button>
                </td>
            @endif
        <br>
    </div>
    <br>
</div>


            <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Agregar comisionado</h4>
                        </div>
                        <div class="modal-body">

                            <form id="form_agregar" class="form" action="{{url("/oficios/comisionado/agregarcomisionados")}}" role="form" method="POST" >
                                {{ csrf_field() }}
                            <input type="hidden" id="id_oficio" name="id_oficio" value="{{$oficios->id_oficio}}">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">

                                    <div class="dropdown">
                                        <label for="selectPersonal">Personal comisionado</label>
                                        <select class="form-control" id="selectPersonal" name="selectPersonal" >
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            @foreach($personales as $personal)
                                                <option value="{{$personal->id_personal}}"> {{$personal->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="selectViatico">Requiere viaticos</label>
                                        <select name="selectViatico" id="selectViatico" class="form-control ">


                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="selectAutomovil">Requiere automovil</label>
                                        <select name="selectAutomovil" id="selectAutomovil" class="form-control ">
                                            <option disabled selected>Selecciona...</option>
                                            <option value="2">SI</option>
                                            <option value="1">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none" id="siguiente">
                                <div class="col-md-4 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="automovil">Automovil</label>
                                        <select class="form-control required" id="automoviles" name="automoviles" >
                                            <option disabled selected>Selecciona...</option>
                                        </select>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-4 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="licencia">licencia</label>
                                        <input class="form-control required" id="licencia" name="licencia" />
                                    </div>
                                    <br>
                                </div>
                            </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="guardar_agregado"  class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{---agregar dependencia----}}
        <div class="modal fade" id="modal_dependencia_agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="form_agregar" class="form" action="{{url("/oficio/dependencia/crear/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Agregar otra dependencia</h4>
                    </div>
                    <div class="modal-body">


                            <input type="hidden" id="id_oficio" name="id_oficio" value="{{$oficios->id_oficio}}">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="dependencia">Dependencia de la  comisión</label>
                                        <textarea class="form-control" id="dependencia" name="dependencia" rows="2" placeholder="Ingresa la dependencia de la comisión:
 en la Dirección de institutos Tecnologicos Descentralizados" style="" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 ">
                                    <div class="form-group">
                                        <label for="domicilio3">Dirección de la dependencia de la comisión (calle y numero)</label>
                                        <textarea class="form-control" id="domicilio" name="domicilio" rows="2" placeholder="Ingresa el domicilio de la comisión:
 en Felipe Villanueva No. 535, Col. Centro. " style="" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >

                                <div class="col-md-5 col-md-offset-1">
                                    <div class="dropdown">
                                        <label for="exampleInputEmail1">Estado de la comisión<b style="color:red; font-size:23px;">*</b></label>
                                        <select class="form-control  "placeholder="selecciona una Opcion" id="estados" name="estados" required>
                                            <option disabled selected hidden>Selecciona una opción</option>
                                            @foreach($estados as $estados)
                                                <option value="{{$estados->id_estado}}" data-esta="{{$estados->nombre_estado}}">{{$estados->nombre_estado}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-5 ">
                                    <div class="dropdown">
                                        <label for="exampleInputEmail1">Municipio o Ciudad de dependencia la comisión<b style="color:red; font-size:23px;">*</b></label>
                                        <select class="form-control  "placeholder="selecciona una Opcion" id="municipio" name="municipio" value="" required>
                                            <option disabled selected hidden>Selecciona una opción</option>
                                        </select>
                                    </div>
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
        {{----fin deendencia---}}
        <div class="modal fade" id="modal_modificar_dependencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form" action="{{url("/oficios/dependencia/editar")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar oficio</h4>
                        </div>
                        <div id="contenedor_modificar_dependencia">


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input  type="submit" class="btn btn-primary" value="Guardar"/>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        {{---modificar oficio--}}
        <div class="modal fade" id="modal_modificar_oficio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form" action="{{url("/oficios/solicitud/modificar")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Modificar solicitud de oficio</h4>
                        </div>
                        <div id="contenedor_modificar_oficio">


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input  type="submit" class="btn btn-primary" value="Guardar"/>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <form action="" method="POST" role="form" id="">
            {{method_field('DELETE') }}
            {{ csrf_field() }}
        </form>
        <!-- eliminar dependencia -->
        <div id="modal_eliminar_dependencia" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form action="{{url("/oficios/eliminar_dependencia/")}}" method="POST" role="form" id="form_eliminar_dependencia">
                    <div class="modal-body">
                        {{method_field('DELETE') }}
                            {{ csrf_field() }}
                            ¿Realmente deseas eliminar esta dependencia?
                        <input type="hidden" id="id_dependencia" name="id_dependencia" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="confirma_elimina_dependencia" type="submit" class="btn btn-danger" value="Aceptar"/>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- eliminar oficio -->
        <div id="modal_eliminar_oficio" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form action="{{url("/oficios/eliminar/")}}" method="POST" role="form" >
                        <div class="modal-body">
                            {{method_field('DELETE') }}
                            {{ csrf_field() }}
                            ¿Realmente deseas eliminar esta dependencia?
                            <input type="hidden" id="id_oficio_dep" name="id_oficio_dep" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input id="confirma_elimina_oficio" type="submit" class="btn btn-danger" value="Aceptar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mensaje de no agregar comisionado -->
        <div id="modal_agrega" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <p class="text-center">No se a agregado <br> ningun comisionado o <br> ninguna dependencia</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>

    </main>
    <form action="" method="POST" role="form" id="form_eliminado">
        {{method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
    <form action="" method="POST" role="form" id="form_delete">
        {{method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <script>

        $(document).ready(function() {
            $(".modificar_dependencia").click(function(){
                var id=$(this).data("id");
                $.get("/oficio/dependencia/modificar/"+id,function(request){
                    $("#contenedor_modificar_dependencia").html(request);
                    $("#modal_modificar_dependencia").modal('show');

                });
            });
            $(".modificar_oficio").click(function(){
                var id=$(this).data("id");
                $.get("/oficios/solicitud_oficio/"+id,function(request){
                    $("#contenedor_modificar_oficio").html(request);
                    $("#modal_modificar_oficio").modal('show');

                });

            });


            $("#selectAutomovil").change(function() {
                var auto=$(this).val();
                if(auto ==2){
                    $("#aceptar").css("display", "none");
                    $("#siguiente").css("display", "inline");



                } if(auto ==1){
                    $("#aceptar").css("display", "inline");
                    $("#siguiente").css("display", "none");



                }
            });

            $("#mensaje").click(function(){

                $('#modal_agrega').modal('show');
            });
            $("#guardar_agregado").click(function(event){
                $("#form_agregar").submit();
            });

            $("#form_agregar").validate({
                rules: {
                    selectPersonal : "required",
                    selectViatico: "required",
                    selectAutomovil: "required",
                },
            });
            $(".eliminar_dependencia").click(function(){
                var id=$(this).data('id');
                $('#id_dependencia').val(id);
                $('#modal_eliminar_dependencia').modal('show');
            });
            $(".eliminar").click(function(){
                var id_oficio=$(this).data('id');
                $('#id_oficio_dep').val(id_oficio);
                $('#modal_eliminar_oficio').modal('show');


            });

            $(".eliminado").click(function(){
                var id=$(this).data('id');

                swal({
                    title: "¿Seguro que desea eliminar?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $("#form_delete").attr("action","/oficios/eliminado/"+id)
                            $("#form_delete").submit();
                        }
                    });
            });

            $("#selectPersonal").change(function(){
                var id_oficio = $('#id_oficio').val();
                var id_personal = $( this ).val();

                $.get("/automovil/"+id_personal+"/"+id_oficio+"",function(response,state){
                  $("#automoviles").empty();
                    $('#automoviles').append('<option disabled selected>Selecciona...</option>');
                    for(i=0; i<response.length; i++)
                  {
                        //  alert(subcatObj);
                        $('#automoviles').append("<option value='"+response[i].id_vehiculo+"'>"+response[i].modelo+""+response[i].placas+"</option>");
                    }
                });
                $.get("/viaticos/"+id_personal+"/"+id_oficio+"",function(response,state){
                    $("#selectViatico").empty();
                    $('#selectViatico').append('<option disabled selected>Selecciona...</option>');
                    for(i=0; i<response.length; i++)
                    {

                        $('#selectViatico').append("<option value='"+response[i].id_respuesta+"'>"+response[i].respuesta+"</option>");
                    }
                });
            });


            $("#estados").change(function(e){
                console.log(e);
                var id_estado= e.target.value;
                $.get('/ajax-subcat?id_estado=' + id_estado,function(data){

                    $('#municipio').empty();
                    $.each(data,function(datos_alumno,subcatObj){
                        //  alert(subcatObj);
                        $('#municipio').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');
                    });
                });
            });

        });
    </script>
@endsection