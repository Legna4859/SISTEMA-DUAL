@extends('layouts.app')
@section('title', 'Anteproyecto autorizar')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Autorizar Anteproyectos  de Residencia por Carreras del Periodo {{ $nombre_periodo }}</h3>
                </div>
            </div>
        </div>
    </div>
    @if($mostrar == 0)
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($carreras as $carrera)
                            <option value="{{$carrera->id_carrera}}" data-esta="{{$carrera->nombre}}">{{$carrera->nombre}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <br>
        </div>
    @endif
    @if($mostrar == 1)
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="dropdown">
                    <label for="exampleInputEmail1">Elige carrrera<b style="color:red; font-size:23px;">*</b></label>
                    <select class="form-control  "placeholder="selecciona una Opcion" id="carrera" name="carrera" required>
                        <option disabled selected hidden>Selecciona una opción</option>
                        @foreach($carreras as $carrera)
                            @if($carrera->id_carrera==$id_carrera)
                                <option value="{{$carrera->id_carrera}}" selected="selected">{{$carrera->nombre}}</option>
                            @else
                                <option value="{{$carrera->id_carrera}}" >{{$carrera->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                </div>
            </div>
            <br>
        </div>
        <div class="row col-md-11 col-md-offset-1">
            <ul class="nav nav-tabs">
                <li ><a href="{{ url('/residencia/autorizar_anteproyecto/anteproyecto_autorizar/'.$id_carrera ) }}">Autorizar Documentación</a></li>
                <li class="active"><a href="#">En proceso de Modificación</a></li>




            </ul>
            <p>
                <br>
            </p>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">

                        <table id="table_enviado" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Nombre del proyecto</th>



                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($anteproyectos_alumn as $anteproyecto)

                                <tr>
                                    <td>{{$anteproyecto['cuenta']}}</td>
                                    <td>{{$anteproyecto['alumno']}} {{$anteproyecto['apaterno']}}  {{$anteproyecto['amaterno']}}</td>
                                    <td>{{$anteproyecto['nom_proyecto']}}</td>


                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="modal_autorizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Autorizar anteproyecto</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_autorizar">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( );
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
                window.location.href='/residencia/autorizar_anteproyecto/anteproyecto_autorizar/'+carrera ;


            });

            $("#table_enviado").on('click','.autorizar',function(){
                var id_anteproyecto=$(this).attr('id');
                $.get("/residencia/autorizar_anteproyecto/anteproyecto_autorizar_alumno/"+id_anteproyecto,function (request) {
                    $("#contenedor_autorizar").html(request);
                    $("#modal_autorizar").modal('show');
                });
            });
        });
    </script>
@endsection