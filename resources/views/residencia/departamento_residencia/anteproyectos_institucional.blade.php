@extends('layouts.app')
@section('title', 'Anteproyecto Institucional')
@section('content')
    <div class="row">

                    <div class="row">
                        <div class="col-md-2 col-md-offset-2" style="text-align: center;">
                            <a    href="{{url('/residencia/departamento_residencia')}}"><span class="glyphicon glyphicon-arrow-left" style="font-size:15px;color:#363636"></span><br>Regresar</a>
                        </div>
                        <div class="col-md-2 col-md-offset-4" style="text-align: center;">
                            <button type="button" class="btn btn-success center" onclick="window.open('{{url('/residencia/exportar_datos_alumnos_residencia')}}')">Exportar datos</button>  </div>
                    </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Proyectos de Residencia Institucional</h3>
                </div>
            </div>
        </div>
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

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {


            $('#table_enviado').DataTable( );


        });
    </script>
@endsection