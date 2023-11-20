@extends('layouts.app')
@section('title', 'Autorizar Documentos de Liberación de Residencia')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Proceso de Modificación de Documentos de Liberación de Residencia por Carreras del Periodo {{ $nombre_periodo }}</h3>
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
                    <a href="{{ url('/residencia/revision_doc_finales/'.$id_carrera ) }}" >Autorizar Documentación</a>
                </li>
                <li class="active"><a href="#">En proceso de Modificación</a></li>
                <li>
                    <a href="{{ url('/residencia/doc_autorizada_finales/'.$id_carrera ) }}" >Documentación Autorizada</a>
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

                        <table id="table_enviado" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>No. cuenta</th>
                                <th>Nombre del alumno</th>



                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($alumnos as $alumno)

                                <tr>
                                    <td>{{$alumno->cuenta}}</td>
                                    <td>{{ $alumno->alumno }} {{$alumno->apaterno}}  {{$alumno->amaterno}}</td>



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
                var id_carrera= $("#carrera").val();
                window.location.href='/residencia/proceso_mod_doc_finales/'+id_carrera ;


            });
        });
    </script>
@endsection