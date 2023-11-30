@extends('layouts.app')
@section('title', 'Gestión Académica')
@section('content')
<div class="row">
    <div class="col-md-10 col-xs-10 col-md-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">GESTIÓN ACADÉMCIA DE ALUMNOS DUALES</h3>
                <h5 class="panel-title text-center">(DOCENTES)</h5>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <table id="paginar_table" class="table table-bordered " style="text-align: center">
                <thead>
                <tr class="info">
                    <th style="text-align: center"><strong>Nombre del Docente</strong></th>
                    <th style="text-align: center"><strong>Ver Estudiantes Asignados</strong></th>
                </tr>
                </thead>
                <tbody>
                @foreach($datos as $dato)
                    <tr>
                        <td>{{$dato->titulo." ".$dato->profesor}}</td>

                        <td>
                            <a href="{{url('/duales/gestion_academica/alumnos')}}">
                                <span class="glyphicon glyphicon-user" style="color: crimson"></span>
                            </a>
                        </td>
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