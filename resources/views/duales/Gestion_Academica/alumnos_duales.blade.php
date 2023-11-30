@extends('layouts.app')
@section('title', 'Gestión Académica')
@section('content')
        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">GESTIÓN ACADÉMCIA DE ALUMNOS DUALES</h3>
                        <h5 class="panel-title text-center">(ALUMNOS)</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-xs-10 col-md-offset-1">
                <table id="paginar_table" class="table table-bordered " style="text-align: center">
                    <thead>
                    <tr class="info">
                        <th style="text-align: center"><strong>NP</strong></th>
                        <th style="text-align: center"><strong>Nombre del Alumno</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($alumnos as $alumno)
                        <tr>
                            <td style="text-align:center">{{ $loop->iteration}}</td>
                            <td style="text-align:center">{{$alumno->nombre." ".$alumno->apaterno." ".$alumno->amaterno}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready( function()
            {
                $('#paginar_table').DataTable();
            });
        </script>

@endsection