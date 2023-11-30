@extends('layouts.app')
@section('title', 'Calificaciones Alumnos Duales')
@section('content')

    <main class="col-md-12">
        <div class="row" style="padding: 1em">
            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-1" style="text-align: center;padding: 1.5em">
                    <button type="button" class="btn center" style="color: whitesmoke;background: #1e7e34;border-radius: 100px"
                            onclick="window.open('{{url('/duales/generar_listas_duales/')}}')">
                        Generar Lista de Asistencia <span class="glyphicon glyphicon-list"></span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-center">CALIFICACIONES ALUMNOS DUALES</h3>
                                    </div>
                                </div>

                                <table id="paginar_table" class="table table-bordered " style="text-align: center">
                                    <thead>
                                    <tr class="info">
                                        <th style="text-align: center"><strong>No. Cuenta</strong></th>
                                        <th style="text-align: center"><strong>Nombre del Alumno Dual</strong></th>
                                        <th style="text-align: center">Calificar Alumno</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datos_registros as $dato_registro)
                                        <tr>
                                            <td>{{$dato_registro->cuenta}}</td>
                                            <td>{{$dato_registro->nombre." ".$dato_registro->apaterno." ".$dato_registro->amaterno}}</td>
                                            <td>
                                                <a href="{{url('/duales/calificar_estudiante/'.$dato_registro->id )}}">
                                                <span class="glyphicon glyphicon-edit" style="color: blue"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#paginar_table').DataTable();
        });
    </script>

@endsection