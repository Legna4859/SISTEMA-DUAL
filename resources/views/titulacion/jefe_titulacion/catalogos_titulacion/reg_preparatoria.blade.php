@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class=" text-center">Preparatorias</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-5">
                <p style="text-align: center">Agregar preparatoria<button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar otra preparatoria" data-target="#modal_agregar_preparatoria" type="button" class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="paginar_table" class="table table-bordered table-resposive">
                    <thead>
                    <tr>
                        <th>Número</th>
                        <th>Nombre de la preparatoria</th>
                        <th>Nombre de la entidad</th>
                        <th>Tipo de estudio antecedente</th>
                        <th>Tipo educativo antecedente</th>
                        <th>Editar</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $numero=0; ?>
                    @foreach($preparatorias as $preparatoria)
                        <tr>
                            <?php $numero++; ?>
                            <td>{{ $numero }}</td>
                            <td>{{$preparatoria->preparatoria}} </td>
                            <td>{{$preparatoria->nom_entidad}}</td>
                                <td>{{$preparatoria->tipo_estudio_antecedente}}</td>
                                <td>{{$preparatoria->tipo_educativo_atecedente}}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary editar_preparatoria" id="{{ $preparatoria->id_preparatoria }}">Editar preparatoria</button>
                                </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    {{-- Modal agregar preparatoria--}}
    <div class="modal fade" id="modal_agregar_preparatoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Agregar preparatoria</h4>
                </div>
                <form class="form" id="form_reg_preparatoria" action="{{url("/titulacion/guardar_nueva_preparatoria/")}}" role="form" method="POST" >
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="nombre_preparatoria">Nombre preparatoria</label>
                                <textarea class="form-control" id="nombre_preparatoria"  name="nombre_preparatoria" rows="2"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"  required></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                    <div class="dropdown">
                        <label for="id_decision">Selecciona entidad federativa de la preparatoria</label>
                        <select class="form-control" id="id_entidad_federativa" name="id_entidad_federativa" >
                            <option disabled selected hidden>Selecciona una opción</option>
                            @foreach($estados as $estado)
                                <option value="{{$estado->id_entidad_federativa}}"> {{$estado->nom_entidad }}</option>
                            @endforeach
                        </select>
                    </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="dropdown">
                                <label for="id_decision">Selecciona tipo de estudio de antecedente</label>
                                <select class="form-control" id="id_tipo_estudio_antecedente" name="id_tipo_estudio_antecedente" >
                                    <option disabled selected hidden>Selecciona una opción</option>
                                    @foreach($tipo_estudio_antecedente as $tipo)
                                        <option value="{{$tipo->id_tipo_estudio_antecedente}}"> {{$tipo->tipo_estudio_antecedente }} (tipo educativo: {{$tipo->tipo_educativo_atecedente }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                        </div>
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button  type="button" id="guardar_preparatoria" class="btn btn-primary" >Guardar</button>
                </div>

            </div>

        </div>
    </div>



    <div class="modal fullscreen-modal fade" id="modal_modificar_preparatoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <form id="form_editar_preparatoria" class="form" action="{{url("/titulacion/guardar_modificacion_preparatoria/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar preparatoria</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_modificar_preparatoria">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" style="" class="btn btn-primary"  >Guardar modificación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $(document).ready( function() {
            $("#guardar_preparatoria").click(function (){
                var nombre_preparatoria = $("#nombre_preparatoria").val();
                if( nombre_preparatoria != ''){
                    var id_entidad_federativa = $("#id_entidad_federativa").val();
                    if( id_entidad_federativa != null){
                        var id_tipo_estudio_antecedente = $("#id_tipo_estudio_antecedente").val();
                        if( id_tipo_estudio_antecedente != null) {
                            $("#form_reg_preparatoria").submit();
                            $("#guardar_preparatoria").attr("disabled", true);
                        }else{
                            swal({
                                position: "top",
                                type: "warning",
                                title: "Selecciona tipo de estudio de antecedente",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }



                    }else{
                        swal({
                            position: "top",
                            type: "warning",
                            title: "Selecciona entidad federativa de la preparatoria",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    }

                }else{
                    swal({
                        position: "top",
                        type: "warning",
                        title: "Ingresa nombre de la preparatoria.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            });
            $(".editar_preparatoria").click(function (){
                var id_preparatoria =$(this).attr('id');

                $.get("/titulacion/modificar_preparatoria/"+id_preparatoria,function(request){
                    $("#contenedor_modificar_preparatoria").html(request);
                    $("#modal_modificar_preparatoria").modal('show');

                });
            });
            $('#aceptar_registro').click(function (){
                $("#aceptar_registro").attr("disabled", true);
                swal({
                    type: "success",
                    title: "Registro exitoso",
                    showConfirmButton: false,
                    timer: 1500
                });
            });

        });
    </script>
@endsection