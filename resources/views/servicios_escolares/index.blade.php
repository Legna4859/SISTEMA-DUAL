@extends('layouts.app')
@section('title', 'S.Escolares')
@section('content')
    <div class="row">
        <div class="col-md-10 col-xs-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">BIENVENIDO</h3>
                </div>
                <div class="panel-body" style="padding: 70px 0px">
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h5 class="panel-title">Calificaciones</h5>
                                <p class="panel-text">
                                    Administrar los periodos para la carga de calificaciones.
                                    <br>
                                    Realizar cambios en calificaciones.
                                </p>
                                <a href="/servicios_escolares/evaluaciones" class="btn btn-primary btn-menu-admin">Abrir</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h5 class="panel-title">Datos Estadísticos</h5>
                                <p class="panel-text">Vizualizar datos estadisticos del TESVB</p>
                                <br>
                                <a href="/servicios_escolares/estadisticas" class="btn btn-primary btn-menu-admin">Abrir</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h5 class="panel-title">Modificaciones en periodos</h5>
                                <p class="panel-text">
                                    Viualiza movimientos en periodos de evaluación.
                                </p>
                                <br>
                                <a href="/servicios_escolares/bitacora_periodos" class="btn btn-primary btn-menu-admin">Abrir</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h5 class="panel-title">Modificaciones en calificaciones</h5>
                                <p class="panel-text">
                                    Viualiza movimientos en las calificaciones.
                                </p>
                                <a href="/servicios_escolares/bitacora_evaluaciones" class="btn btn-primary btn-menu-admin">Abrir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection