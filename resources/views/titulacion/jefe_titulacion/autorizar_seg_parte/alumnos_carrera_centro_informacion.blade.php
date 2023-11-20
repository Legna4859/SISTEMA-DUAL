@extends('layouts.app')
@section('title', 'Titulacion')
@section('content')

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Estudiantes de la carrera {{ $carrera->nombre }}  </h3>
                </div>
            </div>
        </div>
    </div>

             <div class="row">


                <div class="col-md-10 col-md-offset-1">
                    <table id="tabla_alumnos" class="table table-bordered " Style="background: white;" >
                        <thead>
                        <tr>
                            <th>NO. CUENTA</th>
                            <th>NOMBRE DEL ALUMNO</th>
                            <th>OPCIÓN DE TITULACIÓN</th>
                            <th>NOMBRE DEL PROYECTO </th>
                            <th>VER PROYECTO </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($reg_titulacion as $alumno)
                            <tr>
                                <td>{{$alumno['no_cuenta'] }} </td>
                                <td>{{$alumno['nombre'] }}</td>
                                <td>{{$alumno['opcion_titulacion'] }}</td>
                                <td>{{$alumno['nom_proyecto'] }}</td>
                                <td> <button type="button" class="btn btn-primary center" onclick="window.open('{{url('/titulacion/'.$alumno['pdf_reporte_titulacion'])}}')">Ver Documento </button></td>

                            </tr>
                        @endforeach



                        </tbody>
                    </table>
                </div>
            </div>





    <script type="text/javascript">



        $(document).ready(function() {
            $('#tabla_alumnos').DataTable();
            $('#tabla_titulacion').DataTable();
        } );

    </script>


@endsection