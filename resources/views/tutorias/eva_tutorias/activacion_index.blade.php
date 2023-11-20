@extends('tutorias.app_tutorias')
@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card bg-info text-white">
                <div class="card-body"><h3>Estado del periodo de evaluación al tutor {{ Session::get('nombre_periodo')}} </h3></div>
            </div>

        </div>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <div class="col-8 offset-2">


        <table class="table table-bordered table-responsive-lg">
            <tr>
                <th>{{$estado}}</th>
                @if($per->estado == 0)
                <th>
                    <a  class="btn btn-success" href="{{url('/tutorias/evaluacion_tutor/estado/activa/')}}">
                        Activar Periodo
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                        </svg>
                    </a>
                </th>
                @elseif($per->estado == 1)
                <th>
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Finalizar Periodo
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-dash" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5.5 6.5A.5.5 0 0 1 6 6h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                        </svg>
                    </button>
                </th>
                @endif
            </tr>
        </table>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Finalizar Periodo</h4> <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Desea finalizar el periodo (Es irrebercible).</p>
                    </div>
                    <div class="modal-footer">
                        <a  class="btn btn-primary"  href="{{url('/tutorias/evaluacion_tutor/estado/desactiva/')}}">Aceptar</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
