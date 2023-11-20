@extends('layouts.app')
@section('title', 'Anteproyecto Carrera')
@section('content')
    <?php
    $unidad = Session::get('id_unidad_admin');
    ?>
    @if($unidad != 26)
    <div class="row">

        <div class="row">
            <div class="col-md-2 col-md-offset-2" style="text-align: center;">
                <a    href="{{url('/residencia/departamento_residencia')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:15px;color:#363636"></span><br>Regresar</a>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Proyectos de Residencia por Carreras</h3>
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
                                <th>Asesor</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($anteproyectos as $anteproyecto)

                                <tr>
                                    <td>{{$anteproyecto->cuenta}}</td>
                                    <td>{{$anteproyecto->alumno}} {{$anteproyecto->apaterno}}  {{$anteproyecto->amaterno}}</td>
                                    <td>{{$anteproyecto->nom_proyecto}}</td>
                                    <td>{{$anteproyecto->profesor}}</td>
                                    <td><button type="button" class="btn btn-light" onclick="window.location='{{ url('/residentes/alumno/'.$anteproyecto->id_anteproyecto ) }}'" title="Revisar anteproyecto"><i class="glyphicon glyphicon-pencil text-info" style="font-size: 20px;"></i></button>


                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_enviado').DataTable( );
            $("#carrera").on('change',function(e){
                var carrera= $("#carrera").val();
       window.location.href='/residencia/departamento_carreras/'+carrera ;


            });
        });
    </script>
@endsection