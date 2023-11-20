@extends('layouts.app')
@section('content')
    @if($ver ==0)
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">BAJAS TEMPORALES DE LOS ESTUDIANTES</h3>
                        <h5 class="panel-title text-center">(PROGRAMAS DE ESTUDIO)</h5>
                    </div>

                </div>
            </div>
        </div>

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

    @else
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">BAJAS TEMPORALES DE LOS ESTUDIANTES</h3>
                    </div>

                </div>
            </div>
        </div>
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
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-body">

                        <table id="table_enviado" class="table table-bordered table-resposive">
                            <thead>
                            <tr>
                                <th>NO.CUENTA</th>
                                <th>NOMBRE DEL ALUMNO </th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($alumnos as $alumno)

                                <tr>
                                    <td>{{ $alumno->cuenta }}</td>
                                    <td>{{ $alumno->nombre }} {{ $alumno->apaterno }} {{ $alumno->amaterno }}</td>
                                   @if($alumno->estado_validacion == 10)
                                        <td>SIN ELIMINACIÓN DE CARGA</td>
                                        @elseif($alumno->estado_validacion == 11)
                                        <td>CON ELIMINACIÓN DE CARGA</td>
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
            $("#carrera").on('change',function(e){
                var id_carrera= $("#carrera").val();
                window.location.href='/servicios_escolares/bajas_temporales/ver/'+id_carrera ;


            });
            $('#table_enviado').DataTable( );
        });
    </script>

@endsection