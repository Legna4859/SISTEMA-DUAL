@extends('layouts.app')
@section('title', 'Agenda del Plan')
@section('content')
    @if(\Illuminate\Support\Facades\Session::get('errors'))
        <div class="alert alert-danger" role="alert">
            @foreach(\Illuminate\Support\Facades\Session::get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        @if(\Illuminate\Support\Facades\Session::forget('errors'))@endif
    @endif
    <main class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url('/auditorias/programas')}}">Programas de auditoría</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}">Detalles del programa</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/programas')}}/{{\Illuminate\Support\Facades\Session::get('id_programa')}}/edit">Planes del programa</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/planes')}}/{{$auditoria_id}}">Detalles del plan</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="{{url('/auditorias/agenda')}}/{{$auditoria_id}}">Agenda del plan</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Editar procesos de la agenda</span>
            </p>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Editar procesos de la agenda</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($procesos as $proceso)
                            <div class="col-md-6">
                                @if(\Illuminate\Support\Facades\Session::get('procesos-agenda'))
                                    @if(in_array($proceso->id_auditoria_proceso,\Illuminate\Support\Facades\Session::get('procesos-agenda')))
                                        <label class="checkbox-inline"><input class="existentes" type="checkbox" data-id="{{$proceso->id_auditoria_proceso}}" checked>{{$proceso->clave.' '.\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                    @else
                                        <label class="checkbox-inline"><input class="existentes" type="checkbox" data-id="{{$proceso->id_auditoria_proceso}}">{{$proceso->clave.' '.\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                    @endif
                                @else
                                    <label class="checkbox-inline"><input class="existentes" type="checkbox" data-id="{{$proceso->id_auditoria_proceso}}">{{$proceso->clave.' '.\App\audParseCase::parseProceso($proceso->des_proceso)}}</label>
                                @endif

                            </div>
                        @endforeach
                    </div>
                    <button class="btn btn-success guardar">Guardar</button>
                </div>
            </div>
        </div>
    </main>

    <form action="{{url('auditorias/validar')}}/{{$auditoria_id}}/edit" method="get" id="procesos">
        <input type="text" name="data" id="data" hidden>
    </form>

    <form  method="POST" role="form" id="form_delete_auditor">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>

    <script>
        $(document).ready(function () {

            $('.guardar').click(function () {
                var agregar=[];
                $('.existentes:checkbox:checked').each(function () {
                    agregar.push($(this).data('id'));
                });
                if (agregar.length>0){
                    $('#data').val(JSON.stringify(agregar));
                    $('#procesos').submit();
                }
                console.log(agregar)
            });

            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

@endsection