@extends('layouts.app')
@section('title', 'Reporte final')
@section('content')
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
            <div class="panel panel-info">
                @foreach($programas as $programa)
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Reporte final del programa de auditorias
                    <strong>
                        {{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}
                    </strong></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group droptrue" id="sortable2">
                        @foreach($notas as $nota)
                            <li class="list-group-item nota_final" contenteditable="true">
                                <strong>{{$nota->proceso}}</strong>
                                <p>{{$nota->descripcion}}</p>
                            </li>
                        @endforeach
                    </ul>
                    <button class="btn btn-success guarda_informe">Guardar e Imprimir</button>
                </div>
                @endforeach
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            $('.guarda_informe').click(function () {
                var notas_finales=[];
                @foreach($programas as $programa)
                    notas_finales[notas_finales.length]="{{\Jenssegers\Date\Date::parse($programa->fecha_i)->format('F')}} - {{\Jenssegers\Date\Date::parse($programa->fecha_f)->format('F Y')}}";

                    $('.nota_final').each(function () {
                        var datos={"proceso":$(this).find('strong').text(),"descripcion":$(this).find('p').text()}
                        notas_finales.push(datos);
                    });
                    notas_finales=JSON.stringify(notas_finales);
                    window.open('{{url('sgc/print_reporte')}}/'+notas_finales,'_blank',"fullscreen=yes");
                @endforeach
                console.log(notas_finales);
            });
            $( "ul.droptrue" ).sortable({
                connectWith: "ul",
                cursor: 'grabbing',
                placeholder: "alert alert-success",
                forcePlaceholderSize: true
            });
        })
    </script>
@endsection