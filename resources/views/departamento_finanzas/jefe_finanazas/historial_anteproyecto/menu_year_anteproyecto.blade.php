@extends('layouts.app')
@section('title', 'Historial del anteproyecto')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <p>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <a href="{{url("/presupuesto_anteproyecto/inicio_historial_anteproyecto")}}">Años de los historiales de los anteproyectos</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>Menú del historial del anteproyecto del presupuesto {{  $year->descripcion }} </span>
            </p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Historial del anteproyecto del presupuesto {{ $year->descripcion }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Techo presupuestal</h5>
                                        <button class="btn btn-primary techo_presupuestal" id="{{ $year->id_year }}">Ver</button>


                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Requisiciones autorizadas de los proyecto</h5>
                                    <button class="btn btn-primary req_autorizadas" id="{{ $year->id_year }}">Ver</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".techo_presupuestal").click(function (){
                // alert($("#grupos").val());
                var id_year = $(this).attr('id');;
                window.location.href='/presupuesto_anteproyecto/historial_anteproyecto_techo/'+id_year;
            });
            $(".req_autorizadas").click(function (){
                // alert($("#grupos").val());
                var id_year = $(this).attr('id');
                window.location.href='/presupuesto_anteproyecto/historial_anteproyecto_proyectos/'+id_year;
            });


        });

    </script>
@endsection