<div class="row">
    <div class="col-md-10  col-md-offset-1">
        <br>
        <div class="panel panel-success">
            @foreach($periodos_ingles as $periodo_ingles)
                @if($periodo_ingles->id_periodo_ingles==$id_periodo_ingles)
                    <div class="panel-heading" style="text-align: center;"><a href="#" style="border-bottom: 2px solid black;">{{ $periodo_ingles->periodo_ingles }}</a></div>
                @else
            <div class="panel-heading "  style="text-align: center;"><a  href="/recargar/periodos_ingles/{{$periodo_ingles->id_periodo_ingles}}" >{{ $periodo_ingles->periodo_ingles }}</a></div>
                @endif
           @endforeach
        </div>
    </div>
</div>