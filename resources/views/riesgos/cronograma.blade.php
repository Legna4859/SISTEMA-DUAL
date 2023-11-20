@extends('layouts.app')
@section('title', 'Cronograma')
@section('content')



    <main class="col-md-12">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Cronograma de acciones</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($array_full as $data)

                            @if(count($data[2]["datos_oportunidad"])!=0)
                        <li role="presentation" ><a href="#tab{{$data[1]}}" aria-controls="tab{{$data[1]}}" role="tab" data-toggle="tab" >{{ $data[0] }}</a></li>
                            @endif
                        @endforeach

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        @foreach($array_full as $data)
                            @if(count($data[2]["datos_oportunidad"])!=0)

                        <div role="tabpanel" class="tab-pane" id="tab{{$data[1]}}">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Area Administrativa</th>
                                    <th>Accion</th>
                                    <th>Fecha Inicial</th>
                                    <th>Fecha Final</th>
                                    <th>Tipo</th>
                                    <th>Observación</th>
                                    <th>Evidencia</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data[2]["datos_oportunidad"] as $oportunidad)

                                    <tr>
                                        <td>{{$oportunidad->nom_departamento}}</td>
                                        <td>{{$oportunidad->des_planseguimiento}}</td>
                                        <td>{{$oportunidad->fecha_inicial}}</td>
                                        <td>{{$oportunidad->fecha}}</td>
                                        <td>Oportunidad</td>
                                        <td>
                                            <form action="{{url("riesgos/seguimiento/tabla/".$oportunidad->id_planseguimiento)}}" method="post">
                                                @csrf
                                                @method("PUT")
                                                    <input type="hidden" name="action" value="oportunidad">
                                                @if(!$oportunidad->released)
                                                    <div class="form-group"><button  class="btn-success btn"><span class="glyphicon glyphicon-ok"></span></button></div>
                                                    <div class="form-group">
                                                        <label for="comments">Descripción: </label>
                                                        <input type="text" class="form-control" name="comments" id="comments">
                                                    </div>
                                                @else
                                                    <div class="form-group"><button  class="btn-danger btn"><span class="glyphicon glyphicon-remove"></span></button></div>
                                                    <div class="form-group">
                                                        <label for="comments">Descripción: </label>
                                                        <span>{{$oportunidad->comments}}</span>
                                                        <input type="hidden" class="form-control" name="comments" id="comments" value="" disabled>
                                                    </div>
                                                @endif

                                            </form>
                                        </td>
                                        <td>
                                            @if($oportunidad->status!=0)
                                            <a href="{{asset("storage")."/".$oportunidad->file}}" target="_blank">Ver evidencia</a>

                                               @else
                                                No hay evidencia
                                            @endif
                                            @if($oportunidad->status==2)
                                                <form action="{{url("riesgos/seguimiento/tabla_update/".$oportunidad->id_planseguimiento)}}" method="post">
                                                    @csrf
                                                    @method("PUT")
                                                    <input type="hidden" name="action" value="oportunidad">
                                                    <input type="hidden" name="value" value="1">
                                                    <div class="form-group"><button  class="btn-success btn" data-toggle="tooltip" data-placement="top" data-original-title="Aprobar"><span class="glyphicon glyphicon-ok"></span></button></div>
                                                </form>
                                                <form action="{{url("riesgos/seguimiento/tabla_update/".$oportunidad->id_planseguimiento)}}" method="post">
                                                    @csrf
                                                    @method("PUT")
                                                    <input type="hidden" name="action" value="oportunidad">
                                                    <input type="hidden" name="value" value="0">
                                                    <div class="form-group"><button  class="btn-danger btn"><span class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" data-original-title="Rechazar"></span></button></div>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach($data[2]["datos_riesgo"] as $riesgo)
                                    <tr>
                                        <td>{{$riesgo->nom_departamento}}</td>
                                        <td>{{$riesgo->accion}}</td>
                                        <td>{{$riesgo->fecha}}</td>
                                        <td>{{$riesgo->fecha_final}}</td>
                                        <td>Riesgo</td>
                                        <td>
                                            <form action="{{url("riesgos/seguimiento/tabla/".$riesgo->id_estrategia_a)}}" method="post">
                                                @csrf
                                                @method("PUT")
                                                <input type="hidden" name="action" value="riesgo">
                                                @if(!$riesgo->released)
                                                    <div class="form-group"><button  class="btn-success btn"><span class="glyphicon glyphicon-ok"></span></button></div>
                                                    <div class="form-group">
                                                        <label for="comments">Descripción: </label>
                                                        <input type="text" class="form-control" name="comments" id="comments">
                                                    </div>
                                                @else
                                                    <div class="form-group"><button  class="btn-danger btn"><span class="glyphicon glyphicon-remove"></span></button></div>
                                                    <div class="form-group">
                                                        <label for="comments">Descripción: </label>
                                                        <span>{{$riesgo->comments}}</span>
                                                        <input type="hidden" class="form-control" name="comments" id="comments" value="" disabled>
                                                    </div>
                                                @endif

                                            </form>


                                        </td>
                                        <td>
                                            @if($riesgo->status!=0)
                                                <a href="{{asset("storage")."/".$riesgo->file}}" target="_blank">Ver evidencia</a>

                                            @else
                                                No hay evidencia
                                            @endif
                                            @if($riesgo->status==2)
                                                <form action="{{url("riesgos/seguimiento/tabla_update/".$riesgo->id_estrategia_a)}}" method="post">
                                                    @csrf
                                                    @method("PUT")
                                                    <input type="hidden" name="action" value="riesgo">
                                                    <input type="hidden" name="value" value="1">
                                                    <div class="form-group"><button  class="btn-success btn" data-toggle="tooltip" data-placement="top" data-original-title="Aprobar"><span class="glyphicon glyphicon-ok"></span></button></div>
                                                </form>
                                                <form action="{{url("riesgos/seguimiento/tabla_update/".$riesgo->id_estrategia_a)}}" method="post">
                                                    @csrf
                                                    @method("PUT")
                                                    <input type="hidden" name="action" value="riesgo">
                                                    <input type="hidden" name="value" value="0">
                                                    <div class="form-group"><button  class="btn-danger btn"><span class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" data-original-title="Rechazar"></span></button></div>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                            @endif
                        @endforeach

                    </div>

                </div>
                {{--

                --}}
            </div>
        </div>
    </main>
    <script>   $('[data-toggle="tooltip"]').tooltip();</script>
@endsection