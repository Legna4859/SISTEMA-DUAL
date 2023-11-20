@extends('layouts.app')
@section('title', 'Status de los Anteproyectos de los Alumnos')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Status de los Anteproyectos de los Alumnos del Periodo {{ $nombre_periodo }}</h3>
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
    @elseif($mostrar == 1)
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
                <li>
                    <a href="{{ url('/residencia/ver_estados_alumnos/'.$id_carrera ) }}" >Anteproyectos Autorizados por los Revisores</a>
                </li>

                <li>
                    <a href="{{ url('/residencia/proceso_mod_anteproyecto/'.$id_carrera ) }}" >En proceso de Modificación</a>
                </li>
                <li class="active"><a href="#">En Proceso de Revisión</a>
                </li>




            </ul>
            <p>
                <br>
            </p>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-body">

                        <table id="table_autorizar" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. cuenta</th>
                                <th>Nombre del alumno</th>
                                <th>Nombre del anteproyecto</th>
                                <th>Estado</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($anteproyecto_autorizados as $anteproyecto)

                                <tr>
                                    <td>{{$anteproyecto->cuenta }}</td>
                                    <td>{{$anteproyecto->nombre }} {{$anteproyecto->apaterno }} {{$anteproyecto->amaterno }}</td>
                                    <td>{{ $anteproyecto->nom_proyecto }}</td>

                                    @if($anteproyecto->estado_enviado == 1)
                                        <td>
                                            Esta en proceso de revisión por sus revisores.
                                        </td>

                                    @endif

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
            $('#table_autorizar').DataTable( );
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/residencia/proceso_revision_anteproyecto/'+id_carrera ;
            });


        });
    </script>
@endsection