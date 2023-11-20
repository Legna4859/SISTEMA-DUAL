@extends('ingles.inicio_ingles.layout_ingles')
@section('title', 'Calificaciones de Ingles')
@section('content')
  <div class="row">
        <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">
                              <b>Boleta de Calificaciones del Periodo {{$periodo->periodo_ingles}}</b>
                              <br>
                              <b>Nombre de la Carrera {{$mostrar_carreras->nombre}}</b>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <table id="table_calificacion_coordinador" class="table table-bordered text-center" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th style="text-align: center; color: black;">No. Cuenta</th>
                        <th style="text-align: center; color: black;">Nombre Completo</th>
                        <th style="text-align: center; color: black;">Boleta de PDF</th>
                    </tr>
                    </thead>
                    <tbody>
                     @foreach($alumnos_cal as $alumnos_calificacion)
                     <tr>
                       <td>{{$alumnos_calificacion->cuenta}}</td>
                       <td>{{$alumnos_calificacion->nombre}} {{$alumnos_calificacion->apaterno}} {{$alumnos_calificacion->amaterno}}</td>
                       <td><button type="button" class="btn btn-success" onclick="window.open('{{url('/ingles/imprimir_calificacion_ingles_alumno/'.$alumnos_calificacion->id_alumno)}}')">
                              <strong style="color:white;"><b>Imprimir Boleta</b></strong>
                      </button></td>
                     </tr>
                     @endforeach
                    </tbody>
                </table>
      </div>
      </div>

         <div class="modal modal fade bs-example-modal-sm" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header btn-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="contenedor_mostrar">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_calificacion_coordinador').DataTable( {

            } );

        });
    </script>
@endsection