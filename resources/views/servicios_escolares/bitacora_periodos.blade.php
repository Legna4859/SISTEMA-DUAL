@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">PERIODOS MODIFICADOS</h3>
                </div>
                <div class="panel-body">
                    <table id="table_enviado" class="table text-center my-0 border-table ">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Carrera</th>
                                <th class="text-center">Docente</th>
                                <th class="text-center">Materia</th>
                                <th class="text-center">Grupo</th>
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Fecha anterior</th>
                                <th class="text-center">fecha actual</th>
                                <th class="text-center">Observaciones</th>
                                <th class="text-center">Fecha en la que se realizo el cambio</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($array_periodos as $bt_periodo)
                            <tr>
                                <td>{{$bt_periodo->{'carrera'} }}</td>
                                <td>{{$bt_periodo->{'docente'} }}</td>
                                <td>{{$bt_periodo->{'materia'} }}</td>
                                <td>{{$bt_periodo->{'semestre'} }}0{{$bt_periodo->{'id_grupo'} }}</td>
                                <td>Unidad {{$bt_periodo->{'unidad'} }}</td>
                                <td>{{$bt_periodo->{'fecha_antigua'} }}</td>
                                <td>{{$bt_periodo->{'fecha_nueva'} }}</td>
                                <td>{{$bt_periodo->{'observaciones'} }}</td>
                                <td>{{$bt_periodo->{'created_at'} }}</td>
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
          //$('#table_enviado').reverse( );



        });
    </script>
@endsection