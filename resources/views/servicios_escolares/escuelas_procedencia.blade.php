@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                            <h3 class="panel-title text-center">AGREGAR ESCUELAS DE PROCEDENCIA</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-5" style="text-align: center;" >
    <button data-toggle="modal"  data-tooltip="true" data-placement="left" title="Agregar escuela" data-target="#modal_crear" type="button" class="btn btn-success btn-lg flotante">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-striped col-md-12" id="tabla_escuela">
                <thead class="">
                <tr class="text-center">
                    <th class="text-center">No.</th>
                    <th class="text-center">NOMBRE DE LA ESCUELA</th>
                    <th class="text-center">MUNICIPIO</th>
                    <th class="text-center">ESTADO</th>
                    <th class="text-center">MODIFICAR</th>
                </tr>
                </thead>
                <?php $i=0; ?>
                    @foreach($escuelas as $escuela)
                        <?php $i++; ?>
                    <tr class="text-center">
                        <td class="text-center">{{$i}}</td>
                        <td class="text-center">{{$escuela->nombre_escuela}}</td>
                        <td class="text-center">{{$escuela->municipio}}</td>
                        <td class="text-center">{{$escuela->estado}}</td>
                        <td class="text-center">
                            <a class="modificar" id="{{ $escuela->id_escuela_procedencia }}"><span class="glyphicon glyphicon-edit em2" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Agregar escuela de procedencia</h4>
                </div>
                <div class="modal-body">

                    <form id="form_agregar" class="form" action="{{url("/registrar/escuela_procedencia/")}}" role="form" method="POST" >
                        {{ csrf_field() }}
                         <div class="row">
                             <div class="col-md-10 col-md-offset-1">
                                 <div class="form-group">
                                     <label for="nombre_escuela">Nombre de la escuela</label>
                                     <textarea class="form-control" id="nombre_escuela" name="nombre_escuela" rows="3" placeholder="Ingresa el nombre de la escuela"style="" required></textarea>
                                </div>
                             </div>
                         </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="estado">Nombre del Estado</label>
                                    <select class="form-control"  id="estado" name="estado" required>
                                        <option disabled selected hidden>Selecciona una opción</option>
                                        @foreach($estados as $estado)
                                            <option value="{{$estado->id_estado}}"> {{$estado->nombre_estado}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="dropdown">
                                <label for="exampleInputEmail1">Municipio o Ciudad de la comisión<b style="color:red; font-size:23px;">*</b></label>
                                <select class="form-control  "placeholder="selecciona una Opcion" id="municipios" name="municipios" value="">
                                    <option disabled selected hidden>Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                        </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" >Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_modificar_esc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_mod_periodo_ingles" class="form" action="{{url("/modificacion/escuela_procedencia/")}}" role="form" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Modificar Escuela de Procedencia</h4>
                    </div>
                    <div class="modal-body">
                        <div id="contenedor_modificar_esc">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button     type="submit"  style="" class="btn btn-primary"  >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#tabla_escuela').DataTable();
            $("#tabla_escuela").on('click','.modificar',function(){
                var id_escuela=$(this).attr('id');
                $.get("/escuela_procedencia/modificar/"+id_escuela,function (request) {
                    $("#contenedor_modificar_esc").html(request);
                    $("#modal_modificar_esc").modal('show');
                });

            });
            $("#estado").change(function(e){
                var id_estado= e.target.value;
                $.get('/ajax-subcat?id_estado=' + id_estado,function(data){

                    $('#municipios').empty();
                    ;
                    $.each(data,function(datos_alumno,subcatObj){
                        //  alert(subcatObj);
                        $('#municipios').append('<option value="'+subcatObj.id_municipio+'" data-muni="'+subcatObj.nombre_municipio+'" >'+subcatObj.nombre_municipio+'</option>');
                    });
                });
            });
            $("#form_agregar").validate({
                rules: {
                    nombre_escuela : "required",
                    estado: "required",
                },
            });
        });
    </script>
@endsection
